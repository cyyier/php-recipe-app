<?php
//插入header
if (!empty($_GET['recipe_id'])) {
    $page_title = 'Edit Recipe';
    $recipe_id = $_GET['recipe_id'];
    $page = 1;
}
else {
    $page_title = 'ADD NEW';
    $page = 0;
}

require_once ('header.php');
require_once ('appvar.php');
?>

<?php
if ($page == 1) {
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die('数据库链接失败');

    $query1 = "SELECT * FROM recipe where recipe_id = '$recipe_id'";
    $data1 = mysqli_query($dbc, $query1);
    $recipe_row = mysqli_fetch_array($data1);
    $recipe_name = $recipe_row['recipe_name'];
    $category_id = $recipe_row['category_id'];
    $recipe_link = $recipe_row['recipe_link'];

    $query2 = "SELECT * FROM step Natural JOIN recipe_step WHERE recipe_id = '$recipe_id' ORDER BY step_order";
    $data2 = mysqli_query($dbc, $query2);


    $query3 = "SELECT * FROM ingredient Natural JOIN recipe_ingredient WHERE recipe_id = '$recipe_id' ORDER BY ingredient_main DESC";
    $data3 = mysqli_query($dbc, $query3);

}

?>


<form enctype="multipart/form-data" method="post" action="editconfirm.php?recipe_id=<?php echo $recipe_id; ?>">

    <div class="field">
        <label class="label">菜谱名</label>
        <div class="control">
            <input id="recipe_name" name="recipe_name" class="input" type="text" required="required" placeholder="红烧猫儿" value="<?php echo $recipe_name ?>">
        </div>
    </div>

    <div class="field">
        <label class="label">类别</label>
        <div class="control">
            <div class="select">
                <select id="category_id" name="category_id">
                    <option value="1" <?php echo $category_id==1 ? "selected":""?>>正餐</option>
                    <option value="2" <?php echo $category_id==2 ? "selected":""?>>甜点</option>
                    <option value="3" <?php echo $category_id==3 ? "selected":""?>>其它</option>
                </select>
            </div>
        </div>
    </div>

    <div class="field">
        <label class="label">原菜谱链接</label>
        <div class="control">
            <input id="recipe_link" name="recipe_link" class="input" type="text"  placeholder="hamster.happy" value="<?php echo $recipe_link  ?>">
        </div>
    </div>

    <div class=="field is-horizontal">
    <label class="label">材料</label>
    <?php for($i=0;$i< 15 ;$i++) {
        if ($page) {
            $ingredient_row = mysqli_fetch_array($data3);
        }
        ?>
            <div class="control">
                <div class="field-body">
                    <div class="select <?php echo $i%2==0? "is-warning":"is-light" ; ?> has-background-warning">
                        <select id="ingredient_main[]" name="ingredient_main[]" >
                            <option value="1" <?php echo $i==0? "selected":""; ?>>主要</option>
                            <option value="0" <?php echo $i!=0? "selected":""; ?> >普通</option>
                        </select>
                    </div>
                    <input id="ingredient_name[]"  name="ingredient_name[]" class="input <?php echo $i%2==0? "is-warning":"is-light"; ?>" type="text" placeholder="猪肉" value="<?php echo $ingredient_row['ingredient_name']; ?>">
                    <input id="ingredient_volume[]" name="ingredient_volume[]" class="input <?php echo $i%2==0? "is-warning":"is-light"; ?>" type="text" placeholder="500" value="<?php echo $ingredient_row['ingredient_volume']; ?>">
                    <input id="ingredient_unit[]" name="ingredient_unit[]" class="input <?php echo $i%2==0? "is-warning":"is-light"; ?>" type="text" placeholder="g" value="<?php echo $ingredient_row['ingredient_unit']; ?>">
                </div>
            </div>

    <?php } ?>


    </div>
    <div class="field">
        <label class="label">步骤</label>
        <div class="control">

    <?php for($i=0;$i<25 ;$i++) {
        if ($page) {
            $step_row = mysqli_fetch_array($data2);
            $step_content = $step_row['step_content'];
            $timer = $step_row['timer'];
            $second = $timer % 60;
            $minute = ($timer - $second) / 60;
        }

        ?>
        <input type="number" id="step_order[]" name="step_order[]" class="input is-warning" value="<?php echo $i + 1; ?>">
            <textarea id="step_content[]" name="step_content[]" class="textarea" placeholder="步骤"><?php echo $step_content; ?></textarea>
            <div class=="field is-horizontal">
            <div class="field-body">
            <input id="minute[]" name="minute[]" class="input is-light" type="int" placeholder="30" value="<?php echo $minute; ?>">分
            <input id="second[]" name="second[]" class="input is-light" type="int" placeholder="30" value="<?php echo $second; ?>">秒
            <?php if(!empty($step_row['step_image'] )) {
                echo sprintf('<img src="%s">',GW_UPLOADPATH . $step_row['step_image']);
            }
            ?>
            <div class="file">
                <label class="file-label">
                    <input class="file-input" type="file" name="step_image[]" id="step_image[]">
                    <span class="file-cta">
            <span class="file-icon">
            <i class="fas fa-upload"></i>
             </span>
            <span class="file-label">
            上传图片
            </span>
            </span>
            </div>

        </div>

    <?php } ?>
        </div>
    </div>

        <div class="control">
            <button class="button" value="submit" type="submit" name="submit">提交</button>
        </div>

</form>



<?php
//插入header
require_once ('footer.php');
?>

