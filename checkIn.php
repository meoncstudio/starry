<?php
	
	ini_set('display_errors',1);
	ini_set('display_startup_errors',1);
	error_reporting(-1);
	ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
	
	Session_Start();
	
	
	require('database.php');
	require('method.php');
	require('ini.php');
	
	$ADM = false;
	@$ADM = $_SESSION['ADM'];
	if($ADM != true){
		header('Location: index.php');
		die();
	}
	
	
	
	
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <title>  </title>
  <link rel="stylesheet" href="https://bj.bcebos.com/v1/leafer/Starry/layui-v2.2.6/css/layui.css" media="all">
  <link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
  <link rel="stylesheet" href="https://anijs.github.io/lib/anicollection/anicollection.css">
  <!--<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>-->
  <link href='https://gz.bcebos.com/v1/myexams/css/font.css?1.2' rel='stylesheet' type='text/css' />

  <style>
    body{
		width: 100%;
		margin: 0px;
		padding: 0px;
		max-width: 500px;
		background: #000;
		text-align: center;
		overflow-y: hidden;
	}
	
	img{
		width: 100%;
	}
	.deepIndex{
		max-width: 500px;
		position: fixed;
		z-index: -3000;
	}
	.coverIndex{
		background: rgba(250, 250, 250, 1);
		color: #000;
		text-align: center;
		padding-top: 40px;
		padding-bottom: 100px;
		z-index: 300000 !important;
		max-width: 500px;
		left: 0px;
		bottom: -100%; 
		height: 250px; 
		box-shadow: 0 1px 40px rgba(0,0,0,.25);
		position: fixed; 
		//border-top-left-radius: 10px; 
		//border-top-right-radius: 10px;
	}
	
	.bg{
		margin: 0;
		padding: 0;
		top: 0px;
		background: url("https://bj.bcebos.com/v1/leafer/Starry/img/bg.png") no-repeat center;
		background-size: cover;
		text-align: center;
		z-index: -30000;
		position: fixed;
		height: 100%;
		width: 100%;
		max-width: 500px;
	}
	.layui-input{
		margin: 7px 0;
	}
	.layui-btn{
		border-radius: 0;
		background: -webkit-linear-gradient(left, rgb(139,43,155), rgb(204,51,153));
		background: linear-gradient(to right, rgb(139,43,155), rgb(204,51,153));
	}
	.invitation-btn{
		border-radius: 0;
		background: -webkit-linear-gradient(left, rgb(255,102,153), rgb(255,0,102));
		background: linear-gradient(to right, rgb(255,102,153), rgb(255,0,102));
	}
	.wechat-pay-btn{
		background: -webkit-linear-gradient(left, #00b09b, #96c93d);
		background: linear-gradient(to right, #00b09b, #96c93d);
	}
	.layui-input{
		border-radius: 0;
	}
	.layui-input:focus{
		border: 1px solid rgb(150,47,148);
	}
	.hide{
		display: none;
	}
	.text-purple{
		color: rgb(150,47,148);
	}
	.avator{
		border-radius: 50%;
		height: 250px;
		width: 250px;
		box-shadow: 0px 0px 30px rgba(166,166,166,.85);
		background: url("https://bj.bcebos.com/v1/leafer/Starry/img/avator.png") no-repeat center;
		background-size: cover;
		margin: 12px auto;
		overflow: hidden;
		cursor: pointer;
	}
	.button{
		cursor: pointer;
	}
	.menuIndex{
		
		background: rgba(0, 0, 0, 0);
		height: 100%;
		width: 100%;
		z-index: 100 !important;
		max-width: 500px;
		position: fixed;
		top: 0px;
		overflow-y:scroll;
		color: #fff;
		padding: 20px 0px;
		text-align: center;
		padding-bottom: 50px;
		
	}
	.items{
		
		border: 1px solid #fff;
		color: #000;
		padding: 15px 30px;
		padding-right: 70px;
		font-size: 16px;
		margin: 15px 20px;
		text-align: left;
		background: rgba(255, 255, 255, 1);
		position: relative;
		transition: all 0.2s;
		border-radius: 3px;
		box-shadow: 0 1px 30px rgba(255,255,255,.25);
		cursor: pointer;
		
	}
	
	.items-static{
		
		border: 1px solid #fff;
		color: #000;
		padding: 30px 30px;
		font-size: 16px;
		margin: 15px 20px;
		text-align: left;
		background: rgba(255, 255, 255, 1);
		position: relative;
		transition: all 0.2s;
		border-radius: 3px;
		box-shadow: 0 1px 30px rgba(255,255,255,.25);
		cursor: pointer;
		
	}
	
	.items:hover{
		
		background: rgba(255, 255, 255, .9);
		color: #000;
		transition: all 0.2s;
		
	}
	
	.items-right-arrow{
		
		right: 30px;
		top: 50%;
		transform: translateY(-50%);
		position: absolute;
		font-size: 32px;
		
	}
	
	.items-description{
		font-size: 12px;
	}
	
	.items-title{
		font-size: 18px;
		font-weight: 400;
	}
	
	.blur {
		background: -webkit-linear-gradient(top, rgb(139,43,155), rgb(204,51,153));
		background: linear-gradient(to bottom, rgb(139,43,155), rgb(204,51,153));
	}
	
	.blur2{
		background: -webkit-linear-gradient(top, #00b09b, #96c93d);
		background: linear-gradient(to bottom, #00b09b, #96c93d);
	}
	
	.blur3{
		background: -webkit-linear-gradient(top, rgb(255, 124, 128), rgb(255, 102, 0));
		background: linear-gradient(to bottom, rgb(255, 124, 128), rgb(255, 102, 0));
	}
	
	b{
		font-weight: bold;
	}
	

	#stars {
		width: 1px;
		height: 1px;
		z-index: -5000;
		border-radius: 50%;
		background: transparent;
		box-shadow: 1804px 1265px #FFF , 365px 332px #FFF , 86px 1888px #FFF , 1888px 484px #FFF , 199px 1489px #FFF , 1459px 1010px #FFF , 807px 388px #FFF , 855px 558px #FFF , 83px 1095px #FFF , 1418px 377px #FFF , 677px 886px #FFF , 862px 1709px #FFF , 1058px 1085px #FFF , 50px 1772px #FFF , 1941px 1544px #FFF , 377px 900px #FFF , 184px 712px #FFF , 1797px 1928px #FFF , 507px 1861px #FFF , 1849px 19px #FFF , 1399px 200px #FFF , 972px 497px #FFF , 795px 1109px #FFF , 746px 970px #FFF , 1524px 972px #FFF , 1631px 389px #FFF , 1026px 1016px #FFF , 1295px 862px #FFF , 1258px 1876px #FFF , 791px 189px #FFF , 1519px 45px #FFF , 592px 1405px #FFF , 620px 130px #FFF , 1044px 1171px #FFF , 37px 1578px #FFF , 1589px 86px #FFF , 1024px 528px #FFF , 1613px 568px #FFF , 912px 1175px #FFF , 1177px 133px #FFF , 67px 1641px #FFF , 1168px 357px #FFF , 310px 1873px #FFF , 1187px 573px #FFF , 308px 1839px #FFF , 565px 24px #FFF , 1691px 1555px #FFF , 1384px 1551px #FFF , 179px 861px #FFF , 1850px 1966px #FFF , 1169px 1979px #FFF , 1182px 1522px #FFF , 616px 751px #FFF , 1083px 908px #FFF , 684px 766px #FFF , 67px 955px #FFF , 1813px 1714px #FFF , 1256px 1413px #FFF , 332px 803px #FFF , 1670px 1921px #FFF , 362px 211px #FFF , 1513px 423px #FFF , 1304px 1145px #FFF , 1292px 1168px #FFF , 611px 802px #FFF , 1297px 575px #FFF , 540px 1289px #FFF , 1551px 1678px #FFF , 1545px 237px #FFF , 423px 138px #FFF , 1088px 28px #FFF , 642px 1637px #FFF , 429px 1293px #FFF , 1276px 1900px #FFF , 1168px 1696px #FFF , 847px 837px #FFF , 151px 1395px #FFF , 1490px 75px #FFF , 1588px 131px #FFF , 1739px 1358px #FFF , 709px 624px #FFF , 343px 502px #FFF , 1342px 1690px #FFF , 175px 1722px #FFF , 964px 1299px #FFF , 892px 1326px #FFF , 519px 1142px #FFF , 1014px 193px #FFF , 1181px 360px #FFF , 325px 139px #FFF , 482px 1199px #FFF , 613px 8px #FFF , 1976px 1125px #FFF , 346px 60px #FFF , 1565px 818px #FFF , 268px 1590px #FFF , 213px 1666px #FFF , 800px 464px #FFF , 974px 1825px #FFF , 1066px 23px #FFF , 1995px 1499px #FFF , 666px 1130px #FFF , 1074px 1710px #FFF , 1636px 1483px #FFF , 1379px 1509px #FFF , 1221px 887px #FFF , 1857px 964px #FFF , 1046px 993px #FFF , 1875px 643px #FFF , 1504px 1607px #FFF , 1065px 641px #FFF , 1095px 752px #FFF , 566px 1737px #FFF , 1972px 1778px #FFF , 146px 1517px #FFF , 1923px 588px #FFF , 557px 881px #FFF , 1885px 1950px #FFF , 1739px 1598px #FFF , 1048px 501px #FFF , 1316px 705px #FFF , 1900px 1697px #FFF , 1187px 917px #FFF , 1688px 1025px #FFF , 648px 1634px #FFF , 1002px 572px #FFF , 603px 1995px #FFF , 215px 693px #FFF , 688px 1374px #FFF , 1389px 1166px #FFF , 1310px 1140px #FFF , 245px 587px #FFF , 845px 63px #FFF , 296px 1646px #FFF , 792px 350px #FFF , 756px 1493px #FFF , 1553px 1079px #FFF , 850px 66px #FFF , 963px 1904px #FFF , 81px 207px #FFF , 1776px 1634px #FFF , 1759px 521px #FFF , 1761px 1536px #FFF , 601px 1485px #FFF , 898px 153px #FFF , 48px 648px #FFF , 1644px 1109px #FFF , 1974px 60px #FFF , 1278px 653px #FFF , 616px 432px #FFF , 1179px 1849px #FFF , 739px 677px #FFF , 808px 1850px #FFF , 1104px 827px #FFF , 984px 888px #FFF , 1027px 44px #FFF , 1462px 1105px #FFF , 902px 1486px #FFF , 769px 441px #FFF , 431px 1195px #FFF , 4px 764px #FFF , 562px 7px #FFF , 952px 1744px #FFF , 822px 971px #FFF , 1016px 1804px #FFF , 1429px 1161px #FFF , 328px 1568px #FFF , 101px 746px #FFF , 649px 1484px #FFF , 1903px 569px #FFF , 733px 871px #FFF , 1554px 505px #FFF , 1076px 642px #FFF , 609px 641px #FFF , 996px 149px #FFF , 1595px 758px #FFF , 14px 1083px #FFF , 261px 767px #FFF , 1274px 1517px #FFF , 1412px 215px #FFF , 1651px 879px #FFF , 284px 1633px #FFF , 1439px 287px #FFF , 1717px 270px #FFF , 1107px 1063px #FFF , 1521px 1831px #FFF , 656px 1702px #FFF , 25px 230px #FFF , 1958px 1615px #FFF , 646px 675px #FFF , 1201px 343px #FFF , 1918px 1064px #FFF , 1932px 609px #FFF , 1203px 900px #FFF , 10px 575px #FFF , 1582px 1828px #FFF , 1184px 462px #FFF , 1px 1619px #FFF , 1440px 1071px #FFF , 1844px 1913px #FFF , 376px 1054px #FFF , 1883px 1236px #FFF , 571px 493px #FFF , 354px 1701px #FFF , 747px 60px #FFF , 11px 1142px #FFF , 1136px 1891px #FFF , 1682px 473px #FFF , 1537px 1520px #FFF , 902px 836px #FFF , 1313px 395px #FFF , 534px 341px #FFF , 230px 1614px #FFF , 14px 1387px #FFF , 1296px 1765px #FFF , 1064px 1270px #FFF , 761px 975px #FFF , 1855px 335px #FFF , 198px 110px #FFF , 1660px 598px #FFF , 1022px 933px #FFF , 518px 356px #FFF , 19px 865px #FFF , 471px 830px #FFF , 758px 358px #FFF , 541px 1652px #FFF , 320px 926px #FFF , 425px 1826px #FFF , 659px 353px #FFF , 708px 778px #FFF , 862px 641px #FFF , 475px 1362px #FFF , 1326px 1449px #FFF , 446px 802px #FFF , 391px 1169px #FFF , 496px 39px #FFF , 1534px 934px #FFF , 1822px 1809px #FFF , 1454px 237px #FFF , 187px 1555px #FFF , 1069px 1977px #FFF , 1880px 1508px #FFF , 279px 418px #FFF , 1938px 1980px #FFF , 1304px 530px #FFF , 1763px 187px #FFF , 1945px 1642px #FFF , 311px 1490px #FFF , 770px 1598px #FFF , 263px 330px #FFF , 1733px 1771px #FFF , 978px 34px #FFF , 325px 1776px #FFF , 873px 1460px #FFF , 365px 33px #FFF , 913px 1999px #FFF , 667px 1021px #FFF , 27px 572px #FFF , 950px 1858px #FFF , 448px 1205px #FFF , 1302px 1138px #FFF , 1269px 932px #FFF , 480px 132px #FFF , 770px 1871px #FFF , 952px 654px #FFF , 623px 90px #FFF , 419px 1683px #FFF , 930px 794px #FFF , 1327px 1651px #FFF , 769px 1536px #FFF , 895px 90px #FFF , 599px 1268px #FFF , 1645px 919px #FFF , 1672px 1080px #FFF , 1637px 1259px #FFF , 243px 1182px #FFF , 1509px 457px #FFF , 1374px 1469px #FFF , 751px 137px #FFF , 1097px 1008px #FFF , 1979px 1381px #FFF , 981px 1825px #FFF , 928px 1930px #FFF , 632px 422px #FFF , 812px 341px #FFF , 1077px 1832px #FFF , 203px 1452px #FFF , 664px 1531px #FFF , 1203px 57px #FFF , 1654px 1203px #FFF , 491px 174px #FFF , 1507px 735px #FFF , 964px 896px #FFF , 52px 1718px #FFF , 1435px 26px #FFF , 753px 635px #FFF , 890px 1847px #FFF , 42px 1353px #FFF , 717px 72px #FFF , 1845px 1212px #FFF , 344px 867px #FFF , 418px 855px #FFF , 899px 1124px #FFF , 1798px 1582px #FFF , 1774px 760px #FFF , 908px 1567px #FFF , 1647px 1210px #FFF , 299px 82px #FFF , 1179px 1317px #FFF , 938px 1580px #FFF , 82px 921px #FFF , 657px 1596px #FFF , 892px 1264px #FFF , 1161px 819px #FFF , 607px 1447px #FFF , 605px 679px #FFF , 1642px 595px #FFF , 1963px 525px #FFF , 1656px 1591px #FFF , 1467px 1743px #FFF , 167px 1420px #FFF , 471px 492px #FFF , 1077px 932px #FFF , 774px 1282px #FFF , 799px 701px #FFF , 400px 258px #FFF , 235px 1937px #FFF , 894px 562px #FFF , 1277px 907px #FFF , 435px 1360px #FFF , 507px 1253px #FFF , 1022px 833px #FFF , 351px 773px #FFF , 1126px 1969px #FFF , 1382px 1620px #FFF , 411px 59px #FFF , 187px 906px #FFF , 644px 1364px #FFF , 1721px 1451px #FFF , 1879px 1390px #FFF , 1396px 318px #FFF , 1002px 891px #FFF , 1930px 1454px #FFF , 1952px 496px #FFF , 1308px 1325px #FFF , 343px 475px #FFF , 285px 373px #FFF , 1329px 1591px #FFF , 901px 1875px #FFF , 966px 254px #FFF , 1624px 1577px #FFF , 371px 589px #FFF , 1918px 1494px #FFF , 841px 589px #FFF , 873px 1657px #FFF , 970px 1697px #FFF , 1354px 975px #FFF , 807px 1099px #FFF , 384px 1608px #FFF , 1600px 1739px #FFF , 110px 1310px #FFF , 687px 1611px #FFF , 324px 394px #FFF , 1267px 224px #FFF , 1122px 1919px #FFF , 1753px 578px #FFF , 611px 479px #FFF , 1494px 475px #FFF , 1595px 368px #FFF , 304px 1379px #FFF , 1663px 87px #FFF , 1789px 1471px #FFF , 941px 1861px #FFF , 287px 657px #FFF , 1882px 217px #FFF , 1766px 1960px #FFF , 144px 966px #FFF , 872px 943px #FFF , 1705px 1909px #FFF , 1318px 1173px #FFF , 1856px 1549px #FFF , 1722px 1482px #FFF , 196px 594px #FFF , 355px 1182px #FFF , 1242px 112px #FFF , 226px 344px #FFF , 674px 895px #FFF , 210px 2px #FFF , 1224px 488px #FFF , 220px 617px #FFF , 1857px 1348px #FFF , 426px 1026px #FFF , 1370px 720px #FFF , 109px 440px #FFF , 1940px 1575px #FFF , 978px 1443px #FFF , 308px 614px #FFF , 1392px 1351px #FFF , 635px 1231px #FFF , 1132px 616px #FFF , 756px 342px #FFF , 1968px 765px #FFF , 1020px 1877px #FFF , 1998px 1325px #FFF , 1296px 1303px #FFF , 1817px 223px #FFF , 1184px 907px #FFF , 546px 845px #FFF , 51px 705px #FFF , 1421px 735px #FFF , 1255px 700px #FFF , 249px 1908px #FFF , 1701px 351px #FFF , 173px 1658px #FFF , 1088px 1476px #FFF , 1930px 1787px #FFF , 689px 1312px #FFF , 615px 1006px #FFF , 1870px 1229px #FFF , 1900px 546px #FFF , 1416px 141px #FFF , 1983px 945px #FFF , 1104px 1351px #FFF , 426px 701px #FFF , 431px 1597px #FFF , 893px 456px #FFF , 1976px 1914px #FFF , 1538px 673px #FFF , 916px 1386px #FFF , 304px 138px #FFF , 1038px 681px #FFF , 1349px 1740px #FFF , 1231px 552px #FFF , 35px 1435px #FFF , 588px 652px #FFF , 793px 575px #FFF , 542px 926px #FFF , 1252px 25px #FFF , 831px 332px #FFF , 718px 283px #FFF , 1327px 1952px #FFF , 1019px 704px #FFF , 888px 1117px #FFF , 1107px 1378px #FFF , 532px 505px #FFF , 1070px 552px #FFF , 346px 645px #FFF , 63px 1783px #FFF , 775px 879px #FFF , 165px 160px #FFF , 788px 1225px #FFF , 1562px 1520px #FFF , 56px 1522px #FFF , 439px 498px #FFF , 1988px 1521px #FFF , 254px 1363px #FFF , 1162px 816px #FFF , 219px 386px #FFF , 1789px 1315px #FFF , 1090px 1415px #FFF , 1361px 315px #FFF , 825px 1306px #FFF , 92px 548px #FFF , 1501px 1946px #FFF , 350px 1735px #FFF , 459px 1533px #FFF , 1417px 931px #FFF , 1849px 174px #FFF , 220px 1084px #FFF , 1357px 209px #FFF , 1974px 358px #FFF , 90px 808px #FFF , 1247px 765px #FFF , 1878px 725px #FFF , 1415px 87px #FFF , 1253px 943px #FFF , 1455px 1919px #FFF , 1321px 337px #FFF , 1210px 1600px #FFF , 1855px 1575px #FFF , 325px 936px #FFF , 1118px 892px #FFF , 703px 294px #FFF , 89px 891px #FFF , 239px 1548px #FFF , 280px 262px #FFF , 1401px 555px #FFF , 1092px 1638px #FFF , 673px 1207px #FFF , 1469px 1358px #FFF , 1253px 1986px #FFF , 1249px 1040px #FFF , 253px 484px #FFF , 1163px 775px #FFF , 426px 162px #FFF , 721px 1761px #FFF , 369px 510px #FFF , 702px 1599px #FFF , 1883px 483px #FFF , 680px 1604px #FFF , 870px 1599px #FFF , 976px 1808px #FFF , 916px 477px #FFF , 1223px 1636px #FFF , 506px 993px #FFF , 898px 1284px #FFF , 1013px 290px #FFF , 1189px 78px #FFF , 25px 588px #FFF , 960px 861px #FFF , 28px 526px #FFF , 959px 681px #FFF , 1426px 1329px #FFF , 294px 557px #FFF , 1907px 1320px #FFF , 1289px 1627px #FFF , 124px 451px #FFF , 967px 653px #FFF , 892px 1460px #FFF , 537px 1385px #FFF , 197px 1954px #FFF , 1543px 302px #FFF , 747px 1953px #FFF , 995px 1630px #FFF , 1423px 1221px #FFF , 1075px 983px #FFF , 1556px 1739px #FFF , 1068px 1425px #FFF , 81px 550px #FFF , 1668px 523px #FFF , 1158px 438px #FFF , 401px 1795px #FFF , 537px 1072px #FFF , 1px 326px #FFF , 249px 118px #FFF , 832px 1544px #FFF , 240px 153px #FFF , 651px 1077px #FFF , 1656px 542px #FFF , 1102px 606px #FFF , 1583px 788px #FFF , 1205px 1842px #FFF , 1657px 1793px #FFF , 1848px 1464px #FFF , 1285px 1395px #FFF , 662px 1227px #FFF , 1790px 134px #FFF , 577px 263px #FFF , 383px 702px #FFF , 1728px 1953px #FFF , 417px 57px #FFF , 1390px 574px #FFF , 1024px 287px #FFF , 1969px 753px #FFF , 1239px 1036px #FFF , 1063px 1313px #FFF , 1784px 1519px #FFF , 1665px 682px #FFF , 806px 1437px #FFF , 394px 917px #FFF , 904px 666px #FFF , 801px 1280px #FFF , 1392px 1930px #FFF , 1611px 1386px #FFF , 1809px 1507px #FFF , 1720px 1300px #FFF , 1721px 1287px #FFF , 969px 240px #FFF , 3px 1070px #FFF , 1198px 538px #FFF , 1416px 1001px #FFF , 1665px 1265px #FFF , 1010px 1275px #FFF , 772px 978px #FFF , 1980px 980px #FFF , 1283px 1573px #FFF , 444px 516px #FFF , 875px 737px #FFF , 258px 716px #FFF , 1698px 758px #FFF , 644px 238px #FFF , 19px 876px #FFF , 355px 1327px #FFF , 1602px 1846px #FFF , 548px 534px #FFF , 1498px 1473px #FFF , 1389px 1136px #FFF , 174px 771px #FFF , 955px 1931px #FFF , 403px 371px #FFF , 1502px 794px #FFF , 117px 876px #FFF , 536px 778px #FFF , 67px 393px #FFF , 119px 1918px #FFF , 1912px 1663px #FFF , 1141px 245px #FFF , 1105px 130px #FFF , 1218px 1608px #FFF , 662px 1502px #FFF , 1907px 927px #FFF , 521px 109px #FFF , 1885px 362px #FFF , 1785px 1935px #FFF , 781px 427px #FFF , 1446px 1991px #FFF , 164px 1539px #FFF , 1807px 1795px #FFF , 1922px 890px #FFF , 1245px 933px #FFF , 446px 450px #FFF , 1743px 79px #FFF , 1959px 310px #FFF , 1348px 749px #FFF , 1954px 128px #FFF , 1980px 1030px #FFF , 1850px 302px #FFF , 1074px 922px #FFF , 174px 403px #FFF , 1579px 733px #FFF , 653px 1958px #FFF , 1511px 1943px #FFF , 1037px 741px #FFF , 602px 1384px #FFF , 103px 402px #FFF , 1722px 1417px #FFF , 1732px 1916px #FFF , 1743px 1803px #FFF , 381px 721px #FFF , 964px 1700px #FFF , 1070px 341px #FFF , 1376px 1258px #FFF , 1884px 570px #FFF , 940px 280px #FFF , 1484px 1658px #FFF , 1806px 1875px #FFF , 1054px 917px #FFF , 1672px 103px #FFF , 783px 574px #FFF , 98px 347px #FFF , 555px 1136px #FFF , 1403px 1237px #FFF , 1203px 339px #FFF , 572px 35px #FFF , 932px 1783px #FFF , 1527px 1850px #FFF , 1959px 1109px #FFF , 892px 623px #FFF , 211px 1388px #FFF , 1581px 1806px #FFF , 868px 1053px #FFF , 1243px 1997px #FFF , 1004px 522px #FFF , 1241px 1707px #FFF , 376px 282px #FFF , 537px 878px #FFF , 1948px 979px #FFF , 532px 688px #FFF , 273px 958px #FFF , 581px 927px #FFF , 1060px 887px #FFF , 486px 1467px #FFF , 1122px 1834px #FFF , 1650px 1763px #FFF , 532px 302px #FFF , 314px 1111px #FFF , 1888px 683px #FFF , 1856px 1040px #FFF , 1780px 1338px #FFF , 24px 1564px #FFF , 1096px 1808px #FFF , 1202px 1968px #FFF , 214px 992px #FFF , 728px 515px #FFF , 247px 278px #FFF , 1670px 45px #FFF , 442px 1579px #FFF , 1143px 30px #FFF , 612px 72px #FFF , 1177px 1303px #FFF , 1898px 1255px #FFF , 378px 1667px #FFF , 326px 1929px #FFF , 1257px 766px #FFF , 1363px 1170px #FFF , 1090px 1667px #FFF , 711px 293px #FFF , 249px 1406px #FFF , 1589px 565px #FFF , 1451px 29px #FFF , 1171px 1459px #FFF , 1294px 1214px #FFF , 342px 942px #FFF , 1945px 353px #FFF , 741px 1185px #FFF , 894px 1453px #FFF , 593px 1584px #FFF , 518px 630px #FFF , 393px 756px #FFF , 34px 608px #FFF;
		animation: animStar 50s linear infinite;
	}
	#stars:after {
		content: " ";
		position: absolute;
		top: 2000px;
		z-index: -5000;
		width: 1px;
		height: 1px;
		border-radius: 50%;
		background: transparent;
		box-shadow: 1804px 1265px #FFF , 365px 332px #FFF , 86px 1888px #FFF , 1888px 484px #FFF , 199px 1489px #FFF , 1459px 1010px #FFF , 807px 388px #FFF , 855px 558px #FFF , 83px 1095px #FFF , 1418px 377px #FFF , 677px 886px #FFF , 862px 1709px #FFF , 1058px 1085px #FFF , 50px 1772px #FFF , 1941px 1544px #FFF , 377px 900px #FFF , 184px 712px #FFF , 1797px 1928px #FFF , 507px 1861px #FFF , 1849px 19px #FFF , 1399px 200px #FFF , 972px 497px #FFF , 795px 1109px #FFF , 746px 970px #FFF , 1524px 972px #FFF , 1631px 389px #FFF , 1026px 1016px #FFF , 1295px 862px #FFF , 1258px 1876px #FFF , 791px 189px #FFF , 1519px 45px #FFF , 592px 1405px #FFF , 620px 130px #FFF , 1044px 1171px #FFF , 37px 1578px #FFF , 1589px 86px #FFF , 1024px 528px #FFF , 1613px 568px #FFF , 912px 1175px #FFF , 1177px 133px #FFF , 67px 1641px #FFF , 1168px 357px #FFF , 310px 1873px #FFF , 1187px 573px #FFF , 308px 1839px #FFF , 565px 24px #FFF , 1691px 1555px #FFF , 1384px 1551px #FFF , 179px 861px #FFF , 1850px 1966px #FFF , 1169px 1979px #FFF , 1182px 1522px #FFF , 616px 751px #FFF , 1083px 908px #FFF , 684px 766px #FFF , 67px 955px #FFF , 1813px 1714px #FFF , 1256px 1413px #FFF , 332px 803px #FFF , 1670px 1921px #FFF , 362px 211px #FFF , 1513px 423px #FFF , 1304px 1145px #FFF , 1292px 1168px #FFF , 611px 802px #FFF , 1297px 575px #FFF , 540px 1289px #FFF , 1551px 1678px #FFF , 1545px 237px #FFF , 423px 138px #FFF , 1088px 28px #FFF , 642px 1637px #FFF , 429px 1293px #FFF , 1276px 1900px #FFF , 1168px 1696px #FFF , 847px 837px #FFF , 151px 1395px #FFF , 1490px 75px #FFF , 1588px 131px #FFF , 1739px 1358px #FFF , 709px 624px #FFF , 343px 502px #FFF , 1342px 1690px #FFF , 175px 1722px #FFF , 964px 1299px #FFF , 892px 1326px #FFF , 519px 1142px #FFF , 1014px 193px #FFF , 1181px 360px #FFF , 325px 139px #FFF , 482px 1199px #FFF , 613px 8px #FFF , 1976px 1125px #FFF , 346px 60px #FFF , 1565px 818px #FFF , 268px 1590px #FFF , 213px 1666px #FFF , 800px 464px #FFF , 974px 1825px #FFF , 1066px 23px #FFF , 1995px 1499px #FFF , 666px 1130px #FFF , 1074px 1710px #FFF , 1636px 1483px #FFF , 1379px 1509px #FFF , 1221px 887px #FFF , 1857px 964px #FFF , 1046px 993px #FFF , 1875px 643px #FFF , 1504px 1607px #FFF , 1065px 641px #FFF , 1095px 752px #FFF , 566px 1737px #FFF , 1972px 1778px #FFF , 146px 1517px #FFF , 1923px 588px #FFF , 557px 881px #FFF , 1885px 1950px #FFF , 1739px 1598px #FFF , 1048px 501px #FFF , 1316px 705px #FFF , 1900px 1697px #FFF , 1187px 917px #FFF , 1688px 1025px #FFF , 648px 1634px #FFF , 1002px 572px #FFF , 603px 1995px #FFF , 215px 693px #FFF , 688px 1374px #FFF , 1389px 1166px #FFF , 1310px 1140px #FFF , 245px 587px #FFF , 845px 63px #FFF , 296px 1646px #FFF , 792px 350px #FFF , 756px 1493px #FFF , 1553px 1079px #FFF , 850px 66px #FFF , 963px 1904px #FFF , 81px 207px #FFF , 1776px 1634px #FFF , 1759px 521px #FFF , 1761px 1536px #FFF , 601px 1485px #FFF , 898px 153px #FFF , 48px 648px #FFF , 1644px 1109px #FFF , 1974px 60px #FFF , 1278px 653px #FFF , 616px 432px #FFF , 1179px 1849px #FFF , 739px 677px #FFF , 808px 1850px #FFF , 1104px 827px #FFF , 984px 888px #FFF , 1027px 44px #FFF , 1462px 1105px #FFF , 902px 1486px #FFF , 769px 441px #FFF , 431px 1195px #FFF , 4px 764px #FFF , 562px 7px #FFF , 952px 1744px #FFF , 822px 971px #FFF , 1016px 1804px #FFF , 1429px 1161px #FFF , 328px 1568px #FFF , 101px 746px #FFF , 649px 1484px #FFF , 1903px 569px #FFF , 733px 871px #FFF , 1554px 505px #FFF , 1076px 642px #FFF , 609px 641px #FFF , 996px 149px #FFF , 1595px 758px #FFF , 14px 1083px #FFF , 261px 767px #FFF , 1274px 1517px #FFF , 1412px 215px #FFF , 1651px 879px #FFF , 284px 1633px #FFF , 1439px 287px #FFF , 1717px 270px #FFF , 1107px 1063px #FFF , 1521px 1831px #FFF , 656px 1702px #FFF , 25px 230px #FFF , 1958px 1615px #FFF , 646px 675px #FFF , 1201px 343px #FFF , 1918px 1064px #FFF , 1932px 609px #FFF , 1203px 900px #FFF , 10px 575px #FFF , 1582px 1828px #FFF , 1184px 462px #FFF , 1px 1619px #FFF , 1440px 1071px #FFF , 1844px 1913px #FFF , 376px 1054px #FFF , 1883px 1236px #FFF , 571px 493px #FFF , 354px 1701px #FFF , 747px 60px #FFF , 11px 1142px #FFF , 1136px 1891px #FFF , 1682px 473px #FFF , 1537px 1520px #FFF , 902px 836px #FFF , 1313px 395px #FFF , 534px 341px #FFF , 230px 1614px #FFF , 14px 1387px #FFF , 1296px 1765px #FFF , 1064px 1270px #FFF , 761px 975px #FFF , 1855px 335px #FFF , 198px 110px #FFF , 1660px 598px #FFF , 1022px 933px #FFF , 518px 356px #FFF , 19px 865px #FFF , 471px 830px #FFF , 758px 358px #FFF , 541px 1652px #FFF , 320px 926px #FFF , 425px 1826px #FFF , 659px 353px #FFF , 708px 778px #FFF , 862px 641px #FFF , 475px 1362px #FFF , 1326px 1449px #FFF , 446px 802px #FFF , 391px 1169px #FFF , 496px 39px #FFF , 1534px 934px #FFF , 1822px 1809px #FFF , 1454px 237px #FFF , 187px 1555px #FFF , 1069px 1977px #FFF , 1880px 1508px #FFF , 279px 418px #FFF , 1938px 1980px #FFF , 1304px 530px #FFF , 1763px 187px #FFF , 1945px 1642px #FFF , 311px 1490px #FFF , 770px 1598px #FFF , 263px 330px #FFF , 1733px 1771px #FFF , 978px 34px #FFF , 325px 1776px #FFF , 873px 1460px #FFF , 365px 33px #FFF , 913px 1999px #FFF , 667px 1021px #FFF , 27px 572px #FFF , 950px 1858px #FFF , 448px 1205px #FFF , 1302px 1138px #FFF , 1269px 932px #FFF , 480px 132px #FFF , 770px 1871px #FFF , 952px 654px #FFF , 623px 90px #FFF , 419px 1683px #FFF , 930px 794px #FFF , 1327px 1651px #FFF , 769px 1536px #FFF , 895px 90px #FFF , 599px 1268px #FFF , 1645px 919px #FFF , 1672px 1080px #FFF , 1637px 1259px #FFF , 243px 1182px #FFF , 1509px 457px #FFF , 1374px 1469px #FFF , 751px 137px #FFF , 1097px 1008px #FFF , 1979px 1381px #FFF , 981px 1825px #FFF , 928px 1930px #FFF , 632px 422px #FFF , 812px 341px #FFF , 1077px 1832px #FFF , 203px 1452px #FFF , 664px 1531px #FFF , 1203px 57px #FFF , 1654px 1203px #FFF , 491px 174px #FFF , 1507px 735px #FFF , 964px 896px #FFF , 52px 1718px #FFF , 1435px 26px #FFF , 753px 635px #FFF , 890px 1847px #FFF , 42px 1353px #FFF , 717px 72px #FFF , 1845px 1212px #FFF , 344px 867px #FFF , 418px 855px #FFF , 899px 1124px #FFF , 1798px 1582px #FFF , 1774px 760px #FFF , 908px 1567px #FFF , 1647px 1210px #FFF , 299px 82px #FFF , 1179px 1317px #FFF , 938px 1580px #FFF , 82px 921px #FFF , 657px 1596px #FFF , 892px 1264px #FFF , 1161px 819px #FFF , 607px 1447px #FFF , 605px 679px #FFF , 1642px 595px #FFF , 1963px 525px #FFF , 1656px 1591px #FFF , 1467px 1743px #FFF , 167px 1420px #FFF , 471px 492px #FFF , 1077px 932px #FFF , 774px 1282px #FFF , 799px 701px #FFF , 400px 258px #FFF , 235px 1937px #FFF , 894px 562px #FFF , 1277px 907px #FFF , 435px 1360px #FFF , 507px 1253px #FFF , 1022px 833px #FFF , 351px 773px #FFF , 1126px 1969px #FFF , 1382px 1620px #FFF , 411px 59px #FFF , 187px 906px #FFF , 644px 1364px #FFF , 1721px 1451px #FFF , 1879px 1390px #FFF , 1396px 318px #FFF , 1002px 891px #FFF , 1930px 1454px #FFF , 1952px 496px #FFF , 1308px 1325px #FFF , 343px 475px #FFF , 285px 373px #FFF , 1329px 1591px #FFF , 901px 1875px #FFF , 966px 254px #FFF , 1624px 1577px #FFF , 371px 589px #FFF , 1918px 1494px #FFF , 841px 589px #FFF , 873px 1657px #FFF , 970px 1697px #FFF , 1354px 975px #FFF , 807px 1099px #FFF , 384px 1608px #FFF , 1600px 1739px #FFF , 110px 1310px #FFF , 687px 1611px #FFF , 324px 394px #FFF , 1267px 224px #FFF , 1122px 1919px #FFF , 1753px 578px #FFF , 611px 479px #FFF , 1494px 475px #FFF , 1595px 368px #FFF , 304px 1379px #FFF , 1663px 87px #FFF , 1789px 1471px #FFF , 941px 1861px #FFF , 287px 657px #FFF , 1882px 217px #FFF , 1766px 1960px #FFF , 144px 966px #FFF , 872px 943px #FFF , 1705px 1909px #FFF , 1318px 1173px #FFF , 1856px 1549px #FFF , 1722px 1482px #FFF , 196px 594px #FFF , 355px 1182px #FFF , 1242px 112px #FFF , 226px 344px #FFF , 674px 895px #FFF , 210px 2px #FFF , 1224px 488px #FFF , 220px 617px #FFF , 1857px 1348px #FFF , 426px 1026px #FFF , 1370px 720px #FFF , 109px 440px #FFF , 1940px 1575px #FFF , 978px 1443px #FFF , 308px 614px #FFF , 1392px 1351px #FFF , 635px 1231px #FFF , 1132px 616px #FFF , 756px 342px #FFF , 1968px 765px #FFF , 1020px 1877px #FFF , 1998px 1325px #FFF , 1296px 1303px #FFF , 1817px 223px #FFF , 1184px 907px #FFF , 546px 845px #FFF , 51px 705px #FFF , 1421px 735px #FFF , 1255px 700px #FFF , 249px 1908px #FFF , 1701px 351px #FFF , 173px 1658px #FFF , 1088px 1476px #FFF , 1930px 1787px #FFF , 689px 1312px #FFF , 615px 1006px #FFF , 1870px 1229px #FFF , 1900px 546px #FFF , 1416px 141px #FFF , 1983px 945px #FFF , 1104px 1351px #FFF , 426px 701px #FFF , 431px 1597px #FFF , 893px 456px #FFF , 1976px 1914px #FFF , 1538px 673px #FFF , 916px 1386px #FFF , 304px 138px #FFF , 1038px 681px #FFF , 1349px 1740px #FFF , 1231px 552px #FFF , 35px 1435px #FFF , 588px 652px #FFF , 793px 575px #FFF , 542px 926px #FFF , 1252px 25px #FFF , 831px 332px #FFF , 718px 283px #FFF , 1327px 1952px #FFF , 1019px 704px #FFF , 888px 1117px #FFF , 1107px 1378px #FFF , 532px 505px #FFF , 1070px 552px #FFF , 346px 645px #FFF , 63px 1783px #FFF , 775px 879px #FFF , 165px 160px #FFF , 788px 1225px #FFF , 1562px 1520px #FFF , 56px 1522px #FFF , 439px 498px #FFF , 1988px 1521px #FFF , 254px 1363px #FFF , 1162px 816px #FFF , 219px 386px #FFF , 1789px 1315px #FFF , 1090px 1415px #FFF , 1361px 315px #FFF , 825px 1306px #FFF , 92px 548px #FFF , 1501px 1946px #FFF , 350px 1735px #FFF , 459px 1533px #FFF , 1417px 931px #FFF , 1849px 174px #FFF , 220px 1084px #FFF , 1357px 209px #FFF , 1974px 358px #FFF , 90px 808px #FFF , 1247px 765px #FFF , 1878px 725px #FFF , 1415px 87px #FFF , 1253px 943px #FFF , 1455px 1919px #FFF , 1321px 337px #FFF , 1210px 1600px #FFF , 1855px 1575px #FFF , 325px 936px #FFF , 1118px 892px #FFF , 703px 294px #FFF , 89px 891px #FFF , 239px 1548px #FFF , 280px 262px #FFF , 1401px 555px #FFF , 1092px 1638px #FFF , 673px 1207px #FFF , 1469px 1358px #FFF , 1253px 1986px #FFF , 1249px 1040px #FFF , 253px 484px #FFF , 1163px 775px #FFF , 426px 162px #FFF , 721px 1761px #FFF , 369px 510px #FFF , 702px 1599px #FFF , 1883px 483px #FFF , 680px 1604px #FFF , 870px 1599px #FFF , 976px 1808px #FFF , 916px 477px #FFF , 1223px 1636px #FFF , 506px 993px #FFF , 898px 1284px #FFF , 1013px 290px #FFF , 1189px 78px #FFF , 25px 588px #FFF , 960px 861px #FFF , 28px 526px #FFF , 959px 681px #FFF , 1426px 1329px #FFF , 294px 557px #FFF , 1907px 1320px #FFF , 1289px 1627px #FFF , 124px 451px #FFF , 967px 653px #FFF , 892px 1460px #FFF , 537px 1385px #FFF , 197px 1954px #FFF , 1543px 302px #FFF , 747px 1953px #FFF , 995px 1630px #FFF , 1423px 1221px #FFF , 1075px 983px #FFF , 1556px 1739px #FFF , 1068px 1425px #FFF , 81px 550px #FFF , 1668px 523px #FFF , 1158px 438px #FFF , 401px 1795px #FFF , 537px 1072px #FFF , 1px 326px #FFF , 249px 118px #FFF , 832px 1544px #FFF , 240px 153px #FFF , 651px 1077px #FFF , 1656px 542px #FFF , 1102px 606px #FFF , 1583px 788px #FFF , 1205px 1842px #FFF , 1657px 1793px #FFF , 1848px 1464px #FFF , 1285px 1395px #FFF , 662px 1227px #FFF , 1790px 134px #FFF , 577px 263px #FFF , 383px 702px #FFF , 1728px 1953px #FFF , 417px 57px #FFF , 1390px 574px #FFF , 1024px 287px #FFF , 1969px 753px #FFF , 1239px 1036px #FFF , 1063px 1313px #FFF , 1784px 1519px #FFF , 1665px 682px #FFF , 806px 1437px #FFF , 394px 917px #FFF , 904px 666px #FFF , 801px 1280px #FFF , 1392px 1930px #FFF , 1611px 1386px #FFF , 1809px 1507px #FFF , 1720px 1300px #FFF , 1721px 1287px #FFF , 969px 240px #FFF , 3px 1070px #FFF , 1198px 538px #FFF , 1416px 1001px #FFF , 1665px 1265px #FFF , 1010px 1275px #FFF , 772px 978px #FFF , 1980px 980px #FFF , 1283px 1573px #FFF , 444px 516px #FFF , 875px 737px #FFF , 258px 716px #FFF , 1698px 758px #FFF , 644px 238px #FFF , 19px 876px #FFF , 355px 1327px #FFF , 1602px 1846px #FFF , 548px 534px #FFF , 1498px 1473px #FFF , 1389px 1136px #FFF , 174px 771px #FFF , 955px 1931px #FFF , 403px 371px #FFF , 1502px 794px #FFF , 117px 876px #FFF , 536px 778px #FFF , 67px 393px #FFF , 119px 1918px #FFF , 1912px 1663px #FFF , 1141px 245px #FFF , 1105px 130px #FFF , 1218px 1608px #FFF , 662px 1502px #FFF , 1907px 927px #FFF , 521px 109px #FFF , 1885px 362px #FFF , 1785px 1935px #FFF , 781px 427px #FFF , 1446px 1991px #FFF , 164px 1539px #FFF , 1807px 1795px #FFF , 1922px 890px #FFF , 1245px 933px #FFF , 446px 450px #FFF , 1743px 79px #FFF , 1959px 310px #FFF , 1348px 749px #FFF , 1954px 128px #FFF , 1980px 1030px #FFF , 1850px 302px #FFF , 1074px 922px #FFF , 174px 403px #FFF , 1579px 733px #FFF , 653px 1958px #FFF , 1511px 1943px #FFF , 1037px 741px #FFF , 602px 1384px #FFF , 103px 402px #FFF , 1722px 1417px #FFF , 1732px 1916px #FFF , 1743px 1803px #FFF , 381px 721px #FFF , 964px 1700px #FFF , 1070px 341px #FFF , 1376px 1258px #FFF , 1884px 570px #FFF , 940px 280px #FFF , 1484px 1658px #FFF , 1806px 1875px #FFF , 1054px 917px #FFF , 1672px 103px #FFF , 783px 574px #FFF , 98px 347px #FFF , 555px 1136px #FFF , 1403px 1237px #FFF , 1203px 339px #FFF , 572px 35px #FFF , 932px 1783px #FFF , 1527px 1850px #FFF , 1959px 1109px #FFF , 892px 623px #FFF , 211px 1388px #FFF , 1581px 1806px #FFF , 868px 1053px #FFF , 1243px 1997px #FFF , 1004px 522px #FFF , 1241px 1707px #FFF , 376px 282px #FFF , 537px 878px #FFF , 1948px 979px #FFF , 532px 688px #FFF , 273px 958px #FFF , 581px 927px #FFF , 1060px 887px #FFF , 486px 1467px #FFF , 1122px 1834px #FFF , 1650px 1763px #FFF , 532px 302px #FFF , 314px 1111px #FFF , 1888px 683px #FFF , 1856px 1040px #FFF , 1780px 1338px #FFF , 24px 1564px #FFF , 1096px 1808px #FFF , 1202px 1968px #FFF , 214px 992px #FFF , 728px 515px #FFF , 247px 278px #FFF , 1670px 45px #FFF , 442px 1579px #FFF , 1143px 30px #FFF , 612px 72px #FFF , 1177px 1303px #FFF , 1898px 1255px #FFF , 378px 1667px #FFF , 326px 1929px #FFF , 1257px 766px #FFF , 1363px 1170px #FFF , 1090px 1667px #FFF , 711px 293px #FFF , 249px 1406px #FFF , 1589px 565px #FFF , 1451px 29px #FFF , 1171px 1459px #FFF , 1294px 1214px #FFF , 342px 942px #FFF , 1945px 353px #FFF , 741px 1185px #FFF , 894px 1453px #FFF , 593px 1584px #FFF , 518px 630px #FFF , 393px 756px #FFF , 34px 608px #FFF;
	}

	#stars2 {
		width: 2px;
		height: 2px;
		z-index: -5000;
		border-radius: 50%;
		background: transparent;
		box-shadow: 114px 658px #FFF , 236px 768px #FFF , 1130px 1503px #FFF , 486px 592px #FFF , 1353px 1407px #FFF , 1583px 1741px #FFF , 450px 1479px #FFF , 1845px 327px #FFF , 1520px 361px #FFF , 580px 1699px #FFF , 1277px 1233px #FFF , 1697px 943px #FFF , 568px 1135px #FFF , 1273px 263px #FFF , 788px 126px #FFF , 1834px 1911px #FFF , 1147px 1652px #FFF , 651px 567px #FFF , 79px 1897px #FFF , 1590px 666px #FFF , 1362px 566px #FFF , 275px 367px #FFF , 556px 479px #FFF , 1063px 476px #FFF , 1337px 1119px #FFF , 1780px 1109px #FFF , 1323px 1655px #FFF , 1740px 1165px #FFF , 525px 60px #FFF , 1513px 1484px #FFF , 708px 280px #FFF , 429px 475px #FFF , 563px 1360px #FFF , 1580px 697px #FFF , 1702px 1164px #FFF , 1649px 1952px #FFF , 1580px 1812px #FFF , 70px 1190px #FFF , 1100px 98px #FFF , 1232px 1896px #FFF , 851px 1047px #FFF , 851px 30px #FFF , 596px 1486px #FFF , 666px 526px #FFF , 1855px 1342px #FFF , 80px 531px #FFF , 248px 1804px #FFF , 1990px 263px #FFF , 1796px 1640px #FFF , 1502px 862px #FFF , 1780px 488px #FFF , 1881px 1191px #FFF , 1063px 876px #FFF , 1614px 1073px #FFF , 1414px 666px #FFF , 1865px 289px #FFF , 687px 352px #FFF , 1329px 1312px #FFF , 279px 136px #FFF , 475px 756px #FFF , 1177px 435px #FFF , 1264px 921px #FFF , 467px 1496px #FFF , 391px 1359px #FFF , 666px 1083px #FFF , 1526px 1251px #FFF , 594px 564px #FFF , 991px 525px #FFF , 1511px 875px #FFF , 1935px 1049px #FFF , 1471px 1430px #FFF , 959px 604px #FFF , 1685px 72px #FFF , 1505px 1876px #FFF , 509px 1627px #FFF , 1065px 978px #FFF , 1860px 884px #FFF , 1038px 464px #FFF , 1051px 106px #FFF , 1056px 728px #FFF , 1953px 45px #FFF , 1483px 638px #FFF , 559px 845px #FFF , 1184px 922px #FFF , 1320px 1117px #FFF , 1572px 747px #FFF , 1971px 43px #FFF , 665px 13px #FFF , 1457px 1153px #FFF , 848px 154px #FFF , 1039px 1837px #FFF , 878px 795px #FFF , 1286px 1705px #FFF , 1946px 1143px #FFF , 1114px 1166px #FFF , 1747px 874px #FFF , 1894px 636px #FFF , 1316px 541px #FFF , 1953px 1620px #FFF , 1446px 1773px #FFF , 974px 833px #FFF , 1814px 1211px #FFF , 102px 335px #FFF , 327px 1868px #FFF , 348px 548px #FFF , 353px 1540px #FFF , 1212px 1872px #FFF , 1968px 129px #FFF , 1531px 644px #FFF , 1939px 559px #FFF , 1397px 1876px #FFF , 1446px 1446px #FFF , 1721px 603px #FFF , 924px 1171px #FFF , 1086px 1954px #FFF , 1798px 310px #FFF , 21px 1595px #FFF , 1462px 1948px #FFF , 149px 1752px #FFF , 804px 318px #FFF , 1262px 636px #FFF , 1051px 100px #FFF , 392px 560px #FFF , 654px 1236px #FFF , 1889px 1159px #FFF , 498px 394px #FFF , 522px 1889px #FFF , 1198px 579px #FFF , 1437px 1866px #FFF , 1049px 1064px #FFF , 286px 921px #FFF , 993px 1790px #FFF , 1557px 1997px #FFF , 1525px 532px #FFF , 481px 1561px #FFF , 790px 683px #FFF , 141px 17px #FFF , 1202px 28px #FFF , 518px 1927px #FFF , 90px 1677px #FFF , 1258px 370px #FFF , 1379px 1536px #FFF , 607px 474px #FFF , 163px 139px #FFF , 1025px 1359px #FFF , 815px 845px #FFF , 231px 1212px #FFF , 192px 806px #FFF , 313px 1946px #FFF , 1132px 1808px #FFF , 624px 767px #FFF , 379px 722px #FFF , 733px 1847px #FFF , 628px 1517px #FFF , 1559px 929px #FFF , 234px 397px #FFF , 1230px 1231px #FFF , 849px 726px #FFF , 1148px 786px #FFF , 546px 1533px #FFF , 477px 822px #FFF , 1325px 480px #FFF , 972px 383px #FFF , 334px 958px #FFF , 1032px 664px #FFF , 1781px 40px #FFF , 38px 1335px #FFF , 1634px 1691px #FFF , 1061px 680px #FFF , 1319px 304px #FFF , 82px 1776px #FFF , 1302px 509px #FFF , 1231px 746px #FFF , 1264px 1509px #FFF , 980px 495px #FFF , 1153px 1381px #FFF , 1981px 1918px #FFF , 70px 113px #FFF , 390px 736px #FFF , 1882px 1925px #FFF , 1380px 1326px #FFF , 257px 1681px #FFF , 860px 998px #FFF , 518px 1136px #FFF , 168px 905px #FFF , 500px 1882px #FFF , 1012px 1572px #FFF , 349px 1916px #FFF , 905px 1339px #FFF , 1940px 1803px #FFF , 23px 1159px #FFF , 9px 1559px #FFF , 1658px 776px #FFF , 820px 1361px #FFF , 171px 983px #FFF , 580px 1902px #FFF , 1268px 263px #FFF , 1734px 994px #FFF , 1872px 29px #FFF , 1475px 435px #FFF;
		animation: animStar 100s linear infinite;
	}
	#stars2:after {
		content: " ";
		position: absolute;
		top: 2000px;
		z-index: -5000;
		width: 2px;
		height: 2px;
		border-radius: 50%;
		background: transparent;
		box-shadow: 114px 658px #FFF , 236px 768px #FFF , 1130px 1503px #FFF , 486px 592px #FFF , 1353px 1407px #FFF , 1583px 1741px #FFF , 450px 1479px #FFF , 1845px 327px #FFF , 1520px 361px #FFF , 580px 1699px #FFF , 1277px 1233px #FFF , 1697px 943px #FFF , 568px 1135px #FFF , 1273px 263px #FFF , 788px 126px #FFF , 1834px 1911px #FFF , 1147px 1652px #FFF , 651px 567px #FFF , 79px 1897px #FFF , 1590px 666px #FFF , 1362px 566px #FFF , 275px 367px #FFF , 556px 479px #FFF , 1063px 476px #FFF , 1337px 1119px #FFF , 1780px 1109px #FFF , 1323px 1655px #FFF , 1740px 1165px #FFF , 525px 60px #FFF , 1513px 1484px #FFF , 708px 280px #FFF , 429px 475px #FFF , 563px 1360px #FFF , 1580px 697px #FFF , 1702px 1164px #FFF , 1649px 1952px #FFF , 1580px 1812px #FFF , 70px 1190px #FFF , 1100px 98px #FFF , 1232px 1896px #FFF , 851px 1047px #FFF , 851px 30px #FFF , 596px 1486px #FFF , 666px 526px #FFF , 1855px 1342px #FFF , 80px 531px #FFF , 248px 1804px #FFF , 1990px 263px #FFF , 1796px 1640px #FFF , 1502px 862px #FFF , 1780px 488px #FFF , 1881px 1191px #FFF , 1063px 876px #FFF , 1614px 1073px #FFF , 1414px 666px #FFF , 1865px 289px #FFF , 687px 352px #FFF , 1329px 1312px #FFF , 279px 136px #FFF , 475px 756px #FFF , 1177px 435px #FFF , 1264px 921px #FFF , 467px 1496px #FFF , 391px 1359px #FFF , 666px 1083px #FFF , 1526px 1251px #FFF , 594px 564px #FFF , 991px 525px #FFF , 1511px 875px #FFF , 1935px 1049px #FFF , 1471px 1430px #FFF , 959px 604px #FFF , 1685px 72px #FFF , 1505px 1876px #FFF , 509px 1627px #FFF , 1065px 978px #FFF , 1860px 884px #FFF , 1038px 464px #FFF , 1051px 106px #FFF , 1056px 728px #FFF , 1953px 45px #FFF , 1483px 638px #FFF , 559px 845px #FFF , 1184px 922px #FFF , 1320px 1117px #FFF , 1572px 747px #FFF , 1971px 43px #FFF , 665px 13px #FFF , 1457px 1153px #FFF , 848px 154px #FFF , 1039px 1837px #FFF , 878px 795px #FFF , 1286px 1705px #FFF , 1946px 1143px #FFF , 1114px 1166px #FFF , 1747px 874px #FFF , 1894px 636px #FFF , 1316px 541px #FFF , 1953px 1620px #FFF , 1446px 1773px #FFF , 974px 833px #FFF , 1814px 1211px #FFF , 102px 335px #FFF , 327px 1868px #FFF , 348px 548px #FFF , 353px 1540px #FFF , 1212px 1872px #FFF , 1968px 129px #FFF , 1531px 644px #FFF , 1939px 559px #FFF , 1397px 1876px #FFF , 1446px 1446px #FFF , 1721px 603px #FFF , 924px 1171px #FFF , 1086px 1954px #FFF , 1798px 310px #FFF , 21px 1595px #FFF , 1462px 1948px #FFF , 149px 1752px #FFF , 804px 318px #FFF , 1262px 636px #FFF , 1051px 100px #FFF , 392px 560px #FFF , 654px 1236px #FFF , 1889px 1159px #FFF , 498px 394px #FFF , 522px 1889px #FFF , 1198px 579px #FFF , 1437px 1866px #FFF , 1049px 1064px #FFF , 286px 921px #FFF , 993px 1790px #FFF , 1557px 1997px #FFF , 1525px 532px #FFF , 481px 1561px #FFF , 790px 683px #FFF , 141px 17px #FFF , 1202px 28px #FFF , 518px 1927px #FFF , 90px 1677px #FFF , 1258px 370px #FFF , 1379px 1536px #FFF , 607px 474px #FFF , 163px 139px #FFF , 1025px 1359px #FFF , 815px 845px #FFF , 231px 1212px #FFF , 192px 806px #FFF , 313px 1946px #FFF , 1132px 1808px #FFF , 624px 767px #FFF , 379px 722px #FFF , 733px 1847px #FFF , 628px 1517px #FFF , 1559px 929px #FFF , 234px 397px #FFF , 1230px 1231px #FFF , 849px 726px #FFF , 1148px 786px #FFF , 546px 1533px #FFF , 477px 822px #FFF , 1325px 480px #FFF , 972px 383px #FFF , 334px 958px #FFF , 1032px 664px #FFF , 1781px 40px #FFF , 38px 1335px #FFF , 1634px 1691px #FFF , 1061px 680px #FFF , 1319px 304px #FFF , 82px 1776px #FFF , 1302px 509px #FFF , 1231px 746px #FFF , 1264px 1509px #FFF , 980px 495px #FFF , 1153px 1381px #FFF , 1981px 1918px #FFF , 70px 113px #FFF , 390px 736px #FFF , 1882px 1925px #FFF , 1380px 1326px #FFF , 257px 1681px #FFF , 860px 998px #FFF , 518px 1136px #FFF , 168px 905px #FFF , 500px 1882px #FFF , 1012px 1572px #FFF , 349px 1916px #FFF , 905px 1339px #FFF , 1940px 1803px #FFF , 23px 1159px #FFF , 9px 1559px #FFF , 1658px 776px #FFF , 820px 1361px #FFF , 171px 983px #FFF , 580px 1902px #FFF , 1268px 263px #FFF , 1734px 994px #FFF , 1872px 29px #FFF , 1475px 435px #FFF;
	}

	#stars3 {
		width: 3px;
		height: 3px;
		z-index: -5000;
		border-radius: 50%;
		background: transparent;
		box-shadow: 519px 875px #FFF , 1497px 751px #FFF , 1256px 88px #FFF , 1168px 1791px #FFF , 1884px 109px #FFF , 1465px 451px #FFF , 450px 370px #FFF , 1560px 703px #FFF , 1788px 1997px #FFF , 1047px 963px #FFF , 1281px 119px #FFF , 439px 96px #FFF , 164px 1956px #FFF , 1360px 930px #FFF , 1387px 347px #FFF , 1073px 1970px #FFF , 1296px 284px #FFF , 25px 1602px #FFF , 455px 944px #FFF , 1177px 738px #FFF , 633px 1142px #FFF , 1730px 1079px #FFF , 1283px 1606px #FFF , 674px 1186px #FFF , 513px 166px #FFF , 1077px 636px #FFF , 1811px 580px #FFF , 971px 1789px #FFF , 694px 1756px #FFF , 703px 1138px #FFF , 1290px 942px #FFF , 351px 1509px #FFF , 1904px 790px #FFF , 68px 819px #FFF , 1097px 362px #FFF , 1035px 331px #FFF , 180px 940px #FFF , 1776px 1229px #FFF , 1487px 781px #FFF , 1131px 1765px #FFF , 1684px 536px #FFF , 939px 367px #FFF , 1102px 1481px #FFF , 741px 887px #FFF , 167px 1132px #FFF , 1756px 529px #FFF , 608px 758px #FFF , 541px 1025px #FFF , 1976px 505px #FFF , 1349px 1257px #FFF , 815px 1388px #FFF , 505px 1351px #FFF , 33px 1945px #FFF , 861px 1695px #FFF , 678px 1360px #FFF , 1615px 727px #FFF , 1138px 726px #FFF , 30px 293px #FFF , 1624px 1044px #FFF , 683px 1242px #FFF , 1781px 1758px #FFF , 906px 1328px #FFF , 1066px 1764px #FFF , 1568px 664px #FFF , 1027px 1876px #FFF , 775px 1099px #FFF , 1605px 208px #FFF , 730px 837px #FFF , 1475px 1482px #FFF , 871px 1759px #FFF , 1240px 15px #FFF , 1987px 705px #FFF , 302px 1049px #FFF , 475px 1015px #FFF , 1843px 1296px #FFF , 493px 631px #FFF , 1613px 164px #FFF , 1863px 156px #FFF , 1479px 423px #FFF , 202px 1499px #FFF , 886px 969px #FFF , 904px 930px #FFF , 1853px 535px #FFF , 726px 914px #FFF , 435px 1205px #FFF , 1732px 1824px #FFF , 1212px 667px #FFF , 499px 31px #FFF , 552px 594px #FFF , 1715px 1814px #FFF , 775px 908px #FFF , 1949px 921px #FFF , 1267px 718px #FFF , 1830px 1960px #FFF , 338px 1325px #FFF , 466px 1120px #FFF , 140px 1675px #FFF , 1919px 664px #FFF , 1136px 771px #FFF , 1888px 1302px #FFF;
		animation: animStar 150s linear infinite;
	}
	#stars3:after {
		content: " ";
		position: absolute;
		top: 2000px;
		z-index: -5000;
		width: 3px;
		height: 3px;
		border-radius: 50%;
		background: transparent;
		box-shadow: 519px 875px #FFF , 1497px 751px #FFF , 1256px 88px #FFF , 1168px 1791px #FFF , 1884px 109px #FFF , 1465px 451px #FFF , 450px 370px #FFF , 1560px 703px #FFF , 1788px 1997px #FFF , 1047px 963px #FFF , 1281px 119px #FFF , 439px 96px #FFF , 164px 1956px #FFF , 1360px 930px #FFF , 1387px 347px #FFF , 1073px 1970px #FFF , 1296px 284px #FFF , 25px 1602px #FFF , 455px 944px #FFF , 1177px 738px #FFF , 633px 1142px #FFF , 1730px 1079px #FFF , 1283px 1606px #FFF , 674px 1186px #FFF , 513px 166px #FFF , 1077px 636px #FFF , 1811px 580px #FFF , 971px 1789px #FFF , 694px 1756px #FFF , 703px 1138px #FFF , 1290px 942px #FFF , 351px 1509px #FFF , 1904px 790px #FFF , 68px 819px #FFF , 1097px 362px #FFF , 1035px 331px #FFF , 180px 940px #FFF , 1776px 1229px #FFF , 1487px 781px #FFF , 1131px 1765px #FFF , 1684px 536px #FFF , 939px 367px #FFF , 1102px 1481px #FFF , 741px 887px #FFF , 167px 1132px #FFF , 1756px 529px #FFF , 608px 758px #FFF , 541px 1025px #FFF , 1976px 505px #FFF , 1349px 1257px #FFF , 815px 1388px #FFF , 505px 1351px #FFF , 33px 1945px #FFF , 861px 1695px #FFF , 678px 1360px #FFF , 1615px 727px #FFF , 1138px 726px #FFF , 30px 293px #FFF , 1624px 1044px #FFF , 683px 1242px #FFF , 1781px 1758px #FFF , 906px 1328px #FFF , 1066px 1764px #FFF , 1568px 664px #FFF , 1027px 1876px #FFF , 775px 1099px #FFF , 1605px 208px #FFF , 730px 837px #FFF , 1475px 1482px #FFF , 871px 1759px #FFF , 1240px 15px #FFF , 1987px 705px #FFF , 302px 1049px #FFF , 475px 1015px #FFF , 1843px 1296px #FFF , 493px 631px #FFF , 1613px 164px #FFF , 1863px 156px #FFF , 1479px 423px #FFF , 202px 1499px #FFF , 886px 969px #FFF , 904px 930px #FFF , 1853px 535px #FFF , 726px 914px #FFF , 435px 1205px #FFF , 1732px 1824px #FFF , 1212px 667px #FFF , 499px 31px #FFF , 552px 594px #FFF , 1715px 1814px #FFF , 775px 908px #FFF , 1949px 921px #FFF , 1267px 718px #FFF , 1830px 1960px #FFF , 338px 1325px #FFF , 466px 1120px #FFF , 140px 1675px #FFF , 1919px 664px #FFF , 1136px 771px #FFF , 1888px 1302px #FFF;
	}
	
	#cloud{
		left: 500px;
		animation: animCloud 200s linear infinite;
		position: fixed;
		bottom: 15px;
		width: 600px;
		z-index: -5000;
		filter: alpha(opacity: 50); 
		opacity: 0.5;
		-moz-opacity:0.5;
		-khtml-opacity: 0.5;
	}
	
	@keyframes animStar {
		0% {
			transform: translateX(0px);
		}
		100% {
			transform: translateX(-2000px);
		}
	}

	@keyframes animCloud{
		0% {
			transform: translateX(0);
		}
		100% {
			transform: translateX(-2000px);
		}
	}
	
	.loadingCover{
		position: fixed; 
		background: #000; 
		z-index: 99999999; 
		height: 100%; 
		width: 100%;
	}
	
	.blackCover{
		
		z-index: 10000;
		background: rgba(0, 0, 0, 0.7);
		position: absolute;
		height: 100%;
		width: 100%;
		position: absolute;
		
	}
	
	.receipt__lines {
	  padding: 0px;
	  border-top: 1px dashed #dce2d6;
	}
	.receipt__line {
	  display: -webkit-box;
	  display: -ms-flexbox;
	  display: flex;
	  -webkit-box-pack: justify;
		  -ms-flex-pack: justify;
			  justify-content: space-between;
	  font-size: 14px;
	  padding: 5px 0px;
	}
	.receipt__line__item {
	  font-weight: 300;
	  text-align: left;
	}
	.receipt__line__price {
	  font-weight: 400;
	  text-align: right;
	}
	
	.receipt__total {
	  display: -webkit-box;
	  display: -ms-flexbox;
	  display: flex;
	  margin: 0px;
	  -webkit-box-pack: justify;
		  -ms-flex-pack: justify;
			  justify-content: space-between;
	  font-size: 16px;
	  background-color: rgba(158, 213, 97, 0.25);
	  color: #000;
	}
	.receipt__total__item, .receipt__total__price {
	  font-weight: 400;
	}
	
	@keyframes tap-me{
		0%{
			width: 80%;
			transform:rotate(0deg);
		}
		25%{
			width: 85%;
			transform:rotate(5deg);
		}
		50%{
			width: 90%;
			transform:rotate(-5deg);
		}
		75%{
			width: 85%;
			transform:rotate(5deg);
		}
		100%{
			width: 80%;
			transform:rotate(0deg);
		}
	}
	
	@keyframes tap-me-2{
		0%{
			transform: translateY(-30px);
		}
		50%{
			transform: translateY(-20px);
		}
		100%{
			transform: translateY(-30px);
		}
	}

	.items-plaid{
		
		border: 1px solid #fff;
		color: #000;
		padding: 15px 15px;
		font-size: 16px;
		margin: 20px;
		text-align: left;
		background: rgba(255, 255, 255, 1);
		position: relative;
		transition: all 0.2s;
		border-radius: 3px;
		box-shadow: 0 1px 30px rgba(255,255,255,.25);
		cursor: pointer;
		
	}
	
	</style>
