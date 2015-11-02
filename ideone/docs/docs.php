<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>PHP Security and User Management | Getting Started Guide</title>
<link rel="shortcut icon" href="../images/favicon.gif"/>
<link rel="shortcut icon" href="../images/favicon.ico"/>
<link rel="stylesheet" type="text/css" href="themes/default/default.css"/>
</head>
<body>
<!-- navigation and logo -->
<div class="nav_bar"> 
  <div class="inner">
    <span class="link"><a href="../index.php" title="Home page ...">Home</a></span>
    <span class="link"><a href="#" title="Getting Started Guide ...">Getting Started</a></span>
    <div class="logo"></div>
  </div>
</div>
<!-- header image -->
<div class="header_wrap">
  <!-- help icon -->
  <div class="help_icon_wrap">
    <div class="help_icon"></div>
  </div>
  <div class="header_image"></div>
</div>
<!-- slogan bar -->
<div class="slogan_bar">PHP Security and User Management! ... Secure Your Pages, Manage Your Users! ...</div>
<div class="slogan_bar_shadow"></div>
<!-- body -->
<div class="body_wrap">
  <h1>Getting Started Guide</h1>
  <div class="divider"><a href="#">Top</a></div>
  <h2>About: PHP Security and User Management</h2>
  <div class="divider"><a href="#">Top</a></div>
  <p>This application features: <strong>Login, Registration, Password Reset,   Lost User Name, Lost Activation, Role based Page Security, User   Profiles, Complete User Account/Credentials Management Back-End, Plus ++ Bonus Addons: File Explorer, Data   Driven Menu System – </strong> that can be used as a  PHP  /MySQL Website Starter Kit or as an   integrated application in your already existing site with all the page   security and user management features already built in.</p>
  <a id="front-end" href="../login.php" class="front_end_png" title="View the front end modules like, Login, Registration, Password Reset, Lost User name and Lost Activation Code,"></a> 
  <a id="user-back-end" href="../user/index.php" class="user_back_end_png" title="Login to view the User Dashboard and learn how you can edit your account details."></a>
  <a id="admin-back-end" href="../admin/index.php" class="admin_back_end_png" title="Login to view the site administration panel and find out how to manage user accounts."></a>
  <a id="getting-started" href="#" class="getting_started_png" title="You are here..."></a>
  <div class="clearBoth"></div>  
  <p>It is a feature rich user management application that is easy to implement and takes   care of all the basics to save you time and allow you to focus on what's   important. Use it as a template to start your next new project or add   it to your existing site to provide Out-Of-The-Box Security, User   Management features and so much more…  </p>
  <h2>Installation</h2>
  <div class="divider"><a href="#">Top</a></div>
  <ol class="ol2">
    <li>Deploy the database script located in the &quot;connect&quot; folder.</li>
    <li>Enter your database connection details in <strong>mysql.php</strong> located in the &quot;connect&quot; folder.</li>
    <li>Add your e-mail to the configuration file &quot;web.config.php&quot; under section five (5).</li>
    <li>Upload the <strong>psum</strong> folder and its contents to your website root.<strong> - http://www.your-site.com/psum</strong></li>
    <li>That's it! For step by step instructions and an overview of some important things, you should take a gander below...</li>
  </ol>
  <h2>PHP Server Requirements</h2>
  <div class="divider"><a href="#">Top</a></div>
  <p>This application requires PHP 5.2.x or above on Linux and 5.3.x or above on Windows Server.&nbsp;PHP 5.2 will suffice on Windows but some functionality will not be available.</p>
  <h2>Unpacking the Downloaded Files</h2>
  <div class="divider"><a href="#">Top</a></div>
  <p>The file download is a ZIP file. So, unpack the file to your desktop. You will get a single folder called &quot;<strong>psum</strong>&quot;, inside which you will find the application files. The file structure inside the unpacked folder should look something like the following image.</p>
  <p>
    <input type="image" name="imageField" id="imageField" src="themes/default/images/file-structure.png" />
  </p>
  
  <h2>Creating the MySQL Database in phpMyAdmin</h2>
  <div class="divider"><a href="#">Top</a></div>
  <p>First things first... If you haven't created a MySQL database before, you can follow the instructions below. Create a new empty database in your hosting control panel and run the provided <strong>dbpsum.sql</strong> script on it to create all the database tables provided with this application.</p>
  <ol class="ol2">
    <li>In your hosting control panel, navigate to the MySQL Databases section.</li>
    <li>Create a new empty database and name it anything you want or use the default (<strong>dbpsum</strong>) used in this application.</li>
    <li>When the database is created, make sure you assign a db user name and password to it. This is absolutely essential to keep your database secure and for the application to be able to connect to it and function properly.</li>
    <li>Once the database is created as described above, navigate to phpMyAdmin within your hosting control panel. You should be able to see the newly created empty database appear in the left hand column.</li>
    <li>Click on the name of the new empty database, then navigate to the &quot;import&quot; tab on top.</li>
    <li>Within the &quot;<strong>File to Import</strong>&quot; section on top, click the &quot;<strong>Browse</strong>&quot; button and navigate to the &quot;connect&quot; folder inside the downloaded files on your desktop. You will see a file named &quot;<strong>dbpsum.sql</strong>&quot;. This is the provided sql script that will create all the tables for us.</li>
    <li>Double click on this file to select it.</li>
    <li>Now click the &quot;<strong>Go</strong>&quot; button on the bottom right of the phpMyAdmin window. This will deploy the database script and create all the required tables inside the new database that we have just created. The image below shows what you should see (approximately) when done.</li>
    <li>Before you leave this window, you should note the location address of your database. It should be displayed somewhere in your hosting control panel. It could be &quot;<strong>localhost</strong>&quot; or something different.</li>
    <li>
      <input type="image" name="imageField3" id="imageField3" src="themes/default/images/db-tables.png" />
    </li>
    <li>OK, the database is done. You can close this window if you want.</li>
    <li>At this point, you should remove the database script file from the &quot;<strong>connect</strong>&quot; folder and keep it in a safe place in case you need to restore or recreate the database later. You do not want to upload this file to your server for obvious security reasons eventhough the connect folder is not directly accessible once the application is deployed (htaccess file).</li>
  </ol>
  <h2>Editing the Connection String</h2>
  <div class="divider"><a href="#">Top</a></div>
  <ol class="ol2">
    <li>The next thing we need to do is to edit the connection string so the application knows where the database is located and how to connect to it with the right security permissions (access rights). So, using your favorite code editor, open the &quot;<strong>mysql.php</strong>&quot; file located inside the &quot;connect&quot; folder within the <strong>psum</strong> folder.</li>
    <li>Make the appropriate changes for the database location, name, user name and password. Here is a screen-shot to help you along:</li>
    <li>
      <input type="image" name="imageField4" id="imageField4" src="themes/default/images/connection-string.png" />
    </li>
    <li>Simply replace db_host, db_name, db_user_name, and db_password with the real values for the database we have created above.</li>
    <li><strong>db_host</strong> could be something like &quot;localhost&quot; or your_user-name.your-site-name.com or something similar. This should be listed in your hosting control panel. If not, please contact your hosting provider&nbsp;for help.</li>
    <li><strong>db_name</strong> is the name of the database you have created above.</li>
    <li><strong>db_user_name</strong> is the user name you have assigned to the database when you've created it.</li>
    <li><strong>db_password</strong> is the password you have assigned to the database when you've created it.</li>
    <li>Once this is in place, the connection string file will know exactly how to connect to the database in a safe and secure manner.</li>
  </ol>
  <h2>Editing the web.config.php</h2>
  <div class="divider"><a href="#">Top</a></div>
  <p>This file stores some global settings that are used throughout the application. Everything here is simple, self explanatory and straight forward. They are created to make programming easier, to avoid redundancy and to give you the convenience to turn features ON/OFF. If we need to change some values or turn features ON/OFF, we can do it all in one place rather than having to update a bunch of files. <strong>THE ONLY THING YOU HAVE TO CHANGE HERE IS YOUR EMAIL ADDRESS SO THE APPLICATION KNOWS WHERE TO SEND THE EMAILS WHEN REQUIRED.</strong></p>
  <p>At the time of this writing, there are 24 plus groups of settings that can be edited. The following sections below highlight a few important ones.</p>
  <ul class="ul1">
    <li><strong>1. Define the ROOT PATH</strong> for your site. If you drop the <strong>psum</strong> folder into your site like: http://www.yoursite.com/psum/, the default path is already set for you! This code is used by the application to properly handle include files. Here is a visual to help you along:</li>
    <li>
      <input type="image" name="imageField5" id="imageField5" src="themes/default/images/root-path.png" />
    </li>
    <li>The .<strong>'/psum/'</strong> appended to the end of this constant denotes the name of the subdirectory (folder) where the application is located under the domain root. If this application is running from within the root directory (<strong>not</strong> inside the <strong>psum</strong> folder), you would simply omit this part. The code would look like this: define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] );. If the <strong>psum</strong> folder is nested within another folder, then you'd modify this line accordingly. If you are unsure what this code would yield and would like to confirm so you can set the path correctly, you can copy and paste this: &lt;?php echo  $_SERVER['DOCUMENT_ROOT'] );?&gt; on a PHP page and upload it to your server. If you view this page in the browser, it will tell you exactly what your document root is. </li>
    <li><strong>2. Site URL</strong> for your site. This code is used by the application for proper navigation purposes. Here is a visual to help you along:</li>
    <li>
      <input type="image" name="imageField6" id="imageField6" src="themes/default/images/site-url.png" />
    </li>
    <li>Again, the same exact principle applies. If this application is running within the root directory of your site (not inside the <strong>psum</strong> folder), the code would look like this: $domainName = $_SERVER['HTTP_HOST'].'/'; ...You simply omit the subdirectory name. If you drop the <strong>psum</strong> folder into your site like: <strong>http://www.yoursite.com/psum/</strong>, the default path is already set for you! </li>
    <li><strong>3. Account Activation URL</strong>: And finally, the third edit is the Account Activation URL. This file is located in the root of the application and is named account-activation.php. It is used to validate new accounts. When registration is complete, the new user receives a confirmation e-mail and must click on the link inside it to validate and activate their account. By setting this URL in the configuration file, the URL in the e-mail will be created properly and the application can do its job. The same exact principle as discussed above apply here as well. Again: If you drop the <strong>psum</strong> folder into your site like: <strong>http://www.yoursite.com/psum/</strong>, the default path is already set for you!  This is number four (4) in the configuration file. See image below:</li>
    <li>
      <input type="image" name="imageField7" id="imageField7" src="themes/default/images/verification-url.png" />
    </li>
    <li><strong>4</strong>. <strong>E-Mail Address</strong>: Before we move on to the next section, remember to <strong>change the e-mail addresses in config. section five (5)</strong> as well. The application utilizes the php-email quite extensively - from confirmation and welcome e-mails to error reporting and admin alerts, etc...</li>
    <li>
      <input type="image" name="imageField11" id="imageField11" src="themes/default/images/emails.png" />
    </li>
  </ul>
  <h2>Moving the Application To Your Server</h2>
  <div class="divider"><a href="#">Top</a></div>
  <ul class="ul1">
    <li>The only thing we have left to do is to upload the files (psum folder and its content) to the hosting server under your root domain. </li>
    <li>To access the application your address should look like this: <strong>http://www.yoursite.com/psum/</strong>.</li>
    <li>The index.php page: <strong>http://www.yoursite.com/psum/</strong>index.php</li>
    <li>The Site Admin: <strong>http://www.yoursite.com/psum/</strong>admin/index.php</li>
    <li>The User Dashboard: <strong>http://www.yoursite.com/psum/</strong>user/index.php</li>
    <li>The Login page: <strong>http://www.yoursite.com/psum/</strong>login.php</li>
    <li>The Registration Page: <strong>http://www.yoursite.com/psum/</strong>register.php</li>
    <li>The Lost Password Page: <strong>http://www.yoursite.com/psum/</strong>recover.php</li>
    <li>The Lost User Name: <strong>http://www.yoursite.com/psum/</strong>recover-un.php</li>
    <li>The Resend Lost Activation Code Page: <strong>http://www.yoursite.com/psum/</strong>lost-activation.php</li>
  </ul>
  <h2>Securing Your Pages</h2>
  <div class="divider"><a href="#">Top</a></div>
  <p>Securing the pages you will create is very simple. You simply insert a PHP snippet at the top of each of your PHP pages that you wish to protect. Once the snippet is in place, you can define the role or roles that are allowed to access the page. User Roles can be created in the admin panel. Let's take a look at how the snippet works:</p>
  <h3>The Code Snippet</h3>
  <div class="divider"><a href="#">Top</a></div>
