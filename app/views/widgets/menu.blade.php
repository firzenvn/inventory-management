<nav class="navbar-default navbar-static-side" role="navigation">
	<div class="sidebar-collapse">
		<ul class="nav" id="side-menu">
		<li class="nav-header">
			<div class="dropdown profile-element"> <span>
				<img alt="image" class="img-circle" src="/img/avatar.png">
				 </span>
				<a data-toggle="dropdown" class="dropdown-toggle" href="#">
				<span class="clear"> <span class="text-muted text-xs block">{{Auth::user()->username}} <b class="caret"></b></span> </span> </a>
				<ul class="dropdown-menu animated fadeInRight m-t-xs">
					<li><a href="{{{ URL::route("users.change-password.get") }}}">Change password</a></li>
					<li class="divider"></li>
					<li><a href="{{{ URL::to('users/logout') }}}">Logout</a></li>
				</ul>
			</div>
		</li>
	<?php $uri = Request::path(); ?>
	@if(!empty($menus))
	<?php $i=1; ?>
		@foreach($menus as $key=>$menu)
		@if($menu->parent_id==0)
		<?php
			$check = ($menu->url=='/'.$uri)? true : false;
		?>
		<li class="<?php if($check && $i!=1) echo 'active'; elseif($uri=='/' && $i==1) echo 'active'; ?>">
			<a href="{{$menu->url}}"><i class="fa {{$menu->icon}}"></i> <span class="nav-label">{{$menu->name}}</span> @if($menu->url=='#') {{'<span class="fa arrow"></span>'}} @endif</a>
			<?php genSubMenu($menus,$menu->id,$uri);  ?>
		</li>
		<?php $i++; ?>
		@endif
		@endforeach
	@endif
	 </ul>
	</div>
</nav>

<!-- END NAVIGATION -->
<?php
function genSubMenu($menus, $parent_id = 0,$uri=null)
{
	$cnt = 0;
	foreach ($menus as $menu) {
		if($menu->url == '/'.$uri)
			$c = 'active';
		else
			$c = '';
		if ($menu->parent_id == $parent_id) {
			if($cnt==0){
				echo '<ul class="nav nav-second-level">';
			}
			echo '<li class="'.$c.'"><a href="'.$menu->url.'">'.$menu->name.'</a></li>';
			$cnt++;
		}
	}
	if($cnt>0){
		echo '</ul>';
	}
}
?>