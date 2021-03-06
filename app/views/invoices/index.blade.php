<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>{{ Lang::get('orders.invoice') }}</h2>
    </div>
    <div class="col-lg-4">
        <div class="title-action">
            {{Form::button('Back',array('class'=>'btn btn-white','onclick'=>'window.history.back();'))}}
            {{--<a href="#" class="btn btn-white"><i class="fa fa-check "></i> Save</a>--}}
            {{--<a href="invoice_print.html" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Print Invoice </a>--}}
        </div>
    </div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>{{ Lang::get('orders.order') }} #  {{ $order_id }}</h5>
			</div>
			<div class="ibox-content">
				<div>
	                {{Form::open(array('route'=>'invoices.list','method'=>'get'))}}
					<a href="{{ URL::route('invoices.create.get',array('order_id' => $order_id)) }}"  class="btn btn-sm btn-info">Create</a>
	                <div class="pull-right">
	                    {{--<a class="btn btn-sm btn-default" href="{{URL::route('invoices.list')}}">Reset</a>--}}
	                    {{--{{Form::submit('Search',array('class'=>'btn btn-sm btn-primary'))}}--}}
	                </div>
	            </div>
				<div class="widget-body">
	                <div class="table-responsive">

	                <table class="table table-bordered dataTable">
	                    <thead>
	                    <tr>
	                        <th>
                                {{ Lang::get('orders.no') }}
                                {{--<a href="{{URL::route('invoices.list', array('sort' => 'id', 'order' => 'desc'))}}"><i class="fa fa-caret-up"></i></a>--}}
                                {{--<a href="{{URL::route('invoices.list', array('sort' => 'id', 'order' => 'asc'))}}"><i class="fa fa-caret-down"></i></a>--}}
                            </th>

                            <th>{{ Lang::get('orders.bill_to_name') }}</th>
                            <th>{{ Lang::get('orders.invoice_date') }}
                                {{--<a href="{{URL::route('invoices.list', array('sort' => 'created_at', 'order' => 'desc'))}}"><i class="fa fa-caret-up"></i></a>--}}
                                {{--<a href="{{URL::route('invoices.list', array('sort' => 'created_at', 'order' => 'asc'))}}"><i class="fa fa-caret-down"></i></a>--}}
                            </th>
                            <th>
                                {{ Lang::get('orders.amount') }}
                                {{--<a href="{{URL::route('invoices.list', array('sort' => 'paid_total', 'order' => 'desc'))}}"><i class="fa fa-caret-up"></i></a>--}}
                                {{--<a href="{{URL::route('invoices.list', array('sort' => 'paid_total', 'order' => 'asc'))}}"><i class="fa fa-caret-down"></i></a>--}}
                            </th>
                             <th style="width: 11%;"></th>
	                    </tr>
	                    <tr role="row" style="display: none">
	                        <td class="hasinput">
	                            {{Form::text('id',Input::get('id'),array('class'=>'form-control','placeholder'=>'ID'))}}
	                        </td>
	                        <td class="hasinput">
                                {{Form::text('bill_to_name',Input::get('bill_to_name'),array('class'=>'form-control','placeholder'=>'Name'))}}
                            </td>
	                        <td class="hasinput">
								{{Form::text('invoice_date',Input::get('invoice_date'),array('class'=>'form-control datepicker','placeholder'=> Lang::get('orders.invoice_date')))}}
	                        </td>

	                        <td class="hasinput">
	                            {{Form::text('amount',Input::get('amount'),array('class'=>'form-control','placeholder'=> Lang::get('orders.amount') ))}}
	                        </td>
	                        <td></td>
	                        {{--<td class="hasinput">--}}
	                            {{--{{Form::select('status',Config::get('constant.order_status'),Input::get('status'),array('class'=>'form-control'))}}--}}
	                        {{--</td>--}}
	                    {{Form::close()}}
	                    </tr>

	                    </thead>
	                    <tbody>
	                    @foreach($rows as $row)

	                    <tr>
	                        <td>{{$row->seq_no}}</td>
	                        <td>{{$row->order->customer->first_name}}</td>
	                        <td>{{$row->created_at}}</td>
	                        <td>{{ number_format($row->paid_total,0)}}</td>
	                        <td>
                                <a href="{{URL::route('invoices.view.get',array('id'=>$row->id))}}"><i class="fa fa-eye"></i> View</a>
                            </td>
{{--	                        <td>{{$row->status}}</td>--}}
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
	                                'bill_to_name' =>Input::get('bill_to_name'),
	                                'invoice_date' =>Input::get('invoice_date'),
	                                'amount' =>Input::get('amount'),
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