<pre>
&lt;?php
//------------------------------------------------------------
// RESTRICT ACCESS TO PAGE
//------------------------------------------------------------
require_once('web.config.php'); 
require_once(ROOT_PATH.'global.php');
$auth_roles = array('owner','superadmin','etc.'); // &lt;&lt; add roles here
//$premium_on = 1; $premium_access_levels = array('1','2');// &lt;&lt; add premium access levels here
require_once(ROOT_PATH.'modules/authorization/auth.php'); 
?&gt;
</pre>
  <h3>Explanation</h3>
  <div class="divider"><a href="#">Top</a></div>
  <ol class="ol2">
    <li><strong>require_once('web.config.php');</strong>      This code tells the application to include the web.config.php file which contains all the important application settings. Depending on where your protected page is located within the file structure, you have to adjust this URL so it is properly pointing to the <strong>web.config.php</strong> file. It doesn't matter how deeply your page is nested inside folders, just make sure the URL is correct. For example: if the php page you are protecting is in the same directory as the web.config.php file is, then the URL is: <strong>'web.config.php</strong>', if it is nested one level down (inside a folder that is located root level), then: '<strong>../web.config.php</strong>', if two levels, then: '<strong>../../web.config.php</strong>' etc. etc.</li>
    <li><strong>require_once(ROOT_PATH.'global.php');</strong>      This is another include file that tracks user sessions allowing the &quot;visitors online&quot; counter to work. If you don't want to track current visitors, you can turn this feature off in the web.config.php file&nbsp;in section 17.</li>
    <li><strong>$auth_roles = array('owner','superadmin','etc','etc'); // &lt;&lt; add roles here</strong>      This is where you define the allowed Roles (groups) that can access this page. As you can see above, the owner and superadmin are defined as allowed roles to view this fictional page. This means that any user who is in either of these two roles are permitted to view this page. You can add as many roles to the database as desired, name them as you wish and used them in your pages. So, in the above line of code, you would enter the role or roles in the manner you see it above, inside '<strong>single quotes</strong>' separated by a coma <strong>,</strong> and you're good to go. </li>
    <li><strong>require_once(ROOT_PATH.'modules/authorization/auth.php');</strong>      This is the PHP file that actually does all the work to authorize and authenticate the user trying to view the page.    </li>
    <li><strong>$premium_on = 1; $premium_access_levels = array('1','2','etc','etc'); // &lt;&lt; add premium access levels here </strong>IMPORTANT! This line is used for pages with Premium Membership Content.   The PayPal Subscription feature allows your registered users to   subscribe to premium content on your site. When you create your premium   content pages that you want not only to authenticate and authorize   users, but also to make sure that  premium subscribers are checked and   validated before viewing the page, you use this additional line.   Otherwise comment it out by putting two forward slashes infornt like   this: <br />
    <strong>// $premium_on = 1; $premium_access_levels = array('1','2');</strong>. PHP will ignore code that is commented out. You can also just delete this line of code.</li>
  </ol>
  <h3>Suggestion:</h3>
  <div class="divider"><a href="#">Top</a></div>
  <p>It is highly recommended that you include the owner role in all protected pages because access is strictly restricted to the defined roles on each protected page. This ensures that the owner of the site has the highest privileges and can access any page. 
    However, if the naming conventions of the default roles do not suffice, you can create your own roles and hierarchy in the admin panel and use them accordingly in your protected pages. Please note that while the use of the default roles are not mandatory, they are protected by the application and delete requests are simply ignored - just in case you need them later and wish you did not delete them.</p>
  <p>There are no limits to the number of roles and no limits on how many roles a user is in. The application logic is very flexible and it is entirely up to you how you use them. The only thing you need to remember is that whatever role(s) is/are present in your code snippet, users in those roles are permitted to view the page. That's it!</p>
  <h2>The reCAPTCHA Control</h2>
  <div class="divider"><a href="#">Top</a></div>
  <p>If you want to take advantage of the recaptcha modules that are built in to the Login, Registration, Password Reset and Lost Activation modules, it is highly recommended that you register an account and create your own public and private keys. You can go here <a href="http://www.google.com/recaptcha" title="Register a reCaptcha account" target="_new">http://www.google.com/recaptcha</a> to do all of that. I have included a generic set of keys so you can test the application without having to mess with it but it is not secure since everyone who downloads the application will have the same pair of keys. So, please make sure you DON'T forget!</p>
  <h3>Turning The reCaptcha Control ON/OFF</h3>
  <div class="divider"><a href="#">Top</a></div>
  <p>Recaptcha adds an extra layer of security to your application and it is highly recommended. However, if you do not wish to use it on your Login and Registration pages, you can turn them off in the web.config.php file. Simply set the value to zero (0). To turn it back on, set the value back to one (1). Here is a visual to help you along:</p>
  <p><input type="image" name="imageField8" id="imageField8" src="themes/default/images/recaptcha.png" /></p>
  <h2>File Structure and Architecture</h2>
  <div class="divider"><a href="#">Top</a></div>
  <p>This app was built with simple event driven programming so the code is easy to understand and edit even if you are a beginning / junior PHP developer. </p>
  <p>There are lots of files - only because I tried to break out and isulate every distinct functionality to make finding and editing code as easy as possible. Once you've become familiar with the basic organization, it will be a breez to make edits and modifications.</p>
  <p>The actual files that are viewed in the browser, only contain include files to keep things clean and organized. All code files are located and organized in the &quot;modules&quot; folders. One for each major section of the site. There is a &quot;modules&quot; folder in the site root, &quot;admin&quot; section, user &quot;folder&quot; and another one in the &quot;feedback&quot; folder. Each &quot;modules&quot; folder also contains an &quot;.htacces&quot; file that prevents direct access to these code files. They can only be used as include files within the application. Here is a visual to help you along.</p>
  <p><input type="image" name="imageField10" id="imageField10" src="themes/default/images/control-folder-2.png" /></p>
  <p>As you can see, the control directories are pretty srtraight forward and just about explain themselves. Each directory is named after the functionality it contains. The PHP files inside them are also organized the same easy to follow way based on nothing more than common sense...or so is my hope. This allows you, hopefully, to quickly explore and find the code you're looking for.  </p>
  <h2>PayPal Subscriptions - Premium Membership</h2>
  <p>The administrator of the site, within the admin panel, can create an unlimited number of subscription categories, each with an unlimited number of subcategories (rates).</p>
  <p><span class="bodyText">This section comprises of four main categories:</span>  </p>
  <ol class="ol2">
    <li>The PayPal Configuration form that allows you to enter your PayPal merchant details:</li>
    <li>The Premium Options (Categories):</li>
    <li>The Subscription Rates that can be assigned to any of the Premium Options. This functionality supports all three subscription periods, Period-1,2 and 3, two of which are optional, Period-1 and 2. One important thing to mention here is the "Premium Access Level". When you create a Subscription Rate, you assign a premium access level to each that tells the application who can access the premium content page. For example: <br />
      <br />
      Let's say you create a subscription rate with the premium access level of 1. After the user subscribes to this subscription rate, PayPal sends a confirmation notice to the IPN (instant payment notification) page within the site. The IPN handles the transaction and among many other things, it updates the user table by assigning the access level to the user. This user is now an active premium member with access to premium content pages that have the access level 1.<br />
      <br />Remember our code snippet above??? This line: $premium_on = 1; $premium_access_levels = array('1','2');// << add premium access levels here - comment out if NOT premium content.<br />
    <br />When you add the code snippet to your pages, you define the access levels that are allowed to view the page's content. So, if the snippet above contains a 1, users with premium access level 1 can view the page. You can include multiple access levels allowing users from each of those access levels to view the page.</li>
    <li>The PayPal Transactions Gridview that shows all recorded incoming transactions sent by PayPal. Full details can be viewed for each transaction. Registered users while not premium members are presented with a signup form when they login to their acount. Once the premium membership is active, the form is automatically hidden from the user until their subscription expires.
      <br />
      <br />
    Finally, if you only wish to use the login and user management components and have no need for premium subscriptions, you can turn the entire module off within the config file. It will be completely hidden from the user. You can also hide it within the administration panel.</li>
  </ol>
  <h3>PayPal Instant Payment Notification (IPN)</h3>
  <p>The PayPal IPN file of this application automates the process of Premium Subscriptions. It handles all the transactions sent by PayPal and verifies and double checks all incoming information and it is safe against all fradulent submissions. Fradulent submissions as well as failed transactions are recorded in the database, flagged, and an alert email is sent to the site administrator with the transaction details as well as the full raw data stream captured by the IPN.</p>
  <h2>The Configuration File - Settings and Options</h2>
  <h3>- Output Buffering</h3>
