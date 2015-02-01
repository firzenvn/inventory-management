<?php
/**
 * Created by PhpStorm.
 * User: Hieu
 * Date: 21/11/2014
 * Time: 2:02 CH
 */
 ?>
 <script type="text/javascript">
 $(document).ready(function(){
 	var customer_info = '{{ json_encode($model->customer->attributesToArray()) }}';
 	$.each($.parseJSON(customer_info), function( key, val ) {
            $(".cus_" + key).html(val);
     });
     //ORDER: SEARCH CUSTOMER
 });
 </script>