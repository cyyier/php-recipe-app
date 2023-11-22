<?php
//插入header
$page_title = 'Search';
require_once ('appvar.php');
require_once ('header.php');
?>


<?php
//建立查询的函数
function build_query($user_search) {
    $search_query = "SELECT *  FROM recipe";

    //将要查询的关键字放入一个数组
    $clean_search = str_replace(',','',$user_search);
    $search_words = explode(' ',$clean_search);
    $final_search_words = array();
    if (count($search_words) > 0) {
        foreach ($search_words as $word) {
            if (!empty($word)) {
                $final_search_words[] = $word;
            }
        }
    }

    //生成where语句
    $where_list = array();
    if (count($final_search_words) > 0) {
        foreach ($final_search_words as $word) {
            $where_list[] = "recipe_name LIKE '%$word%'";
        }
    }
    $where_clause = implode(' OR ', $where_list);

    //把where_clause加入query
    if (!empty($where_clause)) {
        $search_query .= " WHERE $where_clause";
    }

    return $search_query;
}

//生成页面导航的函数
function generate_page_links($user_search, $cur_page, $num_pages) {
    $page_links = '';

    //如果不是第一页，生成上一页链接
    if ($cur_page > 1) {
        $page_links .= sprintf('<a href="%s?usersearch=%s&page=%s">上一页</a>',
        $_SERVER['PHP_SELF'], $user_search, $cur_page-1);
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
            $page_links .= sprintf('<a href="%s?usersearch=%s&page=%s"> %d </a>',
            $_SERVER['PHP_SELF'],$user_search,$i,$i);
        }
    }

    if ($cur_page < $num_pages) {
        $page_links .= sprintf('<a href="%s?usersearch=%s&page=%s">下一页</a>',
            $_SERVER['PHP_SELF'], $user_search, $cur_page+1);
    }
    else {
        $page_links .= '下一页';
    }

    return $page_links;

    
}

// Grab the sort setting and search keywords from the URL using GET
$user_search = $_GET['usersearch'];

//分页
$cur_page = isset($_GET['page'])? $_GET['page'] : 1;
$result_per_page = 10;
$skip = (($cur_page - 1) * $result_per_page);



// Connect to the database
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die('数据库连接失败');


// 全部结果有多少行
$query = build_query($user_search);
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
    echo generate_page_links($user_search, $cur_page, $num_pages);
}



mysqli_close($dbc);
?>



<?php
//插入header
require_once ('footer.php');
?>
