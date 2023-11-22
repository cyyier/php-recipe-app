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
if(isset($_POST['确认'])) {
    if ($_POST['confirm'] == 'yes') {
        $query = "DELETE FROM recipe_ingredient WHERE recipe_id = '$recipe_id' ";
        mysqli_query($dbc,$query);

        $query = "DELETE FROM recipe_step WHERE recipe_id = '$recipe_id' ";
        mysqli_query($dbc,$query);

        $query = "DELETE FROM recipe WHERE recipe_id = '$recipe_id' ";
        mysqli_query($dbc,$query);

        mysqli_close($dbc);
        echo sprintf('<p>菜谱%s已经成功删除。</p>',$recipe_name);

    }
}

?>
<a href="index.php" class="button">返回主页</a>
<?php
//插入footer
require_once ('footer.php');
?>
