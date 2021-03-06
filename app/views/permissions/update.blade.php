<div class="row">
	<div class="col-lg-12">
		<div class="ibox-title">
			<h5>{{ Lang::get('label.role_manager_title') }}</h5>
		</div>
	<!-- widget div-->
	<div class="ibox-content">

		<!-- widget content -->
		<div class="row">
			{{ Form::open(array('route' => 'permissions.create', 'autocomplete'=>'off', 'method'=>'post','class'=>'form-horizontal')) }}
			{{ Form::hidden('role_id',$role_id) }}
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
					<label class="col-md-2 control-label">{{Lang::get('label.permission_role_id')}} <span class="required">*</span></label>
					<div class="col-md-4">
						{{ Form::select('role_id',Role::getRolesClientToArray(),$role_id,array('class'=>'form-control'))}}
					</div>
				</div>
				<?php $resources = Resource::getResource() ?>
                @if(!is_null($resources))
                    @foreach($resources as $rs)
                        <div class="form-group">
                            <label class="col-md-2 control-label">{{ $rs->description }} </label>
							<div class="col-md-4">
								@foreach($model as $row)
									@if($row->resource == $rs->id)
										<div class="checkbox">
											<label>
											 {{  Form::checkbox($row->resource.'_'.$row->action ,Input::get($row->resource.'_'.$row->action ), $row->type==Permission::ALLOW ? true : false ) }} {{ ucfirst($row->action) }}
											</label>
										</div>
									@endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @endif
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