{{ Form::open(array('route' => 'users.change-password', 'autocomplete'=>'off','class'=>'smart-form client-form')) }}
	<header>
		{{ Lang::get('users.change_password.title') }}
	</header>
	@include('layouts._messages')
	<fieldset>
		<section>
			<label class="label">{{ Lang::get('users.old_password') }}</label>
			<label class="input"> <i class="icon-append fa fa-lock"></i>
				{{ Form::password('password', array('placeholder'=> Lang::get('users.old_password'), 'required','autocomplete'=>'on')) }}
			</label>
		</section>

		<section>
            <label class="label">{{ Lang::get('users.new_password') }}</label>
            <label class="input"> <i class="icon-append fa fa-lock"></i>
                {{ Form::password('new_password', array('placeholder'=> Lang::get('users.new_password'), 'required','autocomplete'=>'on')) }}
            </label>
        </section>
		<section>
		    <label class="label">{{ Lang::get('users.new_password_confirmation') }}</label>
		    <label class="input"> <i class="icon-append fa fa-lock"></i>
		        {{ Form::password('new_password_confirmation', array('placeholder'=> Lang::get('users.new_password_confirmation'), 'required','autocomplete'=>'on')) }}
		    </label>
		</section>
	</fieldset>
	<footer>
		{{ Form::submit(Lang::get('users.btn_change_password'), array('class'=>'btn btn-primary'))}}
	</footer>

{{ Form::close() }}