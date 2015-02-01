<div class="row">
	<div class="col-lg-12">
		<div class="ibox-title">
			<h5>{{ Lang::get('label.client_user_manager_title') }}</h5>
		</div>
	<!-- widget div-->
	<div class="ibox-content">

		<!-- widget content -->
		<div class="row">
			{{ Form::open(array('route'=>'client-users.create', 'autocomplete'=>'off', 'method'=>'post','class'=>'form-horizontal')) }}

			@if($errors->any() && !empty($errors))
			<div class="invent_alert iA-error">
		        <div style="margin:10px 0px 0px 40px;">
					<ul>
						{{ implode('',$errors->all('<li>:message</li>')) }}
					</ul>
				</div>
		     </div>
			@endif
			<fieldset>
				<div class="form-group">
                    <label class="col-md-2 control-label">{{Lang::get('label.client_user_username')}} <span class="required">*</span></label>
                    <div class="col-md-4">
                        {{ Form::text('username','',array('placeholder'=>Lang::get('label.client_user_username'),'required','class'=>'form-control'))}}
                    </div>
                </div>
				<div class="form-group">
					<label class="col-md-2 control-label">{{Lang::get('label.client_user_first_name')}} <span class="required">*</span></label>
					<div class="col-md-4">
						{{ Form::text('first_name','',array('placeholder'=>Lang::get('label.client_user_first_name'),'required','class'=>'form-control'))}}
					</div>
				</div>
				<div class="form-group">
                    <label class="col-md-2 control-label">{{Lang::get('label.client_user_last_name')}} <span class="required">*</span></label>
                    <div class="col-md-4">
                        {{ Form::text('last_name','',array('placeholder'=>Lang::get('label.client_user_last_name'),'required','class'=>'form-control'))}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">{{Lang::get('label.client_user_email')}} <span class="required">*</span></label>
                    <div class="col-md-4">
                        {{ Form::email('email','',array('placeholder'=>Lang::get('label.client_user_email'),'required','class'=>'form-control'))}}
                    </div>
                </div>
                 <div class="form-group">
                    <label class="col-md-2 control-label">{{Lang::get('label.client_user_password')}} <span class="required">*</span></label>
                    <div class="col-md-4">
                        {{ Form::password('password',array('placeholder'=>Lang::get('label.client_user_password'),'required','class'=>'form-control'))}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">{{Lang::get('label.client_user_phone')}} <span class="required">*</span></label>
                    <div class="col-md-4">
                        {{ Form::text('phone','',array('placeholder'=>Lang::get('label.client_user_phone'),'required','class'=>'form-control'))}}
                    </div>
                </div>
			</fieldset>

			<div class="form-group">
                <div class="col-sm-4 col-sm-offset-2">
						{{Form::button('Back',array('class'=>'btn btn-default','onclick'=>'window.history.back();'))}}
						{{Form::submit('Submit',array('class'=>'btn btn-primary'))}}
				</div>
			</div>
			{{ Form::close() }}
		</div>
		</div>
	</div>
</div>