{{Form::open(array('route'=>'customers.list','method'=>'get'))}}
<div class="row">
	<div class="col-lg-12">
        <div class="ibox-title">
            <h5>{{ Lang::get('customer.title') }}</h5>
        </div>
        <div class="ibox-content">
        <div >
		<?php $uri_config=array('uri'=>'customers','link'=>'create'); ?>
		@include('_partial._global_bar')
		</div>
		<div style="margin-top: 10px">
    				<table class="table table-bordered">
				<thead>

					<tr>
						<th>#</th>
						<th>{{ Lang::get('customer.first_name');BaseModel::renderHtmlSort('first_name','CustomersController@getIndex') }}</th>
						<th>{{ Lang::get('customer.last_name');BaseModel::renderHtmlSort('last_name','CustomersController@getIndex') }}</th>
						<th>{{ Lang::get('customer.email');BaseModel::renderHtmlSort('email','CustomersController@getIndex') }}</th>
						<th>{{ Lang::get('customer.customer_group_id');BaseModel::renderHtmlSort('customer_group_id','CustomersController@getIndex')}}</th>
						<th>{{ Lang::get('customer.phone_no');BaseModel::renderHtmlSort('phone_no','CustomersController@getIndex') }}</th>
						<th>{{ Lang::get('customer.zipcode');BaseModel::renderHtmlSort('zipcode','CustomersController@getIndex') }}</th>
						<th>{{ Lang::get('customer.city');BaseModel::renderHtmlSort('city','CustomersController@getIndex') }}</th>
						<th>{{ Lang::get('customer.country_id');BaseModel::renderHtmlSort('country_id','CustomersController@getIndex') }}</th>
						<th>{{ Lang::get('customer.province_id');BaseModel::renderHtmlSort('province_id','CustomersController@getIndex') }}</th>
						<th></th>
					</tr>
					<tr role="row">

                        <td class="hasinput">
                            {{Form::text('seq_no',Input::get('seq_no'),array('class'=>'form-control','placeholder'=>'Eg:2;2>4'))}}
                        </td>
                        <td class="hasinput">
                            {{Form::text('first_name',Input::get('first_name'),array('class'=>'form-control','placeholder'=>Lang::get('customer.first_name')))}}
                        </td>
                        <td class="hasinput">
                            {{Form::text('last_name',Input::get('last_name'),array('class'=>'form-control','placeholder'=>Lang::get('customer.last_name')))}}
                        </td>
                        <td class="hasinput">
                            {{Form::text('email',Input::get('email'),array('class'=>'form-control','placeholder'=>Lang::get('customer.email')))}}
                        </td>
                        <td class="hasinput">
                            {{Form::text('customer_group_id',Input::get('customer_group_id'),array('class'=>'form-control','placeholder'=>Lang::get('customer.customer_group_id')))}}
                        </td>
                        <td class="hasinput">
                            {{Form::text('phone_no',Input::get('phone_no'),array('class'=>'form-control','placeholder'=>Lang::get('customer.phone_no')))}}
                        </td>
                        <td class="hasinput">
                            {{Form::text('zipcode',Input::get('zipcode'),array('class'=>'form-control','placeholder'=>Lang::get('customer.zipcode')))}}
                        </td>
                        <td class="hasinput">
                            {{Form::text('city',Input::get('city'),array('class'=>'form-control','placeholder'=>Lang::get('customer.city')))}}
                        </td>
                        <td class="hasinput">
                            {{Form::select('country_id',Country::getCountryToArray(),Input::get('country_id'),array('class'=>'form-control','placeholder'=>Lang::get('customer.country_id')))}}
                        </td>
                        <td class="hasinput">
                            {{Form::text('province_id',Input::get('province_id'),array('class'=>'form-control','placeholder'=>Lang::get('customer.province_id')))}}
                        </td>
                        <td style="min-width: 56px">
                        </td>

                    </tr>
				</thead>
				<tbody>
				@foreach($rows as $row)
					<tr>
						<td>{{ $row->seq_no }}</td>
						<td>{{ $row->first_name }}</td>
						<td>{{ $row->last_name }}</td>
						<td>{{ $row->email }}</td>
						<td>{{ isset($row->group->name)?$row->group->name:'' }}</td>
						<td>{{ $row->phone_no }}</td>
						<td>{{ $row->zipcode }}</td>
						<td>{{ $row->city }}</td>
						<td>{{{ isset($row->country->name)?$row->country->name:'' }}}</td>
						<td>{{{ isset($row->province_id)?$row->province_id:'' }}}</td>

						<td>
							<a href="{{ URL::route('customers.update',array('id'=>$row->id)) }}"><i class="fa fa-pencil-square-o"></i></a> |
							<a href="{{ URL::route('customers.delete',array('id'=>$row->id)) }}" onclick="return confirm('You sure?')"> <i class="fa fa-times"></i></a>
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
                            'first_name' =>Input::get('first_name'),
                            'last_name' =>Input::get('last_name'),
                            'email' =>Input::get('email'),
                            'phone_no' =>Input::get('phone_no'),
                            'customer_group_id' =>Input::get('customer_group_id'),
                            'zipcode' =>Input::get('zipcode'),
                            'city' =>Input::get('city'),
                            'province_id' =>Input::get('province_id'),
                            'country_id' =>Input::get('country_id'),
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