$(document).ready(function(){
	$('#menu-dashboard').parent().attr('class','active');
	$('.right-side').load('./pages/templates/dashboard.html', { date : Date() });

	$('#menu-reservation').on('click',function(){
		$("[class^='active']").each(function(i){
            $(this).removeAttr('class');
        });
		
		$(this).parent().attr('class','active');
		$('.right-side').load('./pages/templates/reservation/index.html', { date : Date() });
	});

	$('#menu-dashboard').on('click',function(){
		$("[class^='active']").each(function(i){
            $(this).removeAttr('class');
        });
		
		$(this).parent().attr('class','active');
		$('.right-side').load('./pages/templates/dashboard.html', { date : Date() });
	});

	$('#menu-attractions').on('click',function(){
		$("[class^='active']").each(function(i){
            $(this).removeAttr('class');
        });

		$(this).parent().attr('class','active');
		$('.right-side').load('./pages/templates/attractions/index.html', { date : Date() });
	});

	$('#menu-getataxi').on('click',function(){
		$("[class^='active']").each(function(i){
            $(this).removeAttr('class');
        });

		$(this).parent().attr('class','active');
		$('.right-side').load('./pages/templates/getataxi/index.html', { date : Date() });
	});

	// $('#menu-orders').on('click',function(){
	// 	$("[class^='active']").each(function(i){
 //            $(this).removeAttr('class');
 //        });

	// 	$(this).parent().attr('class','active');
	// 	$('.right-side').load('./pages/templates/orders.html', { date : Date() });
	// });

	// $('#menu-report').on('click',function(){
	// 	$("[class^='active']").each(function(i){
 //            $(this).removeAttr('class');
 //        });

	// 	$(this).parent().attr('class','active');
	// 	$('.right-side').load('./pages/templates/reports.html', { date : Date() });
	// });

	// $('#edit-profile').on('click',function(){
	// 	$("[class^='active']").each(function(i){
 //            $(this).removeAttr('class');
 //        });
        
	// 	$('.right-side').load('./pages/templates/profile.html', { date : Date() });
	// });
});

//SHOUTOUT
function shout(type,msg){
	$( "#shoutout" ).shoutout({
		type : type,
		msg : msg
	});
}

