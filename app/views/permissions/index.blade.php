{{Form::open(array('route'=>'permissions.list','method'=>'get'))}}
<div class="row">
	<div class="col-lg-12">
        <div class="ibox-title">
            <h5>{{ Lang::get('label.permission_manager_title') }}</h5>
        </div>
        <div class="ibox-content">
        <div class="">
		<?php $uri_config=array('uri'=>'permissions','link'=>''); ?>
    	@include('_partial._global_bar')
    	</div>
		<!-- widget div-->
    	<div style="margin-top: 10px">
    		<!-- widget content -->
    				<table class="table table-bordered">
				<thead>
					<tr>
						<th>{{ Lang::get('permission.role_id');BaseModel::renderHtmlSort('role_id','PermissionsController@getIndex') }}</th>
						<th>{{ Lang::get('permission.type');BaseModel::renderHtmlSort('type','PermissionsController@getIndex') }}</th>
						<th>{{ Lang::get('permission.action');BaseModel::renderHtmlSort('action','PermissionsController@getIndex') }}</th>
						<th>{{ Lang::get('permission.resource');BaseModel::renderHtmlSort('resource','PermissionsController@getIndex') }}</th>
						<th>{{ Lang::get('label.created_at');BaseModel::renderHtmlSort('created_at','PermissionsController@getIndex') }}</th>
						<th>{{ Lang::get('label.updated_at');BaseModel::renderHtmlSort('updated_at','PermissionsController@getIndex') }}</th>
						<th></th>
					</tr>
					<tr role="row">
                            <td class="hasinput">
                                {{Form::text('role_id',Input::get('role_id'),array('class'=>'form-control','placeholder'=>'Role name'))}}
                            </td>
                            <td class="hasinput">
                            <?php
								$arr_type=array_merge(array(''=>'== Select one =='),Config::get('constant.permission_types')); ?>
                                {{Form::select('type',$arr_type,Input::get('type'),array('class'=>'form-control','placeholder'=>'type'))}}
                            </td>
                            <td class="hasinput">
                                <?php
                                 $arr_action=array_merge(array(''=>'== Select one =='),Config::get('constant.permission_actions')); ?>
                                {{Form::select('action',$arr_action,Input::get('action'),array('class'=>'form-control','placeholder'=>'action'))}}
                            </td>
                            <td class="hasinput">
                             {{Form::select('resource',Resource::getResoureToArray(),Input::get('resource'),array('class'=>'form-control','placeholder'=>'resource'))}}
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
						<td>{{ $row->role->role_name }}</td>
						<td>{{{ $row->type?$row->type:'' }}}</td>
						<td>{{{ $row->action?$row->action:'' }}}</td>
						<td>{{{ $row->resource?$row->resource:'' }}}</td>
						<td>{{ date('h:i:s d/m/Y',strtotime($row->created_at)) }}</td>
						<td>{{ date('h:i:s d/m/Y',strtotime($row->updated_at)) }}</td>
						<td>
							<a href="{{ URL::route('permissions.update',array('role_id'=>$row->role_id)) }}"><i class="fa fa-pencil-square-o"></i></a> |
							<a href="{{ URL::route('permissions.delete',array('role_id'=>$row->role_id)) }}" onclick="return confirm('You sure?')"> <i class="fa fa-times"></i></a>

						</td>
					</tr>
				@endforeach
				</tbody>
			</table>

		<div class="row">
            <div class="col-sm-6 text-right">
                <div class="dataTables_paginate paging_bootstrap_full">
                    {{ //$rows->addQuery('order',Input::get('order'))->addQuery('sort', Input::get('sort'))->links()
                        $rows->appends(array(
	                         'role_id' =>Input::get('role_id'),
	                         'type' =>Input::get('type'),
	                         'action' =>Input::get('action'),
	                         'resource' =>Input::get('resource'),
	                         'created_at' =>Input::get('created_at'),
	                         'updated_at' =>Input::get('updated_at'),
	                         'sort' =>Input::get('sort'),
	                         'order' =>Input::get('order'),)
	                     )->links();
                    }}
                </div>
            </div>
		</div>
	</div>
	</div>
	</div>
</div>
{{Form::close()}}