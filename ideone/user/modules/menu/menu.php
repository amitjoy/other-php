<?php
//---------------------------------------------------------------
// INCLUDE DB CONNECTION
//---------------------------------------------------------------
require_once(ROOT_PATH.'connect/mysql.php');
require_once(ROOT_PATH.'user/modules/menu/error_messages.php');

$menu_category = 'user dash';
//---------------------------------------------------------------
// GET MENU FROM DB
//---------------------------------------------------------------
$get_menu = mysqli_query($conn, "SELECT MenuId, Url, Target, Label, Title, Description, ParentId, OrdinalPosition, IsEnabled FROM menus WHERE (IsEnabled = 1) AND MenuName = '$menu_category' ORDER BY ParentId, OrdinalPosition, Label")
or die($dataaccess_error);

if(mysqli_num_rows($get_menu) > 0)
{
	// loop through menu items
	while ($menu_item = mysqli_fetch_assoc($get_menu))
	{
		$menu_data['MenuItem'][$menu_item['MenuId']] = $menu_item;
		$menu_data['MenuParent'][$menu_item['ParentId']][] = $menu_item['MenuId'];
	} 
	
	// output the menu
	echo HorizMenu(0, $menu_data); 
}
else
{
	$display_empty_menu = 1;
}

//---------------------------------------------------------------
// BUILD MENU FUNCTION FOR SUPERFISH
//---------------------------------------------------------------
function HorizMenu($parent_id, $menu_data)
{
    $html = '';

    if (isset($menu_data['MenuParent'][$parent_id]))
    {
		$html = '<ul class="sf-menu">';
        foreach ($menu_data['MenuParent'][$parent_id] as $itemId)
        {
            // menu variables
			$url = $menu_data['MenuItem'][$itemId]['Url'];
			$target = $menu_data['MenuItem'][$itemId]['Target'];
			$title = $menu_data['MenuItem'][$itemId]['Title'];
			$label = $menu_data['MenuItem'][$itemId]['Label'];
			
			$html .= '<li class="current"><a href="'.$url.'" target="'.$target.'" title="'.$title.'">'.$label.'</a>';

            // find childitems recursively
            $html .= HorizMenu($itemId, $menu_data);

            $html .= '</li>';
        }
        $html .= '</ul>';
    }

    return $html;
}
?>