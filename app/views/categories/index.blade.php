<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Categories</h5>
				<div class="ibox-tools">
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
				</div>
			</div>
			<div class="ibox-content">
			{{Form::open(array('route'=>'categories.list','method'=>'get'))}}
			<div class="">
				<a href="{{ URL::route('categories.create') }}"  class="btn btn-primary">Create</a>

				<div class="pull-right">
					<a class="btn btn-sm btn-default" href="{{URL::route('categories.list')}}">Reset</a>
					{{Form::submit('Search',array('class'=>'btn btn-primary'))}}
				</div>
			</div>
			<table class="table table-striped table-bordered table-hover dataTables-example" >
				<thead>
				<tr>
					<th nowrap >
						{{Lang::get('label.id')}}
						<a href="{{URL::route('categories.list', array('sort' => 'seq_no', 'order' => 'desc'))}}"><i class="fa fa-caret-up"></i></a>
						<a href="{{URL::route('categories.list', array('sort' => 'seq_no', 'order' => 'asc'))}}"><i class="fa fa-caret-down"></i></a>
					</th>
					<th nowrap >{{Lang::get('label.category_name')}}</th>
					<th nowrap >{{Lang::get('label.category_description')}}</th>
					<th nowrap >{{Lang::get('label.status')}}</th>
					<th style="width: 9%;" ></th>
				</tr>
				<tr role="row">
						<td class="hasinput">
							{{Form::text('seq_no',Input::get('seq_no'),array('class'=>'form-control','placeholder'=>Lang::get('label.id')))}}
						</td>
						<td class="hasinput">
							{{Form::text('name',Input::get('name'),array('class'=>'form-control','placeholder'=>Lang::get('label.category_name')))}}
						</td>
						<td class="hasinput">
							{{Form::text('description',Input::get('description'),array('class'=>'form-control','placeholder'=>Lang::get('label.category_description')))}}
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
					<td>{{$row->description}}</td>
					<td>@if($row->status==1) {{'Enable'}} @else {{'Disable'}} @endif</td>
					<td>
						<a href="{{URL::route('categories.update.get',array('id'=>$row->id))}}"> <i class="fa fa-pencil-square-o"></i>Edit</a>
						<a href="{{URL::route('categories.delete',array('id'=>$row->id))}}" onclick="return confirm('Are you sure you want to delete this row?')"> <i class="fa fa-times"></i>Delete</a>
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