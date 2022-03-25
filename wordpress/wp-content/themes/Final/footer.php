<nav class="c"></nav>
</div>
<footer class="site-footer">
    <div class="ftop">
        <div class="flef">
            <?php dynamic_sidebar('footer1')?>
        </div>
        <div class="frig">
            <?php dynamic_sidebar('footer2')?>
            <div class="hd-search">
                <?php get_search_form() ?>
            </div>
        </div>

    </div>
    <nav class="c"></nav>
    <div class="fbottm">
        <p>
            Copyright &copy;
            <?php bloginfo('name'); ?>
            <?php echo date('Y'); ?> All Rights Reserved
        </p>

        <nav class="fotmenu">
            <?php wp_nav_menu(array("theme_location"=>"footer")); ?>
        </nav>
        <nav class="c"></nav>

    </div>

</footer>

<?php wp_footer(); ?>

</main>
</body>

</html>
