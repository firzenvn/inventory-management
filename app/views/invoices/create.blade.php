{{ Form::open(array('route'=>'invoices.create', 'autocomplete'=>'off', 'method'=>'post','class'=>'form-horizontal')) }}
@include('layouts._messages')
{{ Form::hidden('order_id',$model->id)}}
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
<div class="row invoice">
    <div class="col-lg-12">
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="ibox-content p-xl">

                <div class="row">
                    <div class="col-sm-6">
                        <div role="panel-heading">
                            <h5 style="border-bottom: 1px solid #ccc"><strong><a class="" href="{{URL::route('orders.update.get',array('id'=>$model->id))}}" >{{Lang::get('orders.order')}} # {{$model->id}}</a></strong></h5>
                        </div>
                        <dl class="dl-horizontal">
                            <dt><strong>Order Date:</strong></dt>
                            <dd>{{ $model->purchased_on }}</dd>
                            <dt><strong>Order Status:</strong></dt>
                            <dd>{{ Config::get('constant.order_status')[$model->status] }}</dd>

                        </dl>
                    </div>
                    <div class="col-sm-6">
                        <div role="panel-heading">
                            <h5 style="border-bottom: 1px solid #ccc"><strong>{{Lang::get('orders.acc_info')}}</strong></h5>
                        </div>
                        <dl class="dl-horizontal">
                            <dt><strong>{{Lang::get('customer.customer_name')}}:</strong></dt>
                            <dd class="cus_first_name"></dd>
                            <dt><strong>{{Lang::get('customer.email')}}:</strong></dt>
                            <dd class="cus_email"></dd>
                            <dt><strong>{{Lang::get('customer.customer_group_id')}}:</strong></dt>
                            <dd>{{$model->customer->group->name}}</dd>
                        </dl>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div role="panel-heading">
                            <h5 style="border-bottom: 1px solid #ccc">{{Lang::get('customer.billing_address')}}</h5>
                        </div>
                        <strong class="cus_first_name"></strong>
                        <address>
                            <span class="cus_address"></span><br>
                            <span class="cus_city"></span> , <span class="cus_zipcode"></span><br>
                            <span  class="cus_province_id"></span><br>
                            <abbr title="Phone" >P: </abbr><span class="cus_phone_no"></span>
                        </address>
                    </div>

                    <div class="col-sm-6 text-left">
                        <div role="panel-heading">
                            <h5 style="border-bottom: 1px solid #ccc">{{Lang::get('customer.shipping_address')}}</h5>
                        </div>
						<strong class="cus_first_name"></strong>
                        <address>
                            <span class="cus_address"></span><br>
                            <span class="cus_city"></span> , <span class="cus_zipcode"></span><br>
                            <span  class="cus_province_id"></span><br>
                            <abbr title="Phone" >P: </abbr><span class="cus_phone_no"></span>
                        </address>
                    </div>
                </div>

                <div class="table-responsive m-t">
                    <table class="table invoice-table">
                        <thead>
                        <tr>
                            <th>{{Lang::get('orders.order_item')}}</th>
                            <th>{{Lang::get('label.price')}}</th>
                            <th>{{Lang::get('label.quantity')}}</th>
                            <th style="width: 20%;">{{Lang::get('orders.qty_to_invoice')}}</th>
                            <th>Total Price</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($model->orderItem as $item)
                            @if($item->qty_to_invoice < $item->qty_add)
                            <tr>
                                <td>
                                    <div><strong>{{$item->product->name}}</strong></div>
                                    <small><strong>{{Lang::get('label.sku')}} :</strong> {{$item->product->sku}}</small>
                                </td>
                                <td>{{number_format($item->product->price,0)}}</td>
                                <td class="qty_to_add">
                                    {{Lang::get('orders.order')}} <strong>{{ $item->qty_add  }}</strong> </br>
                                    {{Lang::get('orders.invoice')}} <strong>{{ $item->qty_to_invoice  }}</strong> </br>
                                </td>

                                <td class="qty_to_invoice">
                                    {{ Form::hidden('product_order_item[]', $item->product_id) }}
                                    {{ Form::number('qty_add['.$item->product_id.']',Input::get('qty_add['.$item->product_id.']',$item->qty_add)  ,array('style'=>'width: 25%','min'=>0,'max'=>($item->qty_add - $item->qty_to_invoice))) }}
                                </td>
                                <td>{{ number_format($item->product->price * $item->qty_add,0)}}</td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- /table-responsive -->

                <table class="table invoice-total">
                    <tbody>
                    <tr>
                        <td><strong>{{ Lang::get('orders.sub_total') }} :</strong></td>
                        <td>{{ number_format($model->base_grand_total,0) }}</td>
                    </tr>

                    <tr>
                        <td><strong>{{ Lang::get('orders.total') }} :</strong></td>
                        <td>{{ number_format($model->base_grand_total,0) }}</td>
                    </tr>
                    </tbody>
                </table>
                <div class="text-right">
                    <button class="btn btn-primary" type="submit"><i class="fa fa-dollar"></i> Make A Payment</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{ Form::close() }}

@include('javascript.invoiceScript')
