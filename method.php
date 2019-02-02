<?php

//MySQL Database
require_once 'database.php';

	function SQL($sql){
		
		$result = mysqli_query($GLOBALS['conn'], $sql);
		
		
		if(is_bool($result)){
			return $result;
		}
		
		$results = array();
		
		while ($row = mysqli_fetch_assoc($result)){
			$results[] = $row;
		}
		
		return $results;
		
	}
	
	function getSubstr($str, $leftStr, $rightStr){
		$left = strpos($str, $leftStr);
		$right = strpos($str, $rightStr,$left);
		if($left < 0 or $right < $left) return '';
		return substr($str, $left + strlen($leftStr), $right-$left-strlen($leftStr));
	}
	
	function text2Pic($text = '', $fontSize = 18, $font = 'Regular', $colorRGB = array(0, 0, 0), $alphaRGB = array(255, 255, 255)){
		
		//$fontSize = 18; //字体大小 14px
		//$text = '18020054'; 
		//$font = 'font/RTWSShangGoG0v1/LightCond.otf';
		$font = 'font/RTWSShangGoG0v1/' . $font . '.otf';
		$font  =   iconv("UTF-8","gb2312",$font);
		$fontarea = imagettfbbox($fontSize,0,$font,$text); //确定会变化的字符串的位置
		$text_width = $fontarea[2]-$fontarea[0]+($fontSize/3); //字符串文本框长度
		$text_height = $fontarea[1]-$fontarea[7]+($fontSize/3) + 5; ////字符串文本框高度
		$im = imagecreate( $text_width , $text_height );
		//$color = imagecolorallocate ( $im , 0 , 0 , 0);  //文本色彩
		$color = imagecolorallocate ($im , $colorRGB[0] , $colorRGB[1] , $colorRGB[2]);
		
		imagealphablending($im , false);
		imagesavealpha($im , true);
		imageantialias($im, true);
		
		//$bg = imagecolorallocatealpha($im, 255, 255, 255, 127);
		$bg = imagecolorallocatealpha($im, $alphaRGB[0], $alphaRGB[1], $alphaRGB[2], 127);
		imagefill($im, 0, 0, $bg);
		
		
		imagettftext ($im, $fontSize, 0 , 0, $text_height - ($fontSize/2.5), $color, $font, $text); 
		
		ob_start ();
		imagepng ($im);
		$image_data = ob_get_contents ();
		ob_end_clean ();
		
		$image_data_base64 = base64_encode ($image_data);
		
		imagedestroy ($im);
		
		return $image_data_base64;
	
	}
	
	function compress_html($string){
		$string=str_replace("\r\n",'',$string);//清除换行符 
		$string=str_replace("\n",'',$string);//清除换行符
		$string=str_replace("\t",'',$string);//清除制表符
		$pattern=array(
			"/> *([^ ]*) *</",//去掉注释标记
			"/[\s]+/",
			"/<!--[^!]*-->/",
			"/\" /",
			"/ \"/",
			"'/\*[^*]*\*/'"
		);
		
		$replace=array (
			">\\1<",
			" ",
			"",
			"\"",
			"\"",
			""
		);
		return preg_replace($pattern, $replace, $string);
	}
	
	
	function getPhoto($user){
		
		$ret = $user;
		$file = strtoupper($ret['lastName'] . $ret['firstName'] . '_' . noSpace($ret['middleName'])) . '.jpg';
		$fileName = 'GradPhoto/' . $file;
		
		
		
		if(file_exists($fileName)){
			return base64_encode(file_get_contents($fileName));
		}else{
			$base64 = $ret['photo'];
			return $base64;
		}
		
	}
	
	function noSpace($str){
		return preg_replace('# #','',$str);
	}
	
	
	
	function checkTicketPurchase($username){
		
		$ret = SQL("SELECT * FROM `graduation_prom_2018_tickets` WHERE `username` = '$username' ");
		
		return !empty($ret);
		
	}
	
	function getSpecificCourse($str){
		
		$ps = $_SESSION['ps'];
		$list = $ps['account']['sections'];
		
		for($t = 0; $t < count($list); $t ++){
			if($list[$t]['name'] == $str){
				return $list[$t];
			}
		}
		
		return false;
		
	}
	
	
	function sendSMS($phone, $template, $var){
		
		require 'SUBMAIL/app_config.php';
		require_once('SUBMAIL/SUBMAILAutoload.php');
		
		$submail=new MESSAGEXsend($message_configs);
		$submail->setTo($phone);
		
		$submail->SetProject($template);
		for($t = 0; $t < count($var); $t ++){
			$submail->AddVar($var[$t]['key'],$var[$t]['value']);
		}
		
		$xsend=$submail->xsend();
		return $xsend;
		
	}
	
	function isBindedPhone($ret){
		
		if(empty($ret[0]['phone'])){
			return false;
		}
		return true;
		
	}
	
	function base64ToPic($base64){
		
		return base64_decode($base64);
		
	}
	
	

?>