<html xmlns="https://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="icon" type="image/png" href="{@master_cdn}/img/master.png" />
		<title>{@name} - <?php echo $title; ?></title>
		<script src="{@client_cdn}/js/jquery-latest.js" type="text/javascript"></script>
		<script src="{@client_cdn}/js/jquery-ui.js" type="text/javascript"></script>
		<script src="{@client_cdn}/js/flashclient.js"></script>
		<script src="{@client_cdn}/js/flash_detect_min.js"></script>
		<script src="{@client_cdn}/js/client.js" type="text/javascript"></script>
		<script src="{@client_cdn}/js/screen.js" type="text/javascript"></script>
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<style type="text/css">

			*, body {
				margin: 0;
				padding: 0;
				font: initial;
			}

			@import url('https://fonts.googleapis.com/css?family=Roboto');

			.things {
				width: 220;
				background: rgba(0,0,0,.3);
				padding: 10px 15px;
				position: absolute;
				z-index: 1000;
				border-radius: 5px;
				box-shadow: inset 0 0 0px 2px rgba(255,255,255,.3);
				left: -5px;
				top: -4px;
			}

			.things .player {
				display: block;				
				margin-top: 0px;
				margin-left: 0px;
			}

			.things .back {
		        width: 150px;
			    border-radius: 1px;
			    display: inline-block;
			    background: #2779af;
			    padding: 8px 10px;
			    text-align: center;
			    color: #fff;
			    float: left;
			    cursor: pointer;
			    font-weight: 200;
			    margin: auto;
			    text-decoration: none;
			    font-family: 'Roboto', sans-serif;
			    font-size: 16px;
			    border-radius: 2px;
			    box-shadow: inset 0 0 0px 2px rgba(0,0,0,.3);
			    -webkit-transition: all 0.3s ease;
			    -o-transition: all 0.3s ease;
			    transition: all 0.3s ease;
			}

			.things .back:hover {
				background: #3498db;
			}

			.things .full {
			    width: 20px;
			    font-weight: 200;
			    display: inline-block;
			    background: #27ae60;
			    padding: 8px 10px;
			    text-align: center;
			    color: #fff;
			    float: right;
			    border-radius: 2px;
			    margin: auto;
			    text-decoration: none;
			    box-shadow: inset 0 0 0px 2px rgba(0,0,0,.3);
			    font-family: 'Roboto', sans-serif;
			    font-size: 16px;
			    -webkit-transition: all 0.3s ease;
			    -o-transition: all 0.3s ease;
			    transition: all 0.3s ease;
			    cursor: pointer;
			}

			.things .full:hover {
				background: #2ecc71;
			}
		</style>
	</head>
	<body>
		<div id="client-ui">
			<div id="client" style='position:absolute; left:0; right:0; top:0; bottom:0; overflow:hidden; height:100%; width:100%;background: #000;'></div>
			<div class="things">
				<div id="player" style="margin-bottom: 5px;">
			       <embed src="{@client_cdn}/player.swf" width="220" height="20" type="application/x-shockwave-flash" id="ply" name="ply" quality="high" allowfullscreen="false" allowscriptaccess="false" flashvars="type=mp3&amp;file={@radio}&amp;volume=50&amp;autostart=true&amp;backcolor=#00367c&amp;frontcolor=0xffffff&amp;&amp;lightcolor=0x00ADFF&amp;&amp;screencolor=0x00ADFF&amp;">
			      </embed>
		      	</div>
		      	<a href="{@url}" class="back" target="_blank"><i class="fa fa-home"></i></a>
		      	<a class="full" onclick="toggleFullScreen()"><i id="fscreen" class="fa fa-expand"></i></a>
			</div>
		</div>
		<script>
			var Client = new SWFObject("{@flash_client_url}{@habbo_swf}", "client", "100%", "100%", "10.0.0");
			Client.addVariable("client.allow.cross.domain", "1");
			Client.addVariable("client.notify.cross.domain", "0");
			Client.addVariable("connection.info.host", "{@host}");
			Client.addVariable("connection.info.port", "{@port}");
			Client.addVariable("site.url", "{@url}");
			Client.addVariable("url.prefix", "{@url}");
			Client.addVariable("client.reload.url", "{@url}/");
			Client.addVariable("client.fatal.error.url", "{@url}/");
			Client.addVariable("client.connection.failed.url", "{@url}/");
			Client.addVariable("logout.url", "{@url}/web");
			Client.addVariable("logout.disconnect.url", "{@url}/web");
			Client.addVariable("external.variables.txt", "{@external_variables}");
			Client.addVariable("external.texts.txt", "{@external_flash_texts}");
			Client.addVariable("productdata.load.url", "{@productdata}");
			Client.addVariable("furnidata.load.url", "{@furnidata}");
			Client.addVariable("external.figurepartlist.txt", "{@figuredata}");
			Client.addVariable("flash.dynamic.avatar.download.configuration", "{@figuremap}");
			Client.addVariable("use.sso.ticket", "1");
			Client.addVariable("sso.ticket", "{@ticket}");
			Client.addVariable("account_id", "<?php echo $this->users->get('id'); ?>");
			Client.addVariable("processlog.enabled", "1");
			Client.addVariable("client.starting", "{@name} Hotel está cargando ...");
			Client.addVariable("client.starting.revolving", "Para ciencia, \u00A1T\u00FA, monstruito!\/Cargando mensajes divertidos... Por favor, espera.\/\u00BFTe apetecen salchipapas con qu\u00E9?\/Sigue al pato amarillo.\/El tiempo es s\u00F3lo una ilusi\u00F3n.\/\u00A1\u00BFTodav\u00EDa estamos aqu\u00ED?!\/Me gusta tu camiseta.\/Mira a la izquierda. Mira a la derecha. Parpadea dos veces. \u00A1Ta-ch\u00E1n!\/No eres t\u00FA, soy yo.\/Shhh! Estoy intentando pensar.\/Cargando el universo de p\u00EDxeles.");
			<?php if($room) { ?>Client.addVariable("forward.id", "<?php echo $room; ?>");<?php } ?>
			Client.addVariable("flash.client.url", "{@flash_client_url}");
			Client.addVariable("flash.client.origin", "popup");
			Client.addVariable("nux.lobbies.enabled", "true");
			Client.addParam('base', '{@flash_client_url}');
			Client.addParam('allowScriptAccess', 'always');
			Client.addParam('menu', false);
			Client.addParam('wmode', "opaque");
			Client.write('client');
			FlashExternalInterface.signoutUrl = "{@url}/web";
		</script>
	</body>
