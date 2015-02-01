<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>{{ Lang::get('orders.order') }}</h2>
    </div>
    <div class="col-lg-4">
        <div class="title-action">
            {{--<a href="#" class="btn btn-white"><i class="fa fa-check "></i> Save</a>--}}
            {{--<a href="invoice_print.html" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Print Invoice </a>--}}
        </div>
    </div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>{{ Lang::get('orders.order_title') }}</h5>
			</div>
			<div class="ibox-content">
				<div>
	                {{Form::open(array('route'=>'orders.list','method'=>'get'))}}
	                <a href="{{ URL::route('orders.create') }}"  class="btn btn-sm btn-info">Create</a>
	                <div class="pull-right">
	                    <a class="btn btn-sm btn-default" href="{{URL::route('orders.list')}}">Reset</a>
	                    {{Form::submit('Search',array('class'=>'btn btn-sm btn-primary'))}}
	                </div>
	            </div>
				<div class="widget-body">
	                <div class="table-responsive">

	                <table class="table table-bordered dataTable">
	                    <thead>
	                    <tr>
	                        <th>
	                            {{ Lang::get('orders.no') }}
	                            <a href="{{URL::route('orders.list', array('sort' => 'id', 'order' => 'desc'))}}"><i class="fa fa-caret-up"></i></a>
	                            <a href="{{URL::route('orders.list', array('sort' => 'id', 'order' => 'asc'))}}"><i class="fa fa-caret-down"></i></a>
	                        </th>
	                        <th style="width: 13%;">{{ Lang::get('orders.purchased_on') }}
	                            <a href="{{URL::route('orders.list', array('sort' => 'purchased_on', 'order' => 'desc'))}}"><i class="fa fa-caret-up"></i></a>
	                            <a href="{{URL::route('orders.list', array('sort' => 'purchased_on', 'order' => 'asc'))}}"><i class="fa fa-caret-down"></i></a>
	                        </th>
	                        <th>{{ Lang::get('orders.bill_to_name') }}</th>
	                        <th>{{ Lang::get('orders.ship_to_name') }}</th>
	                        <th>
	                            {{ Lang::get('orders.gt_base') }}
	                            <a href="{{URL::route('orders.list', array('sort' => 'base_grand_total', 'order' => 'desc'))}}"><i class="fa fa-caret-up"></i></a>
	                            <a href="{{URL::route('orders.list', array('sort' => 'base_grand_total', 'order' => 'asc'))}}"><i class="fa fa-caret-down"></i></a>
	                        </th>
	                        <th>
	                            {{ Lang::get('orders.gt_purchased') }}
	                            <a href="{{URL::route('orders.list', array('sort' => 'purchased_grand_total', 'order' => 'desc'))}}"><i class="fa fa-caret-up"></i></a>
	                            <a href="{{URL::route('orders.list', array('sort' => 'purchased_grand_total', 'order' => 'asc'))}}"><i class="fa fa-caret-down"></i></a>
	                        </th>

	                        <th>{{ Lang::get('label.status') }}</th>
	                        <th style="width:8%;"></th>
	                        <th style="width: 11%;"></th>
	                    </tr>
	                    <tr role="row">
	                        <td class="hasinput">
	                            {{Form::text('seq_no',Input::get('seq_no'),array('class'=>'form-control','placeholder'=>Lang::get('orders.no')))}}
	                        </td>
	                        <td class="hasinput">
	                            {{Form::text('purchased_on[from]',Input::get('purchased_on')['from'],array('class'=>'form-control datepicker','placeholder'=>'From'))}}
	                            {{Form::text('purchased_on[to]',Input::get('purchased_on')['to'],array('class'=>'form-control datepicker','placeholder'=>'To'))}}
	                        </td>
	                        <td class="hasinput">
	                            {{Form::text('bill_customer',Input::get('bill_customer'),array('class'=>'form-control','placeholder'=>'Name'))}}
	                        </td>
	                        <td class="hasinput">
	                            {{Form::text('ship_customer',Input::get('ship_customer'),array('class'=>'form-control','placeholder'=>'Name'))}}
	                        </td>
	                        <td class="hasinput">
	                            {{Form::text('gtb',Input::get('gtb'),array('class'=>'form-control','placeholder'=>'G.T(Base)'))}}
	                            {{--{{Form::text('gtb_from',Input::get('gtb_from'),array('class'=>'form-control','placeholder'=>'Manage Name'))}}--}}
	                            {{--{{Form::text('gtb_to',Input::get('gtb_to'),array('class'=>'form-control','placeholder'=>'Manage Name'))}}--}}
	                        </td>
	                        <td class="hasinput">
	                            {{Form::text('gtp',Input::get('gtp'),array('class'=>'form-control','placeholder'=>'G.T(Purchased)'))}}
	                            {{--{{Form::text('gtp_from',Input::get('gtp_from'),array('class'=>'form-control','placeholder'=>'Manage Email'))}}--}}
	                            {{--{{Form::text('gtp_to',Input::get('gtp_to'),array('class'=>'form-control','placeholder'=>'Manage Email'))}}--}}
	                        </td>

	                        <td class="hasinput">
	                            {{Form::select('status',Config::get('constant.order_status'),Input::get('status'),array('class'=>'form-control'))}}
	                        </td>
	                        <td></td>
	                        <td></td>
	                    {{Form::close()}}
	                    </tr>

	                    </thead>
	                    <tbody>
	                    @foreach($rows as $row)
	                    <tr>
	                        <td>{{$row->seq_no}}</td>
	                        <td>{{$row->purchased_on}}</td>
	                        <td>{{$row->customer->first_name}}</td>
	                        <td>{{$row->customer->first_name}}</td>
	                        <td>{{ number_format($row->base_grand_total,0) }}</td>
	                        <td>{{ number_format($row->purchased_grand_total,0 )}}</td>
	                        <td>{{ Config::get('constant.order_status')[$row->status] }}</td>
	                        <td>
	                            <a class="" href="{{URL::route('invoices.list',array('order_id'=>$row->id))}}" ><i class="fa fa-paste"></i>{{ Lang::get('orders.invoice') }}</a>
                                <a class="" href="{{URL::route('shipments.list',array('order_id'=>$row->id))}}" ><i class="fa fa-paste"></i>{{ Lang::get('orders.ship') }}</a>
	                        </td>
	                        <td>
	                            <a href="{{URL::route('orders.update.get',array('id'=>$row->id))}}"><i class="fa fa-pencil-square-o"></i> Edit</a>
	                            <a href="{{URL::route('orders.delete',array('id'=>$row->id))}}" onclick="return confirm('You sure?')"> <i class="fa fa-times"></i>Delete</a>
	                        </td>
	                    </tr>
	                    @endforeach

	                    </tbody>
	                </table>

	            </div>
                    <div class="row">
	                    <div class="col-sm-6 text-right">
	                        <div class="dataTables_paginate paging_bootstrap_full">
	                            {{ $rows->appends(array(
	                                'id' =>Input::get('id'),
	                                'purchased_on' =>Input::get('purchased_on'),
	                                'bill_customer' =>Input::get('bill_customer'),
	                                'ship_customer' =>Input::get('ship_customer'),
	                                'gtb' =>Input::get('gtb'),
	                                'gtp' =>Input::get('gtp'),
	                                'status' =>Input::get('status')
	                            ))->links() }}
	                        </div>
	                    </div>
	                </div>
	            </div>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
	$('.datepicker').datepicker({
	   format: 'yyyy-mm-dd'
	});
});
</script>