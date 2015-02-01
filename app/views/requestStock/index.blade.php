<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Stock Sending Manager</h5>
				<div class="ibox-tools">
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
				</div>
			</div>
			<div class="ibox-content">

				{{Form::open(array('route'=>'requestStock.index','method'=>'get'))}}
				<div class="">
					<a href="{{URL::route('requestStock.create')}}" class="btn btn-primary">Create Request Stock</a>

					<div class="pull-right">
						<a class="btn btn-sm btn-default" href="{{URL::route('requestStock.default')}}">Reset</a>
						{{Form::submit('Search',array('class'=>'btn btn-primary'))}}
					</div>
				</div>
				<table class="table table-striped table-bordered table-hover dataTables-example" >
					<thead>
					<tr>
						<th nowrap >{{Lang::get('label.id')}}</th>
						<th nowrap >{{Lang::get('label.source')}}</th>
						<th nowrap >{{Lang::get('label.destination_warehouse')}}</th>
						<th nowrap >{{Lang::get('label.created_on')}}</th>
						<th nowrap >{{Lang::get('label.created_by')}}</th>
						<th nowrap >{{Lang::get('label.status')}}</th>

						<th style="width: 9%;" ></th>
					</tr>
					<tr role="row">
						<td class="hasinput">
							{{Form::text('seq_no',Input::get('seq_no'),array('class'=>'form-control','placeholder'=>Lang::get('label.id')))}}
						</td>
						<td class="hasinput">
							{{Form::text('source_warehouse',Input::get('source_warehouse'),array('class'=>'form-control','placeholder'=>Lang::get('label.source')))}}
						</td>
						<td class="hasinput">
							{{Form::text('destination_warehouse',Input::get('destination_warehouse'),array('class'=>'form-control','placeholder'=>Lang::get('label.destination_warehouse')))}}
						</td>
						<td class="hasinput">
							{{Form::text('created_on_from',Input::get('created_on_from'),array('class'=>'form-control','placeholder'=>Lang::get('label.from')))}}
							{{Form::text('created_on_to',Input::get('created_on_to'),array('class'=>'form-control','placeholder'=>Lang::get('label.to')))}}
						</td>
						<td class="hasinput">
							{{Form::text('created_by',Input::get('created_by'),array('class'=>'form-control','placeholder'=>Lang::get('label.created_by')))}}
						</td>
						<td class="hasinput">
							{{Form::select('status',array(''=>'All',0=>'Init',1=>'Processing',2=>'Complete'),Input::get('status'),array('class'=>'form-control'))}}
						</td>
						<td></td>
						{{Form::close()}}
					</tr>
					</thead>
					<tbody>
					@foreach($rows as $row)
						<tr>
							<td>{{$row->seq_no}}</td>
							<td>{{$row->source->name}}</td>
							<td>{{$row->destination->name}}</td>
							<td>{{$row->created_at}}</td>
							<td>{{$row->created_by}}</td>
							<td>@if($row->status==1) {{'Processing'}} @elseif($row->status==2) {{'Complete'}} @else {{'Init'}} @endif</td>
							<td>
								<a href="#"><i class="fa fa-pencil-square-o"></i> Edit</a>
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
							'seq_no' =>Input::get('seq_no'),
							'source_warehouse' =>Input::get('source_warehouse'),
							'destination_warehouse' =>Input::get('destination_warehouse'),
							'created_on_from' =>Input::get('created_on_from'),
							'created_on_to' =>Input::get('created_on_to'),
							'created_by' =>Input::get('created_by'),
							'status' =>Input::get('status'),
						))->links() }}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>