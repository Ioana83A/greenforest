$(document).ready(function()
{
	var is_chrome = window.chrome;
	var is_opera = window.opera;
	var is_mozilla = !(window.mozInnerScreenX == null);
	var isMac = navigator.platform.toUpperCase().indexOf('MAC')!==-1;
		if(is_chrome || is_opera)
		{
			$('#e_character').css('line-height','16px');
		}
		if(isMac)
		{
				$('#e_character').css('line-height','12px');
		}
		
		if ($('html').is('.ie8, .ie7, .ie6'))
		{
				$('#e_character').css('line-height','16px');
		}
		
		if(isMac && (is_mozilla || is_opera))
		{
			$('#prev_category').css('padding-top','1px');
			$('#prev_collection').css('padding-top','1px');
			$('#prev_project').css('padding-top','1px');
			$('#next_category').css('padding-top','1px');
			$('#next_collection').css('padding-top','1px');
			$('#next_project').css('padding-top','1px');			
		}
});