
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
	@endforeach<tr>
	<td colspan="10"  style="border: none">
		<div class="col-sm-6 text-right">
		     <div class="dataTables_paginate paging_bootstrap_full">
		         {{ $product_supplier_items->links() }}
		     </div>
		 </div>
	</td>
</tr>

<script type="text/javascript">
$(document).ready(function(){
	$("#product_supplier_items .pagination a").unbind( "click" );
	$("#product_supplier_items .pagination a").click(function() {
		$('#product_supplier_items').load($(this).attr('href'));
		return false;
	});
	$("#product_supplier_items .delete-assign-item").unbind( "click" );
	$("#product_supplier_items .delete-assign-item").click(function(){
		deleteProduct(this);
		return false;
	});
	importData();
});
</script>