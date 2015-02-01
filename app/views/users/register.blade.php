   @include('layouts._messages')
{{ Form::open(array('route' => 'users.create', 'autocomplete'=>'on','class'=>'smart-form client-form')) }}
	<header>
		{{ Lang::get("users.register.title") }}
	</header>

	<fieldset>
		<div class="row">
            <section class="col col-6">
                <label class="input">
                    {{ Form::text('first_name', Input::get('first_name'), array('placeholder'=> Lang::get('users.first_name'), 'required')) }}
                </label>
            </section>
            <section class="col col-6">
                <label class="input">
                    {{ Form::text('last_name', Input::get('last_name'), array('placeholder'=> Lang::get('users.last_name'), 'required')) }}
                </label>
            </section>
        </div>
		<section>
			<label class="input"> <i class="icon-append fa fa-user"></i>
				{{ Form::text('username', Input::get('username'), array('placeholder'=> Lang::get('users.username'), 'required', 'autofocus','autocomplete'=>'on')) }}
				<b class="tooltip tooltip-bottom-right">Needed to enter the website</b> </label>
		</section>

		<section>
			<label class="input"> <i class="icon-append fa fa-envelope"></i>
				{{ Form::text('email', Input::get('email'), array('placeholder'=> Lang::get('users.email'), 'required')) }}
				<b class="tooltip tooltip-bottom-right">Needed to verify your account</b> </label>
		</section>

		<section>
			<label class="input"> <i class="icon-append fa fa-lock"></i>
				{{ Form::password('password', array('placeholder'=> Lang::get('users.password'), 'required')) }}
				<b class="tooltip tooltip-bottom-right">Don't forget your password</b> </label>
		</section>

		<section>
			<label class="input"> <i class="icon-append fa fa-lock"></i>
				{{ Form::password('password_confirmation', array('placeholder'=> Lang::get('users.password_confirmation'), 'required')) }}
				<b class="tooltip tooltip-bottom-right">Don't forget your password</b> </label>
		</section>

	</fieldset>

	<fieldset>
		<section>
                <label class="input"><i class="icon-append fa fa-suitcase"></i>
                    {{ Form::text('company_name', Input::get('company_name'), array('placeholder'=> Lang::get('users.company_name'), 'autofocus','autocomplete'=>'on')) }}
                </label>
            </section>

            <section>
                <label class="input"><i class="icon-append fa fa-phone"></i>
                    {{ Form::text('phone', Input::get('phone'), array('placeholder'=> Lang::get('users.phone'), 'autofocus','autocomplete'=>'on')) }}
                </label>
            </section>

            <section>
                <label class="input"><i class="icon-append fa fa-globe"></i>
                    {{ Form::text('website_url', Input::get('website_url'), array('placeholder'=> Lang::get('users.website_url'), 'autofocus','autocomplete'=>'on')) }}
                </label>
            </section>
	</fieldset>
	<footer>
		{{ Form::submit('Register', array('class'=>'btn btn-primary'))}}
	</footer>

	<div class="message">
		<i class="fa fa-check"></i>
		<p>
			{{Lang::get('users.register_success_mess')}}
		</p>
	</div>
{{ Form::close() }}
