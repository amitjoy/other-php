<?php
// detect if IE is less than version 9
if(DETECT_IE == 1)
{
	if(preg_match('/(?i)msie [1-8]/',$_SERVER['HTTP_USER_AGENT']))
	{
		echo '<div id="msgBox_IE" class="msgBox_IE"><a id="hide_warning" href="#" class="btn_close">Close</a>NOTE: Some CSS3 features are not supported by your browser. Please consider installing the latest version of <a href="http://windows.microsoft.com/en-US/internet-explorer/products/ie/home" title="Download Internet Exploder from Microsoft" class="ie">Internet Exploder,</a> or <a href="http://www.mozilla.com/en-US/firefox/fx/" title="Download FireFox from Mozilla" class="ff">FireFox,</a> or <a href="http://www.google.com/chrome/intl/en/make/download.html?brand=CHKZ" title="Download Google Chrome from Google" class="ch">Google Chrome,</a> or <a href="http://www.opera.com/download/" title="Download Opera from opera.com" class="op">Opera</a></div>';
	}
}
?>