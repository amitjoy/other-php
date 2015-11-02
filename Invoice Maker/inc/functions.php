<?
@include "db.php";
@include "geekmail.php";
$res=mysql_query("select * from config")or die(mysql_error());
	while($row=mysql_fetch_array($res)){
		$cfg[$row['name']]=$row['value'];
	}
session_start();




function mailer($to,$subject,$message,$attach=''){
global $cfg;
	$geekMail = new geekMail();	
	$geekMail->setMailType('html');
	$geekMail->from($cfg['email'], $cfg['name']);
	$geekMail->to(array($to));
	$geekMail->subject($subject);
	$geekMail->message(nl2br($message));
	if($attach){
		$geekMail->attach($attach);
	}
	if (!$geekMail->send())
	{
		return 0;
	}else{
		return 1;
	}
}


function encrypt($string) {
global $cfg;
	$key=$cfg['admin_pass'];
  $result = '';
  for($i=0; $i<strlen($string); $i++) {
    $char = substr($string, $i, 1);
    $keychar = substr($key, ($i % strlen($key))-1, 1);
    $char = chr(ord($char)+ord($keychar));
    $result.=$char;
  }

  return base64_encode($result);
}

function decrypt($string) {
global $cfg;
	$key=$cfg['admin_pass'];
  $result = '';
  $string = base64_decode($string);

  for($i=0; $i<strlen($string); $i++) {
    $char = substr($string, $i, 1);
    $keychar = substr($key, ($i % strlen($key))-1, 1);
    $char = chr(ord($char)-ord($keychar));
    $result.=$char;
  }

  return $result;
}

function smart_pagination($page,$total,$limit,$url){
global $ext;
$lang['back']='Inapoi';
$lang['page']='Pagina';
$lang['next']='Inainte';
	$adjacents = 2;
	$total_pages =$total;

	/* Setup page vars for display. */
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1
	
	$username=$ext;
	/* 
		Now we apply our rules and draw the pagination object. 
		We're actually saving the code to a variable in case we want to draw it more than once.
	*/
	$pagination = "";
	if($lastpage > 1)
	{	
		if ($page > 1) 
			$pagination.= "<div class='pageleft_on' onclick=\"setfiltru('page','".($prev)."')\"></div>";
		else
			$pagination.= "<div class='pageleft_off'></div>";	
		$pagination.="<div class='pagecenter'>";
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<a href='javascript:void(0)' class='active'>".$counter."</a>";
				else
					$pagination.= "<a href='javascript:void(0)' onclick=\"setfiltru('page','".($counter)."')\">".$counter."</a>";					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<a href='javascript:void(0)' class='active'>".$counter."</a>";
					else
						$pagination.= "<a href='javascript:void(0)' onclick=\"setfiltru('page','".($counter)."')\">".$counter."</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href='javascript:void(0)' onclick=\"setfiltru('page','".($lpm1)."')\">".$lpm1."</a>";		
				$pagination.= "<a href='javascript:void(0)' onclick=\"setfiltru('page','".($lastpage)."')\">".$lastpage."</a>";			
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a href='javascript:void(0)' onclick=\"setfiltru('page','1')\">1</a>";		
				$pagination.= "<a href='javascript:void(0)' onclick=\"setfiltru('page','2')\">2</a>";		
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<a href='javascript:void(0)' class='active'>".$counter."</a>";
					else
						$pagination.= "<a href='javascript:void(0)' onclick=\"setfiltru('page','".($counter)."')\">".$counter."</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href='javascript:void(0)' onclick=\"setfiltru('page','".($lmp1)."')\">".$lpm1."</a>";		
				$pagination.= "<a href='javascript:void(0)' onclick=\"setfiltru('page','".($lastpage)."')\">".$lastpage."</a>";			
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<a href='javascript:void(0)' onclick=\"setfiltru('page','1')\">1</a>";		
				$pagination.= "<a href='javascript:void(0)' onclick=\"setfiltru('page','2')\">2</a>";	
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<a href='javascript:void(0)' class='active'>".$counter."</a>";
					else
						$pagination.= "<a href='javascript:void(0)' onclick=\"setfiltru('page','".($counter)."')\">".$counter."</a>";					
				}
			}
		}
		$pagination.='</div>';
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<div class='pageright_on' onclick=\"setfiltru('page','".($next)."')\"></div>";
		else
			$pagination.= "<div class='pageright_off'></div>";	
	}
	return $pagination;
	}  
?>