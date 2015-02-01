<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Update Product #{{$model->id}} </h5>
				<div class="ibox-tools">
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
					<a class="close-link">
						<i class="fa fa-times"></i>
					</a>
				</div>
			</div>
			<div class="ibox-content">

			{{ Form::open(array('route'=>'products.update', 'autocomplete'=>'off', 'method'=>'post','class'=>'form-horizontal')) }}
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
			<fieldset>
				<div class="form-group">
					<label class="col-md-2 control-label">{{Lang::get('label.category')}} <span class="required">*</span></label>
					<div class="col-md-4">
						@foreach($categories as $cate)
							<label class="col-md-2 control-label">{{$cate->name}}</label>
							<?php $sub_categories = SubCategory::where('category_id','=',$cate->id)->get(); ?>
							<div class="col-md-10">
							@foreach($sub_categories as $sub_cate)
								<div class="checkbox">
									<label>
									  <input type="checkbox" class="checkbox style-2" name="sub_cate[]" value="{{$sub_cate->id}}" <?php if(in_array($sub_cate->id,$sub_cates)) echo 'checked="checked"'; ?>>
									  <span>{{$sub_cate->name}}</span>
									</label>
								</div>
							@endforeach
							</div>
						@endforeach
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">{{Lang::get('label.name')}} <span class="required">*</span></label>
					<div class="col-md-4">
						{{ Form::text('name',$model->name,array('placeholder'=>Lang::get('label.name'),'required','class'=>'form-control'))}}
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">{{Lang::get('label.sku')}} <span class="required">*</span></label>
					<div class="col-md-4">
						{{ Form::text('sku',$model->sku,array('placeholder'=>Lang::get('label.sku'),'required','class'=>'form-control'))}}
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">{{Lang::get('label.price')}} <span class="required">*</span></label>
					<div class="col-md-4">
						{{ Form::text('price',$model->price,array('placeholder'=>Lang::get('label.price'),'required','class'=>'form-control'))}}
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">{{Lang::get('label.quantity')}} <span class="required">*</span></label>
					<div class="col-md-4">
						{{ Form::text('quantity',$model->quantity,array('placeholder'=>Lang::get('label.quantity'),'class'=>'form-control'))}}
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">{{Lang::get('label.status')}} <span class="required">*</span></label>
					<div class="col-md-4">
						{{ Form::select('status',array(1 => Lang::get('label.enable'), 0 => Lang::get('label.disable')),$model->status,array('class'=>'form-control'))}}
					</div>
				</div>
			</fieldset>

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
</div>