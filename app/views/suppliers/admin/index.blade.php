<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Suppliers</h5>
				<div class="ibox-tools">
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
				</div>
			</div>
			<div class="ibox-content">
			{{Form::open(array('route'=>'admin.suppliers.list','method'=>'get'))}}
			<div class="">
				{{--<a href="{{ URL::route('admin.suppliers.create') }}" class="btn btn-primary ">Add a new row</a>--}}
				<div class="pull-right">
					<a class="btn btn-sm btn-default" href="{{URL::route('admin.suppliers.list')}}">Reset</a>
					{{Form::submit('Search',array('class'=>'btn btn-sm btn-primary'))}}
				</div>
			</div>
			<table class="table table-striped table-bordered table-hover dataTables-example" >
				<thead>
					<tr>
						<th nowrap >
							{{Lang::get('label.id')}}
							<a href="{{URL::route('admin.suppliers.list', array('sort' => 'id', 'order' => 'desc'))}}"><i class="fa fa-caret-up"></i></a>
							<a href="{{URL::route('admin.suppliers.list', array('sort' => 'id', 'order' => 'asc'))}}"><i class="fa fa-caret-down"></i></a>
						</th>
						<th nowrap >{{Lang::get('label.client_id')}}</th>
						<th nowrap >{{Lang::get('label.supplier_name')}}</th>
						<th nowrap >{{Lang::get('label.supplier_person')}}</th>
						<th nowrap >
							{{Lang::get('label.supplier_email')}}
							<a href="{{URL::route('admin.suppliers.list', array('sort' => 'email', 'order' => 'desc'))}}"><i class="fa fa-caret-up"></i></a>
							<a href="{{URL::route('admin.suppliers.list', array('sort' => 'email', 'order' => 'asc'))}}"><i class="fa fa-caret-down"></i></a>
						</th>
						<th nowrap >
							{{Lang::get('label.phone_no')}}
							<a href="{{URL::route('admin.suppliers.list', array('sort' => 'phone_no', 'order' => 'desc'))}}"><i class="fa fa-caret-up"></i></a>
							<a href="{{URL::route('admin.suppliers.list', array('sort' => 'phone_no', 'order' => 'asc'))}}"><i class="fa fa-caret-down"></i></a>
						</th>
						<th nowrap >{{Lang::get('label.fax')}}</th>
						<th nowrap >{{Lang::get('label.street')}}</th>
						<th nowrap >{{Lang::get('label.city')}}</th>
						<th style="width: 8%;" >{{Lang::get('label.status')}}</th>
						<th style="width: 9%;">{{Lang::get('label.action')}}</th>
					</tr>

					<tr role="row">
						<td class="hasinput">
							{{Form::text('id',Input::get('id'),array('class'=>'form-control','placeholder'=>Lang::get('label.id')))}}
						</td>
						<td class="hasinput">
							{{Form::text('id',Input::get('client_id'),array('class'=>'form-control','placeholder'=>Lang::get('label.client_id')))}}
						</td>
						<td class="hasinput">
							{{Form::text('name',Input::get('name'),array('class'=>'form-control','placeholder'=>Lang::get('label.supplier_name')))}}
						</td>
						<td class="hasinput">
							{{Form::text('person',Input::get('person'),array('class'=>'form-control','placeholder'=>Lang::get('label.supplier_person')))}}
						</td>
						<td class="hasinput">
							{{Form::text('email',Input::get('email'),array('class'=>'form-control','placeholder'=>Lang::get('label.supplier_email')))}}
						</td>
						<td class="hasinput">
							{{Form::text('phone_no',Input::get('phone_no'),array('class'=>'form-control','placeholder'=>Lang::get('label.phone_no')))}}
						</td>
						<td class="hasinput">
							{{Form::text('fax',Input::get('fax'),array('class'=>'form-control','placeholder'=>Lang::get('label.fax')))}}
						</td>
						<td class="hasinput">
							{{Form::text('street',Input::get('street'),array('class'=>'form-control','placeholder'=>Lang::get('label.street')))}}
						</td>
						<td class="hasinput">
							{{Form::text('city',Input::get('city'),array('class'=>'form-control','placeholder'=>Lang::get('label.city')))}}
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
					<td>{{$row->id}}</td>
					<td>{{$row->client_id}}</td>
					<td>{{$row->name}}</td>
					<td>{{$row->person}}</td>
					<td>{{$row->email}}</td>
					<td>{{$row->phone_no}}</td>
					<td>{{$row->fax}}</td>
					<td>{{$row->street}}</td>
					<td>{{$row->city}}</td>
					<td>@if($row->status==1) {{'Enable'}} @else {{'Disable'}} @endif</td>
					<td>
						<a href="{{URL::route('admin.suppliers.update.get',array('id'=>$row->id))}}"> <i class="fa fa-pencil-square-o"></i>Edit</a>
						<a href="{{URL::route('admin.suppliers.delete',array('id'=>$row->id))}}" onclick="return confirm('Are you sure you want to delete this row?')"> <i class="fa fa-times"></i>Delete</a>
					</td>
				</tr>
				@endforeach
			</tbody>
			</table>

				<div class="row">
					<div class="col-sm-6">
						<div class="dataTables_paginate paging_simple_numbers" id="editable_paginate">
						{{ $rows->appends(array(
							'id' =>Input::get('id'),
							'name' =>Input::get('name'),
							'person' =>Input::get('person'),
							'email' =>Input::get('email'),
							'phone_no' =>Input::get('phone_no'),
							'fax' =>Input::get('fax'),
							'street' =>Input::get('street'),
							'city' =>Input::get('city'),
							'status' =>Input::get('status')
						))->links() }}
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>