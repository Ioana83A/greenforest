
$(document).ready(function()
{
	var products_titles = new Array();
	var offset=0,i;
	var offset1=parseInt($("#offset").val());
	var product_variant_text,product_variant_text_1,product_variant_text_2;
		
	$("#hidden_products_titles li" ).each(function( index ) {
		products_titles.push($(this).html());
	
	});
	var nb_products = products_titles.length;


	for(i=offset;i<(offset+4);i++)
		{
			$(".title").eq(i).text(products_titles[i]);
		}
		
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

	
	$('.bx-prev').click(function(){
			var i,j;
			if(offset >=3) offset -= 3;
			else offset = nb_products-3;
			if(offset1 >=3) offset1 -= 3;
			else offset1 = nb_products-3;
			$(".page").text("Pagina "+((offset1/3)+1)+" din "+Math.ceil(nb_products/3));
	
			for(i=offset;i<(offset+3);i++)
			{
				j = i%3;
				$(".title").eq(j).text(products_titles[i]);
			}
	});
	
	$('.bx-next').click(function(){
		
		var i,j;
		if(offset < (nb_products-3)) offset += 3;
		else  offset=0;
		if(offset1 < (nb_products-3)) offset1 += 3;
		else  offset1=0;
		$(".page").text("Pagina "+((offset1/3)+1)+" din "+Math.ceil(nb_products/3));
		for(i=offset;i<(offset+3);i++)
		{
			j = i%3;
			
			$(".title").eq(j).text(products_titles[i]);
			
		}

		
	});
	$('.product_variant').mouseenter(function(){
									 
		var img_src = $(this).find('.variant_image').val();
		$('#product_big_image').find('img').attr('src',img_src);
		$('#selected_variant').attr('id','');
		$(this).attr('id','selected_variant');
		product_variant_text = $(this).html();
		product_variant_text_1= product_variant_text.substring(0, product_variant_text.indexOf('<'));
		product_variant_text_2= product_variant_text.substring(product_variant_text.indexOf('<'), product_variant_text.length - 1);
		$(this).html('vezi detalii'+product_variant_text_2);
		
		
	});
	
	$('.product_variant').mouseleave(function(){
		$(this).html(product_variant_text);
	});
});