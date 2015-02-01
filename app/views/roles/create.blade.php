<div class="row">
	<div class="col-lg-12">
		<div class="ibox-title">
			<h5>{{ Lang::get('label.role_manager_title') }}</h5>
		</div>
		<!-- widget div-->
		<div class="ibox-content">
			<div class="row">
				{{ Form::open(array('action'=>'roles.create', 'autocomplete'=>'off', 'method'=>'post','class'=>'form-horizontal')) }}

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
						<label class="col-md-2 control-label">{{Lang::get('role.role_name')}} <span class="required">*</span></label>
						<div class="col-md-4">
							{{ Form::text('role_name','',array('placeholder'=>Lang::get('role.role_name'),'required','class'=>'form-control'))}}
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
