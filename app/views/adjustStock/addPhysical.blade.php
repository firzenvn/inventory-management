{{ HTML::script('js/plugins/papaparse/papaparse.js')}}
{{ HTML::script('js/inventory/custom-script.js')}}
<div class="row" style="margin-bottom: 20px">
	<div class="col-lg-12">
		<div class="ibox-title">
			<h5>{{ Lang::get('adjuststock.physical_stocktaking') }}</h5>
		</div>
		<div class="ibox-content">
			<div class="" style="margin-top: 10px">
				{{ Form::open(array('action'=>'adjustStock.add_product_phy', 'autocomplete'=>'off', 'method'=>'post','class'=>'form-horizontal','files'=>true)) }}
				{{ Form::hidden('rp',Input::get('report_id')) }}
				@if($errors->any() && !empty($errors))
				<div class="invent_alert iA-error">
					<div style="margin:10px 0px 0px 40px;">
						<ul>
							{{ implode('',$errors->all('<li>:message</li>')) }}
						</ul>
					</div>
				</div>
				@endif
				<fieldset>
				<div class="panel-heading">
                    <h5 style="border-bottom: 1px solid #ccc">Physical Stocktaking Infomation</h5>
                </div>
                <div class="form-group" style="padding-left: 30px">
                	<div ><span class="pull-left"><strong>Warehouse</strong> : {{ isset($model->warehouse->name)?$model->warehouse->name:'' }}<br><br>{{ $model->warehouse->street.' - '.$model->warehouse->city.' - '.$model->warehouse->country->name }}</span>
                	    <span class="pull-left" style="margin-left: 40px">
                	    <p>Reason(s) for physical stocktaking stock</p>
                	    {{ Form::textarea('reasons',isset($model->reasons)?$model->reasons:'') }}</span>
                	 </div>
                </div>
                <div class="panel-heading">
                    <h5 style="border-bottom: 1px solid #ccc">Import Products for Physical Stocktaking</h5>
                </div>
                <div class="panel-heading" id="order-items">
                    <div class="row">
                        <div class="col-lg-3">
                            Please choose CSV file to import
                            <div class="row">
                                {{Form::hidden('id_re',Input::get('report_id'))}}
                                {{Form::file('csv_file',array('class'=>'col-lg-6','id'=>'csv_file'))}}
                                {{Form::button('Import',array('class'=>'btn btn-sm btn-primary import-ajax col-lg-4'))}}
                                {{ Form::textarea('content','',array('id'=>'fileDisplayArea','class'=>'hidden')) }}
                            </div>

                        </div>
                        <div class="col-lg-9">
                            When you want to assign loads of products to a Supplier, the structure of CSV file is as follows:
                            <h2 style="text-transform: uppercase">Sku,Qty</h2>
                            <h5>SKU:SKU of product</h5>
                            <h5>QTY:Quantity of product</h5>
                        </div>
                    </div>

                </div>
                <div class="panel-heading">
                    <h5 style="border-bottom: 1px solid #ccc">Choose Products for Physical Stocktaking</h5>
                </div>
                <div class="panel-heading">
                    <p class="pull-right"><input type="button" class="btn btn-sm btn-primary" id="btn-search" value="Search"></p>
                </div>
                <div>
	                <table class="table table-bordered">
	                    <thead>

	                        <tr>
	                            <th>{{ Lang::get('adjuststock.id');BaseModel::renderHtmlSort('first_name','AdjustStockController@getAddPhysical') }}</th>
	                            <th>{{ Lang::get('adjuststock.name');BaseModel::renderHtmlSort('last_name','AdjustStockController@getAddPhysical') }}</th>
	                            <th>{{ Lang::get('adjuststock.status');BaseModel::renderHtmlSort('email','AdjustStockController@getAddPhysical') }}</th>
	                            <th>{{ Lang::get('adjuststock.sku');BaseModel::renderHtmlSort('customer_group_id','AdjustStockController@getAddPhysical')}}</th>
	                            <th>{{ Lang::get('adjuststock.image'); }}</th>
	                            <th>{{ Lang::get('adjuststock.price');BaseModel::renderHtmlSort('zipcode','AdjustStockController@getAddPhysical') }}</th>
	                            <th>{{ Lang::get('adjuststock.physicaltaking'); }}</th>
	                            <th></th>
	                        </tr>
	                        <tr role="row">

	                            <td class="hasinput">
	                                {{Form::text('seq_no',Input::get('seq_no'),array('class'=>'form-control','placeholder'=>'Eg:2;2>4'))}}
	                            </td>

	                            <td class="hasinput">
	                                {{Form::text('name',Input::get('name'),array('class'=>'form-control','placeholder'=>Lang::get('adjuststock.name')))}}
	                            </td>
	                            <td class="hasinput">
	                                {{Form::select('status',array(''=>'-- Select one --','1'=>'Active','0'=>'Inactive'),Input::get('status'),array('class'=>'form-control','placeholder'=>Lang::get('adjuststock.status')))}}
	                            </td>
	                            <td class="hasinput">
	                                {{Form::text('sku',Input::get('sku'),array('class'=>'form-control','placeholder'=>Lang::get('adjuststock.sku')))}}
	                            </td>
	                            <td class="hasinput">

	                            </td>
	                            <td class="hasinput">
	                                {{Form::text('price',Input::get('price'),array('class'=>'form-control','placeholder'=>'Eg:2;2>4'))}}
	                            </td>
	                            <td class="hasinput">

	                            </td>
	                            <td style="min-width: 56px">
	                            </td>

	                        </tr>
	                    </thead>
	                    <tbody class="search-rs">
	                    </tbody>


	                </table>
                </div>
                 <div class="panel-heading">
                    <h5 style="border-bottom: 1px solid #ccc">List product review</h5>
                 </div>
                 <div>
                    <table class="table table-bordered">
                        <thead>

                            <tr>
                                <th>{{ Lang::get('adjuststock.id');}}</th>
                                <th>{{ Lang::get('adjuststock.name');}}</th>
                                <th>{{ Lang::get('adjuststock.status');}}</th>
                                <th>{{ Lang::get('adjuststock.sku');}}</th>
                                <th>{{ Lang::get('adjuststock.image'); }}</th>
                                <th>{{ Lang::get('adjuststock.price');}}</th>
                                <th>{{ Lang::get('adjuststock.physicaltaking'); }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="review">
                         <?php
                             $limit=2;
                             $count=1;
                             $list_id=array();
                             ?>
                         @if(!empty($data))

                         @foreach($data as $k=>$r)
                           <?php if($r[0]=='id')
                                    continue;
                           ?>
							<tr id="tr_c_{{$r[0]}}" class="item_re">
								<td>{{$r[0]}}</td>
                                <td>{{$r[1]}}</td>
                                <td>{{$r[2]}}</td>
                                <td>{{$r[3]}}</td>
                                <td>{{$r[4]}}</td>
                                <td>{{$r[5]}}</td>
                                <td><input class="phy_qty_{{$r[0]}}" name="phy_qty[{{$r[0]}}]" type="text" value="{{$r[6]}}"></td>
                                <td style="text-align: center"><i class="fa fa-times fa-hover" data="{{$r[0]}}"></i> | <i class="fa fa-check" data="{{$r[0]}}"></i><input class="choise1" name="reviews[{{$r[0]}}]" type="hidden" value="{{$r[0]}}"></td>
                            </tr>
                            @endforeach

                          @endif
                        </tbody>
                        <?php $list_id=array(1,2,3); $str='['.implode(',',$list_id).']'; ?>
                    </table>
                 </div>
                </fieldset>

			</div>
			<div class="form-group">
                <div class=" col-sm-offset-2">
                        {{Form::button('Back',array('class'=>'btn btn-default','onclick'=>'window.history.back();'))}}
                        {{Form::submit('Save',array('class'=>'btn btn-primary'))}}
                        {{Form::submit('Confirm completed',array('class'=>'btn btn-success','name'=>'complate'))}}
                        {{Form::submit('Confirm completed and update stock',array('class'=>'btn btn-success','name'=>'complate_update'))}}
                </div>
            </div>
            {{ Form::close() }}
		</div>
	</div>
</div>
<style>
.footer{
	position: relative;
}
</style>
<script type="text/javascript">
$(document).ready(function(){
	$('#btn-search').click(function(){
		var page='';
		bind(page);
	});
	$('.fa-hover').click(function(){
		var a=confirm('Do you want remove product?');
		var id=$(this).attr('data');
		if(a){
			//thu hien gui request xoa ban ghie
			$.ajax({
                type: "POST",
                url: "{{ URL::route('adjustStock.ajax_remove.get') }}",
                dataType:'json',
                data: {rid:{{ Input::get('report_id') }},id:id}
            }).done(function(data){
                 if(data.status==1)
                 {
                    $('#tr_c_'+id).empty();
                    alert(data.mes);
                    return;
                 }else
                 {
                    alert('Error remote product');
                    return;
                 }
            });
		}
	});
	$('.fa-check').click(function(){
        var a=confirm('Do you want update physcal report?');
        var id=$(this).attr('data');
        var qty=$('.phy_qty_'+id).val();
        if(a){
            //thu hien gui request xoa ban ghie
            $.ajax({
                type: "POST",
                url: "{{ URL::route('adjustStock.ajax_update_physical.get') }}",
                dataType:'json',
                data: {rid:{{ Input::get('report_id') }},id:id,qty:qty}
            }).done(function(data){
                 if(data.status==1)
                 {
                    alert(data.mes);
                    return;
                 }else
                 {
                    alert('Error add product');
                    return;
                 }
            });
        }
    });
	$('.import-ajax').click(function(){
    		$('.form-horizontal').submit();
    });
});
function bind(page){
	var name=$("input[name='name']" ).val();
	var sku=$("input[name='sku']" ).val();
	var seq_no=$("input[name='seq_no']" ).val();
	var status=$("select[name='status']" ).val();
	var price=$("input[name='price']" ).val();
	var allow='';
	$('input[name^="reviews"]').each(function() {
		if(allow=='')
            allow=$(this).val();
        else
            allow=allow+','+$(this).val();
    });
	 $.ajax({
        type: "POST",
        url: "{{ URL::route('adjustStock.ajax_search.get') }}",
        dataType:'html',
        data: {rid:{{ Input::get('report_id') }},name:name,sku:sku,price:price,status:status,id:seq_no,all:allow,page:page,switch:'physical'},
         beforeSend: function(){
              $('.search-rs').html('<tr><td colspan="8" style="text-align: center">Searching...</td></tr>');
         }
    }).done(function(data){
         $('.search-rs').html(data);
         return;
    });
}

</script>