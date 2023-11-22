<?php
$category_id = $_GET['cid'];
switch ($category_id)
{
    case 1:
        $page_title = '大饭店';;
        break;
    case 2:
        $page_title = '甜品站' ;
        break;

    case 3:
        $page_title = '小吃摊';
        break;
    default:
        $page_title = '全部菜谱';

}

require_once ('header.php');
require_once ('appvar.php');
require_once ('pagelinks.php');
?>


<?php
//插入header
require_once ('footer.php');
?>