<pre>
//------------------------------------------------------------
// comment out if output_buffering is already ON
//------------------------------------------------------------ 
ob_start();
</pre>
  <p>If output_buffering is already turned on for your hosting account, you can comment this out. Leaving it ON however will not do anything bad so if you don't want to bother with it you don't have to.</p>
  <h3>- Magic Quotes</h3>
<pre>
//------------------------------------------------------------
// turn off magic quotes
//------------------------------------------------------------ 
//ini_set('magic_quotes_gpc', 0); // 1=on 0=off
</pre>
  <p>If magic quotes are not already turned off in php.ini, you can uncomment this line and it will turn it off for you. By default, this line is commented out because ordinarily this is not an issue.</p>
  <h3>- Sessions</h3>
<pre>
//------------------------------------------------------------
// instantiate sessions
//------------------------------------------------------------ 
if(!isset($_SESSION)){
  session_start();
}
</pre>
  <p>This just instantiates the PHP sessions so the application can function properly.</p>
  <h3>0. Browser Warning</h3>
<pre>
//------------------------------------------------------------
// 0. WARN IF IE IS LESS THAN version 9.0
//------------------------------------------------------------ 
define('DETECT_IE', 1); // 1=Yes 0=No
</pre>
  <p>This can be turned OFF by setting the value to 0 (zero). The CSS code (styling) of this script uses a lot of CSS3 which is poorly supported by Internet Explorer older than version 9. The above configuration displays a banner on top of the page to inform the user that their browser is out of date.</p>
  <h3>1. Root Path</h3>
