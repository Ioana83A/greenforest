
$(document).ready(function()
{
	var product_variant_text,product_variant_text_1,product_variant_text_2;
	
	
	$('.project_image').mouseenter(function(){									   
		var pic = $(this).find('img').attr('src');
		if(pic.substr(pic.length - 13) != "blank_img.jpg")  
		{
			$(this).find('img').css('box-shadow','2px 2px 2px 0px rgba(0, 0, 0, 0.35)');
			filter:progid:DXImageTransform.Microsoft.Blur(PixelRadius='15', MakeShadow='true', ShadowOpacity='0.40');
		}	
	});
	
	$('.project_image').mouseleave(function(){
									   
		$(this).find('img').css('box-shadow','none');
		
	});
	$('.arrow_back_grey').mouseenter(function(){
									   
		$(this).find('img').attr('src','images/back-arrow-over.png');
	
	});
	$('.arrow_back_grey').mouseleave(function(){
									   
		$(this).find('img').attr('src','images/back-arrow.png');
	
	});

	
	$('.product_variant').mouseenter(function(){
									 
		var img_src = $(this).find('.variant_image').val();
		$('#product_big_image').find('img').attr('src',img_src);
		$('#selected_variant').attr('id','');
		$(this).attr('id','selected_variant');
		product_variant_text = $(this).html();
		product_variant_text_1= product_variant_text.substring(0, product_variant_text.indexOf('<'));
		product_variant_text_2= product_variant_text.substring(product_variant_text.indexOf('<'), product_variant_text.length - 1);
		$(this).html('show details'+product_variant_text_2);
		
		
	});
	
	$('.product_variant').mouseleave(function(){
		$(this).html(product_variant_text);
	});
});