$(document).ready(function(){
	$('.right-side').load('./pages/templates/reports.html', { date : Date() });

	$('#menu-dashboard').on('click',function(){
		$('.right-side').load('./pages/templates/dashboard.html', { date : Date() });
	});

	$('#menu-orders').on('click',function(){
		$('.right-side').load('./pages/templates/orders.html', { date : Date() });
	});

	$('#menu-report').on('click',function(){
		$('.right-side').load('./pages/templates/reports.html', { date : Date() });
	});
});