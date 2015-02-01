{{ HTML::script('js/plugins/papaparse/papaparse.js')}}
{{ HTML::script('js/inventory/custom-script.js')}}
<div class="row" style="margin-bottom: 20px">
	<div class="col-lg-12">
		<div class="ibox-title">
			<h5>{{ Lang::get('label.new_stock_sending') }}</h5>
		</div>
		<div class="ibox-content">
			<div class="" style="margin-top: 10px">
				{{ Form::open(array('action'=>'sendStock.add_detail.post', 'autocomplete'=>'off', 'method'=>'post','class'=>'form-horizontal')) }}
				{{ Form::hidden('sending_id',Input::get('sending_id')) }}
				{{ Form::hidden('source_warehouse_id',$model->source_warehouse_id,array('id'=>'source_warehouse_id')) }}
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
						<h5 style="border-bottom: 1px solid #ccc">Stock Sending Infomation</h5>
					</div>
					<div class="form-group">
						<label class="col-md-2 control-label">{{Lang::get('label.source_warehouse')}}</label>
						<div class="col-md-4">
							<span>{{isset($model->source->name)?$model->source->name:''}}</span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2 control-label">{{Lang::get('label.destination')}}</label>
						<div class="col-md-4">
							<span>{{isset($model->destination->name)?$model->destination->name:''}}</span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2 control-label">{{Lang::get('label.reasons_for_sending_stock')}} <span class="required">*</span></label>
						<div class="col-md-4">
							{{ Form::textarea('reasons',isset($model->reasons)?$model->reasons:'',array('placeholder'=>Lang::get('label.reasons_for_sending_stock'),'required','class'=>'form-control')) }}
						</div>
					</div>
					<div class="panel-heading">
						<h5 style="border-bottom: 1px solid #ccc">Import Products to Send Stock</h5>
					</div>
					<div class="panel-heading" id="order-items">
						<div class="row">
							<div class="col-lg-3">
								Please choose CSV file to import
								<div class="row">
									{{Form::file('csv_file',array('class'=>'col-lg-6','id'=>'csv_file'))}}
									{{Form::submit('Import',array('class'=>'btn btn-sm btn-primary col-lg-4'))}}
									{{ Form::textarea('content','',array('id'=>'fileDisplayArea','class'=>'hidden')) }}
								</div>

							</div>
							<div class="col-lg-9">
								If you want to send stock from a warehouse by importing loads of products, the structure of CSV file is as follows:
								<h2 style="text-transform: uppercase">Sku,Qty</h2>
								<h5>SKU:SKU of product</h5>
								<h5>QTY:Quantity of product</h5>
							</div>
						</div>

					</div>
					<div class="panel-heading">
						<h5 style="border-bottom: 1px solid #ccc">Choose Products to Send Stock</h5>
					</div>
					<div class="panel-heading">
						<p class="pull-right"><input type="button" class="btn btn-sm btn-primary" id="btn-search" value="Search"></p>
					</div>
					<div>
						<table class="table table-bordered">
							<thead>
							<tr>
								<th></th>
								<th>{{ Lang::get('label.id'); }}</th>
								<th>{{ Lang::get('label.name')}}</th>
								<th>{{ Lang::get('label.status')}}</th>
								<th>{{ Lang::get('label.sku')}}</th>
								<th>{{ Lang::get('label.total_quantity')}}</th>
								<th>{{ Lang::get('label.quantity_sent')}}</th>
							</tr>
							<tr role="row">
								<td class="hasinput"><input type="checkbox" name="product_list" id="checkAll" value="all"/></td>
								<td class="hasinput">
									{{Form::text('seq_no_from',Input::get('seq_no'),array('class'=>'form-control','placeholder'=>'From','id'=>'seq_no_from'))}}
									{{Form::text('seq_no_to',Input::get('seq_no'),array('class'=>'form-control','placeholder'=>'To','id'=>'seq_no_to'))}}
								</td>
								<td class="hasinput">
									{{Form::text('name',Input::get('name'),array('class'=>'form-control','id'=>'p_name','placeholder'=>Lang::get('label.name')))}}
								</td>
								<td class="hasinput">
									{{Form::select('status',array(''=>'-- Select one --','1'=>'Enable','0'=>'Disable'),Input::get('status'),array('id'=>'p_status','class'=>'form-control'))}}
								</td>
								<td class="hasinput">
									{{Form::text('sku',Input::get('sku'),array('class'=>'form-control','id'=>'p_sku','placeholder'=>Lang::get('label.sku')))}}
								</td>
								<td class="hasinput">
									{{Form::text('total_qty_from',Input::get('total_qty')['from'],array('class'=>'form-control','id'=>'total_qty_from','placeholder'=>'From'))}}
									{{Form::text('total_qty_to',Input::get('total_qty')['to'],array('class'=>'form-control','id'=>'total_qty_to','placeholder'=>'To'))}}
								</td>
								<td class="hasinput">
								</td>
							</tr>
							</thead>
							<tbody class="search-rs">
							@foreach($products as $row)
								<tr id="tr_c_{{$row->product->seq_no}}">
									<td>{{Form::checkbox('product_arr['.$row->product_id.']', $row->product->sku);}}</td>
									<td>{{$row->product->seq_no}}</td>
									<td>{{$row->product->name}}</td>
									<td>@if($row->product->status==1) {{'Enable'}} @else {{'Disable'}} @endif</td>
									<td>{{$row->product->sku}}</td>
									<td>{{$row->total_qty}}</td>
									<td><input name="qty_send[{{$row->product_id}}]" type="text" value=""/></td>
								</tr>
							@endforeach
							</tbody>
						</table>
					</div>

				</fieldset>

			</div>
			<div class="form-group">
				<div class=" col-sm-offset-2">
					{{Form::button('Back',array('class'=>'btn btn-default','onclick'=>'window.history.back();'))}}
					{{Form::submit('Save',array('class'=>'btn btn-primary'))}}
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
	.form-horizontal .control-label{
		padding-top: 0px;
	}
