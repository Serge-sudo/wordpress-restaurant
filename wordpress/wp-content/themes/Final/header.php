<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>
        <?php bloginfo('name'); ?>
    </title>
    <meta charset="<?php bloginfo('charset'); ?>">
    <?php wp_head(); ?>
    <!--    <link rel="icon" type="image/png" href="/path/image.png" />-->
</head>

<body>
    <main>
        <header class="site-header">
            <a href="<?php echo home_url(); ?>">
                <?php dynamic_sidebar('titlebar') ?>
            </a>
            <nav class="site-nav">
                <?php wp_nav_menu(array("theme_location"=>"primary")); ?>
            </nav>
            <nav class="c"></nav>
        </header>