<pre>
// ------------------------------------------------------------
// 1. ROOT PATH FOR INCLUDE FILES
// ------------------------------------------------------------
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/psum/'); // psum is subdirectory
</pre>
  <p>This code establishes the root path for the site so all files know where they are located and can perform their functions&nbsp;properly. It is used to include code files. The code shown above basically says -I am located at: http://www.your-domain-name.com/psum/. It is looking for the psum folder under the domain it is running under. You can change the name of the psum folder by renaming it and then changing all references to it here in the configuration file. So if you renamed the psum folder to xyz, you would replace all occurances of psum with xyz.</p>
  <h3>2. Site URL</h3>
<pre>
// ------------------------------------------------------------
// 2. WEBSITE ADDRESS
// ------------------------------------------------------------
function siteURL()
{
	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	$domainName = $_SERVER['HTTP_HOST'].'/'.'psum/'; // psum is subdirectory
	return $protocol.$domainName;
}
define( 'SITE_URL', siteURL() );
</pre>
  <p>This code establishes the site URL and carries out a similar functionality as described above. It is used mostly when including Jquery or image files.</p>
  <h3>3. Account Activation URL</h3>
<pre>
// ------------------------------------------------------------
// 3. ACCOUNT ACTIVATION URL
// ------------------------------------------------------------
function verificationURL()
{
	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	$domainName = $_SERVER['HTTP_HOST'].'/'.'psum/'; // psum is subdirectory
	$pageName = 'account-activation.php';
	return $protocol.$domainName.$pageName;
}
define( 'ACCOUNT_ACTIVATION_URL', verificationURL() );
</pre>
  <p>The above code establishes the&nbsp;account activation URL / Location. After account registration, the new user is sent an account activation e-mail with confirmation and a link that they have to click to confirm their e-mail address and actually activate their account.</p>
  <h3>4. Default Login Destination</h3>
