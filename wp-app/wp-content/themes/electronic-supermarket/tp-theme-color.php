<?php

$electronic_supermarket_tp_theme_css = '';

//theme-color
$electronic_supermarket_tp_color_option = get_theme_mod('electronic_supermarket_tp_color_option');

if($electronic_supermarket_tp_color_option != false){
$electronic_supermarket_tp_theme_css .='.main-navigation .menu > ul > li.highlight, .box:before,.box:after,a.added_to_cart.wc-forward,.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button,.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt,a.added_to_cart.wc-forward,.page-numbers,.prev.page-numbers,.next.page-numbers,span.meta-nav,#theme-sidebar button[type="submit"],#footer button[type="submit"],#comments input[type="submit"],.site-info,.book-tkt-btn a.register-btn,.toggle-nav i, #return-to-top,.error-404 [type="submit"],#slider h6,.news-detail:after,.newsletter_shortcode input[type="submit"],.innermenuboxupper,#slider .carousel-control-prev-icon, #slider .carousel-control-next-icon,.more-btn a:hover,.readmore-btn a,.main-navigation a:hover,.main-navigation .current-menu-item > a,.woocommerce ul.products li.product .onsale, .woocommerce span.onsale{';
$electronic_supermarket_tp_theme_css .='background-color: '.esc_attr($electronic_supermarket_tp_color_option).';';
$electronic_supermarket_tp_theme_css .='}';
}

if($electronic_supermarket_tp_color_option != false){
$electronic_supermarket_tp_theme_css .='a,#theme-sidebar .textwidget a,#footer .textwidget a,.comment-body a,.entry-content a,.entry-summary a,.page-template-front-page .media-links a:hover,.topbar-home i.fas.fa-phone-volume,#theme-sidebar h3,.page-box h4 a,.readmore-btn a,.box-content a ,.woocommerce-message::before ,.logo a, .logo p ,.wp-block-search .wp-block-search__label,#theme-sidebar h2.wp-block-heading,.timebox i,#slider .carousel-control-prev-icon:hover, #slider .carousel-control-next-icon:hover,#footer h3,#slider .carousel-control-prev-icon:hover, #slider .carousel-control-next-icon:hover,.more-btn a,#theme-sidebar li a:hover, #footer li a:hover,post_tag :hover,#theme-sidebar .tagcloud a:hover,#footer .tagcloud a:hover, #theme-sidebar .widget_tag_cloud a:hover  {';
$electronic_supermarket_tp_theme_css .='color: '.esc_attr($electronic_supermarket_tp_color_option).';';
$electronic_supermarket_tp_theme_css .='}';
}
if($electronic_supermarket_tp_color_option != false){
$electronic_supermarket_tp_theme_css .='.main-navigation .current_page_item > a,.wp-block-quote:not(.is-large):not(.is-style-large),.product-search input,#theme-sidebar .tagcloud a:hover,#footer .tagcloud a:hover, #theme-sidebar .widget_tag_cloud a:hover {';
	$electronic_supermarket_tp_theme_css .='border-color: '.esc_attr($electronic_supermarket_tp_color_option).';';
$electronic_supermarket_tp_theme_css .='}';
}
if($electronic_supermarket_tp_color_option != false){
$electronic_supermarket_tp_theme_css .='.woocommerce-message {';
$electronic_supermarket_tp_theme_css .='border-top-color: '.esc_attr($electronic_supermarket_tp_color_option).';';
$electronic_supermarket_tp_theme_css .='}';
}

//preloader

$electronic_supermarket_tp_preloader_color1_option = get_theme_mod('electronic_supermarket_tp_preloader_color1_option');
$electronic_supermarket_tp_preloader_color2_option = get_theme_mod('electronic_supermarket_tp_preloader_color2_option');
$electronic_supermarket_tp_preloader_bg_color_option = get_theme_mod('electronic_supermarket_tp_preloader_bg_color_option');

if($electronic_supermarket_tp_preloader_color1_option != false){
$electronic_supermarket_tp_theme_css .='.center1{';
	$electronic_supermarket_tp_theme_css .='border-color: '.esc_attr($electronic_supermarket_tp_preloader_color1_option).' !important;';
$electronic_supermarket_tp_theme_css .='}';
}
if($electronic_supermarket_tp_preloader_color1_option != false){
$electronic_supermarket_tp_theme_css .='.center1 .ring::before{';
	$electronic_supermarket_tp_theme_css .='background: '.esc_attr($electronic_supermarket_tp_preloader_color1_option).' !important;';
$electronic_supermarket_tp_theme_css .='}';
}
if($electronic_supermarket_tp_preloader_color2_option != false){
$electronic_supermarket_tp_theme_css .='.center2{';
	$electronic_supermarket_tp_theme_css .='border-color: '.esc_attr($electronic_supermarket_tp_preloader_color2_option).' !important;';
$electronic_supermarket_tp_theme_css .='}';
}
if($electronic_supermarket_tp_preloader_color2_option != false){
$electronic_supermarket_tp_theme_css .='.center2 .ring::before{';
	$electronic_supermarket_tp_theme_css .='background: '.esc_attr($electronic_supermarket_tp_preloader_color2_option).' !important;';
$electronic_supermarket_tp_theme_css .='}';
}
if($electronic_supermarket_tp_preloader_bg_color_option != false){
$electronic_supermarket_tp_theme_css .='.loader{';
	$electronic_supermarket_tp_theme_css .='background: '.esc_attr($electronic_supermarket_tp_preloader_bg_color_option).';';
$electronic_supermarket_tp_theme_css .='}';
}

// footer-bg-color
$electronic_supermarket_tp_footer_bg_color_option = get_theme_mod('electronic_supermarket_tp_footer_bg_color_option');

if($electronic_supermarket_tp_footer_bg_color_option != false){
$electronic_supermarket_tp_theme_css .='#footer{';
	$electronic_supermarket_tp_theme_css .='background: '.esc_attr($electronic_supermarket_tp_footer_bg_color_option).' !important;';
$electronic_supermarket_tp_theme_css .='}';
}