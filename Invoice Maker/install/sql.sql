CREATE TABLE IF NOT EXISTS `config` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(32) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`id`, `name`, `value`) VALUES
(1, 'lang_page', 'Page'),
(2, 'lang_date', 'Date'),
(3, 'lang_bank', 'Bank'),
(4, 'lang_bank_account', 'Bank Account'),
(5, 'lang_pmethod', 'Payment Method'),
(6, 'lang_duedate', 'Due Date'),
(7, 'lang_description', 'Description'),
(8, 'lang_qty', 'Quantity'),
(9, 'lang_amount', 'Amount'),
(10, 'lang_invoice', 'Invoice'),
(11, 'lang_client', 'Client'),
(12, 'lang_payto', 'Pay To'),
(13, 'lang_subtotal', 'Subtotal'),
(14, 'lang_total', 'Total'),
(15, 'lang_taxes', 'Taxes'),
(16, 'lang_netprice', 'Net Price'),
(17, 'display_logo', '1'),
(18, 'logo', 'style/images/logo.png'),
(19, 'name', ''),
(20, 'address', ''),
(21, 'footer', 'Copyright\r\nAll Rights Reserved'),
(22, 'bank_name', ''),
(23, 'website', ''),
(24, 'bank_account', ''),
(25, 'watermark', ''),
(26, 'currency', ''),
(27, 'lang_status', 'Status'),
(28, 'lang_paid', 'Paid'),
(29, 'lang_unpaid', 'Unpaid'),
(30, 'lang_partial', 'Partially Paid'),
(31, 'submit', 'Update'),
(32, 'email', ''),
(33, 'size', 'A4'),
(34, 'enable_payments', '1'),
(35, 'paypal_email', ''),
(36, 'paypal_currency', 'USD');


CREATE TABLE IF NOT EXISTS `invoices` (
  `id` int(11) NOT NULL auto_increment,
  `client_name` varchar(255) NOT NULL,
  `client_email` varchar(255) NOT NULL,
  `client_phone` varchar(255) NOT NULL,
  `client_address` text NOT NULL,
  `client_location` varchar(255) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `vat` int(11) NOT NULL,
  `total` varchar(32) NOT NULL,
  `currency` varchar(32) NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;



CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(11) NOT NULL auto_increment,
  `from` varchar(255) NOT NULL,
  `date` int(12) NOT NULL,
  `amount` varchar(32) NOT NULL,
  `invoice` int(7) NOT NULL,
  `pmethod` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `qty` int(11) NOT NULL,
  `price` varchar(11) NOT NULL,
  `invoice` int(11) NOT NULL,
  `taxes` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `invoice` (`invoice`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `taxes` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(32) NOT NULL,
  `value` varchar(32) NOT NULL,
  `hidden` int(1) NOT NULL default '0',
  `default` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