<pre>
// ------------------------------------------------------------
// 4. DEFAULT LOGIN DESTINATION URL
// ------------------------------------------------------------
// if USE_DEFAULT_LOGIN_DESTINATION is set to 1, all users will be 
// redirected to DEFAULT_LOGIN_DESTINATION_URL after login, accept 
// the users who's destination URL has been custom set in admin panel.
define( 'USE_DEFAULT_LOGIN_DESTINATION', 0 ); // 1=On 0=Off
define( 'DEFAULT_LOGIN_DESTINATION_URL', siteURL().'index.php' ); // global login destination
</pre>
  <p>This configuration option allows the adminstrator to set the default login destination. If it is set to 1, the login destination will be whatever is defined in the second option. In the above code, the destination is set to the index.php file. You can set this to whatever you want as long as the page is located within the site. You can also set the login destination for individual users in the administration panel. This overrides the default destination set here in the configuration file&nbsp;for those users&nbsp;only.</p>
  <h3>5. Default Themes</h3>
<pre>
// ------------------------------------------------------------
// 5. DEFAULT THEMES - CSS
// ------------------------------------------------------------
define( 'SITE_STYLE', SITE_URL.'themes/default/default.css' ); // root files non IE
define( 'ADMIN_STYLE', SITE_URL.'admin/themes/default/default.css' ); // admin files
define( 'USER_STYLE', SITE_URL.'user/themes/default/default.css' ); // user area files
define( 'USER_MENU_STYLE', SITE_URL.'user/themes/default/superfish.css' ); // user area files
define( 'ACCORDION_STYLE', SITE_URL.'user/themes/default/accordion.css' ); // user area files
define( 'FEEDBACK_STYLE', SITE_URL.'feedback/themes/default/default.css' ); // feedback form
</pre>
  <p>The default theme locations are set here. If you know CSS, you create as many design as you want and modify the above code so it points to your CSS files.</p>
  <h3>6. E-mail Addresses</h3>
