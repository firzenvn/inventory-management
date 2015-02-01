{{Form::open(array('route'=>'admin.customer-groups.list','method'=>'get'))}}
<div class="row">
	<div class="col-lg-12">
        <div class="ibox-title">
            <h5>{{ Lang::get('customerGroup.title') }}</h5>
        </div>

		<!-- widget div-->
    	<div class="ibox-content">
    	    <div>
			<div class="clear">
				<div class="pull-right">
					<a class="btn btn-sm btn-default" href="{{URL::route('admin.customer-groups.list')}}">Reset</a>
					{{Form::submit('Search',array('class'=>'btn btn-sm btn-primary'))}}
				</div>
			</div>
        	</div>

    		<!-- widget content -->
    		<div style="margin-top: 10px">

    				<table class="table table-bordered">
				<thead>

					<tr>
						<th>#</th>
						<th>{{ Lang::get('label.client_id');BaseModel::renderHtmlSort('name','CustomerGroupAdminController@getIndex')}}</th>
						<th>{{ Lang::get('customerGroup.name');BaseModel::renderHtmlSort('name','CustomerGroupAdminController@getIndex')}}</th>
						<th>{{ Lang::get('customerGroup.status');BaseModel::renderHtmlSort('status','CustomerGroupAdminController@getIndex') }}</th>
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
                                {{Form::text('name',Input::get('name'),array('class'=>'form-control','placeholder'=>Lang::get('customerGroup.name')))}}
                            </td>
                            <td class="hasinput">
                                {{Form::select('status',array(''=>'All','0'=>'Disable','1'=>'Enable'),Input::get('status'),array('class'=>'form-control','placeholder'=>Lang::get('customerGroup.status')))}}
                            </td>
                            <td style="min-width: 56px">

                            </td>

                        </tr>
				</thead>
				<tbody>
				@foreach($rows as $row)
					<tr>
						<td>{{ $row->id }}</td>
						<td>{{ $row->client_id }}</td>
						<td>{{ $row->name }}</td>
						<td>{{ $row->status==1?'Enable':'Disable'}}</td>
						<td>
							<a href="{{ URL::route('admin.customer-groups.update',array('id'=>$row->id)) }}"><i class="fa fa-pencil-square-o"></i></a> |
							<a href="{{ URL::route('admin.customer-groups.delete',array('id'=>$row->id)) }}" onclick="return confirm('You sure?')"> <i class="fa fa-times"></i></a>
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
                            'name' =>Input::get('name'),
                            'status' =>Input::get('status'),
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