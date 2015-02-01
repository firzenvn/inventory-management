{{Form::open(array('route'=>'admin.client-users.list','method'=>'get'))}}
<div class="row">
	<div class="col-lg-12">
        <div class="ibox-title">
            <h5>{{ Lang::get('label.client_user_manager_title') }}</h5>
        </div>
        <div class="ibox-content">
        <div class="">
		<?php $uri_config=array('uri'=>'client-users','link'=>'create'); ?>
        @include('_partial._global_bar')
        </div>
		<!-- widget div-->
    	<div style="margin-top: 10px">
    		<!-- widget content -->
    			<table class="table table-bordered">
				<thead>

					<tr>
						<th>#</th>
						<th>{{ Lang::get('label.client_id'); }}</th>
						<th>{{ Lang::get('client-user.client_user_username'); }}</th>
						<th>{{ Lang::get('client-user.client_user_first_name'); }}</th>
						<th>{{ Lang::get('client-user.client_user_last_name'); }}</th>
						<th>{{ Lang::get('client-user.client_user_email');BaseModel::renderHtmlSort('email','ClientUsersController@getIndex') }}</th>
						<th>{{ Lang::get('client-user.client_user_role');BaseModel::renderHtmlSort('email','ClientUsersController@getIndex') }}</th>
						<th>{{ Lang::get('client-user.client_user_phone');BaseModel::renderHtmlSort('phone','ClientUsersController@getIndex') }}</th>
						<th></th>
					</tr>
					<tr role="row">
                            <td class="hasinput">
                                {{Form::text('id',Input::get('id'),array('class'=>'form-control','placeholder'=>'Eg:2;2>4'))}}
                            </td>
                            <td class="hasinput">
								{{Form::text('client_id',Input::get('client_id'),array('class'=>'form-control','placeholder'=>Lang::get('label.client_id')))}}
							</td>
                            <td class="hasinput">
                                {{Form::text('username',Input::get('username'),array('class'=>'form-control','placeholder'=>'user name'))}}
                            </td>
                            <td class="hasinput">
                                {{Form::text('first_name',Input::get('first_name'),array('class'=>'form-control','placeholder'=>'first name'))}}
                            </td>
                            <td class="hasinput">
                                {{Form::text('last_name',Input::get('last_name'),array('class'=>'form-control','placeholder'=>'last name'))}}
                            </td>

                            <td class="hasinput">
                                {{Form::text('email',Input::get('email'),array('class'=>'form-control','placeholder'=>'email'))}}
                            </td>
                             <td class="hasinput">
                                {{Form::text('role',Input::get('role'),array('class'=>'form-control','placeholder'=>'role'))}}
                            </td>
                            <td class="hasinput">
                                {{Form::text('phone',Input::get('phone'),array('class'=>'form-control','placeholder'=>'phone'))}}
                            </td>
                            <td style="min-width: 56px">

                            </td>

                        </tr>
				</thead>
				<tbody>
				@foreach($rows as $row)
					<tr>
						<td>{{ isset($row->id)?$row->id:'' }}</td>
						<td>{{ $row->client_id }}</td>
						<td>{{ $row->username }}</td>
						<td>{{ $row->first_name}}</td>
						<td>{{$row->last_name }}</td>
						<td>{{{ $row->email?$row->email:'' }}}</td>
						<td>{{{ isset($row->roleUser->role->role_name)?$row->roleUser->role->role_name:'' }}}</td>
						<td>{{{ $row->phone?$row->phone:'' }}}</td>
						<td>
							<a href="{{ URL::route('admin.client-users.update',array('id'=>$row->id)) }}"><i class="fa fa-pencil-square-o"></i></a> |
							<a href="{{ URL::route('admin.client-users.delete',array('id'=>$row->id)) }}" onclick="return confirm('You sure?')"> <i class="fa fa-times"></i></a>
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
                         'username' =>Input::get('username'),
                         'email' =>Input::get('email'),
                         'phone' =>Input::get('phone'),
                         'first_name' =>Input::get('first_name'),
                         'last_name' =>Input::get('last_name'),
                       //  'created_at' =>Input::get('created_at'),
                        // 'updated_at' =>Input::get('updated_at'),
                         'sort' =>Input::get('sort'),
                         'order' =>Input::get('order'),)
                       )->links()
                    }}
                </div>
            </div>
        </div>
		</div>
	</div>

</div>
{{Form::close()}}