<pre>
// ------------------------------------------------------------
// 6. EMAIL ADDRESSES
// ------------------------------------------------------------
define( 'NO_REPLY', 'hunzonian@gmail.com' );
define( 'GENERAL_CONTACT', 'hunzonian@gmail.com' );
define( 'BULK_MAIL_TO', 'hunzonian@gmail.com' );
</pre>
  <p>This section is described in the setup above. The application uses lots of e-mail functionality throughout and needs to know who the e-mails are sent from.</p>
  <h3>7. Minimum Password Requirements</h3>
<pre>
// ------------------------------------------------------------
// 7. MINIMUM PASSWORD REQUIREMENTS
// ------------------------------------------------------------
define( 'MIN_PASSWORD_LENGTH', 7 ); // set min length
define( 'REQUIRE_NUMBER', 1 ); // 0=no 1=yes
define( 'REQUIRE_SPECIAL_CHAR', 1 ); // 0=no 1=yes
define( 'ALLOW_USERNAME_IN_PASS', 0 ); // 0=no 1=yes
define( 'ALLOW_PW_STRENGTH_CHECK', 1 ); // 0=no 1=yes
</pre>
  <p>This section allows you to set the password requirements for new account registrations. The options are self explanatory.</p>
  <h3>8. Account Approval</h3>
<pre>
// ------------------------------------------------------------
// 8. APPROVE NEW ACCOUNT ON CREATION
// ------------------------------------------------------------
define('INSTANT_ACCOUNT_APPROVAL', 0); // 0=no 1=yes
define('BY_ADMIN_APPROVAL_ONLY', 0); // 0=no 1=yes

// notify admin on new registration
define('REGISTRATION_NOTIFICATION', 0); // 0=no 1=yes
// notify admin on account activation
define('ACTIVATION_NOTIFICATION', 0); // 0=no 1=yes
</pre>
  <p>The above code&nbsp;provides an option to approve / activate accounts after the user clicks on the account activation link in the e-mail they get after registration or to activate accounts only by admin approval. The default configuration can be seen above. Both values are&nbsp;set to zero (0). This means that accounts are not approved upon creation (because the user has to click on the link sent in the verification e-mail), and admin approval is not required. To approve accounts upon creation without sending a verification e-mail, simply set the first value to 1. To allow the administrator(s) to approve all new accounts, simply set the second value to 1. You can also set the REGISTRATION_NOTIFICATION and ACTIVATION_NOTIFICATION options to send a notification email to the administrator.</p>
  <h3>9. Default Role</h3>
