<div class="row">
	<div class="col-lg-12">
		<div class="ibox-title">
			<h5>{{ Lang::get('label.new_stock_request') }}</h5>
		</div>
		<div class="ibox-content">
			<div class="" style="margin-top: 10px">
				{{ Form::open(array('action'=>'requestStock.create_request', 'method'=>'post','class'=>'form-horizontal')) }}
				<fieldset>
					<div class="form-group">
						<label class="col-md-2 control-label">{{Lang::get('label.source')}} <span class="required">*</span></label>
						<div class="col-md-4">
							{{ Form::select('source_id',Warehouse::getWarehouseToArray(),'',array('required','class'=>'form-control'))}}
						</div>
					</div>
				</fieldset>
				<fieldset>
					<div class="form-group">
						<label class="col-md-2 control-label">{{Lang::get('label.destination_warehouse')}} <span class="required">*</span></label>
						<div class="col-md-4">
							{{ Form::select('destination_id',Warehouse::getWarehouseToArray(),'',array('required','class'=>'form-control'))}}
						</div>
					</div>
				</fieldset>

				<div class="form-group">
					<div class="col-sm-4 col-sm-offset-2">
						{{Form::button('Back',array('class'=>'btn btn-default','onclick'=>'window.history.back();'))}}
						{{Form::submit('Continue',array('class'=>'btn btn-primary'))}}
					</div>
				</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>