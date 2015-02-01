{{--<div class="row wrapper border-bottom white-bg page-heading">--}}
    {{--<div class="col-lg-8">--}}
        {{--<h2>{{ Lang::get('label.assign_product') }}</h2>--}}
    {{--</div>--}}
    {{--<div class="col-lg-4">--}}
        {{--<div class="title-action">--}}
            {{--<a href="#" class="btn btn-white"><i class="fa fa-check "></i> Save</a>--}}
            {{--<a href="invoice_print.html" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Print Invoice </a>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}

{{ Form::open(array('route'=>'suppliers.product-supplier', 'autocomplete'=>'off', 'method'=>'post','class'=>'form-horizontal')) }}
{{ Form::hidden('supplier_id',$model->id,array('class'=>'input-search-ajax-p-subpplier'))}}
<div class="wrapper wrapper-content animated fadeInRight">
	{{--SEARCH CUSTOMER--}}
	<div class="row select-product">
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
					        {{Form::submit(Lang::get('supplier.title.assign_product'),array('class'=>'btn btn-primary btn-sm'))}}
					        {{Form::button('Search',array('class'=>'btn btn-sm btn-primary search-ajax'))}}
					    </div>
					</div>
					<div class="row" id="list-product"></div>
                </div>
            </div>
        </div>
    </div>
    @if($product_supplier_item_count > 0)
    <div class="row">
	    <div class="col-lg-12">
	        <div class="ibox float-e-margins">
	            <div class="ibox-title">
	                <h5>{{ Lang::get('supplier.title.import.submit') }}</h5>
	                <div class="ibox-tools">
	                    <a class="collapse-link">
	                        <i class="fa fa-chevron-up"></i>
	                    </a>
	                </div>
	            </div>
	             <div class="ibox-content" id="order-items">
	                <div class="row">
						<div class="col-lg-3">
							{{ Lang::get('supplier.title.choose_file') }}
							<div class="row">
								{{Form::file('csv_file',array('class'=>'col-lg-6','id'=>'csv_file'))}}
                                {{Form::button('Import',array('class'=>'btn btn-sm btn-primary import-ajax col-lg-4'))}}
                                {{ Form::textarea('csv_content_file','',array('id'=>'csv-content-file','class'=>'hidden')) }}
							</div>

						</div>
						<div class="col-lg-9">
						    When you want to assign loads of products to a Supplier, the structure of CSV file is as follows:
						    <h2 style="text-transform: uppercase">Sku,Cost,Discount,Tax,Supplier_sku</h2>
						    <h5>SKU:SKU of product</h5>
						    <h5>COST:price cost of product</h5>
						    <h5>DISCOUNT:Discount of product by percentage</h5>
						    <h5>TAX:tax of product by percentage</h5>
						    <h5>SUPPLIER_SKU:SKU of supplier's product</h5>
						</div>
	                </div>
                </div>
	        </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Items</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content" id="order-items">
	                <div class="row">
	                    <div class="col-sm-3 text-left pull-left">
	                    <?php $product_supp_items = Session::get('product_supplier_search'); ?>
	                        <div class="input-group">
	                           {{Form::text('sku',Input::get('sku',isset($product_supp_items['sku']) ? $product_supp_items['sku'] : ''),array('class'=>'form-control input-search-ajax-p-subpplier','placeholder'=>Lang::get('label.sku')))}}
	                            <span class="input-group-btn">
	                                {{Form::button('Search',array('class'=>'btn btn-primary search-ajax-p-subpplier','data-button'=>'{"data": "product_supplier_items", "link": "' .  URL::route('suppliers.product-supplier.get') .'"}'))}}
	                            </span>
	                        </div>
	                    <?php Session::forget('product_supplier_search');?>
	                    </div>
	                    <div class="col-sm-3 text-right pull-right">
	                        {{--<a class="btn btn-sm btn-default" href="{{URL::route('suppliers.list')}}">Reset</a>--}}
                            <a class="btn btn-sm btn-primary add-product" href="javascript:void(0)" onclick="addProduct(this)">{{ Lang::get('supplier.title.assign_product') }}</a>
                        </div>
	                </div>
                    <div class="table-responsive">
                        <table class="table table-bordered dataTable">
		                    <thead>
		                    <tr>
		                        <th nowrap style="width: 6%;">
		                            {{Lang::get('label.id-item')}}
		                        </th>
		                        <th nowrap >{{Lang::get('label.name')}}</th>
		                        <th nowrap style="width: 15%;">{{Lang::get('label.sku')}}</th>
		                        <th nowrap style="width: 11%;">{{Lang::get('label.price')}}</th>
		                        <th nowrap style="width: 9%;">{{Lang::get('label.status')}}</th>
		                        <th nowrap style="width: 9%;">Cost</th>
		                        <th nowrap style="width: 9%;">Tax(%)</th>
		                        <th nowrap style="width: 9%;">Discount(%)</th>
		                        <th nowrap style="width: 9%;">Supplier Sku</th>
		                        <th nowrap style="width: 9%;"></th>
		                    </tr>

		                    </thead>
		                    <tbody id="product_supplier_items">

		                    @foreach($product_supplier_items as $row)
		                    <tr id="{{$row->product->sku}}" class="data_items">
		                        {{ Form::hidden('product_item[]', $row->product->id ,null,array('class'=>'product_item'))}}
		                        <td>{{$row->product->id}}</td>
		                        <td>{{$row->product->name}}</td>
		                        <td>{{$row->product->sku}}</td>
		                        <td>{{number_format($row->product->price,0)}}</td>
		                        <td>@if($row->product->status==1) {{'Enable'}} @else {{'Disable'}} @endif</td>
		                        <td class="hasinput">
		                            {{Form::text('product_item_info'.'['.$row->product->id .']'.'[cost]',Input::get($row->product->id.'[cost]',number_format($row->cost,4)),array('class'=>'form-control im-cost'))}}
		                        </td>
		                        <td class="hasinput">
		                            {{Form::text('product_item_info'.'['.$row->product->id .']'.'[tax]',Input::get($row->product->id.'[tax]',$row->tax),array('class'=>'form-control im-tax'))}}
		                        </td>
		                        <td class="hasinput">
		                            {{Form::text('product_item_info'.'['.$row->product->id .']'.'[discount]',Input::get($row->product->id.'[discount]',$row->discount),array('class'=>'form-control im-discount'))}}
		                        </td>
		                        <td class="hasinput">
		                            {{Form::text('product_item_info'.'['.$row->product->id.']'.'[supplier_sku]',Input::get($row->product->id.'[supplier_sku]',$row->supplier_sku),array('class'=>'form-control im-supplier_sku'))}}
		                        </td>
		                        <td>  <a href="{{ URL::route('suppliers.delete-product-supplier.get',array('id'=>$row->id,'supplier_id'=>$model->id))}}" class="delete-assign-item" > <i class="fa fa-times"></i>Delete</a></td>
		                    </tr>
		                    @endforeach
							<tr>
								<td colspan="10"  style="border: none">
									<div class="col-sm-6 text-right">
									     <div class="dataTables_paginate paging_bootstrap_full">
									         {{ $product_supplier_items->links() }}
									     </div>
									 </div>
								</td>
							</tr>
		                    </tbody>
		                </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
        <script>
			$(document).ready(function(){
			    $('#collapse-list-product.collapse-link').trigger("click");
			    $('.select-product').css("display","none");
			});
        </script>
	@else
		<script>
		$(document).ready(function(){
			addProduct();
			$('.select-product').css("display","block");
			$('#collapse-list-product.collapse-link').trigger("click");
	    });
    </script>
	@endif
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
$(document).ready(function(){
	$("#product_supplier_items .pagination a").unbind( "click" );
    $('#product_supplier_items .pagination a').click(function() {
    	$('#product_supplier_items').load($(this).attr('href'));
    	return false;
    });
    $("#product_supplier_items .delete-assign-item").unbind( "click" );
    $("#product_supplier_items .delete-assign-item").click(function(){
        deleteProduct(this);
        return false;
    });

    importData();
	//AJAX SEARCH
	$('.search-ajax-p-subpplier').on('click', function(){
		var query_string = "";
		$(".input-search-ajax-p-subpplier").each(function(index) {
			//if ($(this).val() != '') {
				query_string += encodeURIComponent($(this).attr('name')) + "=" + encodeURIComponent($(this).val());
				query_string += "&";
			//}
		});
		$('#product_supplier_items').load('{{ URL::route('suppliers.search-product-supplier.get') }}' + '?' + query_string);
	});
	$('.import-ajax').click(function(){
		console.log($('#csv-content-file').val());
		if($('#csv-content-file').val().length > 0){
			$('.form-horizontal').submit();
		}else{
			alert("You must choose file for import");
		}
	});
	$('#csv_file').change(function(e) {
	    var fileInput = document.getElementById('csv_file');
	    var csv_file = fileInput.files[0];
	    var textname = /^.*\.(csv)$/;

	    if (csv_file.name.match(textname)) {
	        Papa.parse(csv_file, {
	            complete: function(results, file) {
	                $('#csv-content-file').html(array2json(results.data));
                	console.log("Parsing complete:", results);
                }
	        });
	    } else {
	        alert("File not supported!");
	    }
	});
});
function deleteProduct(obj){
	var x;
    if (confirm('Are you sure you want to delete this item?') == true) {
        $('#product_supplier_items').load($(obj).attr('href'));
    }
}
function addProduct(obj){
	//ORDER: LOAD PRODUCT LIST
	$('#list-product').load('{{ URL::route('suppliers.listProducts.get',array('supplier_id'=>$model->id)) }}');
	$('#collapse-list-product.collapse-link').trigger("click");
	$('.select-product').css("display","block");
	if(obj != null ){
		$(obj).addClass('disabled', true);
	}
}
function importData(){
	var dataImport = '{{ Session::get('dataImport','') }}';
	//console.log(dataImport.length );
	if(dataImport.length > 0){
		var objData = $.parseJSON(dataImport);
		//console.log(objData);
		$("#product_supplier_items .data_items").each(function(index){
			var ele_id = this.id;
			//          console.log(ele_id);
			//          console.log(objData[ele_id].cost);
			//console.log(objData[ele_id]);
			//console.log(objData[ele_id].length);
			//if(objData[ele_id].count())
			$.each(objData[ele_id],function(key,val){
				$('#'+ele_id+" .im-"+key).val(val);
			});
		});
	}
}
</script>
