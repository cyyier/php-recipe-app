<?php
//插入header
$page_title = 'Home';
require_once ('appvar.php');
require_once ('header.php');
?>

<!--<div class="columns is-mobile ">
    <div class="column is-5 is-offset-one-quarter has-text-centered">
            <figure class="image">
                <img class="is-rounded" src="images/shuizhuroupian.png" alt="dinner">
                <figcaption class="is-size-7">♡Dinner♡</figcaption>
            </figure>

            <figure class="image">
                <img class="is-rounded" src="images/caomeidangao.png" alt="dinner">
                <figcaption class="is-size-7">♡Steet♡</figcaption>
        </figure>

        <figure class="image">
            <img class="is-rounded" src="images/zhangyushao.png" alt="dinner">
            <figcaption class="is-size-7">♡Ohter♡</figcaption>
        </figure>


    </div>
</div>-->
<div>
    <img class="is-rounded" src="hamster.jpg" alt="dinner">

</div>



<br>
<br>
<br>

<nav class="navbar is-fixed-bottom"><div class="column has-text-left">
        <form  method="get" action="search.php">
            <label for="usersearch">今天吃点啥？</label>
            <input class="input" type="text" id="usersearch" name="usersearch">
            <input class="button is-fullwidth is-warning" type="submit" value="搜索">

        </form>
</nav>

<?php
//插入header
require_once ('footer.php');
?>




       