<pre>
// ------------------------------------------------------------
// 9. DEFAULT ROLES IN ORDER OF PRIORITY
// ------------------------------------------------------------
// owner = 1
// superadmin = 2
// admin = 3
// member = 4
// user = 5
define('DEFAULT_ROLE', "user");
define('DEFAULT_ROLE_ID', 5);
</pre>
  <p>This code defines the default role used when a new registration occures and a new account is created. There is no limit on the number roles that can be created within the administration panel. The above 5 roles are already defined and are the defaults. Although you don't have to use them in the pages you create, the application won't allow you delete them.</p>
  <h3>10. Max. Number of Login Attempts</h3>
<pre>
// ------------------------------------------------------------
// 10. MAX NUMBER OF LOGIN ATTEMPTS BEFORE LOCKOUT
// ------------------------------------------------------------
define('MAX_LOGIN_ATTEMPT', 4); 
define('LOCKOUT_DURATION', 5); // minutes
</pre>
  <p>Here you can define the maximum number of Login attempts before lockout occures. If the user account name (user name actually exists in the database, then that account will be locked after the max. login attempt so no further abuse can occure. If the account(s) requested are random and or don't actually exist (the person or bot is just guessing), then lockout also occures but only with a cookie.</p>
  <h3>11. Auto Login Duration</h3>
<pre>
// ------------------------------------------------------------
// 11. AUTO LOGIN DURATION - Remember me cookie
// ------------------------------------------------------------
define('AUTO_LOGIN_DURATION', 1728000); // 20 days in seconds
</pre>
  <p>If the user checks the &quot;remember me&quot; checkbox during login, an autologin cookie will be set for the duration specified above. As long as the cookie exists in the user's browser, he / she will be automatically logged in when visiting password restricted pages within the site. If the browser cache is cleared, the user will have to login again. The auto login duration can be set in the above code. 86400&nbsp;seconds = 1 day. The default above is set for 20 days.</p>
  <h3>12. Gridview Default Page Size</h3>
<pre>
// ------------------------------------------------------------
// 12. GRIDVIEW DEFAULT PAGE SIZE
// ------------------------------------------------------------
define('GV_PAGE_SIZE', 10); // rows
</pre>
  <p>Gridviews are used throughout the application to display data from the database. Each gridview allows record paging and displays a certain number of records each page. The default number per page is set to 10 above. You can change this number as you desire.</p>
  <h3>13. Recaptcha Keys</h3>
<pre>
// ------------------------------------------------------------
// 13. RECAPTCHA KEYS - GET YOURS @ http://www.google.com/recaptcha
// ------------------------------------------------------------
define( 'RECAPTCHA_PRIVATE_KEY', "xyz" );
define( 'RECAPTCHA_PUBLIC_KEY', "xyz" );
</pre>
  <p>As mentioned above: If you want to take advantage of the recaptcha modules that are built in to the Login, Registration, Password Reset, Lost User Name, Lost Activation modules, it is highly recommended that you register an account and create your own public and private keys. You can go here http://www.google.com/recaptcha to do all of that. I have included a generic set of keys so you can test the application without having to mess with it but it is not secure since everyone who downloads the application will have the same pair of keys. So, please make sure you DON'T forget!</p>
  <h3>14. Enable / Disable Captcha</h3>
<pre>
// ------------------------------------------------------------
// 14. ENABLE DISABLE CAPTCHA
// ------------------------------------------------------------
define('LOGIN_CAPTCHA_ON', 0); // 1=on 0=off
define('REGISTER_CAPTCHA_ON', 1); // 1=on 0=off
define('FEEDBACK_CAPTCHA_ON', 1); // 1=on 0=off
define('CAPTCHA_ON_X', 3); // turn captcha ON after x failure
</pre>
  <p>This functionality allows you to disable the captcha control on the Login and Registration forms&nbsp;by default but have it auto activate after the set number of failed attempts. The default above is set to 3 tries. If on the third try the form submission is not successful, the captcha is automatically activated&nbsp;and displayed&nbsp;for successive tries.</p>
  <h3>15. Enable / Disable User Profiles</h3>
<pre>
// ------------------------------------------------------------
// 15. USER PROFILES
// ------------------------------------------------------------
define('ENABLE_USER_PROFILES', 1); // 1=yes 0=no
</pre>
  <p>This functionality allows you to disable The user account section where registered users can edit their account information.</p>
  <h3>16. Avatar Image File</h3>
<pre>
// ------------------------------------------------------------
// 16. AVATAR IMAGE FILE
// ------------------------------------------------------------
define('AVATAR_FILE_SIZE', 51200); // 50 Kb max. -> 1 kilobyte = 1024 bytes
define('AVATAR_FILE_DIRECTORY', ROOT_PATH.'user/upload/avatars/'); // upload directory
define('AVATAR_IMAGE_URL', SITE_URL.'user/upload/avatars/'); // default avatar url
define('DEFAULT_AVATAR_IMAGE', 'default-avatar.png'); // default avatar image
</pre>
  <p>The above section defines the maximum file size, the directory where the avatar images are uploaded, the default avatar image and its location.</p>
  <h3>17. Visitors Counter</h3>
<pre>
// ------------------------------------------------------------
// 17. UNIQUE VISITORS ONLINE COUNTER
// ------------------------------------------------------------
define('ENABLE_VISITOR_COUNT', 0); // 1=yes 0=no
define('LAST_X_MINUTES', 15); // counts number of visitors in last x minutes
</pre>
  <p>This functionality allows you to enable / disable the visitors online counter and set the last number of minutes to count the number of current visitors.</p>
  <h3>18. Contact / Feedback Form</h3>
<pre>
// ------------------------------------------------------------
// 18. CONTACT FORM
// ------------------------------------------------------------
// company logo
define('COMPANY_LOGO_SIZE', 51200); // 50 Kb max. -> 1 kilobyte = 1024 bytes
define('COMPANY_LOGO_DIRECTORY', ROOT_PATH.'feedback/upload/'); // upload directory
define('COMPANY_LOGO_URL', SITE_URL.'feedback/upload/'); // default logo url
define('DEFAULT_COMPANY_LOGO', 'company.png'); // default logo image

// contact email form
define('MIN_FEEDBACK_LENGTH', 20); // min. text length
define('MAX_FEEDBACK_LENGTH', 1000); // max text length
define('MIN_FEEDBACK_WORDS', 3); // min number of words
</pre>
  <p>The above settings allow you to configure some settings for the modal dialog based Contact / Feedback form included with this application. It can be used as a simple contact form or a sophisticated feedback system. Option categories and subcategories can be created within the amin panel.</p>
  <h3>19. Premium Membership</h3>
<pre>
// ------------------------------------------------------------
// 19. PREMIUM MEMBERSHIP
// ------------------------------------------------------------
// show/hide from users
define('ENABLE_PREMIUM_MEMBERSHIP', 1); // 1=yes 0=no
// show/hide in admin panel
define('HIDE_PREMIUM_MEMBERSHIP_IN_ADMIN', 0); // 1=yes 0=no
</pre>
  <p>This option allows you to enable / disable the Premium Membership section both in the admin and user panel. Helpful if you don't require this functionality.</p>
  <h3>20.&nbsp;Scheduled Maintenance</h3>
<pre>
// ------------------------------------------------------------
// 20. SCHEDULED MAINTENANCE
// ------------------------------------------------------------
define('SCHEDULED_MAINTENANCE', 0); // 1=show 0=hide
define('UNDER_CONSTRUCTION_PAGE', SITE_URL.'maintenance.html');
</pre>
  <p>If set to 1, all pages with this constant in their header will be redirected to the maintenance.html page. Useful to take the site temporarily offline. You can change the value of this url to point the redirect action to any page.</p>
  <h3>21.&nbsp;Show / Hide modules</h3>
<pre>
// ------------------------------------------------------------
// 21. SHOW / HIDE THE FOLLOWING MODULES
// ------------------------------------------------------------
define('SHOW_REGISTRATION', 1); // 1=yes 0=no
define('SHOW_PASSWORD_RESET', 1); // 1=yes 0=no
define('SHOW_LOST_USER_NAME', 1); // 1=yes 0=no
define('SHOW_RESEND_ACTIVATION', 1); // 1=yes 0=no
</pre>
  <p>The code above allows you to enable / disable the registration, password reset, lost user name and resend activation modules.</p>
  <h3>22.&nbsp;Show / Hide Admin Sticky Bar</h3>
<pre>
// ------------------------------------------------------------
// 22. SHOW / HIDE ADMIN STICKY BUTTON BAR
// ------------------------------------------------------------
define('SHOW_STICKY_BAR', 1); // 1=yes 0=no
</pre>
  <p>The sticky bar in the admin panel is an icon based navigation element linking to essential parts of the admin area. The above configuration option allows you to disable the sticky bar if you have no need for it.</p>
  <h3>23.&nbsp;Protected Downloads</h3>
<pre>
// ------------------------------------------------------------
// 23. PROTECTED DOWNLOADS
// ------------------------------------------------------------
define('ENABLE_DOWNLOADS', 1);
define('DOWNLOAD_DIRECTORY',  ROOT_PATH.'download/'); // protected download directory
define('MAX_UPLOAD_FILE_SIZE', 20971520); // 20 Mb max. -> 1 megabyte = 1048576 bytes
</pre>
  <p>The above setting allows you to enable / disable the protected downloads section and allow you to configure the download directory location and maximum upload file size.</p>
  <h3>24.&nbsp;Account Sharing</h3>
<pre>
// ------------------------------------------------------------
// 24. ACCOUNT SHARING
// ------------------------------------------------------------
define('ACCOUNT_SHARING', 0); // 1=allowed 0=not allowed
</pre>
  <p>If set to zero (0), only the latest login per account is valid and all others will be logged off. If set to 1, each account can be used simultaneously by multiple users using the same credentials. This functionality is especially useful for premium membership to prevent account sharing.</p>
  <h2>End Note</h2>
  <div class="divider"><a href="#">Top</a></div>
  <p>Do you need more info? Let me know and I will add the explanations here... Cheers, Hunzonian</p> 
</div>
</body>
</html>