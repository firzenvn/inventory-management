{{Form::open(array('route'=>'customer-groups.list','method'=>'get'))}}
<div class="row">
	<div class="col-lg-12">
        <div class="ibox-title">
            <h5>{{ Lang::get('customerGroup.title') }}</h5>
        </div>

		<!-- widget div-->
    	<div class="ibox-content">
    	    <div>
    	    <?php $uri_config=array('uri'=>'customer-groups','link'=>'create'); ?>
        	@include('_partial._global_bar')
        	</div>

    		<!-- widget content -->
    		<div style="margin-top: 10px">

    				<table class="table table-bordered">
				<thead>

					<tr>
						<th>#</th>
						<th>{{ Lang::get('customerGroup.name');BaseModel::renderHtmlSort('name','CustomerGroupController@getIndex')}}</th>
						<th>{{ Lang::get('customerGroup.status');BaseModel::renderHtmlSort('status','CustomerGroupController@getIndex') }}</th>
						<th></th>
					</tr>
					<tr role="row">

                            <td class="hasinput">
                                {{Form::text('seq_no',Input::get('seq_no'),array('class'=>'form-control','placeholder'=>'Eg:2;2>4'))}}
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
						<td>{{ isset($row->seq_no)?$row->seq_no:'' }}</td>
						<td>{{ $row->name }}</td>
						<td>{{ $row->status==1?'Enable':'Disable'}}</td>
						<td>
							<a href="{{ URL::route('customer-groups.update',array('id'=>$row->id)) }}"><i class="fa fa-pencil-square-o"></i></a> |
							<a href="{{ URL::route('customer-groups.delete',array('id'=>$row->id)) }}" onclick="return confirm('You sure?')"> <i class="fa fa-times"></i></a>
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