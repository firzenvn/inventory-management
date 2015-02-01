{{--{{Form::open(array('route'=>'products.list','method'=>'get','name'=>'abc'))}}--}}
	<div class="pull-right">
		{{--<a class="btn btn-sm btn-default" href="{{URL::route('products.list')}}">Reset</a>--}}
		{{--{{Form::button('Search',array('class'=>'btn btn-sm btn-primary search-ajax'))}}--}}
	</div>
</div>
	<!-- widget div-->
	<div role="content">
		<!-- widget content -->
		<div class="widget-body">
			<div class="table-responsive">
				<table class="table table-bordered dataTable">
					<thead>
					<tr>
						<th nowrap >
							{{Lang::get('orders.no')}}
							{{--<a href="{{URL::route('products.list', array('sort' => 'id', 'order' => 'desc'))}}"><i class="fa fa-caret-up"></i></a>--}}
							{{--<a href="{{URL::route('products.list', array('sort' => 'id', 'order' => 'asc'))}}"><i class="fa fa-caret-down"></i></a>--}}
						</th>
						<th nowrap >{{Lang::get('label.name')}}</th>
						<th nowrap >{{Lang::get('label.sku')}}</th>
						<th nowrap >{{Lang::get('label.price')}}</th>
						<th nowrap style="width: 9%;">{{Lang::get('label.quantity')}}</th>
						<th nowrap style="width: 9%;">{{Lang::get('orders.lb_select')}}</th>
						<th nowrap style="width: 9%;">{{Lang::get('orders.qty_to_add')}}</th>
					</tr>
					<tr role="row">
						<td class="hasinput">
							{{Form::text('seq_no',Input::get('seq_no'),array('class'=>'form-control input-search-ajax','placeholder'=>Lang::get('orders.no')))}}
						</td>
						<td class="hasinput">
							{{Form::text('name',Input::get('name'),array('class'=>'form-control input-search-ajax','placeholder'=>Lang::get('label.name')))}}
						</td>
						<td class="hasinput">
							{{Form::text('sku',Input::get('sku'),array('class'=>'form-control input-search-ajax','placeholder'=>Lang::get('label.sku')))}}
						</td>
						<td class="hasinput">
							{{Form::text('price',Input::get('price'),array('class'=>'form-control input-search-ajax','placeholder'=>Lang::get('label.price')))}}
						</td>
						<td class="hasinput">
						</td>
						<td></td>
						<td></td>
{{--						{{Form::close()}}--}}
					</tr>
					</thead>
					<tbody>
					<?php $product_items = Session::get('product_items'); $qty_to_add = Session::get('qty_to_add');?>
					@foreach($rows as $row)
					<tr>
						<td>{{$row->seq_no}}</td>
						<td>{{$row->name}}</td>
						<td>{{$row->sku}}</td>
						<td>{{$row->price}}</td>
						<td>{{$row->quantity}}</td>
						<td class="text-center product_item">
								<?php //echo ($product_items[$row->seq_no] == $row->id) ? "1" : "0"; ?>
{{--						    {{ Form::text('product_item['.$row->seq_no.']',$product_items[$row->seq_no])}}--}}
							{{ Form::checkbox('product_item['.$row->seq_no.']', $row->id  )}}
						</td>
						<td class="qty_to_add">
                            {{ Form::number('qty_to_add['.$row->id.']','' ,array('style'=>'width: 100%','disabled','min'=>0,'max'=>$row->quantity)) }}
                        </td>
					</tr>
					<?php
					Session::forget('product_items');
					Session::forget('qty_to_add');
					?>
					@endforeach

					</tbody>
				</table>
			</div>
			<div class="row">
				<div class="col-sm-6 text-right">
					<div class="dataTables_paginate paging_bootstrap_full">
						{{ $rows->links() }}
					</div>
				</div>
			</div>
		</div>
		<!-- end widget content -->

	</div>
	<!-- end widget div -->

</div>

<script type="text/javascript">
$('.search-ajax').on('click', function(){
	var query_string = "";
	$(".input-search-ajax").each(function(index) {
		if ($(this).val() != '') {
			query_string += encodeURIComponent($(this).attr('name')) + "=" + encodeURIComponent($(this).val());
			query_string += "&";
		}
	});
	$('#list-product').load('{{ URL::route('orders.listProducts.get') }}' + '?' + query_string);
});
$(".pagination a").unbind( "click" );
$('.pagination a').click(function() {
	$('#list-product').load($(this).attr('href'));
	return false;
})
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