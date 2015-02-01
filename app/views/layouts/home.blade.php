<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="copyright" content="2014, TruePlus" />

<title>Online Inventory Management System, Web-Based Asset Management, Stock Control, Invoicing</title>

{{ HTML::style('bootstrap/css/bootstrap.min.css')}}
{{ HTML::style('css/justified-nav.css')}}
{{ HTML::style('css/carousel.css')}}
{{ HTML::style('css/salesbinder.css')}}
{{ HTML::script('js/fjx0phj.js')}}
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
{{ HTML::script('js/html5shiv.js')}}
{{ HTML::script('js/respond.min.js')}}
<![endif]-->

</head>

<body>
	<div>
		<div class="container">
			<div class="col-md-4 col-lg-5 pull-left hidden-xs home" style="position: relative; z-index: 1000;">
				<a href="/"><img src="/icons/true_logo.png" class="sb-logo" alt="TrueInventory" /></a>
			</div>
			<div class="navbar navbar-default col-xs-12 col-md-8 col-lg-7">
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle">Features</a>
						 </li>
						<li><a href="{{{ URL::to('users/register') }}}">Pricing &amp; Sign-Up</a></li>
						<li><a href="#">Contact Us</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						@if(Auth::guest())
							<li>
	                            <a href="{{{ URL::to('users/login') }}}" id="customer-login">Login</a>
	                        </li>
                        @else
							<li>
								<a href="#"> Xin chào {{ Auth::user()->username }}</a>
							</li>
							<li>
                                <a href="{{{ URL::to('users/logout') }}}"> Logout</a>
                            </li>
						@endif
					</ul>
				</div>
			</div>
		</div>
	</div>


    <!-- Carousel
    ================================================== -->
    <div id="myCarousel" class="carousel slide">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <!-- <li data-target="#myCarousel" data-slide-to="0" class="active"></li> -->
        <!-- <li data-target="#myCarousel" data-slide-to="1"></li> -->
      </ol>
      <div class="carousel-inner">
        <div class="item active">
          <div class="container">
            <a href="#"><img src="/icons/iphone_app-in_hand.png" class="iphone-app hidden-xs" alt="TrueInventory inventory iPhone App" /></a>
            <div class="carousel-caption">
				<div class="col-lg-8">
					<div class="jumbotron">
						<img src="/icons/laptop_screen.png" class="img-responsive" alt="Inventory Software screen" />
					</div>
				</div>
				<div class="col-lg-4 visible-lg">
					<div class="home-signup">
						<h3>Get started in 15 seconds!</h3>
						<form action="#" method="get" name="form1" class="form-horizontal" role="form">
							<div class="row">
								<div class="col-lg-6">
								  <div class="form-group">
									<label class="sr-only" for="first_name">First Name</label>
									<input type="text" name="first_name" class="form-control" id="first_name" placeholder="First Name" />
								  </div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label class="sr-only" for="last_name">Last Name</label>
										<input type="text" name="last_name" class="form-control" id="last_name" placeholder="Last Name" />
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label class="sr-only" for="email_address">Email Address</label>
										<input type="email" name="email" class="form-control" id="email_address" placeholder="Email Address" />
									</div>
								</div>
							</div>
							<button type="submit" name="TrueInventory" class="btn btn-md btn-success">Create Account</button> <span style="margin-left: 10px; margin-right: 10px;">or use</span> <button type="reset" class="btn btn-md btn-primary">Facebook</button>
							<p style=" margin-top: 48px; font-size: 12px; opacity: 0.8;">Works on any computer (Mac or PC) and Mobile Devices.</p>
						</form>
					</div>
				</div>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="container">
            <div class="carousel-caption">
            	<div class="jumbotron">
			        <h1>Online Inventory Management in the Cloud!</h1>
			        <p class="lead">Now managing over 8 billion dollars worth of inventory in over 100 countries worldwide.*</p>
				</div>
            </div>
          </div>
        </div>
      </div>
      <!-- <a class="left carousel-control hidden-xs" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a> -->
      <!-- <a class="right carousel-control hidden-xs" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a> -->
    </div>


    <div class="container marketing">
		<div class="row">
        <div class="col-lg-12 text-center">
			<h1>Online Inventory Management Software in the Cloud!</h1>
			<p class="lead text-muted">Now managing over 8 billion dollars worth of inventory in over 100 countries worldwide.*</p>
        </div>
		</div>
    </div> 
    
	<div style="background-color: #f5f5f5; margin-bottom: 30px;">
		<div class="container">
			<h3 class="lead" style="text-align: center; text-shadow: 0 1px 2px rgba(255, 255, 255, 0.9);">An easier way for managing your business. TrueInventory is an all-in-one online inventory management system that also organizes your customers, sales leads, purchase orders, estimates and invoices. <a href="#">Get started in 15 seconds!</a></h3>
		</div>
	</div>
      
	<div class="container marketing home">
		<div class="row features">
			<div class="col-sm-6 col-lg-4">
				<h3><a href="#">Inventory Management</a></h3>
				<p class="text-muted"><img src="/icons/inventory.png" alt="Inventory Management" class="home_icon">Manage your inventory and check supply levels in real-time. Receive low inventory notifications and generate Purchase Orders to replenish your stock.</p>
			</div>
			<div class="clearfix visible-xs"></div>
			<div class="col-sm-6 col-lg-4">
			  <h3><a href="#">Locations and Zones</a></h3>
			  <p class="text-muted"><img src="/icons/locations.png" alt="Locations and Zones" class="home_icon">Have multiple warehouses, offices, or retail stores? No problem. Easily track where all your inventory is by organizing everything into locations and zones.</p>
			</div>
			<div class="clearfix visible-xs visible-sm visible-md"></div>
			<div class="col-sm-6 col-lg-4">
			  <h3><a href="#">Item Variations</a></h3>
			  <p class="text-muted"><img src="/icons/variations.png" alt="Inventory Item Variations" class="home_icon">Organize your inventory items by using custom attributes such as size, color, and location. View how many you have globally or at each location.</p>
			</div>
			<div class="clearfix visible-xs visible-lg"></div>
			<div class="col-sm-6 col-lg-4">
			  <h3><a href="#">Customer Accounts</a></h3>
			  <p class="text-muted"><img src="/icons/accounts.png" alt="Manage Customer Accounts with CRM" class="home_icon">With a built-in CRM you can keep track of all your customer accounts with ease. Add multiple contacts, private notes, and review their purchase history.</p>
			</div>
			<div class="clearfix visible-xs visible-sm visible-md"></div>
			<div class="col-sm-6 col-lg-4">
			  <h3><a href="#">Invoices & Estimates</a></h3>
			  <p class="text-muted"><img src="/icons/billing.png" alt="Online Invoicing and Estimates" class="home_icon">Create beautiful, professional invoices & estimates in just a few seconds and then instantly email them as PDF's directly to your customers or prospects.</p>
			</div>
			<div class="clearfix visible-xs"></div>
			<div class="col-sm-6 col-lg-4">
			  <h3><a href="#">Purchase Orders</a></h3>
			  <p class="text-muted"><img src="/icons/purchase_order.png" alt="Purchase Orders" class="home_icon">With integrated Purchase Orders, you can easily replenish your inventory levels by ordering more stock and even track when those new items will arrive.</p>
			</div>
			<div class="clearfix visible-xs visible-sm visible-md visible-lg"></div>
			<div class="col-sm-6 col-lg-4">
			  <h3><a href="#">Financial Reports</a></h3>
			  <p class="text-muted"><img src="/icons/reports.png" alt="Financial Reports" class="home_icon">Generate extremely detailed financial reports for both your inventory and services. Filter your reports by date-range and category to see what's making you the most money.</p>
			</div>
			<div class="clearfix visible-xs"></div>
			<div class="col-sm-6 col-lg-4">
			  <h3><a href="#">Activity Feeds</a></h3>
			  <p class="text-muted"><img src="/icons/activity.png" alt="Activity Feeds" class="home_icon">TrueInventory tracks all important changes to your data using Activity Feeds so you're always in the loop. See who's done what and when it happened.</p>
			</div>
			<div class="clearfix visible-xs visible-sm visible-md"></div>
			<div class="col-sm-6 col-lg-4">
			  <h3><a href="#">User Permissions</a></h3>
			  <p class="text-muted"><img src="/icons/permissions.png" alt="Custom User Permissions" class="home_icon">Custom user permissions allows you to toggle what each of your team members can see and do. Hide things, make things read-only, or hide everyone else's stuff.</p>
			</div>
		</div>
	</div>

<footer>
	<div class="foot">
		<div class="inner">
			<div class="sb-menu">
				<a href="/">Home</a> |
				<a href="#">Features&nbsp;Tour</a> |
				<a href="#">Pricing &amp; Sign Up</a> |
				<a href="#">Our&nbsp;Blog</a> |
				<a href="#">About Us</a> |
				<a href="#">Support</a> |
				<a href="#">Contact&nbsp;Us</a>
			</div>
			<div class="copyright">&copy; 2014 trueplus.vn </div>
	    </div>
	</div>
</footer>


{{ HTML::script('js/jquery-1.11.1.min.js')}}
{{ HTML::script('js/sb.js')}}
{{ HTML::script('bootstrap/js/bootstrap.min.js')}}

</body>
</html>
