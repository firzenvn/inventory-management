<div class="row">
	<div class="col-lg-12">

		<div class="panel blank-panel">

			<div class="panel-heading">
				<div class="panel-title m-b-md"><h4>Warehouse</h4></div>
				<div class="panel-options">

					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#tab-1">Warehouse Information</a></li>
						<li class=""><a data-toggle="tab" href="#tab-2">Product</a></li>
					</ul>
				</div>
			</div>

			<div class="panel-body">

				<div class="tab-content">
					<div id="tab-1" class="tab-pane active">
						<div class="ibox float-e-margins">
							<div class="ibox-title">
								<h5>Update Warehouse #{{$model->seq_no}}</h5>
								<div class="ibox-tools">
									<a class="collapse-link">
										<i class="fa fa-chevron-up"></i>
									</a>
								</div>
							</div>
							<div class="ibox-content">

								{{ Form::open(array('route'=>'warehouse.update', 'autocomplete'=>'off', 'method'=>'post','class'=>'form-horizontal')) }}
								{{ Form::hidden('id',$model->id)}}

								@if($errors->any() && !empty($errors))
									<div class="invent_alert iA-error">
										<div style="margin:10px 0px 0px 40px;">
											<ul>
												@foreach($errors->all() as $message)
													<li>{{ $message }}</li>
												@endforeach
											</ul>
										</div>
									</div>
								@endif

								<div class="form-group">
									<label class="col-md-2 control-label">{{Lang::get('label.warehouses_name')}} <span class="required">*</span></label>
									<div class="col-md-4">
										{{ Form::text('name',$model->name,array('placeholder'=>Lang::get('label.warehouses_name'),'required','class'=>'form-control'))}}
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 control-label">{{Lang::get('label.manager_name')}} <span class="required">*</span></label>
									<div class="col-md-4">
										{{ Form::text('manager_name',$model->manager_name,array('placeholder'=>Lang::get('label.manager_name'),'required','class'=>'form-control'))}}
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 control-label">{{Lang::get('label.manager_email')}} <span class="required">*</span></label>
									<div class="col-md-4">
										{{ Form::text('manager_email',$model->manager_email,array('placeholder'=>Lang::get('label.manager_email'),'required','class'=>'form-control'))}}
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 control-label">{{Lang::get('label.phone_no')}} <span class="required">*</span></label>
									<div class="col-md-4">
										{{ Form::text('phone_no',$model->phone_no,array('placeholder'=>Lang::get('label.phone_no'),'required','class'=>'form-control'))}}
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 control-label">{{Lang::get('label.street')}} <span class="required">*</span></label>
									<div class="col-md-4">
										{{ Form::text('street',$model->street,array('placeholder'=>Lang::get('label.street'),'required','class'=>'form-control'))}}
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 control-label">{{Lang::get('label.city')}} <span class="required">*</span></label>
									<div class="col-md-4">
										{{ Form::text('city',$model->city,array('placeholder'=>Lang::get('label.city'),'required','class'=>'form-control'))}}
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 control-label">{{Lang::get('label.country')}} <span class="required">*</span></label>
									<div class="col-md-4">
										{{ Form::select('country_id',$countries,$model->country_id,array('class'=>'form-control'))}}
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 control-label">{{Lang::get('label.state_province')}}</label>
									<div class="col-md-4">
										{{ Form::text('province',$model->province,array('placeholder'=>Lang::get('label.state_province'),'class'=>'form-control'))}}
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 control-label">{{Lang::get('label.zip_code')}} <span class="required">*</span></label>
									<div class="col-md-4">
										{{ Form::text('zipcode',$model->zipcode,array('placeholder'=>Lang::get('label.zip_code'),'required','class'=>'form-control'))}}
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 control-label">{{Lang::get('label.status')}} <span class="required">*</span></label>
									<div class="col-md-4">
										{{ Form::select('status',array(1 => Lang::get('label.enable'), 0 => Lang::get('label.disable')),$model->status,array('class'=>'form-control'))}}
									</div>
								</div>

								<div class="hr-line-dashed"></div>
								<div class="form-group">
									<div class="col-sm-4 col-sm-offset-2">
										{{Form::button('Back',array('class'=>'btn btn-white','onclick'=>'window.history.back();'))}}
										{{Form::submit('Submit',array('class'=>'btn btn-primary'))}}
									</div>
								</div>
								{{ Form::close() }}
							</div>
						</div>
					</div>

					<div id="tab-2" class="tab-pane">
						<div class="ibox float-e-margins">
							<div class="ibox-title">
								<h5>Warehouse Product</h5>
								<div class="ibox-tools">
									<a class="collapse-link">
										<i class="fa fa-chevron-up"></i>
									</a>
								</div>
							</div>
							<div class="ibox-content">

								{{Form::open(array('route'=>'warehouseProduct.list','method'=>'get'))}}
								<div class="">
									{{--<a href="#" class="btn btn-primary">Add Product to Warehouse</a>--}}

									<div class="pull-right">
										{{Form::button('Search',array('class'=>'btn btn-primary','id'=>'btn-search'))}}
									</div>
								</div>
								<table class="table table-striped table-bordered table-hover dataTables-example" >
									<thead>
									<tr>
										<th nowrap >
											{{Lang::get('label.id')}}
										</th>
										<th nowrap >{{Lang::get('label.name')}}</th>
										<th nowrap >{{Lang::get('label.sku')}}</th>
										<th nowrap >{{Lang::get('label.price')}}</th>
										<th nowrap >{{Lang::get('label.status')}}</th>
										<th nowrap >{{Lang::get('label.total_quantity')}}</th>
										<th nowrap >{{Lang::get('label.available_quantity')}}</th>

										<th style="width: 9%;" ></th>
									</tr>
									<tr role="row">
										<td class="hasinput">
											{{Form::text('seq_no_from',Input::get('seq_no'),array('class'=>'form-control','placeholder'=>'From','id'=>'seq_no_from'))}}
											{{Form::text('seq_no_to',Input::get('seq_no'),array('class'=>'form-control','placeholder'=>'To','id'=>'seq_no_to'))}}
										</td>
										<td class="hasinput">
											{{Form::text('name',Input::get('name'),array('class'=>'form-control','id'=>'p_name','placeholder'=>Lang::get('label.name')))}}
										</td>
										<td class="hasinput">
											{{Form::text('sku',Input::get('sku'),array('class'=>'form-control','id'=>'p_sku','placeholder'=>Lang::get('label.sku')))}}
										</td>
										<td class="hasinput">
											{{Form::text('price_from',Input::get('price_from'),array('class'=>'form-control','placeholder'=>'From','id'=>'price_from'))}}
											{{Form::text('price_to',Input::get('price_to'),array('class'=>'form-control','placeholder'=>'To','id'=>'price_to'))}}
										</td>
										<td class="hasinput">
											{{Form::select('status',array(''=>'All',0=>'Disable',1=>'Enable'),Input::get('status'),array('class'=>'form-control','id'=>'p_status'))}}
										</td>
										<td class="hasinput">
											{{Form::text('total_qty_from',Input::get('total_qty')['from'],array('class'=>'form-control','id'=>'total_qty_from','placeholder'=>'From'))}}
											{{Form::text('total_qty_to',Input::get('total_qty')['to'],array('class'=>'form-control','id'=>'total_qty_to','placeholder'=>'To'))}}
										</td>
										<td class="hasinput">
											{{Form::text('available_qty_from',Input::get('available_qty_from')['from'],array('class'=>'form-control','id'=>'available_qty_from','placeholder'=>'From'))}}
											{{Form::text('available_qty_to',Input::get('available_qty_to')['to'],array('class'=>'form-control','id'=>'available_qty_to','placeholder'=>'To'))}}
										</td>
										<td></td>
										{{Form::close()}}
									</tr>
									</thead>
									<tbody class="search-rs">
									@foreach($rows as $row)
										{{Form::open(array('route'=>'warehouseProduct.update_qty','method'=>'post'))}}
										{{Form::hidden('id',$row->id)}}
										<tr>
											<td>{{$row->product->seq_no}}</td>
											<td>{{$row->product->name}}</td>
											<td>{{$row->product->sku}}</td>
											<td>{{$row->product->price}}</td>
											<td>@if($row->product->status==1) {{'Enable'}} @else {{'Disable'}} @endif</td>
											<td class="hasinput">
												{{Form::text('total_qty',$row->total_qty,array('class'=>'form-control input-search-ajax'))}}
											</td>
											<td>{{$row->available_qty}}</td>
											<td>
												<button class="btn btn-primary" type="submit"><i class="fa fa-check"></i></button>
											</td>
										</tr>
										{{Form::close()}}
									@endforeach

									</tbody>
								</table>

							</div>
							<div class="row">
								<div class="col-sm-6 text-right">
									<div class="dataTables_paginate paging_simple_numbers" id="editable_paginate">
										{{ $rows->appends(array(
											'id' =>Input::get('id'),
											'name' =>Input::get('name'),
											'sku' =>Input::get('sku'),
											'price' =>Input::get('price'),
											'status' =>Input::get('status'),
											'total_qty' =>Input::get('total_qty'),
											'available_qty' =>Input::get('available_qty')
										))->links() }}
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>

			</div>

		</div>
