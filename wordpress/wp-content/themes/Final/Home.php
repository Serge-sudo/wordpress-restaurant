<?php get_header(); ?>
<?php get_template_part('slide'); ?>
<div class="container" id="menu">

    <div class="men">
        <?php 

if(have_posts()){
    while(have_posts()){
        the_post();
      $categ = get_the_category(); 
     if($categ[0]->cat_name == "News" || $categ[0]->cat_name == "նՈՐՈՒԹՅՈՒՆՆԵՐ" || $categ[0]->cat_name == null) continue; 
        ?>

        <article class="post n">
            <a href="<?php  the_permalink(); ?>">
                <?php the_post_thumbnail("norm"); ?>
                <div class="exc n">
                    <?php the_excerpt();  ?>
                </div>
                <div class="titlearea n">
                    <h2 class="titleofpost n">

                        <?php the_title(); ?>

                    </h2>
                </div>


            </a>
        </article>
        <?php 
} 
}
?>
        <nav class="c"></nav>
    </div>
    <?php get_footer(); ?>
