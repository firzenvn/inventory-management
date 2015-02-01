<div class="row">
	<div class="col-lg-12">
		<div class="ibox-title">
	        <h5>{{ Lang::get('adjuststock.physical_stocktaking') }}</h5>
	    </div>
	    <div class="ibox-content">
			<div class="" style="margin-top: 10px">
				{{ Form::open(array('action'=>'adjustStock.create_adjust.get', 'autocomplete'=>'off', 'method'=>'post','class'=>'form-horizontal')) }}
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
                            <label class="col-md-2 control-label">{{Lang::get('adjuststock.select_wh_ad_stock')}} <span class="required">*</span></label>
                            <div class="col-md-4">
                                {{ Form::select('warehouse_id',Warehouse::getWarehouseToArray(),'',array('placeholder'=>Lang::get('adjuststock.select_wh_phy_stock'),'required','class'=>'form-control'))}}
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