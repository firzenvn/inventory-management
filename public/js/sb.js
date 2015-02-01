$(function() {
  // Setup drop down menu
  $('.dropdown-toggle').dropdown();
 
  // Fix input element click problem
  $('.dropdown input, .dropdown label').click(function(e) {
    e.stopPropagation();
  });
});

$(document).ready(function(){
	$('#customer-login').click(function (e) {
		$("#webaddress").focus();
	});
});

$('#webaddress').keypress(function (e) {
  if (e.which == 13) {
    loc = $("#webaddress").val(); 
    if(loc.length > 1){
    	location.href='https://'+loc+'.salesbinder.com';
    }
    return false;
  }
});