<?php 
error_reporting(0);
require_once "EXPLORE.php";
require_once "status_code.php";
define("USER", "arsenalnerk");
define("PWD", "123456");
$client = new SoapClient("http://ideone.com/api/1/service.wsdl"
,array('proxy_host'=> "172.16.1.11",'proxy_port'=> 3128)
	);
// --------------------------------------------------------------
// IF PROFILES ARE ENABLED IN CONFIG FILE
// --------------------------------------------------------------
if(ENABLE_USER_PROFILES == 1){ 
?>
<?php require_once(ROOT_PATH.'user/modules/accordion/banner.html.php'); ?>

	 <form action='' method='post'>
	<fieldset>
		<legend>Write your code</legend>
		Select Your Language: <select name="PL">
		<option value="">--- PROGRAMMING LANGUAGE ---</option>
			<?php
			$result = $client->getLanguages($user="arsenalnerk",$pass="123456");
			foreach( $result["languages"] as $k=>$v)
			{
				echo "<option value='".$k."'>".$v."</option>";
			}
			?>
		</select><br/>
		<textarea id="code" style="height: 350px; width: 100%;" name="code">
		<?=stripslashes($_POST["code"])?>
		</textarea>
	</fieldset>
	<input type="submit" value="Execute" class="amit_button"/>
	</form>
</body>
</html>
<?php

	$code = stripslashes($_POST["code"]);
	$lang = $_POST["PL"];
	//explore($client->getLanguages($user="arsenalnerk",$pass="123456"));
	if(($code)) {
	$result = $client->createSubmission($user = USER, $pass= PWD, $sourceCode = $code, $language = $lang, $input = "", $run = 1, $private = 0);
	//explore($result);
	$stat = $client->getSubmissionStatus($user = USER, $pass= PWD,$link = $result["link"]);
	//explore($stat);
	$output = $client->getSubmissionDetails($user = USER, $pass= PWD, $link = $result["link"], $withSource = 1, $withInput = 0, $withOutput = 1, $withStderr = 1, $withCmpinfo=1);
	echo $output["output"];
	explore($output);
	//echo $output["output"];
	}
?> 
    </div>
  </div>
</div>
<?php 
}
else
{
	// if profiles are not enabled in web.config
	require_once(ROOT_PATH.'user/modules/accordion/error_messages.php');
	echo $profiles_not_enabled;
} 
?>