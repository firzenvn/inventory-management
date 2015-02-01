<script src="/js/inventory/customer-create-script.js"></script>
<div class="row">
	<div class="col-lg-12">
		<div class="ibox-title">
			<h5>{{ Lang::get('customer.title') }}</h5>
		</div>
	<!-- widget div-->
	<div class="ibox-content">

		<!-- widget content -->
		<div class="row">
			{{ Form::open(array('action'=>'customers.create', 'autocomplete'=>'off', 'method'=>'post','class'=>'form-horizontal')) }}

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
                <div class="panel-heading">
                    <h5 style="border-bottom: 1px solid #ccc">Account Infomation</h5>
                </div>
                <!-- widget div-->
				<div class="form-group">
					<label class="col-md-2 control-label">{{Lang::get('customer.customer_group_id')}} </label>
					<div class="col-md-4">
						{{ Form::select('customer_group_id',CustomerGroup::getGroupToArray(),'',array('placeholder'=>Lang::get('customer.customer_group_id'),'class'=>'form-control'))}}
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">{{Lang::get('customer.prefix')}} <span class="required">*</span></label>
					<div class="col-md-4">
                        {{ Form::select('prefix',AppHelper::getPrefixCustomer(),'',array('class'=>'form-control','required'))}}
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">{{Lang::get('customer.first_name')}} <span class="required">*</span></label>
					<div class="col-md-4">
                        {{ Form::text('first_name','',array('class'=>'form-control','required'))}}
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">{{Lang::get('customer.middle')}}</label>
					<div class="col-md-4">
                        {{ Form::text('middle','',array('class'=>'form-control'))}}
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">{{Lang::get('customer.last_name')}} <span class="required">*</span></label>
					<div class="col-md-4">
                        {{ Form::text('last_name','',array('class'=>'form-control','required'))}}
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">{{Lang::get('customer.email')}} <span class="required">*</span></label>
					<div class="col-md-4">
                        {{ Form::email('email','',array('class'=>'form-control','required'))}}
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">{{Lang::get('customer.phone_no')}} <span class="required">*</span></label>
					<div class="col-md-4">
                        {{ Form::text('phone_no','',array('class'=>'form-control','required'))}}
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">{{Lang::get('customer.fax')}} <span class="required">*</span></label>
					<div class="col-md-4">
                        {{ Form::text('fax','',array('class'=>'form-control','required'))}}
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">{{Lang::get('customer.dob')}} <span class="required">*</span></label>
					<div class="col-md-4">
                        {{ Form::select('date',AppHelper::getDate(),'',array('class'=>'form-control','required','style'=>'width:30%;float:left;margin-left:5px;'))}}
                        {{ Form::select('month',AppHelper::getMonth(),'',array('class'=>'form-control','required','style'=>'width:30%;float:left;;margin-left:5px;'))}}
                        {{ Form::select('year',AppHelper::getYear(),'',array('class'=>'form-control','required','style'=>'width:30%;float:left;;margin-left:5px;'))}}
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">{{Lang::get('customer.tax')}} <span class="required">*</span></label>
					<div class="col-md-4">
                        {{ Form::text('vat_number','',array('class'=>'form-control','required'))}}
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">{{Lang::get('customer.gender')}} <span class="required">*</span></label>
					<div class="col-md-4">
                        {{ Form::select('gender',AppHelper::getGender(),'',array('class'=>'form-control'))}}
					</div>
				</div>
				<div role="panel-heading">
                    <h5 style="border-bottom: 1px solid #ccc">Customer's Address</h5>
                </div>
				<div class="form-group">
                    <label class="col-md-2 control-label">{{Lang::get('customer.company')}}</label>
                    <div class="col-md-4">
                        {{ Form::text('company','',array('class'=>'form-control'))}}
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-md-2 control-label">{{Lang::get('customer.address')}} <span class="required">*</span></label>
                    <div class="col-md-4">
                        {{ Form::text('address','',array('class'=>'form-control','required'))}}
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-md-2 control-label">{{Lang::get('customer.city')}} <span class="required">*</span></label>
                    <div class="col-md-4">
                        {{ Form::text('city','',array('class'=>'form-control','required'))}}
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-md-2 control-label">{{Lang::get('customer.country_id')}} <span class="required">*</span></label>
                    <div class="col-md-4">
                        {{ Form::select('country',Country::getCountryToArray(),'',array('class'=>'form-control','required'))}}
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-md-2 control-label">{{Lang::get('customer.province_id')}} <span class="required">*</span></label>
                    <div class="col-md-4">
                        {{ Form::text('province','',array('class'=>'form-control','required'))}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">{{Lang::get('customer.zipcode')}} <span class="required">*</span></label>
                    <div class="col-md-4">
                        {{ Form::text('zipcode','',array('class'=>'form-control','required'))}}
                    </div>
                </div>
                <div role="panel-heading">
                    <h5 style="border-bottom: 1px solid #ccc">Password Management</h5>
                </div>
				<div class="form-group">
                    <label class="col-md-2 control-label">{{Lang::get('customer.password')}} <span class="required repass">*</span></label>
                    <div class="col-md-4">
                        {{ Form::password('password',array('class'=>'form-control','required'))}}
                        <p>or</p>
						{{ Form::checkbox('autopassword','1')}} {{Lang::get('customer.password-title')}}
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