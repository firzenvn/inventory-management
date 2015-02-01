<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>{{ Lang::get('orders.update_order') }}</h2>
    </div>
    <div class="col-lg-4">
        <div class="title-action">
            {{--<a href="#" class="btn btn-white"><i class="fa fa-check "></i> Save</a>--}}
            {{--<a href="invoice_print.html" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Print Invoice </a>--}}
        </div>
    </div>
</div>
{{ Form::open(array('route'=>'orders.update', 'autocomplete'=>'off', 'method'=>'post','class'=>'form-horizontal')) }}
{{ Form::hidden('order_id',$model->id)}}
<div class="wrapper wrapper-content animated fadeInRight">
	{{--SEARCH CUSTOMER--}}
	<div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>{{Lang::get('orders.select_product')}}</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link" id="collapse-list-product">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
					<div class="row">
					    <div class="col-sm-3 m-b-xs">

					    </div>
					    <div class="pull-right">
					        {{Form::button('Search',array('class'=>'btn btn-sm btn-primary search-ajax'))}}
					    </div>
					</div>
					<div class="row" id="list-product"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>{{Lang::get('orders.order_item')}}</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content" id="order-items">
	                <div class="row">
	                    <div class="col-sm-3 m-b-xs">
		                    <label>
		                        <strong> Order Status</strong>
		                        {{ Form::select('status',Config::get('constant.order_status'),$model->status,array('class'=>'form-control input-s-sm inline'))}}
		                    </label>

	                    </div>

	                    <div class="col-sm-3 text-right pull-right">
                            <a class="btn btn-sm btn-info " href="{{URL::route('invoices.list',array('order_id'=>$model->id))}}" ><i class="fa fa-paste"></i>{{ Lang::get('orders.invoice') }}</a>
                            <a class="btn btn-sm btn-info" href="{{URL::route('shipments.list',array('order_id'=>$model->id))}}" ><i class="fa fa-paste"></i>{{ Lang::get('orders.ship') }}</a>
                            <a class="btn btn-sm btn-primary" href="javascript:void(0)" onclick="addProduct(this)">{{ Lang::get('orders.add_product') }}</a>
                        </div>
	                </div>
                    <div class="table-responsive">
                        <table class="table table-bordered dataTable">
                            <thead>
                                <tr>
                                    <th nowrap >{{Lang::get('label.product')}}</th>
                                    <th nowrap >{{Lang::get('label.sku')}}</th>
                                    <th nowrap >{{Lang::get('label.price')}}</th>
                                    <th nowrap style="width: 9%;">{{Lang::get('orders.qty')}}</th>
                                    <th nowrap  >{{Lang::get('orders.sub_total')}}</th>
                                    <th style="width: 9%;" ></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($model->orderItem as $item)
                                <tr>
                                    <td>{{$item->product->name}}</td>
                                    <td>{{$item->product->sku}}</td>
                                    <td>{{$item->product->price}}</td>
                                    <td class="qty_to_add">
                                        {{ Form::hidden('product_order_item[]', $item->product_id) }}
                                        {{ Form::number('product_qty['.$item->product_id.']',$item->qty_add ,array('style'=>'width: 100%','min'=>0)) }}
                                    </td>
                                    <td>{{ $item->product->price * $item->qty_add}}</td>
                                    <td>
                                        <a href="{{URL::route('order-items.delete',array('id'=>$item->id,))}}" onclick="return confirm('Are you sure you want to delete this item?')"> <i class="fa fa-times"></i>Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                   <td colspan="2"><strong>Total</strong> {{ count($model->orderItem) }} product(s)</td>
                                   <td colspan="2" class="text-right">Subtotal :</td>
                                   <td>{{ $model->base_grand_total }}</td>
                                   <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<div class="row">
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>{{Lang::get('customer.billing_address')}}</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
					<fieldset>
		                <div class="form-group">
		                    <label class="col-md-4 control-label">{{Lang::get('customer.prefix')}} <span class="disabled">*</span></label>
		                    <div class="col-md-8">
		                        {{ Form::select('billing_prefix',AppHelper::getPrefixCustomer(),Input::get('billing_prefix'),array('class'=>'form-control customer_info cus_prefix ','disabled'))}}
		                    </div>
		                </div>
		                <div class="form-group">
		                    <label class="col-md-4 control-label">{{Lang::get('customer.first_name')}} <span class="disabled">*</span></label>
		                    <div class="col-md-8">
		                        {{ Form::text('billing_first_name',Input::get('billing_first_name'),array('class'=>'form-control customer_info cus_first_name','disabled'))}}
		                    </div>
		                </div>
		                <div class="form-group">
		                    <label class="col-md-4 control-label">{{Lang::get('customer.middle')}}</label>
		                    <div class="col-md-8">
		                        {{ Form::text('billing_middle',Input::get('billing_middle'),array('class'=>'form-control customer_info cus_middle'))}}
		                    </div>
		                </div>
		                <div class="form-group">
		                    <label class="col-md-4 control-label">{{Lang::get('customer.last_name')}} <span class="disabled">*</span></label>
		                    <div class="col-md-8">
		                        {{ Form::text('billing_last_name',Input::get('billing_last_name'),array('class'=>'form-control customer_info cus_last_name','disabled'))}}
		                    </div>
		                </div>
		                <div class="form-group">
		                    <label class="col-md-4 control-label">{{Lang::get('customer.email')}} <span class="disabled">*</span></label>
		                    <div class="col-md-8">
		                        {{ Form::email('billing_email',Input::get('billing_last_name'),array('class'=>'form-control customer_info cus_email','disabled'))}}
		                    </div>
		                </div>
		                <div class="form-group">
		                    <label class="col-md-4 control-label">{{Lang::get('customer.phone_no')}} <span class="disabled">*</span></label>
		                    <div class="col-md-8">
		                        {{ Form::text('billing_phone_no',Input::get('billing_phone_no'),array('class'=>'form-control customer_info cus_phone_no','disabled'))}}
		                    </div>
		                </div>
		                <div class="form-group">
		                    <label class="col-md-4 control-label">{{Lang::get('customer.fax')}} <span class="disabled">*</span></label>
		                    <div class="col-md-8">
		                        {{ Form::text('billing_fax',Input::get('billing_fax'),array('class'=>'form-control customer_info cus_fax','disabled'))}}
		                    </div>
		                </div>

		                <div class="form-group">
		                    <label class="col-md-4 control-label">{{Lang::get('customer.tax')}} <span class="disabled">*</span></label>
		                    <div class="col-md-8">
		                        {{ Form::text('billing_vat_number',Input::get('billing_vat_number'),array('class'=>'form-control customer_info cus_vat_number','disabled'))}}
		                    </div>
		                </div>

		                <div role="panel-heading">
		                    <h5 style="border-bottom: 1px solid #ccc">Customer's Address</h5>
		                </div>
		                <div class="form-group">
		                    <label class="col-md-4 control-label">{{Lang::get('customer.company')}}</label>
		                    <div class="col-md-8">
		                        {{ Form::text('billing_company',Input::get('billing_company'),array('class'=>'form-control customer_info cus_company'))}}
		                    </div>
		                </div>
		                <div class="form-group">
		                    <label class="col-md-4 control-label">{{Lang::get('customer.address')}} <span class="disabled">*</span></label>
		                    <div class="col-md-8">
		                        {{ Form::text('billing_address',Input::get('billing_address'),array('class'=>'form-control customer_info cus_address','disabled'))}}
		                    </div>
		                </div>
		                <div class="form-group">
		                    <label class="col-md-4 control-label">{{Lang::get('customer.city')}} <span class="disabled">*</span></label>
		                    <div class="col-md-8">
		                        {{ Form::text('billing_city',Input::get('billing_city'),array('class'=>'form-control customer_info cus_city','disabled'))}}
		                    </div>
		                </div>
		                <div class="form-group">
		                    <label class="col-md-4 control-label">{{Lang::get('customer.country_id')}} <span class="disabled">*</span></label>
		                    <div class="col-md-8">
		                        {{ Form::select('billing_country',Country::getCountryToArray(),Input::get('billing_country'),array('class'=>'form-control customer_info cus_country_id','disabled'))}}
		                    </div>
		                </div>
		                <div class="form-group">
		                    <label class="col-md-4 control-label">{{Lang::get('customer.province_id')}} <span class="disabled">*</span></label>
		                    <div class="col-md-8">
		                        {{ Form::text('billing_province',Input::get('billing_province'),array('class'=>'form-control customer_info cus_province_id','disabled'))}}
		                    </div>
		                </div>
		                <div class="form-group">
		                    <label class="col-md-4 control-label">{{Lang::get('customer.zipcode')}} <span class="disabled">*</span></label>
		                    <div class="col-md-8">
		                        {{ Form::text('billing_zipcode',Input::get('billing_zipcode'),array('class'=>'form-control customer_info cus_zipcode','disabled'))}}
		                    </div>
		                </div>
		                 {{ Form::hidden('bill_customer_id',Input::get('bill_customer_id'),array('class'=>'form-control customer_info cus_id'))}}
		            </fieldset>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
	        <div class="ibox float-e-margins">
	            <div class="ibox-title">
	                <h5>{{Lang::get('customer.shipping_address')}}</h5>
	                <div class="ibox-tools">
	                    <a class="collapse-link">
	                        <i class="fa fa-chevron-up"></i>
	                    </a>
	                </div>
	            </div>
	            <div class="ibox-content">
					<fieldset>
	                    <div class="form-group">
	                        <label class="col-md-4 control-label">{{Lang::get('customer.prefix')}} <span class="disabled">*</span></label>
	                        <div class="col-md-8">
	                            {{ Form::select('shipping_prefix',AppHelper::getPrefixCustomer(),Input::get('shipping_prefix'),array('class'=>'form-control customer_info cus_prefix ','disabled'))}}
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label class="col-md-4 control-label">{{Lang::get('customer.first_name')}} <span class="disabled">*</span></label>
	                        <div class="col-md-8">
	                            {{ Form::text('shipping_first_name',Input::get('shipping_first_name'),array('class'=>'form-control customer_info cus_first_name','disabled'))}}
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label class="col-md-4 control-label">{{Lang::get('customer.middle')}}</label>
	                        <div class="col-md-8">
	                            {{ Form::text('shipping_middle',Input::get('shipping_middle'),array('class'=>'form-control customer_info cus_middle'))}}
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label class="col-md-4 control-label">{{Lang::get('customer.last_name')}} <span class="disabled">*</span></label>
	                        <div class="col-md-8">
	                            {{ Form::text('shipping_last_name',Input::get('shipping_last_name'),array('class'=>'form-control customer_info cus_last_name','disabled'))}}
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label class="col-md-4 control-label">{{Lang::get('customer.email')}} <span class="disabled">*</span></label>
	                        <div class="col-md-8">
	                            {{ Form::email('shipping_email',Input::get('shipping_email'),array('class'=>'form-control customer_info cus_email','disabled'))}}
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label class="col-md-4 control-label">{{Lang::get('customer.phone_no')}} <span class="disabled">*</span></label>
	                        <div class="col-md-8">
	                            {{ Form::text('shipping_phone_no',Input::get('shipping_phone_no'),array('class'=>'form-control customer_info cus_phone_no','disabled'))}}
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label class="col-md-4 control-label">{{Lang::get('customer.fax')}} <span class="disabled">*</span></label>
	                        <div class="col-md-8">
	                            {{ Form::text('shipping_fax',Input::get('shipping_fax'),array('class'=>'form-control customer_info cus_fax','disabled'))}}
	                        </div>
	                    </div>

	                    <div class="form-group">
	                        <label class="col-md-4 control-label">{{Lang::get('customer.tax')}} <span class="disabled">*</span></label>
	                        <div class="col-md-8">
	                            {{ Form::text('shipping_vat_number',Input::get('shipping_vat_number'),array('class'=>'form-control customer_info cus_vat_number','disabled'))}}
	                        </div>
	                    </div>

	                    <div role="panel-heading">
	                        <h5 style="border-bottom: 1px solid #ccc">Customer's Address</h5>
	                    </div>
	                    <div class="form-group">
	                        <label class="col-md-4 control-label">{{Lang::get('customer.company')}}</label>
	                        <div class="col-md-8">
	                            {{ Form::text('shipping_company',Input::get('shipping_company'),array('class'=>'form-control customer_info cus_company'))}}
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label class="col-md-4 control-label">{{Lang::get('customer.address')}} <span class="disabled">*</span></label>
	                        <div class="col-md-8">
	                            {{ Form::text('shipping_address',Input::get('shipping_address'),array('class'=>'form-control customer_info cus_address','disabled'))}}
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label class="col-md-4 control-label">{{Lang::get('customer.city')}} <span class="disabled">*</span></label>
	                        <div class="col-md-8">
	                            {{ Form::text('shipping_city',Input::get('shipping_city'),array('class'=>'form-control customer_info cus_city','disabled'))}}
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label class="col-md-4 control-label">{{Lang::get('customer.country_id')}} <span class="disabled">*</span></label>
	                        <div class="col-md-8">
	                            {{ Form::select('shipping_country',Country::getCountryToArray(),Input::get('shipping_country'),array('class'=>'form-control customer_info cus_country_id','disabled'))}}
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label class="col-md-4 control-label">{{Lang::get('customer.province_id')}} <span class="disabled">*</span></label>
	                        <div class="col-md-8">
	                            {{ Form::text('shipping_province',Input::get('shipping_province'),array('class'=>'form-control customer_info cus_province_id','disabled'))}}
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label class="col-md-4 control-label">{{Lang::get('customer.zipcode')}} <span class="disabled">*</span></label>
	                        <div class="col-md-8">
	                            {{ Form::text('shipping_zipcode',Input::get('shipping_zipcode'),array('class'=>'form-control customer_info cus_zipcode','disabled'))}}
	                        </div>
	                    </div>
	                    {{ Form::hidden('ship_customer_id',Input::get('ship_customer_id'),array('class'=>'form-control customer_info cus_id'))}}
	                </fieldset>
	            </div>
	        </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
					<div class="form-group">
					    <div class="col-sm-4 col-sm-offset-2">
					        {{Form::button('Back',array('class'=>'btn btn-default','onclick'=>'window.history.back();'))}}
                            {{Form::submit('Submit',array('class'=>'btn btn-primary'))}}
					    </div>
					</div>
                </div>
            </div>
        </div>
    </div>

