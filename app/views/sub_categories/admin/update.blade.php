<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Update Sub Category #{{$model->id}} </h5>
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

			{{ Form::open(array('route'=>'admin.sub-categories.update', 'autocomplete'=>'off', 'method'=>'post','class'=>'form-horizontal')) }}
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
				<label class="col-md-2 control-label">{{Lang::get('label.client_id')}} <span class="required">*</span></label>
				<div class="col-md-4">
					{{ Form::text('client_id',$model->client_id,array('placeholder'=>Lang::get('label.client_id'),'required','class'=>'form-control'))}}
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-2 control-label">{{Lang::get('label.category')}} <span class="required">*</span></label>
				<div class="col-md-4">
					{{ Form::select('category_id',$categories,$model->category_id,array('class'=>'form-control'))}}
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-2 control-label">{{Lang::get('label.sub_category_name')}} <span class="required">*</span></label>
				<div class="col-md-4">
					{{ Form::text('name',$model->name,array('placeholder'=>Lang::get('label.sub_category_name'),'required','class'=>'form-control'))}}
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-2 control-label">{{Lang::get('label.sub_category_description')}}</label>
				<div class="col-md-4">
					{{ Form::textarea('description',$model->description,array('placeholder'=>Lang::get('label.sub_category_description'),'class'=>'form-control'))}}
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
</div>