<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Products added daily</h5>
			</div>
			<div class="ibox-content">
				<div class="row">
					<div class="col-lg-7">
						{{Lava::$chartType('Times')->outputInto('time_div')}}
						{{Lava::div($width,$height)}}
						@if(Lava::hasErrors())
							{{Lava::getErrors()}}
						@endif
					</div>
					<div class="col-lg-3">
						@if(!empty($summary))
							<ul class="stat-list">
							@foreach($summary as $key=>$value)
								<li>
									<h3 class="no-margins"> {{$key}} : {{$value}}</h3>
									<div class="progress progress-mini">
										<div style="width: 0%;" class="progress-bar"></div>
									</div>
								</li>
							@endforeach
							</ul>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</div>