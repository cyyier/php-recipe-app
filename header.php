<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    echo '<title>Hamster Recipe -' . $page_title . '</title>';
    ?>
    <link rel="shortcut icon" href="favicon.ico"/>
    <link rel="bookmark"href="favicon.ico" />
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.2/css/bulma.min.css">
    <script type="text/javascript" src="scripts/closeMsg.js"></script>
    <script type="text/javascript" src="scripts/nav.js"></script>
    <script type="text/javascript" src="scripts/timer.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js" async></script>

</head>
<body>


<nav class="container">


    <nav class="navbar is-light" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <a class="navbar-item" href="index.php">
                <img src="hamsterrecipe-logo.png" width="130" >
                <?php
                echo '<p class="id-dark"> - ' . $page_title . '</p>';
                ?>
            </a>


            <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>



        </div>
        <div id="navbarBasicExample" class="navbar-menu has-text-centered">
            <div class="navbar-start">
                <a class="navbar-item" href="index.php">主页</a>
                <a class="navbar-item" href="list.php?cid=4">全部菜谱</a>
                <a class="navbar-item" href="list.php?cid=1">大饭店</a>
                <a class="navbar-item" href="list.php?cid=2">甜品站</a>
                <a class="navbar-item" href="list.php?cid=3">小吃摊</a>
                <a class="navbar-item" href="editrecipe.php">添加新菜谱</a>

            </div>




            </div>

    </nav>


<section class="section">
    <div class="container">






