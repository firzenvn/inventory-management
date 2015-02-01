<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Products</h5>
				<div class="ibox-tools">
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
				</div>
			</div>
			<div class="ibox-content">

			{{Form::open(array('route'=>'products.list','method'=>'get'))}}
			<div class="">
				<a href="{{ URL::route('products.create') }}"  class="btn btn-primary">Create</a>

				<div class="pull-right">
					<a class="btn btn-sm btn-default" href="{{URL::route('products.list')}}">Reset</a>
					{{Form::submit('Search',array('class'=>'btn btn-primary'))}}
				</div>
			</div>
			<table class="table table-striped table-bordered table-hover dataTables-example" >
				<thead>
				<tr>
					<th nowrap >
						{{Lang::get('label.id')}}
						<a href="{{URL::route('products.list', array('sort' => 'seq_no', 'order' => 'desc'))}}"><i class="fa fa-caret-up"></i></a>
						<a href="{{URL::route('products.list', array('sort' => 'seq_no', 'order' => 'asc'))}}"><i class="fa fa-caret-down"></i></a>
					</th>
					<th nowrap >{{Lang::get('label.name')}}</th>
					<th nowrap >{{Lang::get('label.sku')}}</th>
					<th nowrap >{{Lang::get('label.price')}}</th>
					<th nowrap >{{Lang::get('label.quantity')}}</th>
					<th nowrap >{{Lang::get('label.created_at')}}</th>
					<th nowrap >{{Lang::get('label.status')}}</th>
					<th style="width: 9%;" ></th>
				</tr>
				<tr role="row">
						<td class="hasinput">
							{{Form::text('seq_no',Input::get('seq_no'),array('class'=>'form-control','placeholder'=>Lang::get('label.id')))}}
						</td>
						<td class="hasinput">
							{{Form::text('name',Input::get('name'),array('class'=>'form-control','placeholder'=>Lang::get('label.name')))}}
						</td>
						<td class="hasinput">
							{{Form::text('sku',Input::get('sku'),array('class'=>'form-control','placeholder'=>Lang::get('label.sku')))}}
						</td>
						<td class="hasinput">
							{{Form::text('price',Input::get('price'),array('class'=>'form-control','placeholder'=>Lang::get('label.price')))}}
						</td>
						<td class="hasinput">
							{{Form::text('quantity',Input::get('quantity'),array('class'=>'form-control','placeholder'=>Lang::get('label.quantity')))}}
						</td>
						<td class="hasinput">
							{{Form::text('created_at',Input::get('created_at'),array('class'=>'form-control','placeholder'=>Lang::get('label.created_at')))}}
						</td>
						<td class="hasinput">
							{{Form::select('status',array(''=>'All',0=>'Disable',1=>'Enable'),Input::get('status'),array('class'=>'form-control'))}}
						</td>
						<td></td>
					{{Form::close()}}
				</tr>
				</thead>
				<tbody>
				@foreach($rows as $row)
				<tr>
					<td>{{$row->seq_no}}</td>
					<td>{{$row->name}}</td>
					<td>{{$row->sku}}</td>
					<td>{{$row->price}}</td>
					<td>{{$row->quantity}}</td>
					<td>{{date('h:i:s d/m/Y',strtotime($row->created_at))}}</td>
					<td>@if($row->status==1) {{'Enable'}} @else {{'Disable'}} @endif</td>
					<td>
						<a href="{{URL::route('products.update.get',array('id'=>$row->id))}}"> <i class="fa fa-pencil-square-o"></i>Edit</a>
						<a href="{{URL::route('products.delete',array('id'=>$row->id))}}" onclick="return confirm('Are you sure you want to delete this row?')"> <i class="fa fa-times"></i>Delete</a>
					</td>
				</tr>
				@endforeach

				</tbody>
			</table>

			</div>
			<div class="row">
				<div class="col-sm-6 text-right">
					<div class="dataTables_paginate paging_simple_numbers" id="editable_paginate">
						{{ $rows->appends(array(
							'id' =>Input::get('id'),
							'name' =>Input::get('name'),
							'sku' =>Input::get('sku'),
							'price' =>Input::get('price'),
							'quantity' =>Input::get('quantity'),
							'created_at' =>Input::get('created_at'),
							'status' =>Input::get('status')
						))->links() }}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>