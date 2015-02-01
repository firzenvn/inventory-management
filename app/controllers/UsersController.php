<?php

/**
 * Created by PhpStorm.
 * User: DONY
 * Date: 10/2/2014
 * Time: 11:45 PM
 */
class UsersController extends BaseController
{
	protected $layout = "layouts.auth";

	public function __construct()
	{
		$this->beforeFilter('csrf', array('on' => 'post'));
		$this->beforeFilter('auth', array('only' => array('getDashboard')));
	}

	/**
	 * Display login form
	 *
	 */
	public function getLogin()
	{
		$this->layout->content = View::make('users.login');
	}

	/**
	 * Attempt to do login with sso
	 *
	 * @return $this|\Illuminate\Http\RedirectResponse
	 */
	public function postLogin()
	{
		$validator = Validator::make(Input::all(), array(
			'username' => 'required',
			'password' => 'required',
			'customer_code' => 'required',
		));
		if (!$validator->passes()) {
			return Redirect::route('users.login.get')->withInput()->with('error',$validator->messages()->all());
		}

		$remember = (Input::has('remember_me')) ? true : false;
		Session::put('remember_me', $remember);

		$username = Input::get('username');
		$password = Input::get('password');
		$customer_code=Input::get('customer_code');
		//check customer code and user id
		$check=$this->checkUserOwner($customer_code,$username);
		if($check['status']===false){
			if(isset($check['mes']))
				return Redirect::back()->withInput()->with('error',$check['mes']);
			//login on inventory
			if (Auth::attempt(array('username' => Input::get('username'), 'password' => Input::get('password'),'client_id'=>$customer_code),$remember)){
				return Redirect::to('/');
			}
			return Redirect::back()->withInput()->with('error',Lang::get('users.login_error_mess'));
		}else{
			Session::put('login_data', array(
				'username' => $username,
				'customer_code' => $customer_code
			));

			$idOauth = new InventoryIDOauth2();
			$login_url = $idOauth->buildSigninByTicketUrl($username, $password, URL::to('/'));
			return Redirect::to($login_url."&fail_url=". urlencode(URL::route('users.fail-login.get')));
		}
	}

	/**
	 * Attempt to do login with sso
	 *
	 * @return $this|\Illuminate\Http\RedirectResponse
	 */
	public function getFailLogin()
	{
		if (Session::has('login_data')) {
			return Redirect::route('users.login.get')->with('error', Lang::get('users.login_error_mess'))->withInput(Session::get('login_data'));
		}
		return Redirect::route('users.login.get')->with('error', Lang::get('users.login_error_mess'));
	}

	/**
	 * Callback user login sso
	 */
	public function getSsoLoginCallback()
	{
		$idOauth2 = new InventoryIDOauth2();
		list($accessTokenInfo, $userInfo) = $idOauth2->loginCallback();
		$user = User::firstOrNew(array('oauth2_id'=>$userInfo->id));
		$user->username=$userInfo->username;
		$user->email=$userInfo->email;
		$user->phone=$userInfo->phone;
		$user->first_name=$userInfo->first_name;
		$user->last_name=$userInfo->last_name;
		if(!$user->save()){
			Log::error('sso-login-callback: Something is really going wrong.');
		}

		$remember = false;
		if (Session::has('remember_me')) {
			$remember = Session::get('remember_me');
			Session::forget('remember_me');
		}

		Auth::login($user, $remember);

		return View::make('users.sso-image');
	}

	/**
	 * Callback user logout sso
	 */
	public function getSsoLogoutCallback()
	{
		Auth::logout();
		return View::make('users.sso-image');
	}

	/**
	 * Display register form
	 */
	public function getRegister()
	{
		$this->layout->content = View::make('users.register');
	}

