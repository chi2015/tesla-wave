$(function(){
	// zen button hover
	$(" #productTellFriendLink, #productReviewLink, .navNextPrevList, .buttonRow").hover(function(){
		$(this).find("a").stop().animate({opacity:0.7}, "fast") 
	}, function(){
		$(this).find("a").stop().animate({opacity:1}, "fast")
	});
});
$(function(){
	// zen button hover
	$(".buttonRow").hover(function(){
		$(this).find("input").stop().animate({opacity:0.7}, "fast") 
	}, function(){
		$(this).find("input").stop().animate({opacity:1}, "fast")
	});
});

$(function(){
	// zen button hover
	$(".rev-but a, .button-padding a, .button a, .btn1 a, .buttons a").hover(function(){
		$(this).find("img").stop().animate({opacity:0.7}, "fast") 
	}, function(){
		$(this).find("img").stop().animate({opacity:1}, "fast")
	});
});
$(function(){
	// zen button hover
	$("#bannerOne, #bannerTwo, #bannerThree").hover(function(){
		$(this).find(".ribbon").stop().animate({ height:90}, "fast") 
	}, function(){
		$(this).find(".ribbon").stop().animate({ height:72}, "normal")
	});
});
