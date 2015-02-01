<!DOCTYPE html>
<html lang="vi-vn">
<head>
	<meta charset="utf-8">
	<title> True Inventory </title>
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	@include('layouts._resources')
</head>

<body>
<div id="wrapper">
	@menu()
	<div id="page-wrapper" class="gray-bg">
		@include('layouts._header')
		@include('layouts._messages')
		{{$content}}
		@include('layouts._footer')
	</div>
</div>

	<script>
		$(document).ready(function(){
		});
	</script>

</body>

</html>