<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Warehouse Product</h5>
				<div class="ibox-tools">
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
				</div>
			</div>
			<div class="ibox-content">

				{{Form::open(array('route'=>'warehouseProduct.list','method'=>'get'))}}
				<div class="">
					{{--<a href="#" class="btn btn-primary">Add Product to Warehouse</a>--}}

					<div class="pull-right">
						<a class="btn btn-sm btn-default" href="{{URL::route('warehouseProduct.list')}}">Reset</a>
						{{Form::submit('Search',array('class'=>'btn btn-primary'))}}
					</div>
				</div>
				<table class="table table-striped table-bordered table-hover dataTables-example" >
					<thead>
					<tr>
						<th nowrap >
							{{Lang::get('label.id')}}
							<a href="{{URL::route('warehouseProduct.list', array('sort' => 'seq_no', 'order' => 'desc'))}}"><i class="fa fa-caret-up"></i></a>
							<a href="{{URL::route('warehouseProduct.list', array('sort' => 'seq_no', 'order' => 'asc'))}}"><i class="fa fa-caret-down"></i></a>
						</th>
						<th nowrap >{{Lang::get('label.name')}}</th>
						<th nowrap >{{Lang::get('label.sku')}}</th>
						<th nowrap >{{Lang::get('label.price')}}</th>
						<th nowrap >{{Lang::get('label.status')}}</th>
						<th nowrap >{{Lang::get('label.total_quantity')}}</th>
						<th nowrap >{{Lang::get('label.available_quantity')}}</th>

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
							{{Form::select('status',array(''=>'All',0=>'Disable',1=>'Enable'),Input::get('status'),array('class'=>'form-control'))}}
						</td>
						<td class="hasinput">
							{{Form::text('total_qty',Input::get('total_qty'),array('class'=>'form-control','placeholder'=>Lang::get('label.total_quantity')))}}
						</td>
						<td class="hasinput">
							{{Form::text('available_qty',Input::get('available_qty'),array('class'=>'form-control','placeholder'=>Lang::get('label.available_quantity')))}}
						</td>
						<td></td>
						{{Form::close()}}
					</tr>
					</thead>
					<tbody>
					@foreach($rows as $row)
						{{Form::open(array('route'=>'warehouseProduct.update_qty','method'=>'post'))}}
						{{Form::hidden('id',$row->id)}}
						<tr>
							<td>{{$row->product->seq_no}}</td>
							<td>{{$row->product->name}}</td>
							<td>{{$row->product->sku}}</td>
							<td>{{$row->product->price}}</td>
							<td>@if($row->product->status==1) {{'Enable'}} @else {{'Disable'}} @endif</td>
							<td class="hasinput">
								{{Form::text('total_qty',$row->total_qty,array('class'=>'form-control input-search-ajax'))}}
							</td>
							<td>{{$row->available_qty}}</td>
							<td>
								<button class="btn btn-primary" type="submit"><i class="fa fa-check"></i></button>
							</td>
						</tr>
						{{Form::close()}}
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
							'status' =>Input::get('status'),
							'total_qty' =>Input::get('total_qty'),
							'available_qty' =>Input::get('available_qty')
						))->links() }}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>