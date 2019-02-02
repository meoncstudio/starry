<?php
	
	ini_set('display_errors', '1'); 
	ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
	
	require('database.php');
	require('method.php');
	include_once('QRCode/lib/QrReader.php');
	
	
	session_start();
	
	$username = 'NOT_EXIST';
	@$username = $_SESSION['un'];
	
	$ret = SQL("SELECT * FROM `graduation_prom_2018_account` WHERE `username` = '$username'");
	$identity = 'NONE';
	@$identity = $ret[0]['identity'];
	
	if(empty($ret)){
		die();
	}
	
	$mode = 1;
	@$mode = $_REQUEST['mode'];
	
	if($mode == 3){
		
		$serialCode = rand(10,99) . rand(10,99) . date('dH', time()) . rand(10,99) . date('is', time()) . rand(10,99);
		$serialKey = md5("WH MAPLE LEAF GRADUATION PROM 2018 - " . $serialCode);
		
		
		?>

<script>

	
	$('#finishPaymentInWechatBlackCover').fadeIn(250);
	
	
	$.post('CardPurchaseCallback.php', { goods_id: '998', trade_no: '0', card_password: "<?php echo $serialCode . ',' . $serialKey ?>", contact: '<?php echo $username ?>' }, function (data) {
			$('#finishPaymentInWechatBlackCover').fadeOut(250);
			$('#bill-content').hide();
			$('#finish-content').show();
	});
	
	
</script>
	<?php
	
		die();
	
	}
	
	
	$url = "http://k.1ka123.com/goods-25506.html";
	$ip = $_SERVER["REMOTE_ADDR"];
	$ip = '192.' . rand(100, 999) . '.' . rand(10,99) . '.' . rand(10,99);
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; Trident/4.0)');
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:' . $ip, 'CLIENT-IP:' . $ip));
	curl_setopt ($ch, CURLOPT_REFERER, $url); 
	$html = curl_exec($ch);
	curl_close($ch);

	

	$RequestVerificationToken = getSubstr($html, 'name="__RequestVerificationToken" type="hidden" value="', '" />');
	//echo $RequestVerificationToken;
	
	
	$url = 'http://k.1ka123.com/CreateQrPay';
	/**
	$post = array(
		'__RequestVerificationToken' => $RequestVerificationToken,
		'cardNoLength' => '0',
		'cardPwdLength' => '0',
		'cardquantity' => '1',
		'contact' => '258508898',
		'coupon_ctype' => '0',
		'coupon_value' => '0',
		'danjia' => '1.00',
		'goodid' => '25506',
		'is_discount' => '0',
		'kucun' => '301',
		'paymoney' => '1.00',
		'paytype' => 'bank', 
		'pid' => '3',
		'quantity' => '10'
	);
	**/
	
	$post = array(
		'goodid' => '25506',
		'contact' => $username,
		'quantity' => $mode,
		'pid' => '3',
		'name' => '',
		'pwd' => '',
		'phone' => ''
	);
	$options = array(
		CURLOPT_RETURNTRANSFER =>true,
		CURLOPT_HEADER =>false,
		CURLOPT_POST =>true,
		CURLOPT_POSTFIELDS => $post,
	);
	
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	//curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; Trident/4.0)');
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (iPhone; CPU iPhone OS 11_1_1 like Mac OS X) AppleWebKit/603.1.30 (KHTML, like Gecko) Version/11.1.1 Mobile/14E304 Safari/602.1');
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:' . $ip, 'CLIENT-IP:' . $ip));
	curl_setopt ($ch, CURLOPT_REFERER, $url);
	curl_setopt_array($ch, $options);
	$html = curl_exec($ch);
	curl_close($ch);
	
	
	$res = JSON_decode($html, true);
	
	//echo $res;
	//header('Location: ' . $res['data']['h5url']);
	
	$rand = rand(10,99) . date('His');
	
	?>

<script>

	lock = true;
	
	
	$('#finishPaymentInWechatBlackCover').fadeIn(250);
	
	
	var times = 0;
	
	var reload<?php echo $rand ?> = function(){
		
		times ++;
		
		if(times > 24){
			clearInterval(reload<?php echo $rand ?>);
			return;
		}
		
		$.post('checkCard.php', { no: "<?php echo $res['data']['tno'] ?>" }, function (data) {
			if (data !== "" && parseInt(data) === 3){
				//下一步操作
				$('#finishPaymentInWechatBlackCover').fadeOut(250);
				$('#bill-content').hide();
				$('#finish-content').show();
				clearInterval(reload<?php echo $rand ?>);
				times = 30;
			}
		});
	};
	
	setInterval(reload<?php echo $rand ?>, 2500);//5秒钟
	
	
	$('#finishPaymentInWechatBlackCover').click(function(){
		<?php //if($identity=='ADM') echo'//'; ?>window.location.href = "<?php echo urldecode($res['data']['h5url']) ?>";
		//window.open("<?php echo urldecode($res['data']['h5url']) ?>");
	});
	
	$('#finishPaymentInWechatBlackCover').click();
	
	
</script>
	<?php
	
	
	return;
	
	
	
	
	
	
	
	
	$url = "http://k.1ka123.com" . $ret['data']['url'];
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; Trident/4.0)');
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:' . $ip, 'CLIENT-IP:' . $ip));
	curl_setopt ($ch, CURLOPT_REFERER, $url); 
	$html = curl_exec($ch);
	curl_close($ch);
	
	
	$QRPicData = getSubstr($html, '<img class="qrcode" src="data:image/png;base64,', '" width="229" height="229" />');
	$QRPicData2 = getSubstr($html, '<img class="qrcode" src="', '" width="229" height="229" />');
	//var_dump($QRPicData);
	
	$no = getSubstr($html, "$.post('/querystatus', { no: '", "' }, function (data)");
	//echo $no;
	
	
	$fileName = "QRTemp/" . date('YmdHis', time()) . rand(1000,9999) . '.png';
	$myfile = fopen($fileName, "w");
	fwrite($myfile, base64_decode($QRPicData));
	
	$qrcode = new QrReader($fileName);  //图片路径
	$text = $qrcode->text(); //返回识别后的文本
	
	
	
	
	
	
	
?>

<img src="<?php echo $QRPicData2 ?>" />

<script type="text/javascript">
	var reload = function () {
		$.post('http://k.1ka123.com/querystatus', { no: '<?php echo $no ?>' }, function (data) {
			if (data !== "" && parseInt(data) === 3) {
				//parent.window.location.href = ("http://order.1ka123.com/cookie");
				//这里放下一步操作
			}
		});
	};
	setInterval(reload, 5000);//5秒钟
    </script>


<?php

?>