</div>

{{ Form::close() }}
<style>
	.disabled{
		display: none;
	}
</style>
<script type="text/javascript">
function addCustomerInfo(d){
	var data = $(d).data("options");
	$.each( data, function( key, val ) {
		$(".cus_" + key).val(val);
	});
	$(".search-dropdown .search-ac").removeClass("active");
}

function addProduct(obj){
	//ORDER: LOAD PRODUCT LIST
	$('#list-product').load('{{ URL::route('orders.listProducts.get') }}');
	$('#collapse-list-product.collapse-link').trigger("click");
	$(obj).addClass('disabled', true);
}

$(document).ready(function(){

	 $('#collapse-list-product.collapse-link').trigger("click");
	//LOAD CUSTOMER INFO
	var customer_info = '{{ json_encode($model->customer->attributesToArray()) }}';
	$.each($.parseJSON(customer_info), function( key, val ) {
           $(".cus_" + key).val(val);
           if(key != 'id')
                $(".cus_" + key).prop('disabled', true);
    });

    //ORDER: SEARCH CUSTOMER
    $('#search-customer').keyup(function() {
        if($(this).val().length >= 3 ){
            $.ajax({
                type: "POST",
                url: "{{ URL::route('orders.searchCustomer') }}",
                data: {
                    key:$(this).val()
                }
            }).done(function( msg ) {
                $(".search-dropdown .search-ac").html(msg);
            });
        } else{
            $(".search-dropdown .search-ac").html("<li><a href='index.html'>{{Lang::get('orders.keep_typing')}}</li>");
        }
        $(".search-dropdown .search-ac").addClass("active");
        if($(this).val().length == 0 ){
            $(".search-dropdown .search-ac").removeClass("active");
        }
    });
});
</script>
