<div class="row">
	<div class="col-lg-12">
		<div class="ibox-title">
			<h5>{{ Lang::get('customerGroup.title') }}</h5>
		</div>
	<!-- widget div-->
	<div class="ibox-content">

		<!-- widget content -->
		<div class="row">
			{{ Form::open(array('action'=>'customer-groups.update', 'autocomplete'=>'off', 'method'=>'post','class'=>'form-horizontal')) }}
			{{Form::hidden('id',$model->id) }}
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
					<label class="col-md-2 control-label">{{Lang::get('label.client_id')}} <span class="required">*</span></label>
					<div class="col-md-4">
						{{ Form::text('client_id',$model->client_id,array('placeholder'=>Lang::get('label.client_id'),"required",'class'=>'form-control'))}}
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">{{Lang::get('customerGroup.name')}} <span class="required">*</span></label>
					<div class="col-md-4">
						{{ Form::text('name',$model->name,array('placeholder'=>Lang::get('customerGroup.name'),"required",'class'=>'form-control'))}}
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">{{Lang::get('customerGroup.status')}} <span class="required">*</span></label>
					<div class="col-md-4">
                        {{ Form::select('status',array(''=>'--Select one-','0'=>'Disable','1'=>'Enable'),$model->status,array("required",'class'=>'form-control'))}}
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