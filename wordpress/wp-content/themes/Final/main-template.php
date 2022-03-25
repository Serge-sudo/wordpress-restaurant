<?php /* Template Name: Main */ ?>
<?php get_header(); ?>
<?php get_template_part('slide'); ?>
<div class="container">

<?php 

if(have_posts()){
    while(have_posts()){
        the_post();
        ?>

<article class="post vid">

    <div class="cont">
        <?php the_content();  ?>
    </div>
</article>
<?php 
} 
}
?>
<?php get_footer(); ?>
