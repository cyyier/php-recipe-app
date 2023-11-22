<?php
require_once  ('appvar.php');
//插入header
$recipe_id = $_GET['recipe_id'];
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die('数据库链接失败');
$query = "SELECT recipe_name,recipe_link FROM recipe WHERE recipe_id = '$recipe_id'";
$data = mysqli_query($dbc,$query);
$data_row = mysqli_fetch_array($data);
$page_title = $data_row['recipe_name'];
$recipe_name = $data_row['recipe_name'];
require_once ('header.php');

?>

<?php

//展示在页面的确认信息
echo '<div class="field">';
echo sprintf('<p>确定要删除菜谱%s吗？删除的菜谱将无法找回:(</p>',$recipe_name);
echo sprintf('<form method="post" action="removeconfirm.php?recipe_id=%s">',$recipe_id);
echo '<div class="field"><div class="control">';
echo '<label class="radio"><input type="radio" name="confirm" value="yes">确认</label>';
echo '<label class="radio"><input type="radio" name="confirm" value="no">取消</label></div></div>';
echo '<input class="button is-danger" type="submit" value="确认" name="确认"></div>';


?>

<?php
//插入footer
require_once ('footer.php');
?>
