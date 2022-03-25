<?php get_header(); ?>
<?php get_template_part('slide'); ?>
<div class="container">

    <?php 

if(have_posts()){
    while(have_posts()){
        the_post();
        
        ?>

    <article class="post sin">
        <div class="titlearea">
            <h2 class="titleofpost">
                <?php the_title(); ?>
            </h2>
        </div>

        <p class="post-info">
            <?php the_time("d.m.Y"); ?>|
            <?php 
        $cat = get_the_category();
        foreach($cat as $key){
            $link=get_category_link($key->term_id);
            echo "<a href='$link'>".$key->name."</a>";
        }
        
        ?>
        </p>
        <br>
        <div class="cont">
            <?php the_content();  ?>
            <nav class="c"></nav>
        </div>
    </article>
    <?php 
} 
}
?>
    <?php get_footer(); ?>
