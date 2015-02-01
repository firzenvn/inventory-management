<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Warehouses</h5>
				<div class="ibox-tools">
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
				</div>
			</div>
			<div class="ibox-content">
			{{Form::open(array('route'=>'admin.warehouse.list','method'=>'get'))}}
			<div class="">
				<div class="pull-right">
					<a class="btn btn-sm btn-default" href="{{URL::route('admin.warehouse.list')}}">Reset</a>
					{{Form::submit('Search',array('class'=>'btn btn-primary'))}}
				</div>
			</div>
			<table class="table table-striped table-bordered table-hover dataTables-example" >
				<thead>
				<tr>
					<th>
						{{Lang::get('label.id')}}
						<a href="{{URL::route('admin.warehouse.list', array('sort' => 'seq_no', 'order' => 'desc'))}}"><i class="fa fa-caret-up"></i></a>
						<a href="{{URL::route('admin.warehouse.list', array('sort' => 'seq_no', 'order' => 'asc'))}}"><i class="fa fa-caret-down"></i></a>
					</th>
					<th>{{Lang::get('label.client_id')}}</th>
					<th>{{Lang::get('label.name')}}</th>
					<th>{{Lang::get('label.manager_name')}}</th>
					<th>
						{{Lang::get('label.manager_email')}}
						<a href="{{URL::route('admin.warehouse.list', array('sort' => 'manager_email', 'order' => 'desc'))}}"><i class="fa fa-caret-up"></i></a>
						<a href="{{URL::route('admin.warehouse.list', array('sort' => 'manager_email', 'order' => 'asc'))}}"><i class="fa fa-caret-down"></i></a>
					</th>
					<th>
						{{Lang::get('label.phone_no')}}
						<a href="{{URL::route('admin.warehouse.list', array('sort' => 'phone_no', 'order' => 'desc'))}}"><i class="fa fa-caret-up"></i></a>
						<a href="{{URL::route('admin.warehouse.list', array('sort' => 'phone_no', 'order' => 'asc'))}}"><i class="fa fa-caret-down"></i></a>
					</th>
					<th>{{Lang::get('label.street')}}</th>
					<th>{{Lang::get('label.city')}}</th>
					<th>{{Lang::get('label.country')}}</th>
					<th style="width: 9%;">{{Lang::get('label.status')}}</th>
					<th style="width: 9%;">{{Lang::get('label.action')}}</th>
				</tr>
				<tr role="row">
					<td class="hasinput">
						{{Form::text('id',Input::get('id'),array('class'=>'form-control','placeholder'=>Lang::get('label.id') ))}}
					</td>
					<td class="hasinput">
						{{Form::text('client_id',Input::get('client_id'),array('class'=>'form-control','placeholder'=>Lang::get('label.client_id')))}}
					</td>
					<td class="hasinput">
						{{Form::text('name',Input::get('name'),array('class'=>'form-control','placeholder'=>Lang::get('label.name')))}}
					</td>
					<td class="hasinput">
						{{Form::text('manager_name',Input::get('manager_name'),array('class'=>'form-control','placeholder'=>Lang::get('label.manager_name')))}}
					</td>
					<td class="hasinput">
						{{Form::text('manager_email',Input::get('manager_email'),array('class'=>'form-control','placeholder'=>Lang::get('label.manager_email')))}}
					</td>
					<td class="hasinput">
						{{Form::text('phone_no',Input::get('phone_no'),array('class'=>'form-control','placeholder'=>Lang::get('label.phone_no')))}}
					</td>
					<td class="hasinput">
						{{Form::text('street',Input::get('street'),array('class'=>'form-control','placeholder'=>Lang::get('label.street')))}}
					</td>
					<td class="hasinput">
						{{Form::text('city',Input::get('city'),array('class'=>'form-control','placeholder'=>Lang::get('label.city')))}}
					</td>
					<td>
						{{Form::select('country_id',$countries,Input::get('country_id'),array('class'=>'form-control'))}}
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
					<td>{{$row->manager_name}}</td>
					<td>{{$row->manager_email}}</td>
					<td>{{$row->phone_no}}</td>
					<td>{{$row->street}}</td>
					<td>{{$row->city}}</td>
					<td>{{$row->country->name}}</td>
					<td>@if($row->status==1) {{'Enable'}} @else {{'Disable'}} @endif</td>
					<td>
						<a href="{{URL::route('admin.warehouse.update.get',array('id'=>$row->id))}}"><i class="fa fa-pencil-square-o"></i> Edit</a>
						<a href="{{URL::route('admin.warehouse.delete',array('id'=>$row->id))}}" onclick="return confirm('You sure?')"> <i class="fa fa-times"></i>Delete</a>
					</td>
				</tr>
				@endforeach

				</tbody>
			</table>

			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="dataTables_paginate paging_simple_numbers" id="editable_paginate">
						{{ $rows->appends(array(
							'id' =>Input::get('id'),
							'name' =>Input::get('name'),
							'manager_name' =>Input::get('manager_name'),
							'manager_email' =>Input::get('manager_email'),
							'phone_no' =>Input::get('phone_no'),
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