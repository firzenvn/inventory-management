{{Form::open(array('route'=>'customers.list','method'=>'get'))}}
<div class="row">
	<div class="col-lg-12">
        <div class="ibox-title">
            <h5>{{ Lang::get('adjuststock.title_adjust') }}</h5>
        </div>
        <div class="ibox-content">
        <div>
            <div class="clear">
                        <a href="{{ URL::route('adjuststock.create_adjust') }}" class="btn btn-sm btn-primary">Create</a>
            <div class="pull-right">
	                    <a class="btn btn-sm btn-default" href="{{ URL::route('adjust.list') }}">Reset</a>
	                    <input class="btn btn-sm btn-primary" type="submit" value="Search">
	            </div>
	        </div>
        </div>
		<div style="margin-top: 10px">
    				<table class="table table-bordered">
				<thead>

					<tr>
						<th>#</th>
						<th>{{ Lang::get('adjuststock.warehouse');BaseModel::renderHtmlSort('first_name','CustomersController@getIndex') }}</th>
                        <th>{{ Lang::get('adjuststock.user');BaseModel::renderHtmlSort('last_name','CustomersController@getIndex') }}</th>
                        <th>{{ Lang::get('adjuststock.status');BaseModel::renderHtmlSort('email','CustomersController@getIndex') }}</th>
                        <th>{{ Lang::get('adjuststock.reasons');BaseModel::renderHtmlSort('customer_group_id','CustomersController@getIndex')}}</th>
                        <th></th>
					</tr>
					<tr role="row">

                        <td class="hasinput">
                            {{Form::text('seq_no',Input::get('seq_no'),array('class'=>'form-control','placeholder'=>'Eg:2;2>4'))}}
                        </td>
                        <td class="hasinput">
                            {{Form::text('warehouse',Input::get('first_name'),array('class'=>'form-control','placeholder'=>Lang::get('adjuststock.warehouse')))}}
                        </td>
                        <td class="hasinput">
                            {{Form::text('user',Input::get('last_name'),array('class'=>'form-control','placeholder'=>Lang::get('adjuststock.user')))}}
                        </td>
                        <td class="hasinput">
                            {{Form::text('status',Input::get('email'),array('class'=>'form-control','placeholder'=>Lang::get('adjuststock.status')))}}
                        </td>
                        <td class="hasinput">
                            {{Form::text('reasons',Input::get('customer_group_id'),array('class'=>'form-control','placeholder'=>Lang::get('adjuststock.reasons')))}}
                        </td>
                        <td style="min-width: 56px">
                        </td>

                    </tr>
				</thead>
				<tbody>
				@foreach($rows as $row)
					<tr>
						<td>{{ $row->id }}</td>
						<td>{{ $row->warehouse->name }}</td>
						<td>{{ $row->user->username }}</td>
						<td>{{ $row->status }}</td>
						<td>{{ $row->reasons }}</td>
						<td>
							<a href="{{ URL::route('adjuststock.add_product_adjust.get',array('report_id'=>$row->id)) }}"><i class="fa fa-pencil-square-o"></i></a> |
							<a href="{{ URL::route('adjuststock.delete-adjust',array('id'=>$row->id)) }}" onclick="return confirm('You sure?')"> <i class="fa fa-times"></i></a>
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