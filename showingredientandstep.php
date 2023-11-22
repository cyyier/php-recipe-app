<?php
session_start();
require_once  ('appvar.php');
//插入header
$recipe_id = $_GET['recipe_id'];
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die('数据库链接失败');
$query = "SELECT recipe_name,recipe_link FROM recipe WHERE recipe_id = '$recipe_id'";
$data = mysqli_query($dbc,$query);
$data_row = mysqli_fetch_array($data);
$page_title = $data_row['recipe_name'];
require_once ('header.php');

?>
<div>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'] . '?recipe_id=' . $recipe_id; ?>">
    <div class="field is-grouped">
        <p class="control is-expanded">
            <input class="input" type="number" id="howmuch" name="howmuch">
        </p>
        <p class="control">
            <input class="button" type="submit"  name="submit" value="确认">
        </p>
    </div>
</form>
</div>

<table class="table is-fullwidth is-hoverable is-striped">
    <thead>
    <tr>
        <th>材料</th>
        <th>用量</th>
    </tr>
    </thead>
    <tbody>
<?php



//取得所有ingredient_id
$query = "SELECT * FROM ingredient Natural JOIN recipe_ingredient WHERE recipe_id = '$recipe_id' ORDER BY ingredient_main DESC,ingredient_id";
$result = mysqli_query($dbc,$query) or die('获取ingredient_id失败');

if (mysqli_num_rows($result) == 0){
    echo '没有相应的食材';
}

$i = 0;
$change_arr = array(); //把每次循环里的数量放入数组准备在步骤中使用
while ($row = mysqli_fetch_array($result)) {
    $row_ingredient_id =  $row['ingredient_id'];
    if ($i == 0) {
        $main_ingredient_volume = $row['ingredient_volume'];
        $i++;
        $howmuch = isset($_POST['howmuch'])? $_POST['howmuch'] : $main_ingredient_volume; //如果用户输入了howmuch就把它设为howmuch 不然就是第一个

    }
    $volume_before_change = $row['ingredient_volume'];
    $volume_after_change = $row['ingredient_volume']/$main_ingredient_volume*$howmuch;
    $change_arr[$volume_before_change] = $volume_after_change;
    echo sprintf('<tr><th>%s</th><td>%d%s</td></tr>',$row['ingredient_name'],$volume_after_change,$row['ingredient_unit']);

$_SESSION['change_arr' . $recipe_id] = $change_arr;
}


?>

    </tbody>
</table>

<?php

//预览所有步骤

//取得所有step_id
$query = "SELECT * FROM step Natural JOIN recipe_step WHERE recipe_id = '$recipe_id' ORDER BY step_order";
$result = mysqli_query($dbc,$query) or die('获取step_id失败');

if (mysqli_num_rows($result) == 0){
    echo '没有相应的步骤';
}

while ($row = mysqli_fetch_array($result)) {
    $default_row =  $row['step_content'];
    $change_row = strtr($default_row,$change_arr);
    echo $row['step_order'] . '.';
    echo $change_row;
    echo '<br/>';
    $i++;
}



echo '<br/><br/>';

echo '<nav class="navbar is-fixed-bottom"><div class="column has-text-left">';
//原文链接
echo sprintf('<div icon class="container "><span class="icon is-medium"><a class="has-text-dark" href="//%s"><ion-icon name="share-social-outline" class="icon">查看原菜谱</ion-icon> </a> </span> ',$data_row['recipe_link']);
echo sprintf('<span class="icon is-medium"><a class="has-text-dark" href="editrecipe.php?recipe_id=%s"><ion-icon name="create-outline" class="icon">编辑菜谱</ion-icon> </a></span>   ',$recipe_id);
echo sprintf('<span class="icon is-medium"><a class="has-text-danger" href="removerecipe.php?recipe_id=%s"><ion-icon name="close-outline" class="icon">删除菜谱</ion-icon> </a></span>',$recipe_id);
echo sprintf('<a class="button is-fullwidth is-warning" href="showstep.php?recipe_id=%s">开始制作</a></div>',$recipe_id);
echo '</nav>';




mysqli_close($dbc);
?>

<script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
<?php
//插入footer
require_once ('footer.php');
?>


