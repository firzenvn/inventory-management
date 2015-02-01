<?php

/**
 * Class InventoryIDOauth2
 * - Tạo link đăng nhập sử dụng Oauth2 của hệ thông InventoryID
 * - Xử lý login callback khi user đăng nhập và InventoryID trả về authorization_code
 *
 * @author Firzen Le <dangleduc@gmail.com>
 */

class InventoryIDOauth2
{
	const API_CREATE_USER_BY_TICKET = '/users-api/create-by-ticket';

	const APP_ID = "2"; //change this to your app id
	const APP_SECRET = "cus123"; //change this to your app secret
	const LOGIN_REDIRECT_URI = "http://inventory.dev/users/sso-login-callback"; //change this to your login return url
	public $scopes = array('id', 'username', 'email', 'first_name', 'last_name');

	/**
	 * Tạo link đăng nhập qua Oauth2
	 */
	public function generateLoginUrl()
	{
		session_start();
		$_SESSION['state'] = md5(uniqid(rand(), TRUE)); // CSRF protection

		return Config::get('constant.inventory_id_base_url') . "/oauth/authorize?client_id="
		. self::APP_ID . "&response_type=code" . "&redirect_uri=" . urlencode(self::LOGIN_REDIRECT_URI) . "&state="
		. $_SESSION['state'] . "&scope=" . implode(",", $this->scopes);
	}

