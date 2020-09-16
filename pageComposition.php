<?php
	
	Session_Start();
	
	
	require('database.php');
	require('method.php');
	require('ini.php');

	
	
	
	$func = $_REQUEST['func'];
	
	$op = '';
	@$op = $_REQUEST['op'];
	if($op == 'logout'){
		$_SESSION['un'] = 'NOT_EXIST';
		session_destroy();
	}
	
	
	$username = 'NOT_EXIST';
	@$username = $_SESSION['un'];
	
	
	$ret = SQL("SELECT * FROM `graduation_prom_2018_account` WHERE `username` = '$username'");
	
	
	
	if(empty($ret)){
		die();
	}
	
	
	$identity = $ret[0]['identity'];
	if(STARRY_UPDATE && $identity != 'ADM'){
		echo '<span data-lang="updating"></span><script>changeLang();</script>';
		die();
	}
	
	
	
	if($func == 'mainMenu'){
		
		$time = date('Y-m-d H:i:s');
		SQL("UPDATE `graduation_prom_2018_account` SET  `activeTime`='$time'  WHERE `username` = '$username'  ");
		
		
		$identity = $ret[0]['identity'];
			
		?>
			
			<div id="select-entrance">
				<img id="select-entrance-title" src="resource/img/lang-zh/select-entrance.png" style="width: 70%;" />
			
			
			<?php
			
				if(isBindedPhone($ret) == false){
			
			?>
			
			<div class="items" id="BindingPhone">
				<div class="items-title"><span data-lang="bind-phone">绑定手机号</span>&nbsp;
				<img src="resource/img/lang-zh/item-active.png" style="width: 2em;" /></div>
				<div class="items-description" data-lang="bind-phone-description">绑定手机号，随时接收最新动态</div>
				<div class="items-right-arrow"><i class="fa fa-angle-right"></i></div>
				
			</div>
			
			<script>
				$('#BindingPhone').click(function(){
					switchPageDiv('binding-phone');
				});
			</script>
			
			<?php
			
				}
			
			?>
			
			<?php
			
				if((STARRY_ENTRANCE_PurchaseTicket || $identity == 'ADM') && checkTicketPurchase($username) == false && isBindedPhone($ret)){
			
			?>
			
			<div class="items" id="PurchaseTicketButton">
				<div class="items-title"><span data-lang="purchase-ticket">入场票购买</span>&nbsp;
				<img src="resource/img/lang-zh/item-active.png" style="width: 2em;" /></div>
				<div class="items-description" data-lang="purchase-ticket-description">在线购买“星空夏 2018毕业舞会”入场票，支持微信支付</div>
				<div class="items-right-arrow"><i class="fa fa-angle-right"></i></div>
				
			</div>
			
			<script>
			
				
				$('#PurchaseTicketButton').click(function(){
					switchPageDiv('ticket-type');
					setTimeout(function(){
						$('#selectTicketTypeTipWindowBlackCover').fadeIn(500);
					}, 200);
				});
				
			</script>
			
			<?php
			
				}
					
			?>
			
			
			
			<?php
			
				if((STARRY_ENTRANCE_CheckTicket || $identity == 'ADM') && checkTicketPurchase($username) == true && isBindedPhone($ret)){
			
			?>
				
				<div class="items" id="CheckMyTicketButton">
				<div class="items-title"><span data-lang="check-ticket">入场票查看</span>&nbsp;
				<img src="resource/img/lang-zh/item-active.png" style="width: 2em;" /></div>
				<div class="items-description">
				<span data-lang="check-ticket-description">在线查看我的入场票，用于激活和检票出示</span>
				<hr>
				<span data-lang="ticket-type">类型：</span>
				<?php
					
					$retu = SQL("SELECT * FROM `graduation_prom_2018_tickets` WHERE `username` = '$username'  ");
					if($retu[0]['type'] == 'SINGLE'){
						echo '<span data-lang="single-ticket">标准票 SINGLE</span>';
					}else if($retu[0]['type'] == 'COUPLE'){
						echo '<span data-lang="couple-ticket">邀请票 COUPLE</span>';
					}else if($retu[0]['type'] == 'VOLUNTEER'){
						echo '<span data-lang="volunteer-ticket">工作票 VOLUNTEER</span>';
					}else if($retu[0]['type'] == 'ACADEMY'){
						echo '<span data-lang="academy-ticket">学术票 ACADEMY</span>';
					}
					
					echo '<br><span data-lang="ticket-serial-code">编号：</span>No. ' . $retu[0]['serialCode'];
				
				?>
				</div>
				<div class="items-right-arrow"><i class="fa fa-angle-right"></i></div>
				
				
				
				
				
			</div>
			
			<script>
			
				
				$('#CheckMyTicketButton').click(function(){
					switchPageDiv('check-my-ticket');
					$('#mini-account').animate({bottom: '-100%'}, 500);
					refreshQRCode();
				});
				
			</script>
			
			<?php
			
				}
					
			?>
			
			<?php
			
				if((STARRY_ENTRANCE_BindingCouple || $identity == 'ADM') && checkTicketPurchase($username) == true && isBindedPhone($ret)){
			
			?>
				
			<div class="items" id="BindingCoupleButton">
				<div class="items-title"><span data-lang="binding-cp">绑定你的CP</span>&nbsp;
				<img src="resource/img/lang-zh/item-active.png" style="width: 2em;" /></div>
				<div class="items-description">
				<span data-lang="binding-cp-description">在线绑定你的另一半，参与【最佳情侣】评选</span>
				</div>
				<div class="items-right-arrow"><i class="fa fa-angle-right"></i></div>	
			</div>
			
			<script>
			
				
				$('#BindingCoupleButton').click(function(){
					
					$('#fetchingDataBlackCoverTop').fadeIn(250);
					var times = 0;
				
					$.ajax({url:"pageComposition.php",
						data: {func: 'bindingCouplePanel'},
						dataType: 'HTML',
						timeout: 6000,
						type: 'POST',
						async: true,
						success: function(res){
							switchPageDiv('binding-couple');
							$('#binding-couple-panel').html(res);
							$('#fetchingDataBlackCoverTop').fadeOut(250);
						},
						error: function (xhr,status,error){
							$('#BindingCoupleButton').click();
							layui.use('layer', function(){
								var layer = layui.layer;
								layer.msg($.i18n.prop('reauthenticating'));
							});
							return;
						},
						complete(XHR, TS){
							
						}
					});
					
					
				});
				
			</script>
			
			
				
			<?php
			
				}
					



			//jim_itmes	
			if((STARRY_ENTRANCE_LiveVoting || $identity == 'ADM') && checkTicketPurchase($username) == true && isBindedPhone($ret)){
				
			?>

			
			<div id="CoupleVoting" class="items">
				<div class="items-title"><span data-lang="couple-voting">【现场投票】最佳情侣 BEST COUPLE</span>&nbsp;
				<img src="resource/img/lang-zh/item-active.png" style="width: 2em;" /></div>
				<div class="items-description" data-lang="voting-description">Pick 你最喜欢的一对CP吧</div>
				<div class="items-right-arrow"><i class="fa fa-angle-right"></i></div>				
			</div>
			
			<div id="KingVoting" class="items">
				<div class="items-title"><span data-lang="king-voting">【现场投票】舞会之王 PROM KING</span>&nbsp;
				<img src="resource/img/lang-zh/item-active.png" style="width: 2em;" /></div>
				<div class="items-description" data-lang="voting-description">Pick 你最喜欢的舞会男性</div>
				<div class="items-right-arrow"><i class="fa fa-angle-right"></i></div>				
			</div>
			
			<div id="QueenVoting" class="items">
				<div class="items-title"><span data-lang="queen-voting">【现场投票】舞会之皇 PROM QUEEN</span>&nbsp;
				<img src="resource/img/lang-zh/item-active.png" style="width: 2em;" /></div>
				<div class="items-description" data-lang="voting-description">Pick 你最喜欢的舞会女性</div>
				<div class="items-right-arrow"><i class="fa fa-angle-right"></i></div>				
			</div>
			
			<script>
			
				var interv;
				
				$('#CoupleVoting').click(function(){
					
					$('#fetchingDataBlackCoverTop').fadeIn(250);
					var times = 0;
					clearInterval(interv);
				
					$.ajax({url:"pageComposition.php",
						data: {func: 'votingCoupleList'},
						dataType: 'HTML',
						timeout: 300000,
						type: 'POST',
						async: true,
						success: function(res){
							switchPageDiv('couple-voting-panel-frame');
							$('#select-couple-voting-panel').html(res);
							$('#fetchingDataBlackCoverTop').fadeOut(250);
							$('#mini-account').animate({bottom: '-100%'}, 500);
							$('#mini-votes').animate({bottom: '0%'}, 500);
						},
						error: function (xhr,status,error){
							$('#CoupleVoting').click();
							layui.use('layer', function(){
								var layer = layui.layer;
								layer.msg($.i18n.prop('reauthenticating'));
							});
							return;
						},
						complete(XHR, TS){
							
						}
					});
					
				});
				
				$('#KingVoting').click(function(){
					
					$('#fetchingDataBlackCoverTop').fadeIn(250);
					var times = 0;
					clearInterval(interv);
				
					$.ajax({url:"pageComposition.php",
						data: {func: 'votingKingList'},
						dataType: 'HTML',
						timeout: 300000,
						type: 'POST',
						async: true,
						success: function(res){
							switchPageDiv('king-voting-panel-frame');
							$('#select-king-voting-panel').html(res);
							$('#fetchingDataBlackCoverTop').fadeOut(250);
							$('#mini-account').animate({bottom: '-100%'}, 500);
							$('#mini-votes').animate({bottom: '0%'}, 500);
						},
						error: function (xhr,status,error){
							$('#KingVoting').click();
							layui.use('layer', function(){
								var layer = layui.layer;
								layer.msg($.i18n.prop('reauthenticating'));
							});
							return;
						},
						complete(XHR, TS){
							
						}
					});
					
				});
				
				$('#QueenVoting').click(function(){
					
					$('#fetchingDataBlackCoverTop').fadeIn(250);
					var times = 0;
					clearInterval(interv);
				
					$.ajax({url:"pageComposition.php",
						data: {func: 'votingQueenList'},
						dataType: 'HTML',
						timeout: 300000,
						type: 'POST',
						async: true,
						success: function(res){
							switchPageDiv('queen-voting-panel-frame');
							$('#select-queen-voting-panel').html(res);
							$('#fetchingDataBlackCoverTop').fadeOut(250);
							$('#mini-account').animate({bottom: '-100%'}, 500);
							$('#mini-votes').animate({bottom: '0%'}, 500);
						},
						error: function (xhr,status,error){
							$('#Voting').click();
							layui.use('layer', function(){
								var layer = layui.layer;
								layer.msg($.i18n.prop('reauthenticating'));
							});
							return;
						},
						complete(XHR, TS){
							
						}
					});
					
				});

			</script>

			
			
		<?php
				
			}//voting_end
			

			
			
			
				if((STARRY_ENTRANCE_PurchaseGift || $identity == 'ADM') && checkTicketPurchase($username) == true && isBindedPhone($ret)){
			
			?>
			<!--
			<div class="items" id="GiftStoreButton">
				<div class="items-title"><span data-lang="gift-store">星空 · 格子铺</span>&nbsp;
				<img src="resource/img/lang-zh/item-hot.png" style="width: 2em;" /></div>
				<div class="items-description">
				<span data-lang="gift-store-description">为你精心挑选的入场伴手礼，支持微信支付</span>
				</div>
				<div class="items-right-arrow"><i class="fa fa-angle-right"></i></div>
				
			</div>
			
			<script>
			
				
				$('#GiftStoreButton').click(function(){
					switchPageDiv('plaid-shop');
					bgSwitch('4');
					$('#mini-account').animate({bottom: '-100%'}, 500);
				});
				
			</script>
				-->
				
			<?php
			
				}
					
			?>
			
			
			<br><br><br><br><br><br><br><br><br>
			
		</div>
		<script>
			
			switchPageDiv('entrance');
			
			
			setTimeout(function(){
				$('#clickTitleBackTip').css('top' ,$('#select-entrance-title').offset().top - 8 + 'px');
				$('#clickTitleBackTipBlackCover').fadeIn(500);
			}, 1000);
			
			
			function switchPageDiv(id){
				$('#select-entrance').hide();
				$('#select-ticket-type').hide();
				$('#select-ticket-single-detail').hide();
				$('#select-ticket-couple-detail').hide();
				$('#select-ticket-academy-detail').hide();
				$('#select-ticket-volunteer-detail').hide();
				$('#select-ticket-bill').hide();
				$('#select-check-my-ticket').hide();
				$('#select-plaid-shop').hide();
				$('#select-binding-couple').hide();
				$('#select-binding-phone').hide();
				$('#select-king-voting-panel-frame').hide();
				$('#select-queen-voting-panel-frame').hide();
				$('#select-couple-voting-panel-frame').hide();
				$('#select-' + id).fadeIn(250);
			}
			
			
			$('#selectTicketTypeTipWindowBlackCover').click(function(){
				$('#selectTicketTypeTipWindowBlackCover').fadeOut(150);
			});
			
			$('#clickTitleBackTipBlackCover').click(function(){
				$('#clickTitleBackTipBlackCover').fadeOut(150);
			});
			
			
			$('#select-entrance-title').click(function(){
				layui.use('layer', function(){
					var layer = layui.layer;
					layer.msg($.i18n.prop('cannot-go-back'));
				});
			});
			
			$('#select-ticket-type-title').click(function(){
				switchPageDiv('entrance');
			});
			
		</script>
		
		<?php
			
				if((STARRY_ENTRANCE_PurchaseTicket || $identity == 'ADM') && checkTicketPurchase($username) == false && isBindedPhone($ret)){
			
			?>
			
		
			
		<div id="select-ticket-type" class="menuIndex">
			
			<img id="select-ticket-type-title" src="resource/img/lang-zh/select-ticket-type.png" style="width: 70%;" />
			<!--<img src="resource/img/lang-zh/select-ticket-type-tip.png" style="width: 70%;" />-->
			
			
			<div class="items" id="SingleTicket">
				<div class="items-title"><span data-lang="single-ticket">单人标准票 SINGLE</span> &nbsp;</div>
				<div class="items-description" data-lang="single-ticket-description">仅适用于：所有高三学生及教师团队</div>
				<div class="items-right-arrow"><i class="fa fa-angle-right"></i></div>
			</div>
			
			<div class="items" id="CoupleTicket">
				<div class="items-title"><span data-lang="couple-ticket">双人邀请票 COUPLE</span> &nbsp;</div>
				<div class="items-description" data-lang="couple-ticket-description">仅适用于：一名高三学生与一名其他年级学生</div>
				<div class="items-right-arrow"><i class="fa fa-angle-right"></i></div>
			</div>
			
			<div class="items" id="AcademyTicket">
				<div class="items-title"><span data-lang="academy-ticket">学术票 ACADEMY</span> &nbsp;</div>
				<div class="items-description" data-lang="academy-ticket-description">仅适用于：经济12、会计12和计算及媒体12学生</div>
				<div class="items-right-arrow"><i class="fa fa-angle-right"></i></div>
			</div>
			
			
			<div class="items" id="VolunteerTicket">
				<div class="items-title"><span data-lang="volunteer-ticket">工作票 VOLUNTEER</span> &nbsp;</div>
				<div class="items-description" data-lang="volunteer-ticket-description">仅适用于：舞会志愿者</div>
				<div class="items-right-arrow"><i class="fa fa-angle-right"></i></div>
			</div>
			
			
			
			<br><br><br><br><br><br><br><br><br>
			
		</div>
		
		
		<div id="select-ticket-single-detail" class="menuIndex">
		
			<img id="select-ticket-single-detail-title" src="resource/img/lang-zh/ticket-single-title.png" style="width: 60%;" />
			
			<div class="items-static" style="text-align: center; padding: 20px;">
				
				<img src="resource/img/lang-zh/ticket-single-brex.png" style="width: 100%;" />
				
				<hr>
				<div id="ticket-single-panels"></div>
				<hr>
				
				<img src="resource/img/lang-zh/ticket-explain.png" style="width: 100%;" />
				
			</div>
			<br><br><br><br><br><br><br><br><br>
			
		</div>
		
		<div id="select-ticket-couple-detail" class="menuIndex">
			
			<img id="select-ticket-couple-detail-title" src="resource/img/lang-zh/ticket-couple-title.png" style="width: 60%;" />
			
			<div class="items-static" style="text-align: center; padding: 20px;">
				
				<img src="resource/img/lang-zh/ticket-couple-brex.png" style="width: 100%;" />
				
				
				<hr>
				<div id="ticket-couple-panels"></div>
				<hr>
				
				<img src="resource/img/lang-zh/ticket-explain.png" style="width: 100%;" />
				
			</div>
			<br><br><br><br><br><br><br><br><br>
			
			
		</div>
		
		<div id="select-ticket-volunteer-detail" class="menuIndex">
			
			<img id="select-ticket-single-detail-title" src="resource/img/lang-zh/ticket-volunteer-title.png" style="width: 60%;" />
			
			<div class="items-static" style="text-align: center; padding: 20px;">
				
				<img src="resource/img/lang-zh/ticket-volunteer-brex.png" style="width: 100%;" />
				
				<img id="volunteer-price" src="resource/img/ticket-volunteer-price.png?rand=<?php echo time() ?>" style="width: 90%;" />
				
				<img src="resource/img/click-me-purchase.png" style="width: 30%; transform: translateY(-20px); animation: tap-me-2 .5s infinite;" />
				<img src="resource/img/lang-zh/ticket-explain.png" style="width: 100%;" />
				
			</div>
			<br><br><br><br><br><br><br><br><br>
			
		</div>
		
		<div id="select-ticket-academy-detail" class="menuIndex">
			
			<img id="select-ticket-academy-detail-title" src="resource/img/lang-zh/ticket-academy-title.png" style="width: 60%;" />
			
			<div class="items-static" style="text-align: center; padding: 20px;">
				
				<img src="resource/img/lang-zh/ticket-academy-brex.png" style="width: 100%;" />
				
				<hr>
				<div id="ticket-academy-panels"></div>
				<div id="ticket-academy-panels"></div>
				<hr>
				
				<img src="resource/img/lang-zh/ticket-explain.png" style="width: 100%;" />
				
			</div>
			<br><br><br><br><br><br><br><br><br>
			
		</div>
		
		
		<div id="select-ticket-bill" class="menuIndex">
			<img id="select-ticket-bill-title" src="resource/img/lang-zh/bill-title.png" style="width: 70%;" />
			<div style="margin: 0px 30px 120px 30px; background: #fff; min-height: 40%; position: relative; transition: all 1s; color: #000;" id="purchase-bill"></div>
		</div>
		
		
		
		
		<script>
			
			
			
			function switchCouplePurchasePanel(id){
				$('#ticket-couple-purchase-panel').hide();
				$('#ticket-couple-invite-panel').hide();
				$('#ticket-couple-' + id + '-panel').fadeIn(250);
			}
			
			
			var pageFrom = '';
			
			
			
			$('#select-ticket-single-detail-title').click(function(){
				switchPageDiv('ticket-type');
			});
			
			$('#select-ticket-couple-detail-title').click(function(){
				switchPageDiv('ticket-type');
			});
			
			$('#select-ticket-academy-detail-title').click(function(){
				switchPageDiv('ticket-type');
			});
			
			$('#select-ticket-volunteer-detail-title').click(function(){
				switchPageDiv('ticket-type');
			});
			
			
			$('#SingleTicket').click(function(){
				
				$('#fetchingDataBlackCoverTop').fadeIn(250);
				var times = 0;
			
				$.ajax({url:"pageComposition.php",
					data: {func: 'ticketSinglePanels'},
					dataType: 'HTML',
					timeout: 6000,
					type: 'POST',
					async: true,
					success: function(res){
						switchPageDiv('ticket-single-detail');
						$('#ticket-single-panels').html(res);
						$('#fetchingDataBlackCoverTop').fadeOut(250);
					},
					error: function (xhr,status,error){
						times ++;
						if(times < 3){
							$('#SingleTicket').click();
						}else{
							$('#fetchingDataBlackCoverTop').fadeOut(250);
						}
						layui.use('layer', function(){
							var layer = layui.layer;
							layer.msg($.i18n.prop('reauthenticating'));
						});
						return;
					},
					complete(XHR, TS){
						
					}
				});
				
				
				
			});	
			
			
			$('#CoupleTicket').click(function(){
				
				$('#fetchingDataBlackCoverTop').fadeIn(250);
				var times = 0;
			
				$.ajax({url:"pageComposition.php",
					data: {func: 'ticketDoublePanels'},
					dataType: 'HTML',
					timeout: 10000,
					type: 'POST',
					async: true,
					success: function(res){
						switchPageDiv('ticket-couple-detail');
						$('#ticket-couple-panels').html(res);
						$('#fetchingDataBlackCoverTop').fadeOut(250);
					},
					error: function (xhr,status,error){
						times ++;
						if(times < 3){
							$('#CoupleTicket').click();
						}else{
							$('#fetchingDataBlackCoverTop').fadeOut(250);
						}
						layui.use('layer', function(){
							var layer = layui.layer;
							layer.msg($.i18n.prop('reauthenticating'));
						});
						return;
					},
					complete(XHR, TS){
						
					}
				});
			
				
			});
			
			$('#AcademyTicket').click(function(){
				
				$('#fetchingDataBlackCoverTop').fadeIn(250);
			
				$.ajax({url:"pageComposition.php",
					data: {func: 'ticketAcademyPanels'},
					dataType: 'HTML',
					timeout: 6000,
					type: 'POST',
					async: true,
					success: function(res){
						switchPageDiv('ticket-academy-detail');
						$('#ticket-academy-panels').html(res);
						$('#fetchingDataBlackCoverTop').fadeOut(250);
					},
					error: function (xhr,status,error){
						$('#AcademyTicket').click();
						layui.use('layer', function(){
							var layer = layui.layer;
							layer.msg($.i18n.prop('reauthenticating'));
						});
						return;
					},
					complete(XHR, TS){
						
					}
				});
			});
			
			
			$('#VolunteerTicket').click(function(){
				layui.use('layer', function(){
					var layer = layui.layer;
					layer.msg($.i18n.prop('ticket-type-stop-selling'));
				});
			});
			
			
			var lock = false;
			
			$('#select-ticket-bill-title').click(function(){
				if(!lock){
					switchPageDiv(pageFrom);
					bgSwitch(2);
					$('#mini-account').animate({bottom: '0%'}, 500);
				}else{
					layui.use('layer', function(){
						var layer = layui.layer;
						layer.msg($.i18n.prop('cannot-leave-paying'));
					});
				}
			});
			
			
			
			
			
		</script>
		
		
		<?php
		
				}
		
		?>
		
		<?php
			
				if((STARRY_ENTRANCE_CheckTicket || $identity == 'ADM') && checkTicketPurchase($username) == true && isBindedPhone($ret)){
			
			?>
		
		<div id="select-check-my-ticket" class="menuIndex">
			
			<img id="select-check-my-ticket-title" src="resource/img/lang-zh/my-ticket-title.png" style="width: 70%;" />
			<!--<img src="resource/img/lang-zh/select-ticket-type-tip.png" style="width: 70%;" />-->
			
			
			<div class="items-static" id="my-ticket-frame" style="text-align: center; border: 0px; border-radius: 0px;">
				<img src="resource/img/qr-loading.png" id="my-ticket-qr-code" style="width: 100%" />
				
				<img src="resource/img/lang-zh/please-show-qr-code.png" style="width: 90%" />
				<div style="text-align: center; padding-top: 15px;">
					<a id="refreshCode" class="layui-btn layui-btn-lg"><i class="fa fa-refresh"></i>&nbsp;&nbsp;<span data-lang="refresh-qr-code">刷新二维码</span></a>
				</div>
				
				<img src="resource/img/ticket-top.png" style="left: 0px; width: 100%; background-repeat: repeat-x; top: 0%; transform: translateY(-100%); position: absolute;" />
				<img src="resource/img/ticket-bottom.png" style="left: 0px; width: 100%; background-repeat: repeat-x; top: 100%; position: absolute;" />
			</div>
			
			
			<br><br><br><br><br><br><br><br><br>
			
		</div>
		
		<script>
			
			$('#select-check-my-ticket-title').click(function(){
				switchPageDiv('entrance');
				$('#mini-account').animate({bottom: '0%'}, 500);
			});
			
			function refreshQRCode(){
				$('#my-ticket-qr-code').attr('src', 'resource/img/qr-loading.png');
				$('#my-ticket-qr-code').attr('src', 'pageComposition.php?func=checkMyTicket&rand=' + Math.random());
			}
			
			$('#refreshCode').click(function(){
				refreshQRCode();
			});
			
		</script>
		
				
			<?php
			
				}
			
			?>
			
			
			
		<?php
			
				if((STARRY_ENTRANCE_BindingCouple || $identity == 'ADM') && checkTicketPurchase($username) == true && isBindedPhone($ret)){
			
			?>
			
			<div id="select-binding-couple" class="menuIndex">
			
				<img id="select-binding-couple-title" src="resource/img/lang-zh/binding-couple-title.png" style="width: 60%;" />
				
				
				<div style="text-align: center; padding: 20px;" class="items-static">
					<div id="binding-couple-panel"></div>
				</div>
			
				<br><br><br><br><br><br><br><br><br>
			
			</div>
			<script>
			
				$('#select-binding-couple-title').click(function(){
					switchPageDiv('entrance');
				});
			
			
			</script>
				
		<?php
			
				}
			
			?>
			
			<?php
			
			//actual voting panel
		
			if((STARRY_ENTRANCE_LiveVoting || $identity == 'ADM') && checkTicketPurchase($username) == true && isBindedPhone($ret)){
				
				$vote = $ret[0]['vote'];
			
			?>
			
			<div id='select-couple-voting-panel-frame'>
				
				<img id="best-couple-title" src="resource/img/lang-zh/best-couple-title.png" style="width: 70%;" />
				<div id='select-couple-voting-panel'></div>
			
			</div>
			
			<script>
			
			
			$('#best-couple-title').click(function(){
				
				switchPageDiv('entrance');
				$('#mini-account').animate({bottom: '0%'}, 500);
				$('#mini-votes').animate({bottom: '-100%'}, 500);
				
				
			});
			
			</script>
			
			<div id='select-king-voting-panel-frame'>
				
				<img id="prom-king-title" src="resource/img/lang-zh/prom-king-title.png" style="width: 70%;" />
				<div id='select-king-voting-panel'></div>
			
			</div>
			
			<script>
			
			
			$('#prom-king-title').click(function(){
				
				switchPageDiv('entrance');
				$('#mini-account').animate({bottom: '0%'}, 500);
				$('#mini-votes').animate({bottom: '-100%'}, 500);
				
				
			});
			
			</script>
			
			<div id='select-queen-voting-panel-frame'>
				
				<img id="prom-queen-title" src="resource/img/lang-zh/prom-queen-title.png" style="width: 70%;" />
				<div id='select-queen-voting-panel'></div>
			
			</div>
			
			<script>
			
			
			$('#prom-queen-title').click(function(){
				
				switchPageDiv('entrance');
				$('#mini-account').animate({bottom: '0%'}, 500);
				$('#mini-votes').animate({bottom: '-100%'}, 500);
				
				
			});
			
			</script>
			
			<?php
			
			}
			
			?>
			
			<?php
			
				if(!isBindedPhone($ret)){
			
			?>
			
			<div id="select-binding-phone" class="menuIndex">
			
				<img id="select-binding-phone-title" src="resource/img/lang-zh/binding-phone-title.png" style="width: 60%;" />
				
				<div class="items-static" style="text-align: center;">
					<span data-lang="input-your-phone">请输入你的手机号</span>
					<input id="phone-input" data-lang="phone" class="layui-input" placeholder="手机号" style="text-align: center;"></input>
					<div style="text-align: center; padding-top: 15px;">
						<a id="bindPhone" class="layui-btn layui-btn-lg"><i class="fa fa-link"></i>&nbsp;&nbsp;<span data-lang="bind">绑定</span></a>
					</div>
				</div>
				
				<br><br><br><br><br><br><br><br><br>
			
			</div>
			<script>
			
				$('#select-binding-phone-title').click(function(){
					switchPageDiv('entrance');
				});
				
				$('#bindPhone').click(function(){
					
					var phone = $('#phone-input').val();
					$('#fetchingDataBlackCoverTop').fadeIn(250);
					
					$.ajax({url:"requestBindingPhone.php",
						data: {phone: phone},
						dataType: 'JSON',
						timeout: 5000,
						type: 'POST',
						success: function(res){
							if(res.code == 0){
								$('#personInfo').click();
							}
							layui.use('layer', function(){
								var layer = layui.layer;
								layer.msg($.i18n.prop(res.message));
							});
							$('#fetchingDataBlackCoverTop').fadeIn(250);
						},
						error: function (xhr,status,error){
							layui.use('layer', function(){
								var layer = layui.layer;
								layer.msg($.i18n.prop('reauthenticating'));
							});
						},
						complete(XHR, TS){
							isProcessing = false;
						}
					});
				});
			
			</script>
				
			
			<?php
			
				}
			
			?>
			
		<?php
			
				if((STARRY_ENTRANCE_PurchaseGift || $identity == 'ADM') && checkTicketPurchase($username) == true && isBindedPhone($ret)){
			
			?>
		<!--
		<div id="select-plaid-shop" class="menuIndex" style="overflow-y: hidden;">
			
			<img id="select-gift-store-title" src="resource/img/lang-zh/plaid-shop-title.png" style="width: 60%;" />
			
			<div style="height: 100%;">
				<div style="height: 65%; float: left;">
					<div class="items-plaid" style="position: relative; height: 100%; width: 70%;">
					</div>
				</div>
				<div style="height: 65%; float: left;">
					<div class="items-plaid" style="position: relative; height: 100%; width: 70%;">
					</div>
				</div>
				<div style="height: 65%; float: left;">
					<div class="items-plaid" style="position: relative; height: 100%; width: 70%;">
					</div>
				</div>
				<div style="height: 65%; float: left;">
					<div class="items-plaid" style="position: relative; height: 100%; width: 70%;">
					</div>
				</div>
			</div>
		</div>
		
		<script>
		
			$('#select-gift-store-title').click(function(){
				switchPageDiv('entrance');
				bgSwitch('2');
				$('#mini-account').animate({bottom: '0%'}, 500);
			});
		
		
		</script>
		
		-->
			<?php
			
				}
			
			?>
			
					

			
			
			
		<script>
		
			changeLang();
		
		</script>
			<?php
		
		die();
		
	}else if($func == 'purchaseBillSingle'){
			
		if($ret[0]['grade'] != '12' || checkTicketPurchase($username) == true){
			echo 'Invalid request';
			die();
		}
		
		
		
		$list = array();
		
		$list[0]['amount'] = 1;
		$list[0]['name_zh_CN'] = '星空夏电子入场票';
		$list[0]['name_en_US'] = 'STARRY Electronic Ticket';
		$list[0]['price'] = 40.9;
		
		$list[1]['amount'] = 1;
		$list[1]['name_zh_CN'] = '星空夏纪念卡';
		$list[1]['name_en_US'] = 'STARRY Commemorative Card';
		$list[1]['price'] = 0;
		
		$list[2]['amount'] = 1;
		$list[2]['name_zh_CN'] = '星空夏入场手环';
		$list[2]['name_en_US'] = 'STARRY Entrance Bracelet';
		$list[2]['price'] = 0;
		
		
		$lang = $_REQUEST['lang'];
		makeBill($list, $ret, $lang);
		
		
		
		
	}else if($func == 'purchaseBillCouple'){
		
		if($ret[0]['grade'] != '12' || checkTicketPurchase($username) == true){
			echo 'Invalid request';
			die();
		}
		
		$list = array();
		
		$list[0]['amount'] = 2;
		$list[0]['name_zh_CN'] = '星空夏电子入场票';
		$list[0]['name_en_US'] = 'STARRY Electronic Ticket';
		$list[0]['price'] = 40.95;
		
		$list[1]['amount'] = 2;
		$list[1]['name_zh_CN'] = '星空夏纪念卡';
		$list[1]['name_en_US'] = 'STARRY Commemorative Card';
		$list[1]['price'] = 0;
		
		$list[2]['amount'] = 2;
		$list[2]['name_zh_CN'] = '星空夏入场手环';
		$list[2]['name_en_US'] = 'STARRY Entrance Bracelet';
		$list[2]['price'] = 0;
		
		$lang = $_REQUEST['lang'];
		makeBill($list, $ret, $lang);
		
		
		
		
	}else if($func == 'purchaseBillAcademy'){
		
		if(checkTicketPurchase($username) == true){
			echo 'Invalid request';
			die();
		}
		
		$list = array();
		
		$list[0]['amount'] = 3;
		$list[0]['name_zh_CN'] = '星空夏电子入场票 - 学术';
		$list[0]['name_en_US'] = 'STARRY Electronic Ticket';
		$list[0]['price'] = 0;
		
		$list[1]['amount'] = 1;
		$list[1]['name_zh_CN'] = '星空夏纪念卡';
		$list[1]['name_en_US'] = 'STARRY Commemorative Card';
		$list[1]['price'] = 0;
		
		$list[2]['amount'] = 1;
		$list[2]['name_zh_CN'] = '星空夏入场手环';
		$list[2]['name_en_US'] = 'STARRY Entrance Bracelet';
		$list[2]['price'] = 0;
		
		$lang = $_REQUEST['lang'];
		makeBill($list, $ret, $lang);
		
		
		
		
	}else if($func == 'purchaseBillVolunteer'){
		
		$list = array();
		
		$list[0]['amount'] = 2;
		$list[0]['name_zh_CN'] = '星空夏电子入场票 - 工作';
		$list[0]['name_en_US'] = 'STARRY Electronic Ticket - GREY';
		$list[0]['price'] = 0;
		
		$lang = $_REQUEST['lang'];
		makeBill($list, $ret, $lang);
		
		
		
		
	}else if($func == 'ticketSinglePanels'){
		
		?>
		
		<img id="single-price" src="resource/img/ticket-single-price.png?rand=<?php echo time() ?>" style="width: 90%;" />
		<img src="resource/img/click-me-purchase.png" style="width: 30%; transform: translateY(-20px); animation: tap-me-2 .5s infinite;" />
		
		<script>
			
			
			$('#single-price').click(function(){
				
				pageFrom = 'ticket-single-detail';
				<?php 
					if($ret[0]['grade'] == '12'){
				?>
				
				$('#purchaseBillBlackCover').fadeIn(250);
				$('#mini-account').animate({bottom: '-100%'}, 500);
				
				setTimeout(function(){
					$.post("pageComposition.php", {func: 'purchaseBillSingle', lang: lang2}, function(res){
						$('#purchase-bill').html(res);
						switchPageDiv('ticket-bill');
						bgSwitch(3);
						$('#purchaseBillBlackCover').fadeOut(500);
					});
				}, 500);
				
				<?php
					}else{
				?>
				
				layui.use('layer', function(){
					var layer = layui.layer;
					layer.msg($.i18n.prop('ticket-type-unfit'));
				});
				
				<?php
					}
				?>
				
			});
			
			
			changeLang();
			
		</script>
		
		<?php
		
		
	}else if($func == 'ticketDoublePanels'){
		
		?>
		
					
					
					<div id="ticket-couple-invite-panel" style="padding: 0px 20px;">
						
						<?php
						
							$inviter = $ret[0]['inviter'];
							$inv = SQL("SELECT * FROM `graduation_prom_2018_account` WHERE `username` = '$inviter' OR `inviter` = '$username'");
							
							$grade = $ret[0]['grade'];
							
							if(!empty($inv)){
								$invited = true;
							}else{
								$invited = false;
							}
							
							
						?>
						
						<table border="0" style="width: 100%; margin-bottom: 10px;">
							<tr>
								<th style="width: 40%; ">
									<div class="avator" style="background-image: url('data:image/png;base64,<?php echo $ret[0]['photo'] ?>'); width: 90px; height: 90px;"></div>
								</th>
								<th style="width: 20%; transform: translateY(3px);">
									<img src="resource/img/invitation-sign.png" style="width: 100%" />
								</th>
								<th style="width: 40%;">
									<?php
									if($invited){
										?>
										<div class="avator" style="background-image: url('data:image/png;base64,<?php echo $inv[0]['photo'] ?>'); width: 90px; height: 90px;"></div>
										<?php
									}else{
										?>
										<div class="avator" style="background-image: url('resource/img/invitation-invitor-who.png'); width: 90px; height: 90px;"></div>
										<?php
									}
									?>
								</th>
							</tr>
						</table>
						
						<?php
							if(!$invited && $grade == 12){
						?>
						<img src="resource/img/lang-zh/invitation-tip.png" style="width: 80%" />
						<img src="resource/img/lang-zh/share-invitation-code-tip.png" style="width: 80%" />
						
						<div style="padding: 15px; text-align: center; background: url('resource/img/invitation-code-show.png') no-repeat center; background-size: cover; color: #fff;"><div style="text-align: center; letter-spacing:20px; font-weight: 600; transform: translateX(10px); font-size: 20px;"><?php echo $ret[0]['invitationCode'] ?></div></div>
						
						
						<?php
							}else if($invited && $grade == 12){
						?>
						<img src="resource/img/lang-zh/invited-successfully-text.png" style="width: 80%" />
						<div style="text-align: center; padding-top: 15px;">
							<a id="startPurchasePanelFlip" class="layui-btn layui-btn-lg invitation-btn"><i class="fa fa-cart-plus"></i>&nbsp;&nbsp;<span data-lang="start-purchase">开始购票</span></a>
						</div>
						<?php
							}else if(!$invited && $grade != 12){
						?>
							<img src="resource/img/lang-zh/invitation-input.png" style="width: 80%" />
							<img src="resource/img/lang-zh/other-grade-input-invitation-code-tip.png" style="width: 80%" />
							<div style="padding: 5px; text-align: center; background: url('resource/img/invitation-code-show.png') no-repeat center; background-size: cover; color: #fff;"><input id="invitation-code-input" class="layui-input" placeholder="" style="background: rgba(0, 0, 0, 0); border: 0px; text-align: center; color: #fff;"></input></div>
							<div style="text-align: center; padding-top: 15px;">
								<a id="useInvitationCode" class="layui-btn layui-btn-lg invitation-btn"><i class="fa fa-link"></i>&nbsp;&nbsp;<span data-lang="confirm">确定</span></a>
							</div>
							
							<script>
								
								$('#useInvitationCode').click(function(){
									
									var code = $('#invitation-code-input').val();
									$('#fetchingDataBlackCoverTop').fadeIn(250);
									
									$.ajax({url:"requestInvited.php",
										data: {code: code},
										dataType: 'JSON',
										timeout: 6000,
										type: 'POST',
										success: function(res){
											if(res.code == 0){
												$('#CoupleTicket').click();
											}else{	
												$('#fetchingDataBlackCoverTop').fadeOut(250);
											}
											layui.use('layer', function(){
												var layer = layui.layer;
												layer.msg($.i18n.prop(res.message));
											});
										},
										error: function (xhr,status,error){
											times ++;
											if(times < 3){
												$('#useInvitationCode').click();
											}
											layui.use('layer', function(){
												var layer = layui.layer;
												layer.msg($.i18n.prop('rebinding'));
											});
											return;
										},
										complete(XHR, TS){
											
										}
									});
									
								});
								
							</script>
							
						<?php
							}else if($invited && $grade != 12){
						?>
							<img src="resource/img/lang-zh/invited-successfully-text.png" style="width: 80%" />
							<img src="resource/img/lang-zh/wait-finish-payment-tip.png" style="width: 80%" />
						<?php
							}
						?>
					</div>
					
					
					<?php
							if($invited && $grade == 12){
						?>
					<div id="ticket-couple-purchase-panel">
						<img id="couple-price" src="resource/img/ticket-couple-price.png?rand=<?php echo time() ?>" style="width: 90%;" />
						<img src="resource/img/click-me-purchase.png" style="width: 30%; transform: translateY(-20px); animation: tap-me-2 .5s infinite;" />
					</div>
					
					<script>
					
					$('#couple-price').click(function(){
				
						pageFrom = 'ticket-couple-detail';
						
						$('#purchaseBillBlackCover').fadeIn(250);
						$('#mini-account').animate({bottom: '-100%'}, 500);
						
						setTimeout(function(){
							$.post("pageComposition.php", {func: 'purchaseBillCouple', lang: lang2}, function(res){
								$('#purchase-bill').html(res);
								switchPageDiv('ticket-bill');
								bgSwitch(3);
								$('#purchaseBillBlackCover').fadeOut(250);
							});
						}, 500);
						
					});
					
					</script>
						<?php
							}
						?>
		<script>
		
		
			switchCouplePurchasePanel('invite');
			
			$('#startPurchasePanelFlip').click(function(){
				switchCouplePurchasePanel('purchase');
			});
			
		</script>
		
		<script>
			changeLang();
		</script>
		<?php
		
	}else if($func == 'ticketAcademyPanels'){
		
		/**
		$username = $ret[0]['username'];
		
		$retu = SQL("SELECT * FROM `graduation_prom_2018_free_list` WHERE `username` = '$username'   ");
		
		
		if(!empty($retu)){
		?>
		
		<?php echo $retu[0]['name'] ?><br><?php echo $retu[0]['teacher'] ?><br><?php echo $retu[0]['section'] ?>
		
		<?php
		}else{
		?>
		
		<span data-lang="no-course-enroll-record">没有相关课程记录</span>
		<?php
		}
		
		**/
		?>
		
		<?php
		
			$have = false;
			
			$course = array();
			if(getSpecificCourse('Economics 12') !== false){
				$course = getSpecificCourse('Economics 12');
			}else if(getSpecificCourse('Marketing 12') !== false){
				$course = getSpecificCourse('Marketing 12');
			}else if(getSpecificCourse('Accounting 12') !== false){
				$course = getSpecificCourse('Accounting 12');
			}else if(getSpecificCourse('Digital Media 12') !== false){
				$course = getSpecificCourse('Digital Media 12');
			}
			
			
			if(empty($course)){
				echo '<span data-lang="no-course-enroll-record"></span>';
			}else{
			
				$start = $course['enrollments']['startDate'];
				$end = $course['enrollments']['endDate'];
				
				
				if(strtotime($start) < strtotime('2018-01-19T16:00:00.000Z') || strtotime($end) > strtotime('2018-06-30T16:00:00.000Z')){
					echo '<span data-lang="no-course-enroll-record"></span>';
				}else{
					
					echo $course['name'] . '<br>';
					echo $course['teacher']['firstName'] . ' ' . $course['teacher']['lastName'] . '<br>';
					echo $course['expression'];
					
					$have = true;
					
				}
				
			}
			
			if($username == '18020054'){
				$have = true;
			}
			
		?>
		<hr>
		
		<img id="academy-price" src="resource/img/ticket-academy-price.png?rand=<?php echo time() ?>" style="width: 90%;" />
		<img src="resource/img/click-me-purchase.png" style="width: 30%; transform: translateY(-20px); animation: tap-me-2 .5s infinite;" />
		
		<script>
			
			
			$('#academy-price').click(function(){
				
				pageFrom = 'ticket-academy-detail';
				<?php 
					if($have){
				?>
				
				$('#purchaseBillBlackCover').fadeIn(250);
				$('#mini-account').animate({bottom: '-100%'}, 500);
				
				setTimeout(function(){
					$.post("pageComposition.php", {func: 'purchaseBillAcademy', lang: lang2}, function(res){
						$('#purchase-bill').html(res);
						switchPageDiv('ticket-bill');
						bgSwitch(3);
						$('#purchaseBillBlackCover').fadeOut(500);
					});
				}, 500);
				
				<?php
					}else{
				?>
				
				layui.use('layer', function(){
					var layer = layui.layer;
					layer.msg($.i18n.prop('ticket-type-unfit'));
				});
				
				<?php
					}
				?>
				
			});
			
			
			changeLang();
			
		</script>
		
		
		
		<?php
		
		
	}else if($func == 'checkMyTicket'){
		
		include "phpqrcode/phpqrcode.php";
		
		$username = $ret[0]['username'];
		$retu = SQL("SELECT * FROM `graduation_prom_2018_tickets` WHERE `username` = '$username'  ");
		
		if(empty($retu)){
			die();
		}
		
		if($retu[0]['status'] == ''){
			SQL("UPDATE `graduation_prom_2018_tickets` SET `status`='ACTIVATED'  WHERE `username` = '$username'  ");
		}
		
		
		$serialCode = $retu[0]['serialCode'];
		$serialKey = $retu[0]['serialKey'];
		
		$time = time();
		$signature = md5($serialKey . $time . 'STARRY CLOUDYYOUNG GRADUATION PROM 2018' . $serialKey . $time . 'STARRY CLOUDYYOUNG GRADUATION PROM 2018' . $serialKey . $time . 'STARRY CLOUDYYOUNG GRADUATION PROM 2018' . $serialKey . $time . 'STARRY CLOUDYYOUNG GRADUATION PROM 2018' . $serialKey . $time . 'STARRY CLOUDYYOUNG GRADUATION PROM 2018');
		
		$reqStr = '?func=checkIn&serialCode=' . $serialCode . '&signature=' . $signature . '&time=' . $time;
		
		
		$data = 'http://meonc.studio/Starry/checkIn.php' . $reqStr; 
		$errorCorrectionLevel = "M";
		$matrixPointSize = "50";
		QRcode::png($data, false, $errorCorrectionLevel, $matrixPointSize);
		
		
	}else if($func == 'bindingCouplePanel'){
		
		
		?>
		
					<div id="binding-panel" style="padding: 0px 20px;">
						
						<?php
							
							$username = $ret[0]['username'];
							
							$retu = SQL("SELECT * FROM `graduation_prom_2018_voting_couple` WHERE `username1` = '$username' OR `username2` = '$username' ");
							
							$photo1 = $ret[0]['photo'];
							$photo2 = '';
							
							if(empty($retu)){
								$binded = false;
							}else{
								$binded = true;
								
								$user1 = $retu[0]['username1'];
								$retu1 = SQL("SELECT * FROM `graduation_prom_2018_account` WHERE `username` = '$user1'");
								$photo1 = $retu1[0]['photo'];
								
								$user2 = $retu[0]['username2'];
								$retu2 = SQL("SELECT * FROM `graduation_prom_2018_account` WHERE `username` = '$user2'");
								$photo2 = $retu2[0]['photo'];
								
							}
							
							
						?>
						
						<table border="0" style="width: 100%; margin-bottom: 10px;">
							<tr>
								<th style="width: 40%; ">
									<div class="avator" style="background-image: url('data:image/png;base64,<?php echo $photo1 ?>'); width: 90px; height: 90px;"></div>
								</th>
								<th style="width: 17%; transform: translateY(3px);">
									<img src="resource/img/couple-sign.png" style="width: 100%" />
								</th>
								<th style="width: 40%;">
									<?php
									if($binded){
										
										?>
									<div class="avator" style="background-image: url('data:image/png;base64,<?php echo $photo2 ?>'); width: 90px; height: 90px;"></div>
										<?php
									}else{
										?>
										<div class="avator" style="background-image: url('resource/img/invitation-invitor-who.png'); width: 90px; height: 90px;"></div>
										<?php
									}
									?>
								</th>
							</tr>
						</table>
						
						<?php
							if(!$binded){
						?>
						<img src="resource/img/lang-zh/couple-code-show.png" style="width: 80%" />
						<img src="resource/img/lang-zh/share-couple-code-tip.png" style="width: 80%" />
						
						<div style="padding: 15px; text-align: center; background: url('resource/img/invitation-code-show.png') no-repeat center; background-size: cover; color: #fff;"><div style="text-align: center; letter-spacing:20px; font-weight: 600; transform: translateX(10px); font-size: 20px;"><?php echo $ret[0]['coupleCode'] ?></div></div>
						
						<img src="resource/img/lang-zh/couple-input.png" style="width: 80%" />
						<img src="resource/img/lang-zh/input-couple-code-tip.png" style="width: 80%" />
						<div style="padding: 5px; text-align: center; background: url('resource/img/invitation-code-show.png') no-repeat center; background-size: cover; color: #fff;"><input id="couple-code-input" class="layui-input" placeholder="" style="background: rgba(0, 0, 0, 0); border: 0px; text-align: center; color: #fff;"></input></div>
						<div style="text-align: center; padding-top: 15px;">
							<a id="useCoupleCode" class="layui-btn layui-btn-lg invitation-btn"><i class="fa fa-link"></i>&nbsp;&nbsp;<span data-lang="confirm">确定</span></a>
						</div>
						
						<script>
							
							$('#useCoupleCode').click(function(){
								
								var code = $('#couple-code-input').val();
								$('#fetchingDataBlackCoverTop').fadeIn(250);
								
								$.ajax({url:"requestBindingCouple.php",
									data: {code: code},
									dataType: 'JSON',
									timeout: 6000,
									type: 'POST',
									success: function(res){
										if(res.code == 0){
											$('#BindingCoupleButton').click();
										}else{
											$('#fetchingDataBlackCoverTop').fadeOut(250);
										}
										layui.use('layer', function(){
											var layer = layui.layer;
											layer.msg($.i18n.prop(res.message));
										});
									},
									error: function (xhr,status,error){
										$('#useCoupleCode').click();
										layui.use('layer', function(){
											var layer = layui.layer;
											layer.msg($.i18n.prop('rebinding'));
										});
										return;
									},
									complete(XHR, TS){
										
									}
								});
								
							});
							
						</script>
						<?php
							}else if($binded){
						?>
						<img src="resource/img/lang-zh/couple-successfully-text.png" style="width: 80%" />
						<img src="resource/img/lang-zh/participate-best-couple-voting.png" style="width: 80%" />
						<?php
							}
						?>
							
					</div>
					
					

		
		<script>
			changeLang();
		</script>
		<?php
		
		
	}else if($func == 'votingQueenList'){
		
		
		
			$retQ = SQL("SELECT * FROM `graduation_prom_2018_voting_best`  WHERE `gender` = 'F'  ");
			
			?>
			<ul>
			<?php
			
			
			for($t = 0; $t < count($retQ); $t ++){
				
				$username =  $retQ[$t]['username'];
				$cid = $retQ[$t]['cid'];
				$vote_num = $retQ[$t]['votes'];
				
				$ret1 = SQL("SELECT `firstName`, `lastName`, `middleName` FROM `graduation_prom_2018_account` WHERE `username` = '$username'");
				$name1 =  $ret1[0]['lastName'] . ', ' . $ret1[0]['firstName'] . '<br>' . $ret1[0]['middleName'];
				//$photo1 = $ret1[0]['photo'];
				
				
			?>
			<li>
					<div id="vote-frame-q<?php echo $cid ?>" class="items-static" style="padding: 30px; font-size: 16px;">
						<table border="0" style="width: 100%; margin-bottom: 10px;text-align: center">
							<tr>
								<th style="width: 80%; ">
									<?php echo $name1 ?>
								</th>
								
								<th style="width: 17%; position: relative;">
									<div id="btn_vote_q<?php echo $cid ?>" style="font-size: 16px; color: #fff; width: 70px; position: relative; background: url('resource/img/couple-sign.png') no-repeat center; background-size: cover; line-height: 61px;">
										<span id="votes-amount-q<?php echo $cid ?>">0</span>
									</div>
								</th>
								
							</tr>
						</table>
					</div>
					
					
					<script>
							
							var currentVotes_q<?php echo $cid ?> = <?php echo $vote_num ?>;
							
							var numAnim_q<?php echo $cid ?> = new CountUp('votes-amount-q<?php echo $cid ?>', currentVotes_q<?php echo $cid ?> * 0.996 , currentVotes_q<?php echo $cid ?>, 0, 50);
							numAnim_q<?php echo $cid ?>.start();
							
							
							$('#vote-frame-q<?php echo $cid ?>').click(function(){
								
								layer.open({
									type: 1, 
									title: false,
									shadeClose: true,
									content: '<div class="items-static" style="padding: 30px; font-size: 18px; text-align: center;"><?php echo $ret1[0]['lastName'] . ', ' . $ret1[0]['firstName']  ?><input value="100"  class="layui-input"  style="text-align: center;" id="QueenVotingAmount<?php echo $cid ?>" /><a id="QueenVoting<?php echo $cid ?>" class="layui-btn layui-btn-lg"><i class="fa fa-heart"></i>&nbsp;&nbsp;<span data-lang="vote">投票</span></a></div>'
								});
								
								
								
								$('#QueenVoting<?php echo $cid ?>').click(function(){
									
									if(myCurrentVotes < $('#QueenVotingAmount<?php echo $cid ?>').val()){
										layui.use('layer', function(){
											var layer = layui.layer;
											layer.msg($.i18n.prop('vote-not-enough'));
										});
										return;
									}
									
									$('#fetchingDataBlackCoverTop').fadeIn(250);
									
									$.ajax({url:"requestBestVoting.php",
										data: {cid: <?php echo $cid ?>, vote: $('#QueenVotingAmount<?php echo $cid ?>').val()},
										dataType: 'JSON',
										timeout: 3000,
										type: 'POST',
										success: function(res){
											if(res.code!=0){
												layui.use('layer', function(){
													var layer = layui.layer;
													layer.msg($.i18n.prop('vote-failed'));
												});
											}else{
												layer.closeAll('page');
												layui.use('layer', function(){
													var layer = layui.layer;
													layer.msg($.i18n.prop('vote-succeed'));
												});
												myCurrentVotes -= $('#QueenVotingAmount<?php echo $cid ?>').val()
												votes_mini.update(myCurrentVotes);
												refreshQueenVote();
											}
										},
										error: function (xhr,status,error){
											layui.use('layer', function(){
												var layer = layui.layer;
												layer.msg($.i18n.prop('vote-failed'));
											});
											return;
										},
										complete(XHR, TS){
											$('#fetchingDataBlackCoverTop').fadeOut(250);
										}
									});
									
								});
								
							});
							
							
							
							
					</script>
				
				</li>
					<?php
					
			}
					
					?>
			
			</ul>
			
			<script>
			
					
					var myCurrentVotes = <?php echo $ret[0]['vote'] ?>;
					
					//window.clearInterval(interv); 
							interv = setInterval(function(){
								refreshVote();
							},20000);
							
							function refreshQueenVote(){
								
								$.ajax({url:"requestQueenVotes.php",
									data: {},
									dataType: 'JSON',
									timeout: 3000,
									type: 'POST',
									success: function(res){
										
										<?php
										
										for($t = 0; $t < count($retQ); $t ++){
										
										?>
											numAnim_q<?php echo $retQ[$t]['cid'] ?>.update(res.cid<?php echo $retQ[$t]['cid'] ?>);
										<?php
										
										}
										
										?>
										
									},
									error: function (xhr,status,error){
										
									},
									complete(XHR, TS){
										
									}
								});
								
							}
							
							votes_mini.update(<?php echo $ret[0]['vote'] ?>);
							
							
							$('#voting_panel_title').click(function(){
								
								switchPageDiv('entrance');
								$('#mini-account').animate({bottom: '0%'}, 500);
								
							});
							
							
							
					</script>
			
			<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
		
			
			<?php
			
	
	}else if($func == 'votingKingList'){
		
		
		
			$retK = SQL("SELECT * FROM `graduation_prom_2018_voting_best`  WHERE `gender` = 'M'  ");
			
			?>
			<ul>
			<?php
			
			
			for($t = 0; $t < count($retK); $t ++){
				
				$username =  $retK[$t]['username'];
				$cid = $retK[$t]['cid'];
				$vote_num = $retK[$t]['votes'];
				
				$ret1 = SQL("SELECT `firstName`, `lastName`, `middleName` FROM `graduation_prom_2018_account` WHERE `username` = '$username'");
				$name1 =  $ret1[0]['lastName'] . ', ' . $ret1[0]['firstName'] . '<br>' . $ret1[0]['middleName'];
				//$photo1 = $ret1[0]['photo'];
				
				
			?>
			<li>
					<div id="vote-frame-k<?php echo $cid ?>" class="items-static" style="padding: 30px; font-size: 16px;">
						<table border="0" style="width: 100%; margin-bottom: 10px;text-align: center">
							<tr>
								<th style="width: 80%; ">
									<?php echo $name1 ?>
								</th>
								
								<th style="width: 17%; position: relative;">
									<div id="btn_vote_k<?php echo $cid ?>" style="font-size: 16px; color: #fff; width: 70px; position: relative; background: url('resource/img/couple-sign.png') no-repeat center; background-size: cover; line-height: 61px;">
										<span id="votes-amount-k<?php echo $cid ?>">0</span>
									</div>
								</th>
								
								
							</tr>
						</table>
					</div>
					
					
					<script>
							
							var currentVotes_k<?php echo $cid ?> = <?php echo $vote_num ?>;
							
							var numAnim_k<?php echo $cid ?> = new CountUp('votes-amount-k<?php echo $cid ?>', currentVotes_k<?php echo $cid ?> * 0.996 , currentVotes_k<?php echo $cid ?>, 0, 50);
							numAnim_k<?php echo $cid ?>.start();
							
							
							$('#vote-frame-k<?php echo $cid ?>').click(function(){
								
								layer.open({
									type: 1, 
									title: false,
									shadeClose: true,
									content: '<div class="items-static" style="padding: 30px; font-size: 18px; text-align: center;"><?php echo $ret1[0]['lastName'] . ', ' . $ret1[0]['firstName']  ?><input value="100"  class="layui-input"  style="text-align: center;" id="KingVotingAmount<?php echo $cid ?>" /><a id="KingVoting<?php echo $cid ?>" class="layui-btn layui-btn-lg"><i class="fa fa-heart"></i>&nbsp;&nbsp;<span data-lang="vote">投票</span></a></div>'
								});
								
								
								
								$('#KingVoting<?php echo $cid ?>').click(function(){
									
									if(myCurrentVotes < $('#KingVotingAmount<?php echo $cid ?>').val()){
										layui.use('layer', function(){
											var layer = layui.layer;
											layer.msg($.i18n.prop('vote-not-enough'));
										});
										return;
									}
									
									$('#fetchingDataBlackCoverTop').fadeIn(250);
									
									$.ajax({url:"requestBestVoting.php",
										data: {cid: <?php echo $cid ?>, vote: $('#KingVotingAmount<?php echo $cid ?>').val()},
										dataType: 'JSON',
										timeout: 3000,
										type: 'POST',
										success: function(res){
											if(res.code!=0){
												layui.use('layer', function(){
													var layer = layui.layer;
													layer.msg($.i18n.prop('vote-failed'));
												});
											}else{
												layer.closeAll('page');
												layui.use('layer', function(){
													var layer = layui.layer;
													layer.msg($.i18n.prop('vote-succeed'));
												});
												myCurrentVotes -= $('#KingVotingAmount<?php echo $cid ?>').val()
												votes_mini.update(myCurrentVotes);
												refreshKingVote();
											}
										},
										error: function (xhr,status,error){
											layui.use('layer', function(){
												var layer = layui.layer;
												layer.msg($.i18n.prop('vote-failed'));
											});
											return;
										},
										complete(XHR, TS){
											$('#fetchingDataBlackCoverTop').fadeOut(250);
										}
									});
									
								});
								
							});
							
							
							
							
					</script>
				
				</li>
					<?php
					
			}
					
					?>
			
			</ul>
			
			<script>
			
					
					var myCurrentVotes = <?php echo $ret[0]['vote'] ?>;
					
					//window.clearInterval(interv); 
							interv = setInterval(function(){
								refreshVote();
							},20000);
							
							function refreshKingVote(){
								
								$.ajax({url:"requestKingVotes.php",
									data: {},
									dataType: 'JSON',
									timeout: 3000,
									type: 'POST',
									success: function(res){
										
										<?php
										
										for($t = 0; $t < count($retK); $t ++){
										
										?>
											numAnim_k<?php echo $retK[$t]['cid'] ?>.update(res.cid<?php echo $retK[$t]['cid'] ?>);
										<?php
										
										}
										
										?>
										
									},
									error: function (xhr,status,error){
										
									},
									complete(XHR, TS){
										
									}
								});
								
							}
							
							votes_mini.update(<?php echo $ret[0]['vote'] ?>);
							
							
							$('#voting_panel_title').click(function(){
								
								switchPageDiv('entrance');
								$('#mini-account').animate({bottom: '0%'}, 500);
								
							});
							
							
							
					</script>
			
			<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
		
			
			<?php
			
	
	}else if($func == 'votingCoupleList'){
		
		
		
			$retCP = SQL("SELECT * FROM `graduation_prom_2018_voting_couple`");
			
			?>
			<ul>
			<?php
			
			
			for($t = 0; $t < count($retCP); $t ++){
				
				$username1 =  $retCP[$t]['username1'];
				$username2 =  $retCP[$t]['username2'];
				$cid = $retCP[$t]['cid'];
				$vote_num = $retCP[$t]['votes'];
				
				$ret1 = SQL("SELECT `firstName`, `lastName`, `middleName` FROM `graduation_prom_2018_account` WHERE `username` = '$username1'");
				$name1 =  $ret1[0]['lastName'] . ', ' . $ret1[0]['firstName'] . '<br>' . $ret1[0]['middleName'];
				//$photo1 = $ret1[0]['photo'];
	
				$ret2 = SQL("SELECT `firstName`, `lastName`, `middleName` FROM `graduation_prom_2018_account` WHERE `username` = '$username2'");
				$name2 =  $ret2[0]['lastName'] . ', ' . $ret2[0]['firstName'] . '<br>' . $ret2[0]['middleName'];
				//$photo2 = $ret2[0]['photo'];
				//<div class="avator" style="background-image: url('data:image/png;base64,<?php echo $name1 '); width: 90px; height: 90px;"></div>
				
				
				
				
			?>
			<li>
					<div id="vote-frame-<?php echo $cid ?>" class="items-static" style="padding: 30px; font-size: 16px;">
						<table border="0" style="width: 100%; margin-bottom: 10px;text-align: center">
							<tr>
								<th style="width: 40%; ">
									<?php echo $name1 ?>
								</th>
								
								<th style="width: 17%; position: relative;">
									<div id="btn_vote_<?php echo $cid ?>" style="font-size: 16px; color: #fff; width: 70px; position: relative; background: url('resource/img/couple-sign.png') no-repeat center; background-size: cover; line-height: 61px;">
										<span id="votes-amount-<?php echo $cid ?>">0</span>
									</div>
								</th>
								
								<th style="width: 40%;">
									<?php echo $name2 ?>
								</th>	
								
							</tr>
						</table>
					</div>
					
					
					<script>
							
							var currentVotes_<?php echo $cid ?> = <?php echo $vote_num ?>;
							
							var numAnim_<?php echo $cid ?> = new CountUp('votes-amount-<?php echo $cid ?>', currentVotes_<?php echo $cid ?> * 0.996 , currentVotes_<?php echo $cid ?>, 0, 50);
							numAnim_<?php echo $cid ?>.start();
							
							
							$('#vote-frame-<?php echo $cid ?>').click(function(){
								
								layer.open({
									type: 1, 
									title: false,
									shadeClose: true,
									content: '<div class="items-static" style="padding: 30px; font-size: 18px; text-align: center;"><?php echo $ret1[0]['lastName'] . ', ' . $ret1[0]['firstName']  ?> & <?php echo $ret2[0]['lastName'] . ', ' . $ret2[0]['firstName']  ?><input value="100"  class="layui-input"  style="text-align: center;" id="coupleVotingAmount<?php echo $cid ?>" /><a id="coupleVoting<?php echo $cid ?>" class="layui-btn layui-btn-lg"><i class="fa fa-heart"></i>&nbsp;&nbsp;<span data-lang="vote">投票</span></a></div>'
								});
								
								
								
								$('#coupleVoting<?php echo $cid ?>').click(function(){
									
									if(myCurrentVotes < $('#coupleVotingAmount<?php echo $cid ?>').val()){
										layui.use('layer', function(){
											var layer = layui.layer;
											layer.msg($.i18n.prop('vote-not-enough'));
										});
										return;
									}
									
									$('#fetchingDataBlackCoverTop').fadeIn(250);
									
									$.ajax({url:"requestCoupleVoting.php",
										data: {cid: <?php echo $cid ?>, vote: $('#coupleVotingAmount<?php echo $cid ?>').val()},
										dataType: 'JSON',
										timeout: 3000,
										type: 'POST',
										success: function(res){
											if(res.code!=0){
												layui.use('layer', function(){
													var layer = layui.layer;
													layer.msg($.i18n.prop('vote-failed'));
												});
											}else{
												layer.closeAll('page');
												layui.use('layer', function(){
													var layer = layui.layer;
													layer.msg($.i18n.prop('vote-succeed'));
												});
												myCurrentVotes -= $('#coupleVotingAmount<?php echo $cid ?>').val()
												votes_mini.update(myCurrentVotes);
												refreshVote();
											}
										},
										error: function (xhr,status,error){
											layui.use('layer', function(){
												var layer = layui.layer;
												layer.msg($.i18n.prop('vote-failed'));
											});
											return;
										},
										complete(XHR, TS){
											$('#fetchingDataBlackCoverTop').fadeOut(250);
										}
									});
									
								});
								
							});
							
							
							
							
					</script>
				
				</li>
					<?php
					
			}
					
					?>
			
			</ul>
			
			<script>
			
					
					var myCurrentVotes = <?php echo $ret[0]['vote'] ?>;
					
					//window.clearInterval(interv); 
							interv = setInterval(function(){
								refreshVote();
							},20000);
							
							function refreshVote(){
								
								$.ajax({url:"requestCoupleVotes.php",
									data: {},
									dataType: 'JSON',
									timeout: 3000,
									type: 'POST',
									success: function(res){
										
										<?php
										
										for($t = 0; $t < count($retCP); $t ++){
										
										?>
											numAnim_<?php echo $retCP[$t]['cid'] ?>.update(res.cid<?php echo $retCP[$t]['cid'] ?>);
										<?php
										
										}
										
										?>
										
									},
									error: function (xhr,status,error){
										
									},
									complete(XHR, TS){
										
									}
								});
								
							}
							
							votes_mini.update(<?php echo $ret[0]['vote'] ?>);
							
							
							$('#voting_panel_title').click(function(){
								
								switchPageDiv('entrance');
								$('#mini-account').animate({bottom: '0%'}, 500);
								
							});
							
							
							
					</script>
			
			<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
		
			
			<?php
			
	
	}
	
	
	
	function makeBill($list, $ret, $lang){
		
		?>
		
		
		<div style="padding: 20px 40px; font-size: 14px; color: #000; text-align: left;">
			<?php echo $ret[0]['firstName'] . ' ' . $ret[0]['middleName'] . ' ' . $ret[0]['lastName'] ?><br>
			Grade <?php echo $ret[0]['grade'] ?><br>
			<?php echo date('Y-m-d H:i') ?>
		</div>
		
		<div class="receipt__lines"></div>
		
		<div id="bill-content">
			<div style="padding: 20px 40px; color: #000;">
				<ul style="margin: 0; padding: 0;">
				<?php
					
					$total = 0;
					$ticket_amount = $list[0]['amount'];
					
					for($t = 0; $t < count($list); $t ++){
						
						$price = $list[$t]['price'] * $list[$t]['amount'];
						$total += $price;
				
				?>
				  <li class="receipt__line">
					<span class="receipt__line__item"><?php echo $list[$t]['amount'] ?>&nbsp;&nbsp;&nbsp;<?php echo $list[$t]['name_' . $lang] ?></span>
					<span class="receipt__line__price">¥ <?php echo $price ?></span>  
				  </li>
				<?php
				
					}
				
				?>
				</ul>
			</div>
			
			<p class="receipt__total" style="padding: 10px 40px;">
			  <span class="receipt__total__item"><span data-lang="total">Total</span></span>
			  <span class="receipt__total__price">¥ <?php echo $total ?></span>
			</p>
			
			<div class="receipt__lines"></div>
			
			<div style="text-align: center; padding: 30px;">
				<a id="wechatPay" class="layui-btn layui-btn-lg wechat-pay-btn" style="background-color: #96c93d;"><i class="fa fa-wechat"></i>&nbsp;&nbsp;<span data-lang="wechat-pay">微信支付</span></a>
			</div>
		
			<div id="wechatPayFrame"></div>
			
			<img src="resource/img/lang-zh/unpaid.png" style="right: -30px; top: -20px; width: 40%; position: absolute;" id="unpain-sign" />
		
		</div>
		
		<div id="finish-content">
			<div style="padding: 20px 40px; color: #000;">
				<img src="resource/img/lang-zh/finished-payment-tip.png" style="width: 80%" />
				<img src="resource/img/lang-zh/paid.png" style="right: -30px; top: -20px; width: 40%; position: absolute;" id="paid-sign" />
			</div>
			<div class="receipt__lines"></div>
			<div style="text-align: center; padding: 30px;">
				<a id="finishPayNext" class="layui-btn layui-btn-lg wechat-pay-btn" style="background-color: #96c93d;"><i class="fa fa-check"></i>&nbsp;&nbsp;<span data-lang="continue2activate">继续激活</span></a>
			</div>
		</div>
		
		<div style="height: 15px;"></div>
		
		<img src="resource/img/bill-bottom.png" style="left: 0px; width: 100%; background-repeat: repeat-x; top: 100%; position: absolute;" />
		
		
		<script>
		
		$('#finish-content').hide();
		
		$('#wechatPay').click(function(){
			
			var times = 0;
			$('#fetchingDataBlackCoverTop').fadeIn(250);
			
			$.ajax({url:"getCard.php",
				data: {'mode': '<?php echo $ticket_amount ?>'},
				dataType: 'HTML',
				timeout: 8000,
				type: 'POST',
				async: true,
				success: function(res){
					$('#wechatPayFrame').html(res);
					$('#fetchingDataBlackCoverTop').fadeOut(250);
				},
				error: function (xhr,status,error){
					times ++;
					if(times < 3){
						$('#wechatPay').click();
					}
					layui.use('layer', function(){
						var layer = layui.layer;
						layer.msg($.i18n.prop('rebilling'));
					});
					return;
				},
				complete(XHR, TS){
					
				}
			});
		});
		
		$('#finishPayNext').click(function(){
			$('#personInfo').click();
		});
		
		
		changeLang();
		
		</script>
		
		
		<?php
		
	}
	
	
	
?>