</head>
<body>
	
	
	
<div class="blackCover" id="fetchingDataBlackCoverTop" style="z-index: 99999999;">
	<div class="" style="position: fixed; top: 50%; transform: translateY(-50%); color: #fff; text-align: center; width: 100%;">
		<i class="fa fa-star fa-spin fa-4x"></i><br><br>
		<img src="https://bj.bcebos.com/v1/leafer/Starry/img/lang-zh/fetching-data-tip.png" style="width: 40%;" />
	</div>
</div>
	
	<script src="https://gz.bcebos.com/v1/myexams/js/jquery-3.2.1.min.js"></script>

<script src="https://bj.bcebos.com/v1/leafer/Starry/i18n/jquery.i18n.properties.js"></script> 

<script src="https://bj.bcebos.com/v1/leafer/Starry/layui-v2.2.6/layui.all.js"></script>
	
	<div id="mainMenu" class="menuIndex">
	<div class="items-static" style="color: #000;">
	
	<?php
	
	$serialCode = $_REQUEST['serialCode'];
	
	$ret = SQL("SELECT * FROM `graduation_prom_2018_tickets` WHERE  `serialCode` = '$serialCode'  ");
	if(empty($ret)){
		
		?>
		<div style="text-align: center; font-size: 18px;"><span data-lang="invalid-qr-ticket">
		<i class="fa fa-clear"></i>&nbsp;&nbsp;无效二维码：验证失败</span></div>
		<?php
		
	}else{
	
		$serialKey = $ret[0]['serialKey'];
		
		$time = $_REQUEST['time'];
		
		//echo time() - $time;
		
		if(time() - $time == 120){
			
			?>
			<div style="text-align: center; font-size: 18px;"><span data-lang="invalid-qr-ticket">
			<i class="fa fa-clear"></i>&nbsp;&nbsp;无效二维码：二维码已失效</span></div>
			<?php
			
			
		}else{
		
			$signature = md5($serialKey . $time . 'STARRY CLOUDYYOUNG GRADUATION PROM 2018' . $serialKey . $time . 'STARRY CLOUDYYOUNG GRADUATION PROM 2018' . $serialKey . $time . 'STARRY CLOUDYYOUNG GRADUATION PROM 2018' . $serialKey . $time . 'STARRY CLOUDYYOUNG GRADUATION PROM 2018' . $serialKey . $time . 'STARRY CLOUDYYOUNG GRADUATION PROM 2018');
			
			if($_REQUEST['signature'] != $signature){
				
				?>
				<div style="text-align: center; font-size: 18px;"><span data-lang="invalid-qr-ticket">
				<i class="fa fa-clear"></i>&nbsp;&nbsp;无效二维码：验证失败</span></div>
				<?php
				
			}else{
				
				$un = $ret[0]['username'];
				$studs = SQL("SELECT * FROM `graduation_prom_2018_account`  WHERE `username` = '$un'  ");
				
				?>
				
				<div class="avator" id="avator" data-anijs="if: click, do: pulse animated" style="background-image: url('data:image/png;base64,<?php echo $studs[0]['photo'] ?>')">
					<img id="avator_cover" src="https://bj.bcebos.com/v1/leafer/Starry/img/avator_cover.png" style="height: 100%; width: 100%;" />
				</div>
				
				<div style="text-align: center; font-size: 18px;">
					<div style="text-align: center;">
						<b><?php echo $studs[0]['lastName'] ?>, <?php echo $studs[0]['firstName'] ?></b> <?php echo $studs[0]['middleName'] ?><br>
						<?php echo hideStudNum($studs[0]['username']) ?>, Grade <?php echo $studs[0]['grade'] ?>, <?php echo $studs[0]['gender'] ?><br>
						<?php echo $studs[0]['conselorFirstName'] ?> <?php echo $studs[0]['conselorLastName'] ?>, <?php echo $ret[0]['type'] ?>
					</div>
				</div>
				
	<script>
	
		$('#fetchingDataBlackCoverTop').fadeOut(250);
	
	</script>
			
<?php

if($ret[0]['status'] == 'ACTIVATED'){

?>

			<div style="text-align: center; padding-top: 15px; width: 100%;">
				<a id="confirm-entered" class="layui-btn layui-btn-lg" style="width: 100%;"><i class="fa fa-check"></i>&nbsp;&nbsp;<span data-lang="confirm-entered">确认入场</span></a>
			</div>

			<script>
			
			$('#avator_cover').hide();
			
			$('#confirm-entered').click(function(){
				
				$('#fetchingDataBlackCoverTop').fadeIn(250);
				$.ajax({url:"requestCheckIn.php",
					data: {serialCode: '<?php echo $serialCode ?>'},
					dataType: 'JSON',
					timeout: 3000,
					type: 'POST',
					success: function(res){
						if(res.code == -2){
							window.location = 'http://meonc.studio/Starry';
						}else if(res.code != 0){
							layui.use('layer', function(){
								var layer = layui.layer;
								layer.msg(res.message);
							});
						}else{
							$('#confirm-entered').hide();
							$('#avator_cover').fadeIn(250);
						}
					},
					error: function (xhr,status,error){
						
					},
					complete(XHR, TS){
						$('#fetchingDataBlackCoverTop').fadeOut(250);
					}
				});
			});
			
			</script>
				
<?php

}

?>

				
				
				<?php
				
			}
		}
		
	}
	
	?>
	
	
	</div>
	</div>
	
	
	<div class="bg blur" data-anijs="if: load, on: window, do: pulse animated" id="bg2"></div>
	
	<div style="position: fixed; height: 100%; width: 100%; max-width: 500px; top: 0px; left: 0px; z-index: -5000;">
		<div id='stars'></div>
		<div id='stars2'></div>
		<div id='stars3'></div>
		<img id='cloud' src="https://bj.bcebos.com/v1/leafer/Starry/img/cloud2.png" />
	</div>
	
	
	
	
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