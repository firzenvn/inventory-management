@include('layouts._messages')
{{ Form::hidden('order_id',$order->id)}}
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
                            <h5 style="border-bottom: 1px solid #ccc"><strong><a class="" href="{{URL::route('orders.update.get',array('id'=>$order->id))}}" >{{Lang::get('orders.order')}} # {{$order->id}}</a></strong></h5>
                        </div>
                        <dl class="dl-horizontal">
                            <dt><strong>Order Date:</strong></dt>
                            <dd>{{ $order->purchased_on }}</dd>
                            <dt><strong>Order Status:</strong></dt>
                            <dd>{{ Config::get('constant.order_status')[$order->status] }}</dd>

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
                            <dd>{{$order->customer->group->name}}</dd>
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
                            <th>{{Lang::get('orders.total_price')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($invoice->invoiceItem as $item)
                            <tr>
                                <td>
                                    <div><strong>{{$item->product->name}}</strong></div>
                                    <small><strong>{{Lang::get('label.sku')}} :</strong> {{$item->product->sku}}</small>
                                </td>
                                <td>{{ number_format($item->product->price,0)}}</td>
                                <td class="qty_to_add">
                                    {{ $item->qty_add  }}
                                </td>
                                <td>{{ number_format($item->sub_total,0)}}</td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- /table-responsive -->

                <table class="table invoice-total">
                    <tbody>
                    <tr>
                        <td><strong>{{ Lang::get('orders.sub_total') }} :</strong></td>
                        <td>{{ number_format($invoice->paid_total,0) }}</td>
                    </tr>

                    <tr>
                        <td><strong>{{ Lang::get('orders.total') }} :</strong></td>
                        <td>{{ number_format($invoice->paid_total,0) }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{--@include('javascript.invoiceScript')--}}
 <script type="text/javascript">
 $(document).ready(function(){
 	var customer_info = '{{ json_encode($order->customer->attributesToArray()) }}';
 	$.each($.parseJSON(customer_info), function( key, val ) {
            $(".cus_" + key).html(val);
     });
     //ORDER: SEARCH CUSTOMER
 });
 </script>