	/**
	 * Create user with IDOauth
	 *
	 * Redirect to login form when register success
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function postCreate()
	{
		$validator = Validator::make(Input::all(), User::$rules);
		if (!$validator->passes()) {
			return Redirect::route('users.register.get')->with('error', Lang::get('users.register_validate_error_mess'))->withErrors($validator)->withInput();
		}

		$user_info = array(
			'first_name' => Input::get('first_name'),
			'last_name' => Input::get('last_name'),
			'username' => Input::get('username'),
			'password' => Input::get('password'),
			'email' => Input::get('email'),
			'phone' => Input::get('phone'),
			'company_name' => Input::get('company_name'),
			'website_url' => Input::get('website_url'),
		);

		$register_data = array(
			'_cid' => InventoryIDOauth2::APP_ID,
			'register-ticket' => InventoryIDOauth2::encryptTicket($user_info)
		);

		$restInventory = new InventoryIDRestClient();
		$result = $restInventory->post(InventoryIDOauth2::API_CREATE_USER_BY_TICKET, $register_data);

		if ($result['status'] != '200' && !empty($result['error_message'])) {
			return Redirect::route('users.register.get')->with('error', Lang::get('users.register_id_error_mess') . $result['error_message']);
		} else {
			$user_data = $result['user'];

			$client = new Client();
			$client->package_id = User::USER_PACKAGE_TRIAL;
			$client->warehouse_count = 0;
			$client->user_count = 0;
			$client->product_count = 0;
			$client->company_name = isset($user_data['company_name']) ? $user_data['company_name'] : '';
			$client->website_url = isset($user_data['website_url']) ? $user_data['website_url'] : '';
			$client->save();

			$user = new User();
			$user->oauth2_id = $user_data['id'];
			$user->username = $user_data['username'];
			$user->first_name = isset($user_data['first_name']) ? $user_data['first_name'] : '';
			$user->last_name = isset($user_data['last_name']) ? $user_data['last_name'] : '';
			$user->email = isset($user_data['email']) ? $user_data['email'] : '';
			$user->phone = isset($user_data['phone']) ? AppHelper::standardizePhone($user_data['phone']) : '';
			$user->client_id = $client->id;
			$user->save();

			$client = Client::find($client->id);
			$client->owner_user_id = $user->id;
			$client->save();

			Event::fire('users.register', array($user,$client->id));

			return Redirect::route('users.login.get');
		}
	}

	function checkUserOwner($client_id,$user){
		$client = Client::find($client_id);
		$user=User::where('username','=',$user)->where('client_id','=',$client_id)->first();
		if(empty($user))
			return array('status'=>false,'mes'=>Lang::get('users.client_id_not_match'));
		if($client->owner_user_id==$user->id)
			return array('status'=>true);
		return array('status'=>false);
	}

	public function getDashboard()
	{
		$this->layout->content = View::make('inventory.dashboard');
	}

	/**
	 * Redirect to sso logout
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function getLogout()
	{
		return Redirect::to(Config::get('constant.inventory_id_base_url') . '/users/logout?return_url=' . URL::to('/'));
	}

	public function getChangePassword(){
		if(Auth::guest()){
			return Redirect::to('/');
		}else{
			$user = Auth::user();
			$check=$this->checkUserOwner($user->client_id,$user->username);
			if($check['status']===false){
				$this->layout->content = View::make('users.change-password');
			}else{
				return Redirect::to(Config::get('constant.inventory_id_base_url'). '/users/change-pass?return_url='.URL::to('/'));
			}
		}
	}

	public function postChangePassword(){
		$validator = Validator::make(Input::all(), User::$rules_change_password);
		if (!$validator->passes()) {
			return Redirect::route('users.change-password.get')->with('error', Lang::get('users.register_validate_error_mess'))->withErrors($validator)->withInput();
		}

		$user = Auth::user();
		$old_password = Input::get('password');
		$new_password = Input::get('new_password');

		if(!Hash::check($old_password, $user->password)){
			return Redirect::route('users.change-password.get')->with('error', Lang::get('users.wrong_old_password_mess'))->withErrors($validator)->withInput();
		}else{
			$user = User::find($user->id);
			$user->password = Hash::make($new_password);;
			if($user->save()){
				return Redirect::route('dashboard.list.default')->with('success', Lang::get('users.change_password_success_mess'));
			}
			return Redirect::route('users.change-password.get')->with('error', Lang::get('users.change_password_error_mess'));
		}
	}

	public function getClientRegister(){
		App::abort(404,'You need to register as our client at first. But this function is now under construction!');
	}
} 