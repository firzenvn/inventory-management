{{ Form::open(array('route' => 'users.login', 'autocomplete'=>'off','class'=>'smart-form client-form')) }}
	<header>
		{{ Lang::get('users.login.title') }}
	</header>
	@include('layouts._messages')
	<fieldset>
		<section>
			<label class="label">{{ Lang::get('users.username') }}</label>
			<label class="input"> <i class="icon-append fa fa-user"></i>
				{{ Form::text('username', Input::get('username'), array('placeholder'=>Lang::get('users.username'), 'required', 'autofocus','autocomplete'=>'on')) }}
			</label>
		</section>

		<section>
			<label class="label">{{ Lang::get('users.password') }}</label>
			<label class="input"> <i class="icon-append fa fa-lock"></i>
				{{ Form::password('password', array('placeholder'=> Lang::get('users.password'), 'required','autocomplete'=>'on')) }}
			</label>
		</section>
		<section>
			<label class="label">{{ Lang::get('users.client_id') }}</label>

			<label class="input"> <i class="icon-append fa fa-university"></i>
				{{ Form::number('customer_code','',array('placeholder'=> Lang::get('users.client_id'),'autocomplete'=>'on')) }}
			</label>
		</section>

		<section>
			<label class="checkbox">
				{{ Form::checkbox('remember_me', '1',true) }}
				<i></i>{{ Lang::get('users.remember_me') }}</label>
		</section>
		<section>
			<a href="{{ Config::get('constant.inventory_id_base_url'). '/users/recover-password' }}">If you have forgotten your password, change it here</a>
		</section>
	</fieldset>
	<footer>
		{{ Form::submit('Sign in', array('class'=>'btn btn-primary'))}}
	</footer>

{{ Form::close() }}