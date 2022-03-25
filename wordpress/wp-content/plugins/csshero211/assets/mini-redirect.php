<?php

setcookie('csshero_is_on', 0, time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false); //may 2016

//redirect to current url, without parameters
if (is_ssl() ) $secure_s="s"; else  $secure_s="";
$redirect_url = "http".$secure_s."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$redirect_url_array=explode("?",$redirect_url);
$redirect_url=$redirect_url_array[0];
if (isset($_GET['cat'])) $redirect_url.="?cat=".$_GET['cat'];
if (isset($_GET['p'])) $redirect_url.="?p=".$_GET['p'];
if (isset($_GET['page_id'])) $redirect_url.="?page_id=".$_GET['page_id'];
wp_redirect($redirect_url);


exit;
