<?php
//插入header
//判断是新建还是修改 如果是修改page为TRUE
if (!empty($_GET['recipe_id'])) {
    $page_title = 'Edit Recipe Success';
    $recipe_id = $_GET['recipe_id'];
    $page = 1;
}
else {
    $page_title = 'ADD NEW Success';
    $page = 0;
}
require_once ('header.php');
require_once  ('appvar.php');
?>

<?php

if(isset($_POST['submit'])) {
    //post变量
    $recipe_name = $_POST['recipe_name'];
    $category_id = $_POST['category_id'];
    $recipe_link = $_POST['recipe_link'];
    $ingredient_main_array = $_POST['ingredient_main'];
    $ingredient_name_array = $_POST['ingredient_name']; //这是一个数组可以用$ingredient_name[0]等读取
    $ingredient_volume_array = $_POST['ingredient_volume'];//array
    $ingredient_unit_array = $_POST['ingredient_unit'];//array
    $step_order_array = $_POST['step_order'];
    $step_content_array = $_POST['step_content'];//array
    $minute_array = $_POST['minute'];//array
    $second_array = $_POST['second'];//array
    $step_image_array = $_FILES['step_image']['name'];//array
    $step_image_type_array = $_FILES['step_image']['type'];//array
    $step_image_size_array = $_FILES['step_image']['size'];//array


    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die('数据库链接失败');

//向数据库插入recipe表信息
    if($page == 1) {
        $query = "UPDATE recipe SET recipe_name = '$recipe_name', category_id = '$category_id', recipe_link = '$recipe_link' WHERE recipe_id= 'recipe_id'";
        mysqli_query($dbc, $query) or die('向recipe插入查询失败');

        //移除和当前内容的链接
        $query = "DELETE FROM recipe_ingredient WHERE recipe_id = '$recipe_id' ";
        mysqli_query($dbc, $query);

        $query = "DELETE FROM recipe_step WHERE recipe_id = '$recipe_id' ";
        mysqli_query($dbc, $query);
    }

    else {
        //向数据库插入recipe表信息
        $query = "INSERT INTO recipe VALUES ('','$recipe_name','$category_id','$recipe_link')";
        mysqli_query($dbc, $query) or die('向recipe插入查询失败');
        //查询recipe_id
        $query = "SELECT recipe_id FROM recipe WHERE recipe_name = '$recipe_name'  ";
        $result = mysqli_query($dbc,$query);
        $row = mysqli_fetch_array($result);
        $recipe_id = $row['recipe_id'];
    }

//////////////////////////////////////////////////////////////////////
/// ingredient 相关///////////////////////////////////////////////////
/// /////////////////////////////////////////////////////////////////
//创建一个ingredient_id数组并取得id信息
$ingredient_id_array = array();
for ($i = 0; $i < count($ingredient_name_array); $i++) {
    //如果存在ingredient_name就把ingredient信息插入数据库
    if (!empty($ingredient_name_array[$i])) {
        $query = "INSERT INTO ingredient VALUES ('','$ingredient_main_array[$i]','$ingredient_name_array[$i]','$ingredient_volume_array[$i]','$ingredient_unit_array[$i]')";
        mysqli_query($dbc, $query);
        //取得ingredient_id
        $query = "SELECT ingredient_id FROM ingredient WHERE ingredient_main='$ingredient_main_array[$i]' AND ingredient_name='$ingredient_name_array[$i]'AND ingredient_volume = '$ingredient_volume_array[$i]' AND ingredient_unit = '$ingredient_unit_array[$i]'";
        $result = mysqli_query($dbc, $query);
        $row = mysqli_fetch_array($result);
        $ingredient_id = $row['ingredient_id'];
        array_push($ingredient_id_array, $ingredient_id);
    }
}


//向ingredient_recipe表插入recipe_id和ingredients_id
for ($i = 0; $i < count($ingredient_id_array); $i++) {
    $query = "INSERT INTO recipe_ingredient VALUES ('$recipe_id','$ingredient_id_array[$i]')" or die('向ingredient_recipe插入失败');
    mysqli_query($dbc, $query);
}


///////////////////////////////////////////////////////////////////////////////
/// step相关////////////////////////////////////////////////////////////////////
/// ///////////////////////////////////////////////////////////////////////////
//创建一个step_id数组并取得id信息
$step_id_array = array();
for ($i = 0; $i < count($step_content_array); $i++) {
    if (!empty($step_content_array[$i])) {
        //时间换算
        $timer_array = array();
        $timer_array[$i] = $minute_array[$i] * 60 + $second_array[$i];

        //图片移动到指定文件夹

        if (($step_image_type_array[$i] == 'image/png' || $step_image_type_array[$i] == 'image/jpeg') && $step_image_size_array[$i] > 0) {
            //将上传文件移入指定文件夹
            $target = GW_UPLOADPATH . $step_image_array[$i];
            move_uploaded_file($_FILES['step_image']['tmp_name'][$i], $target);
        }

        //将相关信息插入step表
        $query = "INSERT INTO step VALUES ('','$step_order_array[$i]','$step_content_array[$i]','$timer_array[$i]','$step_image_array[$i]')";
        mysqli_query($dbc, $query);

        //取得ingredient_id
        $query = "SELECT step_id FROM step WHERE step_order ='$step_order_array[$i]' AND step_content ='$step_content_array[$i]'AND timer = '$timer_array[$i]' AND step_image = '$step_image_array[$i]'";
        $result = mysqli_query($dbc, $query);
        $row = mysqli_fetch_array($result);
        $step_id = $row['step_id'];
        array_push($step_id_array, $step_id);
    }
}

//向step_recipe表插入recipe_id和step_id
for ($i = 0; $i < count($step_id_array); $i++) {
    $query = "INSERT INTO recipe_step VALUES ('$recipe_id','$step_id_array[$i]')" or die('向step_recipe插入查询失败');
    mysqli_query($dbc, $query);
}


//关闭数据库
    mysqli_close($dbc);
    echo '<div class="notification is-success">';
    echo '<button class="delete"></button>';
    echo '编辑菜谱成功';
    echo '</div>';
    echo sprintf('<a href="showingredientandstep.php?recipe_id=%s">点击查看菜谱</a>',$recipe_id);

}
?>


<?php
//插入footer
require_once ('footer.php');
?>

