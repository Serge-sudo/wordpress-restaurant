<?php get_header(); ?>
<?php get_template_part('slide'); ?>
<div class="container">
<?php 

if(have_posts()){
    while(have_posts()){
        the_post();
        
        ?>

<article class="post">
    <div class="titlearea">
        <h2 class="titleofpost">
            <?php the_title(); ?>
        </h2>
    </div>
    <div class="cont">
        <?php the_content();  ?>
    </div>
</article>
<?php 
} 
}
?>
<?php get_footer(); ?>