</style>
<script type="text/javascript">
$(document).ready(function(){
	$("#checkAll").click(function () {
		$('input:checkbox').not(this).prop('checked', this.checked);
	});

	$('#csv_file').change(function(e) {
		var fileInput = document.getElementById('csv_file');
		var csv_file = fileInput.files[0];
		var textname = /^.*\.(csv)$/;

		if (csv_file.name.match(textname)) {
			Papa.parse(csv_file, {
				complete: function(results, file) {
					$('#fileDisplayArea').html(array2json(results.data));
				}
			});
		} else {
			alert("File not supported!");
		}
	});
});

$('#btn-search').click(function(){
	var seq_no_from = $('#seq_no_from').val();
	var seq_no_to = $('#seq_no_to').val();
	var p_name = $('#p_name').val();
	var p_status = $('#p_status').val();
	var p_sku = $('#p_sku').val();
	var total_qty_from = $('#total_qty_from').val();
	var total_qty_to = $('#total_qty_to').val();
	var warehouse_id = $('#source_warehouse_id').val();
	$.ajax({
		type: "POST",
		url: "{{ URL::route('warehouseProduct.ajax.search') }}",
		dataType:'html',
		data: {
			warehouse_id:warehouse_id,
			seq_no_from:seq_no_from,
			seq_no_to:seq_no_to,
			p_name:p_name,
			p_status:p_status,
			p_sku:p_sku,
			total_qty_from:total_qty_from,
			total_qty_to:total_qty_to
		},
		beforeSend: function(){
			$('.search-rs').html('<tr><td colspan="8" style="text-align: center">Searching...</td></tr>');
		}
	}).done(function(data){
		$('.search-rs').html(data);
	});
});
</script>