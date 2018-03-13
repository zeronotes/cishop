<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>Login</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<script src="<?= base_url()?>resources/js/jqueries/jquery-1.8.3.min.js" type="text/javascript"></script>
	<script>
			 $(document).ready(function() {
			// 	if (!($.browser.safari || $.browser.mozilla)) {
			// 		$("form").hide();
			// 		$("<div class='error' />").html("<h2>Browser Not Supported</h2><br />We currently only support <br/>Firefox (version &gt; 3.5 recommended)<br/>Safari (version &gt; 3 recommended)<br/>Chrome (any version)").appendTo('#login-content');
			// 	}
				// if($.browser.msie) {
				// 	if($.browser.version < 9.0) {
				// 		$("form").hide();
				// 		$("<div class='a' style='width:500px;' />").html("<h2>Bạn đang dùng trình duyệt IE, version nhỏ hơn 9.0 nên không được hỗ trợ</h2><br />Khuyến cáo bạn nên sử dụng trình duyệt version cao hơn, để có được hiệu ứng hiển thị tốt nhất <br/><br/>Firefox (version &gt; 3.5 recommended)<br/>Safari (version &gt; 3 recommended)<br/>Chrome (any version)<br/> IE (version &gt; 8 recommended)").appendTo('#login-wrapper');
				// 	}
				// }

				$('#username').val('');
				$('#password').val('');
				$('#login-form').submit(function() {
					$('.error').fadeOut(1000);
					if($('#username').val() == '' && $('#password').val() == '') {
						$('#error-js').html('Usernamee and Password required!').fadeIn(1000);
						return false;
					}else if($('#username').val() == '') {
						$('#error-js').html('Usernamee required!').fadeIn(1000);
						return false;
					}else if($('#password').val() == '') {
						$('#error-js').html('Password required!').fadeIn(1000);
						return false;
					}
					return true;
					
				});
			});
	</script>

	<style type="text/css">
			* {
				font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
			}
			
			body {
				margin: 0;
				pading: 0;
				color: #fff;
				background:  #031D2E;
				font-size: 14px;
				text-shadow: #050505 0 -1px 0;
				font-weight: bold;
			}
			
			li {
				list-style: none;
			}
			
			#dummy {
				position: absolute;
				top: 0;
				left: 0;
				border-bottom: solid 3px #777973;
				height: 250px;
				width: 100%;
				background: #fff;
				z-index: 1;
			}
			
			#dummy2 {
				position: absolute;
				top: 0;
				left: 0;
				border-bottom: solid 2px #545551;
				height: 252px;
				width: 100%;
				background: transparent;
				z-index: 2;
			}
			
			#login-wrapper {
				margin: 0 0 0 -160px;
				width: 320px;
				text-align: center;
				z-index: 99;
				position: absolute;
				top: 0;
				left: 50%;
			}
			
			#login-top {
				height: 120px;
				padding-top: 140px;
				text-align: center;
			}
			
			label {
				width: 70px;
				float: left;
				padding: 8px;
				line-height: 14px;
				margin-top: -4px;
			}
			
			input.text-input {
				width: 200px;
				float: right;
				background: #fff;
				border: solid 1px #999;
				color: #555;
				height:30px;
				font-size: 13px;
			}
			
			input.button {
				float: right;
				padding: 6px 10px;
				color: #fff;
				font-size: 14px;
				text-shadow: #050505 0 -1px 0;
				background-color: #2F8CC9;
				border: solid 1px #fff;
				font-weight: bold;
				cursor: pointer;
				letter-spacing: 1px;
			}
			
			input.button:hover {
				text-shadow: #050505 0 -1px 2px;
				background-color: #031D2E;
				color: #fff;
			}
			
			p.error,p#error-js,div.error{
				padding: 8px;
				background: rgba(52, 4, 0, 0.4);
				-moz-border-radius: 8px;
                -webkit-border-radius: 8px;
				border-radius: 8px;
				border: solid 1px transparent;
				margin: 6px 0;
			}

			p#error-js {
				display:none;
			}

			#login-form p {
				margin-bottom:10px;

			}
		</style>
</head>

<body id="login">
		
		<div id="login-wrapper" class="png_bg">
			<div id="login-top">
				<h1 style="color: #0B3047">Admin Control Panel</h1>
				<!-- <img src="<?//= base_url()?>resources/ui_images/background/logo_small.png" alt="Login" title="Login">			 -->
			</div>
			
			<div id="login-content">
				<p id="error-js"></p>
				<?php echo validation_errors('<p class="error">').'</p>'?>
				<?php if(isset($fail)):?>
					<p class="error"><?= $fail ?></p>
				<?php endif;?>
				<form name="login-form" id="login-form" method="post" action="<?= base_url()?>administrator/login">					
					<table>
						<tr>
							<td>
								<label>Username</label>
							</td>
							<td>
								<input  name="username" id="username" class="text-input" type="text" placeholder="">
							</td>
						</tr>
						<tr>
							<td>
								<label>Password</label>
							</td>
							<td>
								<input name="password" id="password" class="text-input" type="password">
							</td>
						</tr>
						<tr>
							<td colspan="2"><input class="button" type="submit" value="Sign In"></td>
						</tr>
					</table>
					
				</form>
			</div>
		</div>
		<div id="dummy"></div>
		<div id="dummy2"></div>
  

</body></html>