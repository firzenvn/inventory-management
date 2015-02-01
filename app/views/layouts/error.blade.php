<!DOCTYPE html>
<html lang="vi-vn">
<head>
	<meta charset="utf-8">
	<title> True Inventory </title>
	<meta name="description" content="">
	<meta name="author" content="">

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

	<!-- #CSS Links -->
	{{ HTML::style('bootstrap/css/bootstrap.min.css')}}
	{{ HTML::style('font-awesome/css/font-awesome.min.css')}}

	{{ HTML::style('css/inventory/smartadmin-production.min.css')}}
	{{ HTML::style('css/inventory/smartadmin-skins.min.css')}}

	{{ HTML::style('css/inventory/demo.min.css')}}
	{{ HTML::script('js/jquery-1.11.1.min.js')}}

	<!-- #FAVICONS -->
	<link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon">
	<link rel="icon" href="/img/favicon.ico" type="image/x-icon">

	<!-- #GOOGLE FONT -->
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
</head>

<body class="desktop-detected smart-style-3">

<!-- #HEADER -->
<header id="header">
<div id="logo-group">
	<!-- PLACE YOUR LOGO HERE -->
	<span id="logo"> <img src="/img/admin/logo-pale.png" alt="SmartAdmin"> </span>
	<!-- END LOGO PLACEHOLDER -->
</div>

<!-- pulled right: nav area -->
<div class="pull-right">
	<!-- logout button -->
	<div id="logout" class="btn-header transparent pull-right">
		@if(Auth::guest())
            <li>
                <a href="{{{ URL::to('users/login') }}}" id="customer-login">Login</a>
            </li>
        @else
            <span style="font-size: 35px;" data-toggle="dropdown" class="project-selector dropdown-toggle activity-dropdown"> <i class="fa fa-user"></i> </span>
            <ul class="dropdown-menu">
                <li>
                    <a href="#"><i class="fa fa-key"></i> Đổi mật khẩu</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="{{{ URL::to('users/logout') }}}"><i class="fa fa-power-off"></i> Thoát</a>
                </li>
            </ul>
        @endif
	</div>
	<!-- end logout button -->
	<div id="hide-menu" class="btn-header pull-right">
		<span> <a href="javascript:void(0);" data-action="toggleMenu" title="Collapse Menu"><i class="fa fa-reorder"></i></a> </span>
	</div>
</div>
<!-- end pulled right: nav area -->

</header>
<!-- END HEADER -->
<aside id="left-panel">
	@menu()
</aside>

<!-- #MAIN PANEL -->
<div id="main" role="main">
	<!-- #MAIN CONTENT -->
	<div id="content">
		@yield('content')
	</div>
	<!-- END #MAIN CONTENT -->
</div>
<!-- END #MAIN PANEL -->

<!-- #PAGE FOOTER -->
<div class="page-footer">
	<div class="row" style="margin-right: 0px;">
		<div class="col-xs-12 col-sm-6">
			<span class="txt-color-white">Inventory 2014 &copy;TruePlus.VN</span>
		</div>
		<!-- end col -->
	</div>
	<!-- end row -->
</div>
<!-- END FOOTER -->

<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

<!-- IMPORTANT: APP CONFIG -->
{{ HTML::script('js/inventory/app.config.js')}}

<!-- BOOTSTRAP JS -->
{{ HTML::script('bootstrap/js/bootstrap.min.js')}}

<!-- MAIN APP JS FILE -->
{{ HTML::script('js/inventory/app.min.js')}}

</body>

</html>