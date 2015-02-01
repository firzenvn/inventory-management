<!-- widget div-->
<div role="content">
	<!-- widget content -->
	<div class="widget-body">
		<div class="table-responsive">
			<table class="table table-bordered dataTable">
				<thead>
				<tr>
					<th nowrap style="width: 3%;">
                        <input name="checked_all_product_item" type="checkbox" value="all">
                    </th>
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
				</tr>
				<?php $product_items = Session::get('product_search'); ?>
				<tr role="row">
					<td></td>
					<td class="hasinput">
						{{Form::hidden('supplier_id',isset($supplier_id) ? $supplier_id : '' ,array('class'=>'input-search-ajax'))}}
						{{Form::text('id',Input::get('id',isset($product_items['id']) ? $product_items['id'] : '' ),array('class'=>'form-control input-search-ajax','placeholder'=>Lang::get('label.id-item')))}}
					</td>
					<td class="hasinput">
						{{Form::text('name',Input::get('name',isset($product_items['name']) ? $product_items['name'] : ''),array('class'=>'form-control input-search-ajax','placeholder'=>Lang::get('label.name')))}}
					</td>
					<td class="hasinput">
						{{Form::text('sku',Input::get('sku',isset($product_items['sku']) ? $product_items['sku'] : ''),array('class'=>'form-control input-search-ajax','placeholder'=>Lang::get('label.sku')))}}
					</td>
					<td class="hasinput">
						{{Form::text('price',Input::get('price',isset($product_items['price']) ? $product_items['price'] : ''),array('class'=>'form-control input-search-ajax','placeholder'=>Lang::get('label.price')))}}
					</td>
					<td class="hasinput">
                        {{Form::select('status',array(''=>'All',0=>'Disable',1=>'Enable'),Input::get('status',isset($product_items['status']) ? $product_items['status'] : ''),array('class'=>'form-control input-search-ajax'))}}
                    </td>
					<td class="hasinput">
					</td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<?php Session::forget('product_search');?>
				</thead>
				<tbody>

				@foreach($rows as $row)
				<tr>
					<td class="text-center product_item">
				        {{ Form::checkbox('product_item[]', $row->id ,null,array('class'=>'product_item'))}}
				    </td>
					<td>{{$row->id}}</td>
					<td>{{$row->name}}</td>
					<td>{{$row->sku}}</td>
					<td>{{number_format($row->price,0)}}</td>
					<td>@if($row->status==1) {{'Enable'}} @else {{'Disable'}} @endif</td>
					<td class="hasinput">
                        {{Form::text('product_item_info'.'['.$row->id .']'.'[cost]',Input::get($row->id.'[cost]',number_format(0,4)),array('class'=>'form-control input-search-ajax'))}}
                    </td>
					<td class="hasinput">
                        {{Form::text('product_item_info'.'['.$row->id .']'.'[tax]',Input::get($row->id.'[tax]',0),array('class'=>'form-control input-search-ajax'))}}
                    </td>
					<td class="hasinput">
                        {{Form::text('product_item_info'.'['.$row->id .']'.'[discount]',Input::get($row->id.'[discount]',0),array('class'=>'form-control input-search-ajax'))}}
                    </td>
                    <td class="hasinput">
                        {{Form::text('product_item_info'.'['.$row->id .']'.'[supplier_sku]',Input::get($row->id.'[supplier_sku]',''),array('class'=>'form-control input-search-ajax'))}}
                    </td>
				</tr>

				@endforeach

				</tbody>
			</table>
		</div>
		<div class="row">
			<div class="col-sm-6 text-right">
				<div class="dataTables_paginate paging_bootstrap_full list-products">
					{{ $rows->links() }}
				</div>
			</div>
		</div>
	</div>
	<!-- end widget content -->
</div>
<!-- end widget div -->

<script type="text/javascript">
//AJAX SEARCH
$('.search-ajax').on('click', function(){
	var query_string = "";
	$(".input-search-ajax").each(function(index) {
		//if ($(this).val() != '') {
			query_string += encodeURIComponent($(this).attr('name')) + "=" + encodeURIComponent($(this).val());
			query_string += "&";
		//}
	});
	$('#list-product').load('{{ URL::route('suppliers.listProducts.get') }}' + '?' + query_string);
});
//AJAX PAGINATION
$(".list-products .pagination a").unbind( "click" );
$('.list-products .pagination a').click(function() {
	$('#list-product').load($(this).attr('href'));
	return false;
})
$("input[name='checked_all_product_item']").on( "click", function(){
	if($(this).is(':checked')){
		$(".product_item").prop('checked', true);
	}else{
		$(".product_item").prop('checked', false);
	}
});

$(".product_item input[type=checkbox]").on( "click", function(){
	if($(this).is(':checked')){
		$("input[name='qty_to_add[" + $(this).val() + "]']").prop('disabled', false);
        $("input[name='qty_to_add[" + $(this).val() + "]']").val(1);

	}else{
		$("input[name='qty_to_add[" + $(this).val() + "]']").prop('disabled', true);
        $("input[name='qty_to_add[" + $(this).val() + "]']").val('');
	}
});
$(document).ready(function(){
});
</script>