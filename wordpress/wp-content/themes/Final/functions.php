<?php 
function connect_resources(){
    wp_enqueue_style('style',get_stylesheet_uri());
}
    
add_action('wp_enqueue_scripts','connect_resources');

function custom_theme_setup(){
    add_image_size("norm",300,225,false);
    add_theme_support('post-thumbnails');
    register_nav_menus(array(
        'primary' => __('Primary menu'),
        'footer' => __('Footer menu')
));
}

add_action('after_setup_theme','custom_theme_setup');

function new_excerpt_length($length) {
	return 30;
}
add_filter('excerpt_length', 'new_excerpt_length');

function widgetInit(){
    register_sidebar(array(
        "id"=> "titlebar",
        "name" => "titlebar",
        "before_widget" => "<div class=''>",
        "after_widget" => "</div>"
    ));
    register_sidebar(array(
        "id"=> "sidebar1",
        "name" => "Sidebar",
        "before_widget" => "<div class=''>",
        "after_widget" => "</div>"
    ));
    register_sidebar(array(
        "id"=> "footer1",
        "name" => "footer 1",
        "before_widget" => "<div class=''>",
        "after_widget" => "</div>"
    ));
    register_sidebar(array(
        "id"=> "footer2",
        "name" => "footer 2",
        "before_widget" => "<div class=''>",
        "after_widget" => "</div>"
    ));
    
}
add_action("widgets_init",'widgetInit');
?>
