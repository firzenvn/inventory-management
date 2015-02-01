<div class="clear">
	@if(isset($uri_config))
		<?php
			$link_array=array('mangage','create');
			 if(isset($uri_config['link']) && $uri_config['link']!='')
				$link_array=explode('|',$uri_config['link']);
			else
				$link_array=array();
		 ?>
		@foreach($link_array as $k=>$v)
			<?php $vlink=($v!='manage')?$v:'index'; ?>
			<a href="/{{  $uri_config['uri'] }}/{{ $vlink }}" class="btn btn-sm btn-primary">{{ ucfirst($v) }}</a>
		@endforeach
	@endif
	<div class="pull-right">
    		<a class="btn btn-sm btn-default" href="{{URL::route($uri_config['uri'].'.list')}}">Reset</a>
    		{{Form::submit('Search',array('class'=>'btn btn-sm btn-primary'))}}
    </div>
</div>