{{Form::open(array('route'=>'roles.list','method'=>'get'))}}
<div class="row">
	<div class="col-lg-12">
		<div class="ibox-title">
	        <h5>{{ Lang::get('label.role_manager_title') }}</h5>
	    </div>
		<div class="ibox-content">
			<div class="">
			<?php $uri_config=array('uri'=>'roles','link'=>'create'); ?>
			@include('_partial._global_bar')
			</div>
			<div class="" style="margin-top: 10px">
    		    <table class="table table-striped table-bordered table-hover dataTables-example">
				<thead>

					<tr>
						<th>#</th>
						<th>{{ Lang::get('role.role_name');BaseModel::renderHtmlSort('role_name','RolesController@getIndex')}}</th>
						<th>{{ Lang::get('label.created_at');BaseModel::renderHtmlSort('created_at','RolesController@getIndex') }}</th>
						<th>{{ Lang::get('label.updated_at');BaseModel::renderHtmlSort('updated_at','RolesController@getIndex') }}</th>
						<th></th>
					</tr>
					<tr role="row">

                            <td class="hasinput">
                                {{Form::text('seq_no',Input::get('seq_no'),array('class'=>'form-control','placeholder'=>'Eg:2;2>4'))}}
                            </td>
                            <td class="hasinput">
                                {{Form::text('role_name',Input::get('role_name'),array('class'=>'form-control','placeholder'=>'Role '.Lang::get('role.role_name')))}}
                            </td>
                            <td class="hasinput">
                                {{Form::text('created_at',Input::get('created_at'),array('class'=>'form-control','placeholder'=>Lang::get('label.created_at')))}}
                            </td>
                            <td class="hasinput">
                                {{Form::text('updated_at',Input::get('updated_at'),array('class'=>'form-control','placeholder'=>Lang::get('label.updated_at')))}}
                            </td>
                            <td style="min-width: 56px">

                            </td>

                        </tr>
				</thead>
				<tbody>
				@foreach($rows as $row)
					<tr>
						<td>{{ isset($row->seq_no)?$row->seq_no:'' }}</td>
						<td>{{ $row->role_name }}</td>
						<td>{{ date('h:i:s d/m/Y',strtotime($row->created_at)) }}</td>
						<td>{{ date('h:i:s d/m/Y',strtotime($row->updated_at)) }}</td>
						<td>
							<a href="{{ URL::route('roles.update',array('id'=>$row->id)) }}"><i class="fa fa-pencil-square-o"></i></a> |
							<a href="{{ URL::route('permissions.update',array('role_id'=>$row->id)) }}"><i class="fa fa-user"></i></a> |
							<a href="{{ URL::route('roles.delete',array('id'=>$row->id)) }}" onclick="return confirm('You sure?')"> <i class="fa fa-times"></i></a>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
			</div>
			<div class="row">
	            <div class="col-sm-6 text-right">
	                <div class="dataTables_paginate paging_bootstrap_full">
	                    {{ //$rows->addQuery('order',Input::get('order'))->addQuery('sort', Input::get('sort'))->links()
	                        $rows->appends(array(
	                            'seq_no' =>Input::get('seq_no'),
	                            'role_name' =>Input::get('role_name'),
	                            'created_at' =>Input::get('created_at'),
	                            'updated_at' =>Input::get('updated_at'),
	                            'sort' =>Input::get('sort'),
	                            'order' =>Input::get('order'),)
	                        )->links()}}
	                </div>
	            </div>
	        </div>
        </div>
	</div>
</div>
{{Form::close()}}