<?php get_header(); ?>
<?php get_template_part('slide'); ?>
<div class="container">

<?php 
if(have_posts()){
    while(have_posts()){
        the_post();
        ?>
<article class="post">
    <div class="contact">
        <?php the_content();  ?>
    </div>
    <div class="map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d762.1266050038902!2d44.510313326382985!3d40.175541953076895!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x406abcf83c5e76df%3A0xf56d1ad5d6cfb23d!2z0KDQtdGB0YLQvtGA0LDQvSDQuCDQkdCw0YAg0JzQvtC30LDQuNC6!5e0!3m2!1sru!2sus!4v1513960941861" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
    </div>
</article>
<?php 
} 
}
?>
<?php get_footer(); ?>