</div>
</div>
<script type="text/javascript">
	$('#btn-search').click(function(){
		var seq_no_from = $('#seq_no_from').val();
		var seq_no_to = $('#seq_no_to').val();
		var p_name = $('#p_name').val();
		var p_status = $('#p_status').val();
		var p_sku = $('#p_sku').val();
		var total_qty_from = $('#total_qty_from').val();
		var total_qty_to = $('#total_qty_to').val();
		var price_from = $('#price_from').val();
		var price_to = $('#price_to').val();
		var available_qty_from = $('#available_qty_from').val();
		var available_qty_to = $('#available_qty_to').val();
		$.ajax({
			type: "POST",
			url: "{{ URL::route('warehouseProduct.ajax.list') }}",
			dataType:'html',
			data: {
				seq_no_from:seq_no_from,
				seq_no_to:seq_no_to,
				p_name:p_name,
				p_status:p_status,
				p_sku:p_sku,
				total_qty_from:total_qty_from,
				total_qty_to:total_qty_to,
				price_from:price_from,
				price_to:price_to,
				available_qty_from:available_qty_from,
				available_qty_to:available_qty_to
			},
			beforeSend: function(){
				$('.search-rs').html('<tr><td colspan="8" style="text-align: center">Searching...</td></tr>');
			}
		}).done(function(data){
			$('.search-rs').html(data);
		});
	});
</script>