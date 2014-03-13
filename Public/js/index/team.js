//确定页数
$(function(){
	$('.carousel').carousel();

	// $lastPage = null;
	// $currentPage = null;
	// $lastPicture = $('div.picture1');
	// var timer = null;
	// var isStopped = false;
	// var pageCount = $('div.team-page').length;


	// // myAnimate();
	// var pageHeight = 260;
	// var totalHeight = pageHeight*(pageCount-1);
	// var top = parseInt($('div.team-pages').css('top'));


	// var backToStart = function(){
	// 	$teamPage = $('div.team-pages')
	// 	$teamPage.fadeOut(100,function(){
	// 		setTimeout(function(){
	// 		$teamPage.css('top',0);
	// 		$teamPage.css('display','block');
	// 		animateTeamPage();
	// 		},1000);	
	// 	})
			
	// }
	
	// animateTeamPage = function(){
	// 	var rise = top - totalHeight;
	// 	$('div.team-pages').animate({top: rise + "px"},12000,'linear',function(){
	// 		setTimeout(backToStart ,2000)
	// 	})
	// }
	//animateTeamPage();



	$('li.team-item').hover(function(){		
		var currentTop = parseInt($('div.team-pages').css('top'));
		
		$('div.team-pages').stop();		
		$(this).find('div.team-details').fadeIn(100);
	},function(){
		var currentTop = parseInt($('div.team-pages').css('top'));
		// if((currentTop+totalHeight) > 10){
		// //	animateTeamPage()
		// }else{
		// 	//backToStart();
		// }

		$(this).find('div.team-details').fadeOut(100);
	})		
	


});
