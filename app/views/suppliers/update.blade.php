

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>{{ Lang::get('supplier.title') }}</h2>
    </div>
    <div class="col-lg-4">
        <div class="title-action">
            {{--<a href="#" class="btn btn-white"><i class="fa fa-check "></i> Save</a>--}}
            {{--<a href="invoice_print.html" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Print Invoice </a>--}}
        </div>
    </div>
</div>
{{ HTML::script('js/plugins/papaparse/papaparse.js')}}
{{ HTML::script('js/inventory/custom-script.js')}}
<div class="row">
	<div class="col-lg-12">
		<div class="panel blank-panel">
			<div class="panel-heading">
				<div class="panel-options">
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#tab-1">Supplier Information</a></li>
						<li class=""><a data-toggle="tab" href="#tab-2" class="tab-2">Product</a></li>
					</ul>
				</div>
			</div>
			<div class="panel-body">
				<div class="tab-content">
					<div id="tab-1" class="tab-pane active">
						<div class="ibox float-e-margins">
							<div class="ibox-title">
								<h5>Update Supplier #{{$model->seq_no}}</h5>
								<div class="ibox-tools">
									<a class="collapse-link">
										<i class="fa fa-chevron-up"></i>
									</a>
								</div>
							</div>
							<div class="ibox-content">
                                {{ Form::open(array('route'=>'suppliers.update', 'autocomplete'=>'off', 'method'=>'post','class'=>'form-horizontal')) }}
                                {{ Form::hidden('id',$model->id)}}
                                @if($errors->any() && !empty($errors))
                                <div class="invent_alert iA-error">
                                    <div style="margin:10px 0px 0px 40px;">
                                    <ul>
                                    @foreach($errors->all() as $message)
                                        <li>{{ $message }}</li>
                                    @endforeach
                                    </ul>
                                    </div>
                                </div>
                                @endif

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">{{Lang::get('label.supplier_name')}} <span class="required">*</span></label>
                                    <div class="col-sm-4">
                                        {{ Form::text('supplier_name',$model->name,array('placeholder'=>Lang::get('label.supplier_name'),'required','class'=>'form-control'))}}
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">{{Lang::get('label.supplier_person')}} <span class="required">*</span></label>
                                    <div class="col-sm-4">
                                        {{ Form::text('supplier_person',$model->person,array('placeholder'=>Lang::get('label.supplier_person'),'required','class'=>'form-control'))}}
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">{{Lang::get('label.supplier_email')}} <span class="required">*</span></label>
                                    <div class="col-sm-4">
                                        {{ Form::email('supplier_email',$model->email,array('placeholder'=>Lang::get('label.supplier_email'),'required','class'=>'form-control'))}}
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">{{Lang::get('label.phone_no')}} <span class="required">*</span></label>
                                    <div class="col-sm-4">
                                        {{ Form::text('phone_no',$model->phone_no,array('placeholder'=>Lang::get('label.phone_no'),'required','class'=>'form-control'))}}
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">{{Lang::get('label.fax')}}</label>
                                    <div class="col-sm-4">
                                        {{ Form::text('fax',$model->fax,array('placeholder'=>Lang::get('label.fax'),'class'=>'form-control'))}}
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">{{Lang::get('label.street')}} <span class="required">*</span></label>
                                    <div class="col-sm-4">
                                        {{ Form::text('street',$model->street,array('placeholder'=>Lang::get('label.street'),'required','class'=>'form-control'))}}
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">{{Lang::get('label.city')}} <span class="required">*</span></label>
                                    <div class="col-sm-4">
                                        {{ Form::text('city',$model->city,array('placeholder'=>Lang::get('label.city'),'required','class'=>'form-control'))}}
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">{{Lang::get('label.country')}} <span class="required">*</span></label>
                                    <div class="col-sm-4">
                                        {{ Form::select('country_id',$countries,$model->country_id,array('class'=>'form-control'))}}
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">{{Lang::get('label.state_province')}}</label>
                                    <div class="col-sm-4">
                                        {{ Form::text('province',$model->province,array('placeholder'=>Lang::get('label.state_province'),'class'=>'form-control'))}}
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">{{Lang::get('label.zip_code')}} <span class="required">*</span></label>
                                    <div class="col-sm-4">
                                        {{ Form::text('zipcode',$model->zipcode,array('placeholder'=>Lang::get('label.zip_code'),'required','class'=>'form-control'))}}
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">{{Lang::get('label.website')}}</label>
                                    <div class="col-sm-4">
                                        {{ Form::text('website',$model->website,array('placeholder'=>Lang::get('label.website'),'class'=>'form-control'))}}
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">{{Lang::get('label.description')}}</label>
                                    <div class="col-sm-4">
                                        {{ Form::textarea('description',$model->description,array('placeholder'=>Lang::get('label.description'),'class'=>'form-control'))}}
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">{{Lang::get('label.status')}} <span class="required">*</span></label>
                                    <div class="col-sm-4">
                                        {{ Form::select('status',array(1 => Lang::get('label.enable'), 0 => Lang::get('label.disable')),$model->status,array('class'=>'form-control'))}}
                                    </div>
                                </div>

                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        {{Form::button('Back',array('class'=>'btn btn-white','onclick'=>'window.history.back();'))}}
                                        {{Form::submit('Submit',array('class'=>'btn btn-primary'))}}
                                    </div>
                                </div>
                                {{ Form::close() }}
                            </div>
						</div>
					</div>

					<div id="tab-2" class="tab-pane">
						<div class="ibox float-e-margins">
							<div class="ibox-title">
								<h5>{{ Lang::get('label.assign_product') }}</h5>
								<div class="ibox-tools">
									<a class="collapse-link">
										<i class="fa fa-chevron-up"></i>
									</a>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
var change_tab = 0;
$(".tab-2").on("click",function(){
	if(change_tab == 0)
		$('#tab-2').load('{{ URL::route('suppliers.product-supplier.get',array('supplier_id'=>$model->id)) }}');
	change_tab = 1;
});
</script>

@if(Session::get('assign_product_supplier'))
<script type="text/javascript">
$(".tab-2").trigger("click");</script>
<?php Session::forget('assign_product_supplier');?>
@else
	@if(Session::has('dataImport'))
    <?php Session::forget('dataImport');?>
    @endif
@endif

