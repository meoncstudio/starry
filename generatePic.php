<?php
	
	ini_set('display_errors',1);
	ini_set('display_startup_errors',1);
	error_reporting(-1);
	ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
	
	header("Content-type:text/html;charset=utf-8");
	header ( 'Content-type: image/png' ); 
	$font_size = 18; //字体大小 14px
	$text = 'Yunfan Yang';
	$font = 'font/RTWSShangGoG0v1/LightCond.otf';
	$font  =   iconv("UTF-8","gb2312",$font);
	$fontarea = imagettfbbox($font_size,0,$font,$text); //确定会变化的字符串的位置
	$text_width = $fontarea[2]-$fontarea[0]+($font_size/3); //字符串文本框长度
	$text_height = $fontarea[1]-$fontarea[7]+($font_size/3) + 5; ////字符串文本框高度
	$im = imagecreate( $text_width , $text_height );
	$color = imagecolorallocate ( $im , 0 , 0 , 0);  //文本色彩
	
	imagealphablending($im , false);
	imagesavealpha($im , true);
	imageantialias($im, true);
	
	$bg = imagecolorallocatealpha($im, 255, 255, 255, 127);
    imagefill($im, 0, 0, $bg);
	
	
	imagettftext ( $im , $font_size , 0 , 0, $text_height - ($font_size/2.5) , $color , $font , $text ); 
	
	/**
	ob_start ();
	imagepng ($im);
	$image_data = ob_get_contents ();
	ob_end_clean ();
	
	$image_data_base64 = "data:image/png;base64,". base64_encode ($image_data);
	echo $image_data_base64;
	**/
	imagepng ($im);
	
	imagedestroy ($im);
	
?>