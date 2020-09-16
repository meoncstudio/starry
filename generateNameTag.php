<?php
	
	require('database.php');
	require('method.php');
	require('ini.php');
	
	
	$studs = array();
	$ret = SQL("SELECT `username`, `type` FROM `graduation_prom_2018_tickets` WHERE `type` = 'SINGLE' OR `type` = 'COUPLE'  OR `type` = 'ACADEMY'  ");
	
	for($t = 0; $t < count($ret); $t ++){
		
		$username = $ret[$t]['username'];
		$ret2 = SQL("SELECT `firstName`, `middleName`, `lastName`, `conselorFirstName`, `conselorLastName`, `grade`, `gender` FROM `graduation_prom_2018_account`  WHERE `username` = '$username'  ");
		$studs[$t] = array_merge($ret[$t], $ret2[0]);
	
	}
	
	
	
?>

<!DOCTYPE html>
<html>
<head>

  <link rel="stylesheet" href="resource/layui-v2.2.6/css/layui.css" media="all">
  <link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
  <!--<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>-->
  <link href='resource/font.css?1.2' rel='stylesheet' type='text/css' />
  <style>
  
  body{
	  padding: 30px;
  }
  td, th{
	  padding: 30px;
	  min-width: 180px;
  }
  b{
	  font-weight: 900;
  }
  .fa-circle{
	  font-size: 8px;
	  padding: 1px;
  }
  </style>
</head>
<body>

<table border="0">
 
<?php
	
	$column = 5;
	$row = (int)(count($studs) / $column) + 1;
	$lastRow = count($studs) % $column;
	
	for($t = 0; $t < $row; $t ++){

?>
  <tr>
    <?php
		
		if($row - 1 == $t){
			$column = $lastRow;
		}
		
		for($t2 = 0; $t2 < $column; $t2 ++){
	
	?>
		
		<td>
			<i class="fa fa-bookmark" aria-hidden="true"></i>&nbsp;&nbsp;<b><?php echo $studs[$t * $column + $t2]['lastName'] ?>, <?php echo $studs[$t * $column + $t2]['firstName'] ?></b> <?php echo $studs[$t * $column + $t2]['middleName'] ?><br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo hideStudNum($studs[$t * $column + $t2]['username']) ?>, Grade <?php echo $studs[$t * $column + $t2]['grade'] ?>, <?php echo $studs[$t * $column + $t2]['gender'] ?><br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $studs[$t * $column + $t2]['conselorFirstName'] ?> <?php echo $studs[$t * $column + $t2]['conselorLastName'] ?>, <?php echo $studs[$t * $column + $t2]['type'] ?>
		</td>
		
	<?php
	
		}
	
	?>
  </tr>
  
<?php

	}

?>

</table>


</body>
</html>

<?php


function hideStudNum($stud){
	
	if(!is_numeric($stud) || strlen($stud) < 8){
		return $stud;
	}
	if(strlen($stud) == 8){
		return hideStudNum_($stud, '●', 4, 3);
	}else if(strlen($stud) == 10){
		return hideStudNum_($stud, '●', 6, 3);
	}
}


function hideStudNum_($str, $replacement = '*', $start = 1, $length = 3)  {  
    $len = mb_strlen($str,'utf-8');  
    if ($len > intval($start+$length)) {  
        $str1 = mb_substr($str,0,$start,'utf-8');  
        $str2 = mb_substr($str,intval($start+$length),NULL,'utf-8');  
    } else {  
        $str1 = mb_substr($str,0,1,'utf-8');  
        $str2 = mb_substr($str,$len-1,1,'utf-8');      
        $length = $len - 2;          
    }  
    $new_str = $str1;  
    for ($i = 0; $i < $length; $i++) {   
        $new_str .= $replacement;  
    }  
    $new_str .= $str2;  
  
    return $new_str;  
} 

?>