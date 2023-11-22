<?php
session_start();
//插入header
require_once  ('appvar.php');
$recipe_id = $_GET['recipe_id'];
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die('数据库链接失败');
$query = "SELECT recipe_name FROM recipe WHERE recipe_id = '$recipe_id'";
$data = mysqli_query($dbc,$query);
$data_row = mysqli_fetch_array($data);
$page_title = $data_row['recipe_name'];
require_once ('header.php');
?>

<?php
//生成页面导航的函数
function generate_page_links($recipe_id, $cur_page, $num_pages) {
    $page_links = '';

    //如果不是第一页，生成上一页链接
    if ($cur_page > 1) {
        $page_links .= sprintf('<a class="button is-large is-fullwidth" href="%s?recipe_id=%d&page=%s">上一页</a>',
            $_SERVER['PHP_SELF'], $recipe_id, $cur_page-1);
    }
    else {
        $page_links .= '<p class="button is-large is-light is-fullwidth">上一页</p>';
    }


    //下一页
    if ($cur_page < $num_pages) {
        $page_links .= sprintf('<a class="button is-large is-fullwidth" href="%s?recipe_id=%d&page=%s">下一页</a>',
            $_SERVER['PHP_SELF'], $recipe_id, $cur_page+1);
    }
    else {
        $page_links .= '<p class="button is-large is-light is-fullwidth">下一页</p>';
    }

    $page_links .= sprintf('<a href="showingredientandstep.php?recipe_id=%d">材料</a>',$recipe_id);

    //遍历所有页码
    for ($i = 1; $i <= $num_pages; $i++) {
        if ( $i == $cur_page) {
            $page_links .= ' ' . $i;
        }
        else{
            $page_links .= sprintf('<a href="%s?recipe_id=%d&page=%s"> %d </a>',
                $_SERVER['PHP_SELF'],$recipe_id,$i,$i);
        }
    }

    return $page_links;


}

$cur_page = isset($_GET['page']) ? $_GET['page'] : 1;
$result_per_page = 1;
$skip = (($cur_page-1) * $result_per_page);


//取得所有step表内容
$query = "SELECT * FROM step 
            Natural JOIN recipe_step 
            WHERE recipe_id = '$recipe_id' 
            ORDER BY step_order,step_id";
$result = mysqli_query($dbc,$query) or die('获取step_id失败');
$total = mysqli_num_rows($result);
$num_pages = ceil($total/$result_per_page);

$query = $query . " LIMIT $skip, $result_per_page";
$result =mysqli_query($dbc, $query) or die('获取step分页内容失败');

if (mysqli_num_rows($result) == 0){
    echo '没有相应的步骤';
}

$change_arr = $_SESSION['change_arr' . $recipe_id];

while ($row = mysqli_fetch_array($result)) {
    $default_row =  $row['step_content'];
    $change_row = strtr($default_row,$change_arr);
    echo '<h1 class="title is-1">';
    echo $change_row;
    echo '</h1>';
    if($row['timer'] != 0) {
        echo '<p id="clock"></p>';
        echo sprintf('<button class="button is-large is-warning is-fullwidth" onclick="theTimeFunction(%d)">开始</button>',$row['timer']);
    }
    if(!empty($row['step_image'] )) {
        echo sprintf('<img src="%s">',GW_UPLOADPATH . $row['step_image']);
    }
    echo '<br><br><br><br><br><br><br><br>';

    $i++;
}

echo '<nav class="navbar is-fixed-bottom"><div class="column has-text-centered">';
echo generate_page_links($recipe_id, $cur_page, $num_pages);
echo '</div>';

//进度条
echo sprintf('<progress class="progress is-warning" value="%d" max="%d">%d</progress>', $cur_page,$num_pages,$cur_page/$num_pages);
echo '</nav>';
mysqli_close($dbc);
?>


<?php
//插入footer
require_once ('footer.php');
?>


