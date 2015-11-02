<?php
 
 require 'config.php';
 require 'auth.php';
 
 if($config['salt'] == '') {
 	header('Content-Type: text/plain');
 	die('Please check and configure config.php first.');
 }
 
 if(!$config['skip_log_in'] && ($message = LogInMessage()) !== true) {
 	?><!DOCTYPE html>
<html> 
<head>
	<title><?php echo strip_tags($config['title']); ?> - Login</title> 
	<link rel="stylesheet" media="screen" href="style.css"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
</head> 
<body>
	<h1><?php echo $config['title']; ?> - Login</h1>
	<form action="" method="post">
		<div id="login">
			<?php
				if($message) {
					echo '<div class="error">' . $message . '</div>';
				}
			?>Log in to continue.<br/>
			Username: <input class="i" type="text" name="username" /><br/>
			Password: <input class="i" type="password" name="password" /><br/>
			<input id="login_btn" type="submit" value="Login" />
		</div>
	</form>
</body>
</html><?php 	
 } else {
 	// logged in.
 	
 	if(isset($_GET['input']) && $_GET['input'] == 'logout') {
 		Logout();
 	}
 	
 	if($config['skip_log_in'])
 		$username = 'user';
 	else
 		$username = $_COOKIE['user'];
 	 
?><!DOCTYPE html> 
<html> 
<head>
	<title><?php echo strip_tags($config['title']); ?></title> 
	<link rel="stylesheet" media="screen" href="style.css"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
</head> 
<body>
	<h1><?php echo $config['title']; ?></h1>
	
	<script src="jquery-1.6.3.min.js"></script>
	<script>
		var history = [];
		var i = -1;
		var cd = '~';
		
		function command(cmd) {
			if(cmd.value == 'logout') {
				return true;
			}
			
			$.ajax({
				url: 'c.php',
				type: 'POST',
				dataType: 'json',
				data: 'cmd= ' + encodeURIComponent(cmd.value) + '&cd=' + encodeURIComponent(cd),
				success: function(json) {
					if(cmd.value != '')
						history.push(cmd.value);
					
					$('#r').append('<div class="command"><span><?php echo addslashes($username); ?>@<?php echo addslashes($config['hostname']); ?> ' + cd + ' $</span> ' + cmd.value + '</div>');
					$('#r').append(json.response);
					
					$('body').animate({ scrollTop: $('body').height() }, 450);
					
					$('#i')[0].style.opacity = 0;
					$('#i').animate({ opacity: 1 }, 300);
					
					if(json.cd)
						cd = json.cd;
					$('#i .command span a').html(cd);
					cmd.value = '';
					fixsize();
				}
			});
			
			i = -1;
			
			return false;
		}
		
		function fixsize() {
			$('#input')[0].style.width = ($('#i').width() - $('#i .command span').width() - 20) + 'px'
		}
		
		$(document).ready(function() {
			fixsize();
			
			$(window).keydown(function(e) {
				if(e.which == 38 && history.length > 0) {
					if(i  < 1)
						i = history.length;
					i--;
					
					
					$('#input')[0].value = history[i];
					$('#input').focus();
					return false;
				} else if(e.which == 40) {					
					if(i == history.length - 1) {
						$('#input')[0].value = '';
					} else {
						i++;
						$('#input')[0].value = history[i];
					}
					$('#input').focus();
					return false;
				}
			});
			
			
			$(window).resize(fixsize);
		});
	</script>
	
	<form onsubmit="return command(this.input)">
		<div id="console">
			<div id="r">
				<?php
					if(isset($config['welcome']) && $config['welcome']) {
						echo str_replace(" ", '&nbsp;', $config['welcome']) . '<br/>';
					}
				?>
				<!-- Console results will be appended here. !-->
			</div>
			<div id="i">
				<div class="command"><span><?php echo $username; ?>@<?php echo $config['hostname']; ?> <a>~</a> $</span> <input autocomplete="off" name="input" id="input" /></div>
			</div>
		</div>
	</form>
</body>
</html>
<?php

	}
?>
