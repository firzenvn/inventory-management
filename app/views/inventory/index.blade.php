<div class="row">
	<div class="col-lg-3">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Product</h5>
			</div>
			<div class="ibox-content">
				<h1 class="no-margins">{{$client_info->product_count}}</h1>
				<small>Total Product</small>
			</div>
		</div>
	</div>
	<div class="col-lg-3">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Warehouse</h5>
			</div>
			<div class="ibox-content">
				<h1 class="no-margins">{{$client_info->warehouse_count}}</h1>
				<small>Total Warehouse</small>
			</div>
		</div>
	</div>
	<div class="col-lg-3">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Order</h5>
			</div>
			<div class="ibox-content">
				<h1 class="no-margins">{{$total_order}}</h1>
				<small>Total Order</small>
			</div>
		</div>
	</div>
	<div class="col-lg-3">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Amount</h5>
			</div>
			<div class="ibox-content">
				<h1 class="no-margins">{{number_format($total_amount)}}</h1>
				<small>Total Amount</small>
			</div>
		</div>
	</div>
</div>

@products_added_daily()