	/**
	 * Sử dụng trong trường hợp tích hợp oauth2 theo chuẩn PASSWORD FLOW
	 * Post/Get thông tin đăng nhập của user về id.playagate.vn để lấy ra access_token
	 */
	public function loginPasswordFlowCredentials($username, $password)
	{
		session_start();
		$_SESSION['state'] = md5(uniqid(rand(), TRUE)); // CSRF protection

		$args = array(
			'grant_type' => 'password',
			'client_id' => self::APP_ID,
			'client_secret' => self::APP_SECRET,
			'username' => $username,
			'password' => $password,
			'scope' => implode(",", $this->scopes),
			'state' => $_SESSION['state']
		);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, Config::get('constant.inventory_id_base_url') . '/oauth/access_token');
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($args));
		curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . "/ca.crt");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		$output = curl_exec($ch);
		if ($output === false) {
			curl_close($ch);
			return array(
				array('error' => 'curl_error', 'error_description' => curl_error($ch)),
				null
			);
		}

		curl_close($ch);

		$accessTokenInfo = json_decode($output, true);
		//If json format error?
		if ($accessTokenInfo === false) {
			return array(
				array('error' => 'json_format_error', 'error_description' => $output),
				null
			);
		}
		if (isset($accessTokenInfo['error']))
			return $accessTokenInfo;

		$userInfo = $this->getUserDetails($accessTokenInfo['access_token']);

		return array($accessTokenInfo, $userInfo);
	}

	/**
	 * Hàm xử lý lấy ra thông tin user đã đăng nhập qua oauth2 và trả về authrization_code
	 * 1. từ authorization_code gọi sang ID để lấy access_token
	 * 2. dùng access_token để lấy về thông tin user đang đăng nhập
	 *
	 * @return array(access_token, user)
	 */
	public function loginCallback()
	{
		//get authorization_code
		$code = $_REQUEST["code"];

		//check CSRF
//		session_start();
//		if($_SESSION['state'] == null || ($_SESSION['state'] != $_REQUEST['state']))
//		{
//			die("May be CSRF attack");
//		}

		if (empty($code)) {
			exit('Login with ID failed');
		}

		//get access_token từ authorization_code
		$accessTokenInfo = $this->getAccessTokenDetails($code);
		if ($accessTokenInfo == null) {
			echo "Unable to get Access Token";
			exit(0);
		}

		$userInfo = $this->getUserDetails($accessTokenInfo['access_token']);

		return array($accessTokenInfo, $userInfo);
	}


	/**
	 * Get access_token from authorization_code
	 *
	 * @param $app_id
	 * @param $app_secret
	 * @param $redirect_url
	 * @param $code
	 * @return null
	 */
	public static function getAccessTokenDetails($code)
	{
		$token_url = Config::get('constant.inventory_id_base_url') . "/oauth/access_token?"
			. "client_id=" . self::APP_ID . "&grant_type=authorization_code" . "&redirect_uri=" . urlencode(self::LOGIN_REDIRECT_URI)
			. "&client_secret=" . self::APP_SECRET . "&code=" . $code;
		$response = @file_get_contents($token_url);
		return json_decode($response, true);
	}

	/**
	 * Get user detail from access_token
	 * @param $access_token
	 * @return mixed|null
	 */
	public function getUserDetails($access_token)
	{
		$graph_url = Config::get('constant.inventory_id_base_url') . "/graph-api/me?access_token=" . $access_token;
		$user = json_decode(@file_get_contents($graph_url));
		if (!empty($user))
			return $user;

		return null;
	}

	/**
	 * Build url để thực hiện đăng nhập qua sso
	 *
	 * @param $username
	 * @param $password
	 * @param $return_url
	 * @return string
	 */
	public function buildSigninByTicketUrl($username, $password, $return_url)
	{
		$signinTicket = $this->encryptTicket(array('username' => $username, 'password' => $password));
		return Config::get('constant.inventory_id_base_url') . '/users/signin-by-ticket?_cid=' . self::APP_ID . '&signin-ticket=' . urlencode($signinTicket) . '&return_url=' . urlencode($return_url);
	}

	/**
	 * Tạo url thực hiện register-by-ticket
	 *
	 * @param $user_info
	 * @param $return_url
	 * @return string
	 */
	public function buildRegisterUrl($user_info, $return_url)
	{
		$encryptTicket = $this->encryptTicket($user_info);
		$returnUrl = Config::get('constant.inventory_id_base_url') . '/users/register-by-ticket?_cid=' .
			self::APP_ID . '&register-ticket=' . urlencode($encryptTicket) . '&return_url=' . urlencode($return_url);
		return $returnUrl;
	}

	/**
	 * Hàm refresh_token
	 * Thực hiện sử dụng refresh_token để lấy access_token mới trong trường hợp access_token cũ bị hết hạn mà không cần user đăng nhập lại
	 * @param $refresh_token
	 * @return mixed
	 */
	public static function refreshToken($refresh_token)
	{
		$token_url = Config::get('constant.inventory_id_base_url') . "/oauth/access_token?"
			. "client_id=" . self::APP_ID . "&grant_type=refresh_token" . "&refresh_token=" . urlencode($refresh_token)
			. "&client_secret=" . self::APP_SECRET . "&state=" . time();
		$response = @file_get_contents($token_url);
		return json_decode($response, true);
	}

	/**
	 * Hàm mã hóa thông tin đăng nhập username/password tạo ra signinTicket
	 * @param $args array, vd array('username'=>'un', 'password'=>'pwd', 'email'=>'eml',...)
	 * Returns an encrypted & utf8-encoded
	 * @return string
	 */
	public static function encryptTicket($args = array())
	{
		$pure_string = json_encode($args);
		$iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, self::APP_SECRET, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv);
		return base64_encode($encrypted_string);
	}

	/**
	 * Hàm giải mã signinTicket thành username/password để kiểm tra đăng nhập
	 * Returns decrypted original string
	 */
	public static function decryptTicket($ticket)
	{
		$ticket = base64_decode($ticket);
		$iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, self::APP_SECRET, $ticket, MCRYPT_MODE_ECB, $iv);
		$decrypted_string = trim($decrypted_string, "\0\4");
		return json_decode($decrypted_string, true);
	}

	/**
	 * Return 1x1 pixel image while signing in by sso
	 */
	public static function returnImage()
	{
		header('Content-Type: image/gif');

		# this is an image with 1pixel x 1pixel
		$img = base64_decode('R0lGODdhAQABAPAAAL6+vgAAACwAAAAAAQABAAACAkQBADs=');
		echo $img;
	}
}

?>