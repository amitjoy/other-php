<?php
// declare variables
$msg = '';
$company_logo = '';
$page_title = '';
$category = '';
$subcategory = '';
$subtitle = '';
$page_description = '';
$subcat_title = '';
$show_email_form = 0;

//------------------------------------------------------------
// include files
//------------------------------------------------------------
require_once(ROOT_PATH.'connect/mysql.php');
require_once(ROOT_PATH.'feedback/modules/form/error_messages.php');

//------------------------------------------------------------
// 1. GET PAGE CONTENT - TITLE, DESCRIPTION ETC.
//------------------------------------------------------------

// DB QUERY: get page content
// ------------------------------------------------------------
$get_page_content = mysqli_query($conn, "SELECT PageTitle, Subtitle, PageDescription, CompanyLogo FROM feedback_page Limit 1") 
or die($dataaccess_error);
// ------------------------------------------------------------

if(mysqli_num_rows($get_page_content) == 1)
{
	$row = mysqli_fetch_array($get_page_content);
	$page_title = $row['PageTitle'];
	$subtitle = $row['Subtitle'];
	$page_description = $row['PageDescription'];
	if($row['CompanyLogo'] != 'NULL' && $row['CompanyLogo'] != '')
	{
		$company_logo = $row['CompanyLogo'];
	}
	else
	{
		$company_logo = COMPANY_LOGO_URL.DEFAULT_COMPANY_LOGO;
	}
}

//------------------------------------------------------------
// 2. DISPLAY CATEGORIES - NAVIGATION LEFT
//------------------------------------------------------------

// DB QUERY: get categories
// ------------------------------------------------------------
$get_categories = mysqli_query($conn, "SELECT CategoryId, CategoryName FROM feedback_categories WHERE IsEnabled = 1") 
or die($dataaccess_error);
// ------------------------------------------------------------

if(mysqli_num_rows($get_categories) > 0)
{
	while($row = mysqli_fetch_array($get_categories))
	{
		$category_id = $row["CategoryId"];
		$category_name = $row["CategoryName"];
		
		$category .= '<li><a id='.$category_id.' href=?cid='.$category_id.'&amp;cat='.urlencode($category_name).'>'.$category_name.'</a></li>';
	}
}

//------------------------------------------------------------
// 3. DISPLAY SUBCATEGORIES - NAVIGATION RIGHT
//------------------------------------------------------------

if(isset($_GET['cid']) && !empty($_GET['cid']) && is_numeric($_GET['cid']) && $_GET['cid'] > 0)
{
	// get sent category id for query string
	$cid = mysqli_real_escape_string($conn, $_GET['cid']);
	$cat = mysqli_real_escape_string($conn, $_GET['cat']);
	
	// set cookie for selected category
	setcookie('feedback_cat_id', $cid, time()+3600);
	
	// DB QUERY: get categories
	// ------------------------------------------------------------
	$get_subcategories = mysqli_query($conn, "SELECT SubcategoryId,	CategoryId,	SubcategoryName, IsEnabled FROM feedback_subcategories WHERE CategoryId = $cid AND IsEnabled = 1") 
	or die($dataaccess_error);
	// ------------------------------------------------------------
	
	if(mysqli_num_rows($get_subcategories) > 0)
	{
		$subcat_title = '2. Select a relevant issue for: -- '.$cat;
		
		$i=1;
		while($row = mysqli_fetch_array($get_subcategories))
		{
			// row number
			$rowNumber = $i++;
			
			// assign category name and id
			$subcategory_id = $row["SubcategoryId"];
			$subcategory_name = $row["SubcategoryName"];
			
			$subcategory .= '<li><a href=?scid='.$subcategory_id.'&amp;cat='.urlencode($cat).'&amp;scat='.urlencode($subcategory_name).'>'.$rowNumber.'. '.$subcategory_name.'</a></li>';
		}
	}
}
else
{
	$subcat_title = '';
	$subcategory = '<li><div class="intro_text">'.'<span class="subtitle">'.$subtitle.'</span>'.'<p>'.$page_description.'</p></div></li>';
}

// display e-mail form for category if other
if(isset($_GET['cat']) && strtolower($_GET['cat']) == 'other')
{
	$subcat_title = '2. Please fill in the form below and click the "Send" button:';
	$cid = mysqli_real_escape_string($conn, $_GET['cid']);
	$cat = mysqli_real_escape_string($conn, $_GET['cat']);
	$show_email_form = 1;
}

//------------------------------------------------------------
// 4. DISPLAY E_MAIL FORM FOR SUBCATEGORY
//------------------------------------------------------------

if(isset($_GET['scid']) && !empty($_GET['scid']) && is_numeric($_GET['scid']) && $_GET['scid'] > 0)
{
	$subcat_title = '3. Please fill in the form below and click the "Send" button:';
	$show_email_form = 1;
	$scid = mysqli_real_escape_string($conn, $_GET['scid']);
	$scat = mysqli_real_escape_string($conn, $_GET['scat']);
}
?>