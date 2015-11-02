-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 07, 2011 at 08:44 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dbpsum`
--

-- --------------------------------------------------------

--
-- Table structure for table `downloads`
--

CREATE TABLE IF NOT EXISTS `downloads` (
  `DownloadId` int(11) NOT NULL AUTO_INCREMENT,
  `DownloadName` varchar(100) NOT NULL DEFAULT 'none',
  `FileName` varchar(150) NOT NULL DEFAULT 'none',
  `DateAdded` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `DateModified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `IsEnabled` tinyint(1) NOT NULL DEFAULT '0',
  `PremiumLevel` varchar(100) NOT NULL DEFAULT '1',
  PRIMARY KEY (`DownloadId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `downloads`
--

INSERT INTO `downloads` (`DownloadId`, `DownloadName`, `FileName`, `DateAdded`, `DateModified`, `IsEnabled`, `PremiumLevel`) VALUES
(1, 'Test Download File 1', 'rar.zip', '2011-04-05 00:00:00', '2011-11-06 23:28:20', 1, '0,1,2'),
(2, 'Test Download File 2', 'test.rar', '2011-04-05 00:00:00', '2011-04-07 22:23:04', 1, '0'),
(12, 'Test Download File 3', '1302429301-test.rar', '2011-04-10 02:55:01', '2011-11-07 00:39:20', 1, '0'),
(13, 'Test Download File 4', '1302429324-rar.zip', '2011-04-10 02:55:24', '2011-11-07 00:39:14', 1, '0'),
(14, 'Test Download File 5', '1319964955-another-test.rar', '2011-10-30 01:55:55', '2011-10-30 01:55:55', 1, '0');

-- --------------------------------------------------------

--
-- Table structure for table `feedback_categories`
--

CREATE TABLE IF NOT EXISTS `feedback_categories` (
  `CategoryId` int(11) NOT NULL AUTO_INCREMENT,
  `CategoryName` varchar(100) NOT NULL,
  `IsEnabled` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`CategoryId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `feedback_categories`
--

INSERT INTO `feedback_categories` (`CategoryId`, `CategoryName`, `IsEnabled`) VALUES
(1, 'Bug', 1),
(2, 'Site Content', 1),
(3, 'Suggestion', 1),
(4, 'Compliment', 1),
(5, 'Other', 1);

-- --------------------------------------------------------

--
-- Table structure for table `feedback_page`
--

CREATE TABLE IF NOT EXISTS `feedback_page` (
  `PageId` int(11) NOT NULL AUTO_INCREMENT,
  `PageTitle` varchar(250) DEFAULT NULL,
  `Subtitle` varchar(250) NOT NULL,
  `PageDescription` varchar(500) DEFAULT NULL,
  `CompanyLogo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`PageId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `feedback_page`
--

INSERT INTO `feedback_page` (`PageId`, `PageTitle`, `Subtitle`, `PageDescription`, `CompanyLogo`) VALUES
(1, 'Contact / User Feedback', 'Greetings!', 'Please take a moment to fill out the feedback form. This will greatly help improve our system. Just select a feedback topic on the left and then select a relevant issue here on the right. Thank you!', '');

-- --------------------------------------------------------

--
-- Table structure for table `feedback_subcategories`
--

CREATE TABLE IF NOT EXISTS `feedback_subcategories` (
  `SubcategoryId` int(11) NOT NULL AUTO_INCREMENT,
  `CategoryId` int(11) NOT NULL,
  `SubcategoryName` varchar(100) NOT NULL,
  `CategoryName` varchar(100) NOT NULL,
  `IsEnabled` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`SubcategoryId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `feedback_subcategories`
--

INSERT INTO `feedback_subcategories` (`SubcategoryId`, `CategoryId`, `SubcategoryName`, `CategoryName`, `IsEnabled`) VALUES
(1, 1, 'Browser not supported', 'Bug', 1),
(2, 1, 'Can''t log in', 'Bug', 1),
(3, 1, 'Disability enquiries', 'Bug', 1),
(4, 1, 'Site content', 'Bug', 1),
(5, 1, 'Registration / Privacy', 'Bug', 1),
(6, 1, 'Usability and Design', 'Bug', 1),
(7, 1, 'Objectionable Content', 'Bug', 1),
(8, 1, 'Other', 'Bug', 1),
(9, 2, 'Copyright Violation', 'Site Content', 1),
(10, 2, 'Fraud Report', 'Site Content', 1),
(11, 2, 'Inaccurate Content', 'Site Content', 1),
(12, 2, 'Missing Content', 'Site Content', 1),
(13, 2, 'Objectionable Content', 'Site Content', 1),
(14, 2, 'Other', 'Site Content', 1),
(15, 3, 'Disability support', 'Suggestion', 1),
(16, 3, 'Feature request', 'Suggestion', 1),
(17, 3, 'Site Content', 'Suggestion', 1),
(18, 3, 'Usability and Design', 'Suggestion', 1),
(19, 3, 'Other', 'Suggestion', 1),
(20, 4, 'Disability support', 'Compliment', 1),
(21, 4, 'Site Content', 'Compliment', 1),
(22, 4, 'Usability and Design', 'Compliment', 1),
(23, 4, 'Other', 'Compliment', 1);

-- --------------------------------------------------------

--
-- Table structure for table `membership_coupons`
--

CREATE TABLE IF NOT EXISTS `membership_coupons` (
  `CouponId` int(11) NOT NULL AUTO_INCREMENT,
  `CouponCode` varchar(20) NOT NULL,
  `Discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `DateStart` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `DateEnd` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `DateAdded` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `IsEnabled` tinyint(1) NOT NULL DEFAULT '0',
  `PremiumLevel` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`CouponId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `membership_coupons`
--

INSERT INTO `membership_coupons` (`CouponId`, `CouponCode`, `Discount`, `DateStart`, `DateEnd`, `DateAdded`, `IsEnabled`, `PremiumLevel`) VALUES
(1, 'SAVENOW', '10.00', '2011-04-08 00:00:00', '2011-05-08 00:00:00', '2011-04-08 00:00:00', 1, 1),
(2, 'TRY-IT-NOW', '25.00', '2011-04-11 00:00:00', '2011-05-11 00:00:00', '2011-04-11 00:00:00', 1, 2),
(4, 'TEST-COUPON', '50.00', '2011-04-11 00:00:00', '2011-04-18 00:00:00', '2011-04-11 21:34:27', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `membership_rates`
--

CREATE TABLE IF NOT EXISTS `membership_rates` (
  `RatesId` int(11) NOT NULL AUTO_INCREMENT,
  `TypesId` int(11) NOT NULL,
  `Type` varchar(50) NOT NULL DEFAULT 'Free Membership',
  `RateTitle` varchar(100) NOT NULL,
  `Description` longtext NOT NULL,
  `IntervalLength` int(11) NOT NULL DEFAULT '0',
  `IntervalType` varchar(10) NOT NULL,
  `IsAutoRenew` tinyint(1) NOT NULL DEFAULT '0',
  `AutoRenewTimes` int(11) NOT NULL DEFAULT '0',
  `IsTrial1` tinyint(1) NOT NULL DEFAULT '0',
  `Trial1Rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `Trial1Length` int(11) NOT NULL DEFAULT '0',
  `Trial1Type` varchar(10) NOT NULL DEFAULT 'M',
  `IsTrial2` tinyint(1) NOT NULL DEFAULT '0',
  `Trial2Rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `Trial2Length` int(11) NOT NULL DEFAULT '0',
  `Trial2Type` varchar(10) NOT NULL DEFAULT 'W',
  `MembershipFee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `OrdinalPosition` int(3) NOT NULL DEFAULT '0',
  `IsEnabled` tinyint(1) NOT NULL DEFAULT '0',
  `PremiumLevel` int(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`RatesId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `membership_rates`
--

INSERT INTO `membership_rates` (`RatesId`, `TypesId`, `Type`, `RateTitle`, `Description`, `IntervalLength`, `IntervalType`, `IsAutoRenew`, `AutoRenewTimes`, `IsTrial1`, `Trial1Rate`, `Trial1Length`, `Trial1Type`, `IsTrial2`, `Trial2Rate`, `Trial2Length`, `Trial2Type`, `MembershipFee`, `OrdinalPosition`, `IsEnabled`, `PremiumLevel`) VALUES
(1, 2, 'Silver Membership', 'Weekly - USD 2.49', '<p>Weekly Subscription - USD 2.49</p>', 1, 'W', 0, 1, 0, '0.00', 1, 'M', 0, '0.00', 1, 'W', '2.49', 2, 1, 1),
(2, 2, 'Silver Membership', 'Monthly - USD 9.99 With 30 Day Trial', '<p>Subscribe Now to Enjoy the Following Enhanced Membership Benefits:</p>  <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p> <ul>   <li>First 30 Days FREE!</li>   <li>Then 7 Days for just $5.99</li>   <li>Then $9.99 Monthly for 1 Year</li>   <li>Benefit 4</li>   <li>Benefit 5</li> </ul>', 1, 'M', 1, 12, 1, '0.00', 1, 'M', 1, '5.99', 1, 'W', '9.99', 3, 1, 1),
(3, 2, 'Silver Membership', 'Yearly - USD 119.88', '<p>Yearly Subscription - USD 119.88</p>', 1, 'Y', 0, 1, 0, '0.00', 1, 'M', 0, '0.00', 1, 'W', '119.88', 4, 1, 1),
(4, 3, 'Gold Membership', 'Yearly - USD 139.88', '<p>Yearly Subscription - USD 139.88 - Access to All Premium Content!</p>', 1, 'Y', 0, 1, 0, '0.00', 1, 'M', 0, '0.00', 1, 'W', '139.88', 1, 1, 2),
(5, 2, 'Silver Membership', 'Daily - USD 1.98', '<p>Daily Subscription - USD 1.98</p>', 1, 'D', 0, 1, 0, '0.00', 1, 'M', 0, '0.00', 1, 'W', '1.98', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `membership_types`
--

CREATE TABLE IF NOT EXISTS `membership_types` (
  `TypesId` int(11) NOT NULL AUTO_INCREMENT,
  `Type` varchar(50) NOT NULL DEFAULT 'Free Membership',
  `Description` longtext NOT NULL,
  `OrdinalPosition` int(3) NOT NULL DEFAULT '0',
  `IsEnabled` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`TypesId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `membership_types`
--

INSERT INTO `membership_types` (`TypesId`, `Type`, `Description`, `OrdinalPosition`, `IsEnabled`) VALUES
(2, 'Silver Membership', 'Premium membership with some restrictions.', 1, 1),
(3, 'Gold Membership', 'Top of the line membership access to all options', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE IF NOT EXISTS `menus` (
  `MenuId` int(11) NOT NULL AUTO_INCREMENT,
  `MenuName` varchar(50) NOT NULL DEFAULT 'default',
  `Url` varchar(100) DEFAULT NULL,
  `Target` varchar(10) DEFAULT '_self',
  `Label` varchar(50) NOT NULL,
  `Title` varchar(100) DEFAULT NULL,
  `Description` varchar(250) DEFAULT NULL,
  `ParentId` int(11) DEFAULT '0',
  `ParentLabel` varchar(50) DEFAULT NULL,
  `OrdinalPosition` int(11) DEFAULT NULL,
  `IsEnabled` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`MenuId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`MenuId`, `MenuName`, `Url`, `Target`, `Label`, `Title`, `Description`, `ParentId`, `ParentLabel`, `OrdinalPosition`, `IsEnabled`) VALUES
(1, 'user dash', 'index.php', '_self', 'My Account', 'back to user dash home page', '', 0, 'My Account', 2, 1),
(15, 'user dash', '../index.php', '_new', 'Home', 'Site Index', '', 0, 'Home', 1, 1),
(16, 'user dash', 'premium.php', '_self', 'Premium Membership', 'My premium membership details', '', 1, 'My Account', 1, 1),
(17, 'user dash', 'downloads.php', '_self', 'Downloads', 'My files available for downloads', '', 1, 'My Account', 3, 1),
(18, 'user dash', 'password.php', '_self', 'Account Password', 'My account password', '', 1, 'My Account', 4, 1),
(19, 'user dash', 'security-qa.php', '_self', 'Security Q & A', 'My security question and answer', '', 1, 'My Account', 5, 1),
(20, 'user dash', 'email.php', '_self', 'Email Address', 'My email address', '', 1, 'My Account', 6, 1),
(21, 'user dash', 'profile.php', '_self', 'Profile Details', 'My profile details', '', 1, 'My Account', 7, 1),
(22, 'user dash', 'avatar.php', '_self', 'Avatar Image', 'My avatar image', '', 1, 'My Account', 8, 1),
(23, 'user dash', 'newsletter.php', '_self', 'Newsletter', 'My newsletter settings', '', 1, 'My Account', 9, 1),
(24, 'user dash', 'payment-history.php', '_self', 'Payment History', 'My premium membership payment history', '', 1, 'My Account', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `menu_names`
--

CREATE TABLE IF NOT EXISTS `menu_names` (
  `MenuNameId` int(11) NOT NULL AUTO_INCREMENT,
  `MenuName` varchar(100) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`MenuNameId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `menu_names`
--

INSERT INTO `menu_names` (`MenuNameId`, `MenuName`, `Description`) VALUES
(1, 'user dash', 'none');

-- --------------------------------------------------------

--
-- Table structure for table `paypal_config`
--

CREATE TABLE IF NOT EXISTS `paypal_config` (
  `ConfigId` int(11) NOT NULL AUTO_INCREMENT,
  `PaypalGateway` varchar(200) NOT NULL DEFAULT 'https://www.paypal.com/cgi-bin/webscr',
  `PaypalSandbox` varchar(200) NOT NULL DEFAULT 'https://www.sandbox.paypal.com/cgi-bin/webscr',
  `MerchantAccountId` varchar(100) NOT NULL DEFAULT 'you@paypal.com',
  `IsSandbox` tinyint(1) NOT NULL DEFAULT '0',
  `PaypalCurrency` varchar(3) NOT NULL DEFAULT 'USD',
  `CurrencySymbol` varchar(3) NOT NULL DEFAULT '$',
  `SuccessURL` varchar(255) NOT NULL DEFAULT 'http://www.your-site.com/psum/user/payment-success.php',
  `CancelURL` varchar(255) NOT NULL DEFAULT 'http://www.your-site.com/psum/user/payment-cancel.php',
  `IpnURL` varchar(255) NOT NULL DEFAULT 'http://www.your-site.com/psum/user/paypal_ipn.php',
  PRIMARY KEY (`ConfigId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `paypal_config`
--

INSERT INTO `paypal_config` (`ConfigId`, `PaypalGateway`, `PaypalSandbox`, `MerchantAccountId`, `IsSandbox`, `PaypalCurrency`, `CurrencySymbol`, `SuccessURL`, `CancelURL`, `IpnURL`) VALUES
(1, 'https://www.paypal.com/cgi-bin/webscr', 'https://www.sandbox.paypal.com/cgi-bin/webscr', 'your-paypal-merchant-email@your-site.com', 1, 'USD', '$', 'http://www.your-site.com/psum/user/payment-success.php', 'http://www.your-site.com/psum/user/payment-cancel.php', 'http://www.your-site.com/psum/user/paypal_ipn.php');

-- --------------------------------------------------------

--
-- Table structure for table `paypal_payments`
--

CREATE TABLE IF NOT EXISTS `paypal_payments` (
  `PaypalId` int(11) NOT NULL AUTO_INCREMENT,
  `subscr_id` varchar(100) NOT NULL,
  `txn_id` varchar(100) DEFAULT NULL,
  `txn_type` varchar(255) NOT NULL,
  `UserName` varchar(60) NOT NULL,
  `RatesId` int(11) NOT NULL,
  `custom` varchar(255) NOT NULL,
  `mc_gross` decimal(10,2) NOT NULL DEFAULT '0.00',
  `mc_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `Trial1Amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `Trial2Amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `MembershipFee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `payment_currency` varchar(50) NOT NULL,
  `TransactionDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ExpireDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `item_name` varchar(150) NOT NULL,
  `item_number` varchar(150) NOT NULL,
  `receiver_email` varchar(150) NOT NULL,
  `payer_email` varchar(150) NOT NULL,
  `payment_status` varchar(50) NOT NULL,
  `pending_reason` varchar(255) NOT NULL DEFAULT 'none',
  `BadTransaction` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`PaypalId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE IF NOT EXISTS `profiles` (
  `ProfileId` int(25) NOT NULL AUTO_INCREMENT,
  `UserId` int(25) NOT NULL,
  `UserName` varchar(60) NOT NULL,
  `FirstName` varchar(60) NOT NULL,
  `LastName` varchar(60) NOT NULL,
  `CompanyName` varchar(150) DEFAULT NULL,
  `WebsiteUrl` varchar(255) DEFAULT NULL,
  `ProfileTitle` varchar(200) DEFAULT NULL,
  `ProfileText` text,
  `Phone` varchar(20) DEFAULT NULL,
  `Address` varchar(50) DEFAULT NULL,
  `Street` varchar(50) DEFAULT NULL,
  `City` varchar(100) DEFAULT NULL,
  `State` varchar(100) DEFAULT NULL,
  `Zip` varchar(20) DEFAULT NULL,
  `Country` varchar(100) DEFAULT NULL,
  `AvatarImage` varchar(255) DEFAULT NULL,
  `Newsletter` tinyint(1) NOT NULL DEFAULT '0',
  `Promotion` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ProfileId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`ProfileId`, `UserId`, `UserName`, `FirstName`, `LastName`, `CompanyName`, `WebsiteUrl`, `ProfileTitle`, `ProfileText`, `Phone`, `Address`, `Street`, `City`, `State`, `Zip`, `Country`, `AvatarImage`, `Newsletter`, `Promotion`) VALUES
(19, 114, 'admin', 'Hun', 'Zonian', 'none', 'http://codecanyon.net/item/php-security-user-management/141801', 'PHP + Open Source Rocks!', 'The term open source describes practices in production and development that promote access to the end product''s source materials. Some consider open source a philosophy, others consider it a pragmatic methodology. \r\n\r\nBefore the term open source became widely adopted, developers and producers used a variety of phrases to describe the concept; open source gained hold with the rise of the Internet, and the attendant need for massive retooling of the computing source code. \r\n\r\nOpening the source code enabled a self-enhancing diversity of production models, communication paths, and interactive communities. Subsequently, the new phrase &quot;open-source software&quot; was born to describe the environment that the new copyright, licensing, domain, and consumer issues created.\r\n\r\nThe open source model includes the concept of concurrent yet different agendas and differing approaches in production, in contrast with more centralized models of development such as those typically used in commercial software companies. \r\n\r\nA main principle and practice of open source software development is peer production by bartering and collaboration, with the end-product, source-material, &quot;blueprints&quot;, and documentation available at no cost to the public. This is increasingly being applied in other fields of endeavor, such as biotechnology.', '555-555-1212', 'Planet Earth', 'n/a', 'n/a', 'n/a', '5551212', 'United States', 'http://localhost/psum/user/upload/avatars/admin-hunzonian.jpg', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `RoleId` int(11) NOT NULL AUTO_INCREMENT,
  `RoleName` varchar(50) DEFAULT NULL,
  `Description` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`RoleId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`RoleId`, `RoleName`, `Description`) VALUES
(1, 'owner', 'Priority 1 - Role with HIGHEST privileges - Must be included as allowed role in all protected pages.'),
(2, 'superadmin', 'Priority 2 - Role with 2nd. HIGHEST privileges'),
(3, 'administrator', 'Priority 3 - Role with 3rd. HIGHEST privileges'),
(4, 'member', 'Priority 4 - Privileges are one step above "user" privileges.'),
(5, 'user', 'Priority 5 - Role with LOWEST privileges - This is the DEFAULT role given to new  user accounts.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `UserId` int(25) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(60) NOT NULL,
  `Password` varchar(64) NOT NULL,
  `PasswordQuestion` varchar(100) DEFAULT NULL,
  `PasswordAnswer` varchar(100) DEFAULT NULL,
  `Email` varchar(100) NOT NULL,
  `IsApproved` tinyint(1) NOT NULL DEFAULT '0',
  `IsLockedOut` tinyint(1) NOT NULL DEFAULT '0',
  `IsLoggedIn` tinyint(1) NOT NULL DEFAULT '0',
  `SessionId` varchar(64) NOT NULL DEFAULT '0',
  `CreateDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `LastLoginDate` datetime DEFAULT '0000-00-00 00:00:00',
  `LastLoginIP` varchar(60) NOT NULL,
  `LastPasswordChangeDate` datetime DEFAULT '0000-00-00 00:00:00',
  `LastActivityDate` datetime DEFAULT '0000-00-00 00:00:00',
  `LastLockoutDate` datetime DEFAULT '0000-00-00 00:00:00',
  `LastUnlockDate` datetime DEFAULT '0000-00-00 00:00:00',
  `Comment` longtext,
  `DestinationUrl` varchar(100) NOT NULL DEFAULT 'default',
  `ActivationKey` varchar(64) NOT NULL,
  `IsOwner` tinyint(1) NOT NULL DEFAULT '0',
  `IsPremium` tinyint(1) NOT NULL DEFAULT '0',
  `PremiumType` varchar(100) NOT NULL DEFAULT 'Free Membership',
  `PremiumStartDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `PremiumEndDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `PremiumAmount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `IsCancelled` tinyint(1) NOT NULL DEFAULT '0',
  `CancelledDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `IsEndOfTerm` tinyint(1) NOT NULL DEFAULT '0',
  `EndOfTermDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `IsPending` tinyint(1) NOT NULL DEFAULT '0',
  `PendingDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `PremiumLevel` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`UserId`),
  FULLTEXT KEY `UserName` (`UserName`),
  FULLTEXT KEY `Email` (`Email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=146 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserId`, `UserName`, `Password`, `PasswordQuestion`, `PasswordAnswer`, `Email`, `IsApproved`, `IsLockedOut`, `IsLoggedIn`, `SessionId`, `CreateDate`, `LastLoginDate`, `LastLoginIP`, `LastPasswordChangeDate`, `LastActivityDate`, `LastLockoutDate`, `LastUnlockDate`, `Comment`, `DestinationUrl`, `ActivationKey`, `IsOwner`, `IsPremium`, `PremiumType`, `PremiumStartDate`, `PremiumEndDate`, `PremiumAmount`, `IsCancelled`, `CancelledDate`, `IsEndOfTerm`, `EndOfTermDate`, `IsPending`, `PendingDate`, `PremiumLevel`) VALUES
(114, 'admin', '1417c6235bc79819765456bb0132670060a955e6', 'none', 'none', 'hunzonian@gmail.com', 1, 0, 1, '7e5d8166dcdf1f9c2ddee67bc673a718eeebe2b7', '2011-01-21 17:32:46', '2011-11-07 13:34:04', '127.0.0.1', '0000-00-00 00:00:00', '2011-11-07 13:34:04', '2011-10-21 14:36:44', '2011-10-21 14:37:44', '', 'default', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, 0, 'Free Membership', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0.00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(115, 'test01', '1417c6235bc79819765456bb0132670060a955e6', 'none', 'none', 'test1@foo.org', 1, 0, 0, '815ec6d4b4a71924ac688916650863e7c92614a4', '2011-02-15 12:41:53', '2011-11-06 23:11:43', '127.0.0.1', '0000-00-00 00:00:00', '2011-11-06 23:11:43', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 'default', 'b444ac06613fc8d63795be9ad0beaf55011936ac', 0, 0, 'Free Membership', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0.00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(116, 'test02', '1417c6235bc79819765456bb0132670060a955e6', 'none', 'none', 'test2@foo.org', 1, 0, 0, '20d31b6423f2ab398948d4cfc6a7e29a3b6cbdd9', '2010-12-22 12:42:50', '2011-11-06 23:30:13', '127.0.0.1', '0000-00-00 00:00:00', '2011-11-06 23:30:13', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 'default', '109f4b3c50d7b0df729d299bc6f8e9ef9066971f', 0, 0, 'Free Membership', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0.00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(117, 'test03', '1417c6235bc79819765456bb0132670060a955e6', 'none', 'none', 'test3@foo.org', 1, 0, 0, 'none', '2010-11-22 12:43:23', '2010-11-22 12:43:23', '127.0.0.1', '0000-00-00 00:00:00', '2011-02-20 17:30:25', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 'default', '3ebfa301dc59196f18593c45e519287a23297589', 0, 0, 'Free Membership', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0.00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(118, 'test04', '1417c6235bc79819765456bb0132670060a955e6', 'none', 'none', 'test4@foo.org', 1, 0, 0, 'none', '2011-02-15 12:43:53', '2011-02-20 17:30:37', '127.0.0.1', '0000-00-00 00:00:00', '2011-02-20 17:30:37', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 'default', '1ff2b3704aede04eecb51e50ca698efd50a1379b', 0, 0, 'Free Membership', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0.00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(119, 'test05', '1417c6235bc79819765456bb0132670060a955e6', 'none', 'none', 'test5@foo.org', 1, 0, 0, 'none', '2011-02-15 12:44:24', '2011-02-15 12:44:24', '127.0.0.1', '0000-00-00 00:00:00', '2011-02-15 12:44:24', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 'default', '911ddc3b8f9a13b5499b6bc4638a2b4f3f68bf23', 0, 0, 'Free Membership', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0.00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(120, 'test06', '1417c6235bc79819765456bb0132670060a955e6', 'none', 'none', 'test6@foo.org', 1, 0, 0, 'none', '2011-02-15 12:44:58', '2011-02-15 12:44:58', '127.0.0.1', '0000-00-00 00:00:00', '2011-02-15 12:44:58', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 'default', 'a66df261120b6c2311c6ef0b1bab4e583afcbcc0', 0, 0, 'Free Membership', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0.00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(121, 'test07', '1417c6235bc79819765456bb0132670060a955e6', 'none', 'none', 'test7@foo.org', 1, 0, 0, 'none', '2011-02-15 12:45:21', '2011-02-15 12:45:21', '127.0.0.1', '0000-00-00 00:00:00', '2011-02-15 12:45:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 'default', 'ea3243132d653b39025a944e70f3ecdf70ee3994', 0, 0, 'Free Membership', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0.00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(122, 'test08', '1417c6235bc79819765456bb0132670060a955e6', 'none', 'none', 'test8@foo.org', 1, 0, 0, 'none', '2011-02-15 12:45:49', '2011-02-15 12:45:49', '127.0.0.1', '0000-00-00 00:00:00', '2011-02-15 12:45:49', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 'default', 'd03f9d34194393019e6d12d7c942827ebd694443', 0, 0, 'Free Membership', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0.00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(123, 'test09', '1417c6235bc79819765456bb0132670060a955e6', 'none', 'none', 'test9@foo.org', 0, 0, 0, 'none', '2011-02-15 12:46:18', '2011-02-15 12:46:18', '127.0.0.1', '0000-00-00 00:00:00', '2011-02-15 12:46:18', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 'default', '53d525836cc96d089a5a4218b464fda532f7debe', 0, 0, 'Free Membership', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0.00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(124, 'test10', '1417c6235bc79819765456bb0132670060a955e6', 'none', 'none', 'test10@foo.org', 1, 0, 0, 'none', '2011-02-15 12:47:20', '2011-02-15 12:47:20', '127.0.0.1', '0000-00-00 00:00:00', '2011-02-15 12:47:20', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 'default', '168f4029f416ee06565f12e697dfc1534ae69d32', 0, 0, 'Free Membership', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0.00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(125, 'test11', '1417c6235bc79819765456bb0132670060a955e6', 'none', 'none', 'test11@foo.org', 0, 0, 0, 'none', '2011-02-15 12:50:26', '2011-02-15 12:50:26', '127.0.0.1', '0000-00-00 00:00:00', '2011-02-15 12:50:26', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 'default', '100c4e57374fc998e57164d4c0453bd3a4876a58', 0, 0, 'Free Membership', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0.00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(126, 'test12', '1417c6235bc79819765456bb0132670060a955e6', 'none', 'none', 'test12@foo.org', 1, 0, 0, 'none', '2011-02-15 12:50:50', '2011-02-15 12:50:50', '127.0.0.1', '0000-00-00 00:00:00', '2011-02-15 12:50:50', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 'default', '4ff1a33e188b7b86123d6e3be2722a23514a83b4', 0, 0, 'Free Membership', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0.00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(127, 'test13', '1417c6235bc79819765456bb0132670060a955e6', 'none', 'none', 'test13@foo.org', 0, 0, 0, 'none', '2011-02-15 12:51:30', '2011-02-15 12:51:30', '127.0.0.1', '0000-00-00 00:00:00', '2011-02-15 12:51:30', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 'default', 'd804cd9cc0c42b0652bab002f67858ab803c40c6', 0, 0, 'Free Membership', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0.00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(128, 'test14', '1417c6235bc79819765456bb0132670060a955e6', 'none', 'none', 'test14@foo.org', 1, 0, 0, 'none', '2011-02-15 12:51:57', '2011-02-15 12:51:57', '127.0.0.1', '0000-00-00 00:00:00', '2011-02-15 12:51:57', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 'default', 'd79336a97da7d284c0fe15497d2fa944d1f2abb1', 0, 0, 'Free Membership', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0.00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(129, 'test15', '1417c6235bc79819765456bb0132670060a955e6', 'none', 'none', 'test15@foo.org', 0, 0, 0, 'none', '2011-02-15 12:53:06', '2011-02-15 12:53:06', '127.0.0.1', '0000-00-00 00:00:00', '2011-02-15 12:53:06', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 'default', '61bb70fa60368f069e62d601c357d203700ab2d2', 0, 0, 'Free Membership', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0.00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(130, 'test16', '1417c6235bc79819765456bb0132670060a955e6', 'none', 'none', 'test16@foo.org', 1, 0, 0, 'none', '2011-02-15 12:55:17', '2011-02-15 12:55:17', '127.0.0.1', '0000-00-00 00:00:00', '2011-02-15 12:55:17', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 'default', '1fbefee9cfb86926757519357e077fd6a21aef0f', 0, 0, 'Free Membership', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0.00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(131, 'test17', '1417c6235bc79819765456bb0132670060a955e6', 'none', 'none', 'test17@foo.org', 1, 0, 0, 'none', '2011-02-15 12:56:00', '2011-02-15 12:56:00', '127.0.0.1', '0000-00-00 00:00:00', '2011-02-15 12:56:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 'default', '08a25c0f270b29aeba650e6b2d1a9947a778c5da', 0, 0, 'Free Membership', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0.00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(132, 'test18', '1417c6235bc79819765456bb0132670060a955e6', 'none', 'none', 'test18@foo.org', 1, 0, 0, 'none', '2011-02-15 12:56:22', '2011-02-15 12:56:22', '127.0.0.1', '0000-00-00 00:00:00', '2011-02-15 12:56:22', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 'default', 'cfc996a3aaac95f0fb508f46499dcb72b6d0abee', 0, 0, 'Free Membership', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0.00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(133, 'test19', '1417c6235bc79819765456bb0132670060a955e6', 'none', 'none', 'test19@foo.org', 1, 0, 0, 'none', '2011-02-15 12:56:45', '2011-02-15 12:56:45', '127.0.0.1', '0000-00-00 00:00:00', '2011-02-15 12:56:45', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 'default', 'bba019890aec72f6dd6b4e98513055cae61df098', 0, 0, 'Free Membership', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0.00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(134, 'test20', '1417c6235bc79819765456bb0132670060a955e6', 'none', 'none', 'test20@foo.org', 1, 0, 0, 'none', '2011-02-15 12:57:06', '2011-02-15 12:57:06', '127.0.0.1', '0000-00-00 00:00:00', '2011-02-15 12:57:06', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 'default', '57e5a4df68387d1d97210cf40c41104ce9256cf6', 0, 0, 'Free Membership', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0.00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(143, 'test21', '1417c6235bc79819765456bb0132670060a955e6', 'none', 'none', 'test21@foo.org', 1, 0, 0, '0603c11dac33c578cc6b873f8e9dac98ac2c8639', '2011-10-30 15:09:05', '2011-10-30 15:18:31', '127.0.0.1', '0000-00-00 00:00:00', '2011-10-30 15:18:31', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 'default', '74bc216e4be434b916613ad36a99ca831954ed40', 0, 0, 'Free Membership', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0.00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users_in_roles`
--

CREATE TABLE IF NOT EXISTS `users_in_roles` (
  `UsersInRolesId` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` int(11) NOT NULL,
  `RoleId` int(11) NOT NULL,
  `RoleName` varchar(50) NOT NULL,
  PRIMARY KEY (`UsersInRolesId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=633 ;

--
-- Dumping data for table `users_in_roles`
--

INSERT INTO `users_in_roles` (`UsersInRolesId`, `UserId`, `RoleId`, `RoleName`) VALUES
(617, 114, 1, 'owner'),
(581, 115, 5, 'user'),
(582, 116, 5, 'user'),
(583, 117, 5, 'user'),
(584, 118, 5, 'user'),
(585, 119, 5, 'user'),
(586, 120, 5, 'user'),
(587, 121, 5, 'user'),
(588, 122, 5, 'user'),
(589, 123, 5, 'user'),
(590, 124, 5, 'user'),
(591, 125, 5, 'user'),
(592, 126, 5, 'user'),
(625, 127, 5, 'user'),
(594, 128, 5, 'user'),
(595, 129, 5, 'user'),
(596, 130, 5, 'user'),
(597, 131, 5, 'user'),
(598, 132, 5, 'user'),
(599, 133, 5, 'user'),
(605, 134, 5, 'user'),
(630, 143, 5, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `visitors_counter`
--

CREATE TABLE IF NOT EXISTS `visitors_counter` (
  `CounterId` int(11) NOT NULL AUTO_INCREMENT,
  `VisitorIP` varchar(50) NOT NULL,
  `TimeStamp` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`CounterId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=973 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