<body id="client" class="flashclient">

<?php if (ADS) { ?>

	<!-- PUBLI CUADRADA -->
	<div id="ads2" style="width: 301px;height: 251px;position: fixed;top: 50%;left: 50%;transform: translate(-50%, -50%);background-color: rgba(36,35,30,0.6);-moz-border-radius: 4px;-webkit-border-radius: 4px;border: 6px solid rgba(174,174,174,0.4);z-index: 9997;display: none;">
		<div id="avoid" style="background-color: rgba(0, 0, 0, 0);z-index: 9998;width: 40px;height: 16px;position: absolute;left: 88%;"></div>
		<div id="cerrarads2" style="position: absolute;right: 0px;top: -2px;width: 19px;height: 20px;color: #fff;text-align: center;cursor: pointer;background: url({@client_cdn}/img/close.png) no-repeat;z-index: 9999;"></div>
		<!-- Ads -->
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<!-- 336x280 -->
		<ins class="adsbygoogle"
		     style="display:inline-block;width:336px;height:280px"
		     data-ad-client="ca-pub-3358130948395009"
		     data-ad-slot="9146510377"></ins>
		<script>
		(adsbygoogle = window.adsbygoogle || []).push({});
		</script>
		<!-- End Ads -->
	</div>

	<script type="text/javascript">
		$(function(){
		    var TimesMoved = 0;
		    var TimesToBeMove = Math.floor(Math.random() * (6 - 2 + 1)) + 2;

			$(document).ready(function() {
				$("#ads2").delay(15000).fadeIn(20000);
			});

			setInterval(function(){
				$('#ads2').fadeIn(10000);
				googletag.pubads().refresh();
			}, 900000);
			
		    $("#cerrarads2").on({
			    mouseover:function(){
					if(TimesMoved < TimesToBeMove){
						$(this).animate({
						    "left":(Math.random()*166)+"px",
						    "top":(Math.random()*240)+"px"
						});
						TimesMoved++;
					}
			    }
			});

			$("#cerrarads2").click(function(){
				$('#ads2').fadeOut(1500);
				TimesMoved = 0;
				TimesToBeMove = Math.floor(Math.random() * (6 - 2 + 1)) + 2;
			});
		});
	</script>

	<!-- PUBLI VERTICAL -->
	<div id="ads3" style="width: 161px;height: 601px;position: fixed;top: 50%;left: 10%;transform: translate(-50%, -50%);background-color: rgba(36,35,30,0.6);-moz-border-radius: 4px;-webkit-border-radius: 4px;border: 6px solid rgba(174,174,174,0.4);z-index: 9997;display: none;">
		<div id="avoid" style="background-color: rgba(0, 0, 0, 0);z-index: 9998;width: 40px;height: 16px;position: absolute;left: 77%;"></div>
		<div id="cerrarads3" style="position: absolute;right: 0px;top: -2px;width: 19px;height: 20px;color: #fff;text-align: center;cursor: pointer;background: url({@client_cdn}/img/close.png) no-repeat;z-index: 9999;"></div>
			<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<!-- Ads -->
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<!-- 160x600 -->
		<ins class="adsbygoogle"
		     style="display:inline-block;width:160px;height:600px"
		     data-ad-client="ca-pub-3358130948395009"
		     data-ad-slot="6053443178"></ins>
		<script>
		(adsbygoogle = window.adsbygoogle || []).push({});
		</script>
		<!-- End Ads -->
	</div>
	
	<script type="text/javascript">
		$(function(){
		    var TimesMoved = 0;
		    var TimesToBeMove = Math.floor(Math.random() * (6 - 2 + 1)) + 2;
			$(document).ready(function() {
				//$('.ads').delay(15000).slideUp('slow');
				$("#ads3").delay(15000).fadeIn(20000);
			});

			setInterval(function(){
				$('#ads3').fadeIn(10000);
				googletag.pubads().refresh();
			}, 900000);
			
		    $("#cerrarads3").on({
		        mouseover:function(){
		            if(TimesMoved < TimesToBeMove){
			            $(this).animate({
			                "left":(Math.random()*128)+"px",
			                "top":(Math.random()*400)+"px",
			            });
			            TimesMoved++;
			        }
		        }
		    });

			$("#cerrarads3").click(function(){
				$('#ads3').fadeOut(1500);
				TimesMoved = 0;
				TimesToBeMove = Math.floor(Math.random() * (6 - 2 + 1)) + 2;
		    });
		});
	</script>		

	<!-- PUBLI RECTANGULAR -->
	<div id="ads4" style="width: 729px;height: 91px;position: fixed;top: 90%;left: 50%;transform: translate(-50%, -50%);background-color: rgba(36,35,30,0.6);-moz-border-radius: 4px;-webkit-border-radius: 4px;border: 6px solid rgba(174,174,174,0.4);z-index: 9997;display: none;">
		<div id="avoid" style="background-color: rgba(0, 0, 0, 0);z-index: 9998;width: 40px;height: 16px;position: absolute;left: 95%;"></div>
		<div id="cerrarads4" style="position: absolute;right: 0px;top: -2px;width: 19px;height: 20px;color: #fff;text-align: center;cursor: pointer;background: url({@client_cdn}/img/close.png) no-repeat;z-index: 9999;"></div>
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<!-- Ads -->
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<!-- 728x90 -->
		<ins class="adsbygoogle"
		     style="display:inline-block;width:728px;height:90px"
		     data-ad-client="ca-pub-3358130948395009"
		     data-ad-slot="1623243573"></ins>
		<script>
		(adsbygoogle = window.adsbygoogle || []).push({});
		</script>
		<!-- End Ads -->
	</div>

	<script type="text/javascript">
		$(function(){

		    var TimesMoved = 0;
		    var TimesToBeMove = Math.floor(Math.random() * (6 - 2 + 1)) + 2;

			$(document).ready(function() {
				$("#ads4").delay(15000).fadeIn(20000);
			});

			setInterval(function(){
				$('#ads4').fadeIn(10000);
				googletag.pubads().refresh();
			}, 900000);
			
		    $("#cerrarads4").on({
		        mouseover:function(){
		            if(TimesMoved < TimesToBeMove){
			            $(this).animate({
			                "left":(Math.random()*485)+"px",
			                "top":(Math.random()*72)+"px",
			            });
			            TimesMoved++;
			        }
		        }
		    });

			$("#cerrarads4").click(function(){
				$('#ads4').fadeOut(1500);
				TimesMoved = 0;
				TimesToBeMove = Math.floor(Math.random() * (6 - 2 + 1)) + 2;
			});
		});
	</script>

<?php } ?>

<script type="text/javascript" src="{@cdn}/js/adblock.js"></script>
<script>
	function adBlockDetected() {
		window.location.href = '{@url}/web/adblock';
	}
	
	if(typeof fuckAdBlock === 'undefined') {
		adBlockDetected();
	} else {
		fuckAdBlock.setOption({ debug: false });
		fuckAdBlock.onDetected(adBlockDetected);
	}

	if (!FlashDetect.installed) {
		window.location.href = '{@url}/web/flash';
	}
</script>
</body>
</html>