$(document).ready(function()
{		
$("#collections").mouseenter(function(){
	$(this).find($('img')).attr('src','images/down_arrow_hover.jpg');
	
});
$("#collections").mouseleave(function(){
	$(this).find($('img')).attr('src','images/down_arrow.jpg');
	
});
$("#colectii").mouseenter(function(){
	$(this).find($('img')).attr('src','images/down_arrow_hover.jpg');
	
});
$("#colectii").mouseleave(function(){
  
	$(this).find($('img')).attr('src','images/down_arrow.jpg');
	
});
$("#produse").mouseenter(function(){
	$(this).find($('img')).attr('src','images/down_arrow_hover.jpg');
	
});
$("#produse").mouseleave(function(){
  
	$(this).find($('img')).attr('src','images/down_arrow.jpg');
	
});
$("#proiecte").mouseenter(function(){
	$(this).find($('img')).attr('src','images/down_arrow_hover.jpg');
	
});
$("#proiecte").mouseleave(function(){
  
	$(this).find($('img')).attr('src','images/down_arrow.jpg');
	
});

$(".ddsubmenustyle li a").mouseenter(function(){
	$(this).find($('img')).attr('src','images/arrow_right_green.png');
});
$(".ddsubmenustyle li a").mouseleave(function(){
	$(this).find($('img')).attr('src','images/arrow_right_white.gif');
});

$("#ddsubmenu1 a").mouseenter(function(){
	$("#colectii").find($('img')).attr('src','images/down_arrow_hover.jpg');
});
$("#ddsubmenu1").mouseleave(function(){
	$("#colectii").find($('img')).attr('src','images/down_arrow.jpg');
});

$("#ddsubmenu2 a").mouseenter(function(){
	$("#produse").find($('img')).attr('src','images/down_arrow_hover.jpg');
});
$("#ddsubmenu2").mouseleave(function(){
	$("#produse").find($('img')).attr('src','images/down_arrow.jpg');
});
$("#ddsubmenu3 a").mouseenter(function(){
	$("#proiecte").find($('img')).attr('src','images/down_arrow_hover.jpg');
});
$("#ddsubmenu3").mouseleave(function(){
	$("#proiecte").find($('img')).attr('src','images/down_arrow.jpg');
});
$("#ddsubmenu11 a").mouseenter(function(){
	$("#collections").find($('img')).attr('src','images/down_arrow_hover.jpg');
});
$("#ddsubmenu11").mouseleave(function(){
	$("#collections").find($('img')).attr('src','images/down_arrow.jpg');
});

$("#facebook").mouseenter(function(){
	$(this).find($('img')).attr('src','images/facebook_hover.png');
});

$("#facebook").mouseleave(function(){
	$(this).find($('img')).attr('src','images/facebook.png');
});
});