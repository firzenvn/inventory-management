<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Sub Categories</h5>
				<div class="ibox-tools">
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
				</div>
			</div>
			<div class="ibox-content">
				{{Form::open(array('route'=>'admin.sub-categories.list','method'=>'get'))}}
				<div class="">
					{{--<a href="{{ URL::route('admin.sub-categories.create') }}"  class="btn btn-primary">Create</a>--}}
					<div class="pull-right">
						<a class="btn btn-sm btn-default" href="{{URL::route('admin.sub-categories.list')}}">Reset</a>
						{{Form::submit('Search',array('class'=>'btn btn-primary'))}}
					</div>
				</div>

				<table class="table table-striped table-bordered table-hover dataTables-example" >
					<thead>
					<tr>
						<th nowrap >
							{{Lang::get('label.id')}}
							<a href="{{URL::route('admin.sub-categories.list', array('sort' => 'id', 'order' => 'desc'))}}"><i class="fa fa-caret-up"></i></a>
							<a href="{{URL::route('admin.sub-categories.list', array('sort' => 'id', 'order' => 'asc'))}}"><i class="fa fa-caret-down"></i></a>
						</th>
						<th nowrap>{{Lang::get('label.client_id')}}</th>
						<th nowrap>{{Lang::get('label.category')}}</th>
						<th nowrap >{{Lang::get('label.sub_category_name')}}</th>
						<th nowrap >{{Lang::get('label.sub_category_description')}}</th>
						<th nowrap >{{Lang::get('label.status')}}</th>
						<th style="width: 9%;" ></th>
					</tr>
					<tr role="row">
							<td class="hasinput">
								{{Form::text('id',Input::get('id'),array('class'=>'form-control','placeholder'=>Lang::get('label.id')))}}
							</td>
							<td class="hasinput">
								{{Form::text('client_id',Input::get('client_id'),array('class'=>'form-control','placeholder'=>Lang::get('label.client_id')))}}
							</td>
							<td class="hasinput">
								{{Form::select('category_id',$categories,Input::get('category_id'),array('class'=>'form-control'))}}
							</td>
							<td class="hasinput">
								{{Form::text('name',Input::get('name'),array('class'=>'form-control','placeholder'=>Lang::get('label.sub_category_name')))}}
							</td>
							<td class="hasinput">
								{{Form::text('description',Input::get('description'),array('class'=>'form-control','placeholder'=>Lang::get('label.sub_category_description')))}}
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
						<td>{{$row->category->name}}</td>
						<td>{{$row->name}}</td>
						<td>{{$row->description}}</td>
						<td>@if($row->status==1) {{'Enable'}} @else {{'Disable'}} @endif</td>
						<td>
							<a href="{{URL::route('admin.sub-categories.update.get',array('id'=>$row->id))}}"> <i class="fa fa-pencil-square-o"></i>Edit</a>
							<a href="{{URL::route('admin.sub-categories.delete',array('id'=>$row->id))}}" onclick="return confirm('Are you sure you want to delete this row?')"> <i class="fa fa-times"></i>Delete</a>
						</td>
					</tr>
					@endforeach

					</tbody>
				</table>

			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="dataTables_paginate paging_simple_numbers">
						{{ $rows->appends(array(
							'id' =>Input::get('id'),
							'category_id' =>Input::get('category_id'),
							'name' =>Input::get('name'),
							'description' =>Input::get('description'),
							'status' =>Input::get('status')
						))->links() }}
					</div>
				</div>
			</div>
		</div>
		<!-- end widget content -->

	</div>
	<!-- end widget div -->

</div>