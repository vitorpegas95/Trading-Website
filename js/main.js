var socialShow = false;

$(document).ready(function()
{
	$("#loginBtn").click(function()
	{
		$("#login").fadeIn(1000);
	});
	
	$("#registerBtn").click(function()
	{
		$("#register").fadeIn(1000);
	});
	
	$("#pwBtn").click(function()
	{
		$("#password").toggle(1000);
	});
	
	$("#emailBtn").click(function()
	{
		$("#email").toggle(1000);
	});
	
	$("#phoneBtn").click(function()
	{
		$("#phone").toggle(1000);
	});
	
	$("#nameBtn").click(function()
	{
		$("#name").toggle(1000);
	});
	
	$("#arrowLeft").css("top", $(".social").position().top - ($(".social").height() / 2));
	//$("#arrowRight").css("top", $(".social").position().top - $(".social").height() - 30);
	
	
	$(".social").hover(function()
	{
		if(!socialShow)
		{
			$('.social').animate({
				'right' : "+=64px" //moves left
			});
			
			socialShow = true;
		}

		$("#arrowLeft").fadeOut(400);
		//$("#arrowRight").fadeIn(400);
	}, function()
	{
		if(socialShow)
		{
			$('.social').animate({
				'right' : "-=64px" //moves left
			});
			
		$("#arrowLeft").fadeIn(400);
			socialShow = false;
		}
	});
	
	/*
	$("#arrowRight").click(function()
	{
		$('.social').animate({
        'right' : "-=64px" //moves left
        });

		$("#arrowRight").fadeOut(400);
		$("#arrowLeft").fadeIn(400);
	});
  */
});

$( window ).resize(function() {
  $("#arrowLeft").css("top", $(".social").position().top - ($(".social").height() / 2));
});
