<?php

//建立查询的函数
function build_query($category_id) {
    $search_query = 'SELECT *  FROM recipe';
    if($category_id < 4) {
        $search_query .= " WHERE category_id = '$category_id'";
    }



    return $search_query;
}
//生成页面导航的函数
function generate_page_links($cur_page, $num_pages) {
    $page_links = '';

    //如果不是第一页，生成上一页链接
    if ($cur_page > 1) {
        $page_links .= sprintf('<a href="%s?page=%s">上一页</a>',
            $_SERVER['PHP_SELF'],  $cur_page-1);
    }
    else {
        $page_links .= '上一页';
    }

    //遍历所有页码
    for ($i = 1; $i <= $num_pages; $i++) {
        if ( $i == $cur_page) {
            $page_links .= ' ' . $i;
        }
        else{
            $page_links .= sprintf('<a href="%s?page=%s"> %d </a>',
                $_SERVER['PHP_SELF'],$i,$i);
        }
    }

    if ($cur_page < $num_pages) {
        $page_links .= sprintf('<a href="%s?page=%s">下一页</a>',
            $_SERVER['PHP_SELF'], $cur_page+1);
    }
    else {
        $page_links .= '下一页';
    }

    return $page_links;


}


//分页
$cur_page = isset($_GET['page'])? $_GET['page'] : 1;
$result_per_page = 10;
$skip = (($cur_page - 1) * $result_per_page);



// Connect to the database
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die('数据库连接失败');


// 全部结果有多少行
$query = build_query($category_id);
$result = mysqli_query($dbc, $query) or die('查询失败');
$total = mysqli_num_rows($result);
if ($total == 0) {
    echo '你来到了没有食物的荒漠....';
}
$num_pages = ceil($total / $result_per_page);

//每页显示固定的条数
$query .= " LIMIT $skip, $result_per_page";//跳过的行数，返回的行数
$result = mysqli_query($dbc,$query);
while ($row = mysqli_fetch_array($result)) {
    echo sprintf('<div class="box"><p><a class="has-text-dark" href="showingredientandstep.php?recipe_id=%s">%s</a></p></div>',$row['recipe_id'],$row['recipe_name']);
}

if ($num_pages > 1) {
    echo generate_page_links($cur_page, $num_pages);
}


mysqli_close($dbc);
?>