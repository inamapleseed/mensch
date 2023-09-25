


<style>
        /* ============================ Theme Base ============================*/
    /* Main Slider */
    /* parrallax */

    <?php if($config_parallax_slider) { ?>
            body.common-home .section-space.slideshow .owl-carousel{
                position: fixed;
                top:auto;    
                left: 0;
            } 
            @media (max-width: 991px){
                body.common-home .section-space.slideshow .owl-carousel{
                    position: relative;
                } 
            }
            /* body .section-space.slideshow + .section-space {
                margin-top: calc((800 /19.2) * 1vw)!important;
            } */
            body .section-space:not(.slideshow) {
                z-index: 1;
                position: relative;
                background-color: #fff;;
            }
    <?php  } ?>
    body{
        <?php if($config_background_image){ ?>
            background-image:url("image/<?= $config_background_image; ?>");
        <?php } ?>
        <?= $config_background_style; ?>
    }

    /* Section Padding */
    body .section-space:not(.slideshow.max-offset) {
        padding:calc(<?= $config_section_padding ?>/19.2 * 1vw) 0!important;
    }
    /* Header Letter Case */
    .header-container .header-menu #main-menu>li>a {
        text-transform: <?=$config_header_letter_case;?>!important;
    }

    /* Main Banner Related */
    /* dots */
    .slick-dots li button:before {
        display:none
    }
    .slick-dots {
        padding-left:0;
        text-align: center;
    }
    .slick-dots >* {
        list-style:none;
        display: inline-block;
        margin: 0px 3px 5px;
    }
    .slick-dots li {
        width: auto!important;
        height:auto!important
    }
    body .slideshow .slider-custom-dots .owl-dot{
        list-style:none;
        display: inline-block;
        width: 30px;
        height:5px;
        background:#ccc;
        margin: 10px 7px;
    }
    .slick-dots li button {
        width: 10px!important;
        border-radius: 50%;
        height: 10px!important;
        font-size: 0!important;
        border:none!important;
        padding:0!important;
        background:#000!important;
        margin-right: 8px;
    }
    .slick-dots .slick-active button, body .slideshow .slider-custom-dots.active .owl-dot{
        /* background:#000!important; */
    } 
    .slider-slideshow-description .slider-slideshow-description-texts {
        position: relative;
    }
    body .slider-slideshow-description .slider-slideshow-description-texts .slideshow-text-0 {
        font-size: calc(20px + 2vw) !important;
        font-weight: bold;
        color:#000;
        margin-bottom:1vw;
    }

    body .slider-slideshow-description .slider-slideshow-description-texts .slideshow-text-1 {
        font-size: calc(16px + .520833333vw) !important;
        font-weight: bold;
        margin-bottom:1vw;
    }
    
    .slideshow .slider-custom-dots {
        text-align: left;
        padding: 0px calc(10% + 45px)!important;
        margin: 0 auto;
    }

    body .slideshow .light_image .banner-overlay {
        position:absolute;
        top:0;
        bottom:0;
        left:0;
        right:0;
    } 
    body .slideshow .slider-custom-dots .owl-dot.active {
        background: <?= $config_primary_color ?>!important;
    }
    body .slideshow .light_image .banner-overlay {
        /* background:rgba(255, 255, 255,0.4); */
    } 
    @media (min-width:992px) { 
        body .slideshow .light_image .banner-overlay { 
            display:none;
        }
    }

    body .slideshow .dark_image .banner-overlay {
        background:rgba(0, 0, 0,0.4);
    } 
    body .line {
        top: calc((20px + 4vw) * -1);
        height: 0vh;
        width: 2px;
        background: #000;
        left: 32px;
        opacity: 0;
        position: absolute;
        -webkit-transition: height 300ms cubic-bezier(0.470, 0.000, 0.745, 0.715);
        -moz-transition: height 300ms cubic-bezier(0.470, 0.000, 0.745, 0.715);
        -o-transition: height 300ms cubic-bezier(0.470, 0.000, 0.745, 0.715);
        transition: height 300ms cubic-bezier(0.470, 0.000, 0.745, 0.715);
    }
    body .line.animate {
        opacity: 1;
        height: calc(20px + 4vw)
    }

    .slideshow .fa {
        color:#000;
    }

    body .slider-custom-dots {
        bottom:5%;
    }
    #ToTop:before {
        color:  <?= $config_primary_color ?>!important;
    }
    #ToTop {
        border-radius: 50%;
        background: <?= $config_secondary_color ?>!important;
        /* border:3px solid #000; */
    }
    
  /* ============================ Header Settings ============================*/
    <?php if($config_header_layout == 'layout_2')  { ?>
        @media (min-width:767px) { 
            body .header-container {
                grid-template-columns: 15% 1fr auto;
            } 
        }
        @media (min-width:992px) { 
            body .header-container {
                grid-template-columns: 20% 1fr auto;
            }
            body .header-container .header-top{
                -ms-grid-column: 3;
                grid-column: 3 / 3;
                -ms-grid-row: 1;
                -ms-grid-row-span: 2;
                grid-row: 1 / 3;
            }
            body .header-container .header-logo {
                -ms-grid-column: 1;
                grid-column: 1 / 1;
                -ms-grid-row: 1;
                -ms-grid-row-span: 2;
                grid-row: 1 / 3;
            }
            body .header-container .header-menu {
                -ms-grid-column: 2;
                -ms-grid-column-span: 1;
                grid-column: 2 / 3;
                -ms-grid-row: 1;
                -ms-grid-row-span: 2;
                grid-row: 1 / 3;
                /* justify-content: center; */
                align-items:center;
            }
        }
        @media (min-width:1200px) { 
            body .header-container {
                grid-template-columns: 15% 1fr auto;
            }
        }
    <?php } ?>

 /* ============================ Footer Settings ============================*/

    .footer-bottom { 
        background-color: <?= $config_footer_bottom_background_color; ?> !important; 
        color: <?= $config_footer_bottom_text_color; ?> !important; 
    }
    .footer-bottom p { 
         color: <?= $config_footer_bottom_text_color; ?> !important;    
    }
    .footer-bottom a, .footer-bottom a:hover{ 
         color: <?= $config_footer_bottom_link_color; ?> !important; 
    }

    footer h5 {
        color:<?= $text_footer_heading_color; ?> !important; 
        /* font-size:<?= $text_footer_heading_size; ?>px !important;  */
        font-family:<?= $text_footer_heading_font; ?> !important; 
        text-transform:uppercase;
    } 

    footer {
        background-color: <?= $config_footer_background_color; ?> !important; 
        color:<?= $config_footer_text_color; ?> !important; 
    }

    footer a {
        color:<?= $config_footer_link_color; ?> !important; 
    }
    
    footer a:hover {
        text-decoration: underline;
        color:<?= $config_footer_link_hover_color; ?> !important; 
    }

    /* ============================ Color Settings ============================*/

    body .search-custom .search-box {
        border:1px solid <?= $config_primary_color ?>!important;
    }

    body input:focus,  body textarea:focus{  border:1px solid <?= $config_primary_color ?>!important }
    
    /* theme color */
    <?php if($config_primary_color) { ?>
        .account-container div .icon-font {
            background: <?= $config_primary_color ?>!important;
        }
        .information-faq .panel-title>a{
            background: <?= $config_primary_color ?>!important;
            color:<?= $config_secondary_color ?> !important; 
        }
        /* primary color */
        .account-container a:hover, .account-container a:focus,  .account-container a.active {
            background: <?= $config_primary_color ?>!important;
            color:<?= $config_secondary_color ?> !important; 
        } 

        .header-top svg path {
            fill:<?= $config_primary_color ?> !important; 
        }
        .header-top  #wishlist-total .fa {
           color:<?= $config_primary_color ?> !important; 
        }

        body  .account-container a:hover .icon-font:before, body .account-container a:focus .icon-font:before, body .account-container a:focus h4, body .account-container a:hover p, .account-container a.active .icon-font:before, .account-container a.active p,  body .account-container a.active h3{
            color:<?= $config_secondary_color ?> !important; 
        }

        .login-header .btn.active {
            background: <?= $config_primary_color ?>!important;
            color:#fff!important
        } 
        .bootstrap-datetimepicker-widget td.active, .bootstrap-datetimepicker-widget td.active:hover {
            background: <?= $config_primary_color ?>!important;
            color: #fff;
            text-shadow: 0 -1px 0 rgb(0 0 0 / 25%);
        } 
        .product-product #product-tabs li a:hover:before, .product-product #product-tabs li.active a:before {
            content: '';
            width: 69%;
            margin: 1px auto;
            display: block!important;
            position: absolute;
            left: 0%;
            right: 0;
            bottom: 5px;
            height: 2px;
            text-decoration:none;
            background: <?= $config_secondary_color ?>!important 
        }
        .testimonial_layout_1 .testimonial-placeholder {
            background-color: <?= $config_primary_color ?>!important; 
        }

        .store_layout_2 .location .overlay:after {
            border-color: <?= $config_primary_color ?>!important 
        }

        .hover-overlay .to-overlay {
           background: rgba(<?= $primary_color_rgb ?>, 0.5)!important;
        }
        
        .account-account .account-container a:hover, .account-account .account-container a:focus {border: 1px solid <?= $config_secondary_color; ?> !important;}
        .account-account .account-container a:hover .icon-font:before, .account-account .account-container a:focus .icon-font:before {color: <?= $config_secondary_color; ?> !important;}

        .primary-color, a:hover, a:focus { color: <?= $config_primary_color ?> }
        .primary-color-bg { background-color: <?= $config_primary_color ?> }

        /* body .btn-primary:not(.btn-mi), */
        body .cart-buttons .btn-primary:not(.btn-mi), .swal2-popup .swal2-styled.swal2-confirm,   
        body .slider-slideshow-description .slider-slideshow-description-texts .btn.btn-primary { 
            /* background-color: <?= $config_primary_button_background_color ?> !important;  */
            border:  <?= $config_button_border_width ?>px solid <?= $config_primary_button_border_color ?> !important; 
            color:<?= $config_primary_button_text_color ?> !important; 
        }

        body .btn-default:not(.btn-mi),
        body .cart-buttons .btn-default:not(.btn-mi) { 
            background-color: <?= $config_secondary_button_background_color ?> !important; 
            border: <?= $config_button_border_width ?>px solid <?= $config_secondary_button_border_color ?> !important; 
            color:<?= $config_secondary_button_text_color ?> !important; 
        }
        body .btn-primary:not(.btn-mi),
        body .cart-buttons .btn-primary:not(.btn-mi) { 
            border-radius:<?=$config_button_border_radius;?>px;
        }

        body[class*="account-"] .btn,
        .cart-dorpdown-footer .btn {
            border-radius:<?=$config_button_border_radius;?>px;
        }
        
        body .btn-primary:not(.btn-mi):hover,
        body .cart-buttons .btn-primary:not(.btn-mi):hover,
        body .cart-buttons .btn-primary:not(.btn-mi):focus,  
        body .btn-primary:not(.btn-mi):focus, 
        body .cart-buttons .btn-primary:not(.btn-mi):hover:active,  
        body .btn-primary:not(.btn-mi):hover:active,
        .swal2-popup .swal2-styled.swal2-confirm:hover,
        body .slider-slideshow-description .slider-slideshow-description-texts .btn.btn-primary:hover { 
            background-color: <?= $config_primary_button_background_color ?> !important; 
            opacity:0.7;
            /* border-color: <?= $config_secondary_color ?> !important;  */
            color:<?= $config_primary_button_text_color ?> !important; 
        }

        body .btn-default:not(.btn-mi):hover,
        body .cart-buttons .btn-default:not(.btn-mi):hover,
        body .cart-buttons .btn-default:not(.btn-mi):focus,  
        body .btn-default:not(.btn-mi):focus, 
        body .cart-buttons .btn-default:not(.btn-mi):hover:active,  
        body .btn-default:not(.btn-mi):hover:active
        { 
            background-color: <?= $config_primary_button_background_color ?> !important; 
            opacity:0.8;
            /* border-color: <?= $config_secondary_color ?> !important;  */
            color:<?= $config_primary_button_text_color ?> !important; 
        }

        .header-container #enquiry>a .badge, .header-container #cart>a .badge {
            background-color: <?= $config_primary_color ?> !important; 
            color:<?= $config_secondary_color ?> !important; 
        }
        @keyframes  pulse1{
            0%{
                box-shadow:0 0 0 0 rgba(<?= $primary_color_rgb ?>, 0.4);
            }
            70%{
                box-shadow:0 0 0 15px rgba(<?= $primary_color_rgb ?>, 0);
            }
            100%{
                box-shadow:0 0 0 0 rgba(<?= $primary_color_rgb ?>, 0);
            }
        }


        .pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, .pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span:hover {
            background-color: <?= $config_primary_color ?> !important; 
            border-color: <?= $config_primary_color ?> !important; 
            color:<?= $config_secondary_color ?> !important; 
        }

        .pagination li a:hover, .pagination li span:hover {
            background-color: <?= $config_primary_color ?> !important; 
            border-color: <?= $config_primary_color ?> !important; 
            color:<?= $config_secondary_color ?> !important; 
        }
<?php } ?>



    /* ============================ Font Settings ============================*/

    /* Main Heading */
    body:not(.cke_editable) h2:not(.swal2-title):not([style]) {
        font-size:calc( (<?= $text_h2_size ?>px /1.5 ) + (((<?= $text_h2_size ?>/3)/19.2) * 1vw))!important;
        text-transform: <?=$config_h2_letter_case;?>!important;
        color:<?= $text_h2_color ?>!important;
        /* font-family: <?= $text_h2_font ?> !important; */
    }
    
    body:not(.cke_editable) h2:not(.swal2-title):not([style])::after, body:not(.cke_editable) h2:not(.swal2-title):not([style])::before{
        <?php if($h2_image){ ?>
            background-image:url("image/<?= $h2_image; ?>");
        <?php } ?>
        <?= $h2_style; ?>
    }

    body:not(.cke_editable) h2:not(.swal2-title):not([style])::before {
        content: '';
        width: 48px;
        height: 5px;
        display: block;
        margin: 0px auto 10px;
    }

    body:not(.cke_editable) h2:not(.swal2-title):not([style])::after {
        display: none!important;
    }

    /* product-title, secondary heading(h3) */
    body h3, #filter-groups .item-header{
        color:<?= $text_h3_color ?>!important;
        <?php if($theme_default_product_category_layout_setting == 1){ ?>
            font-size:calc( (<?= $text_h3_size ?>px / 1.5) + (((<?= $text_h3_size ?>/3)/19.2) * 1vw))!important;
            font-family: <?= $text_h3_font ?> !important;
        <?php } ?>
        text-transform: <?=$config_h3_letter_case;?>!important;
    }
    
    h3.product-title::before {
        background-color: <?= $config_secondary_color ?>!important 
    }


    /* body */
    body, p{
        font-size:calc( (<?= $text_body_size ?>px / 1.1) + (((<?= $text_body_size ?>/11)/19.2) * 1vw))!important;
        color:<?=$text_body_color;?>!important;
        /* font-family: <?= $text_body_font ?> !important; */
        font-weight: 500;
        line-height:1.5em!important;
    }
    /* @media (max-width:991px) { 
        body, p{
          font-size:calc( (<?= $text_body_size ?>px / 1.5) + (((<?= $text_body_size ?>/3)/9.91) * 1vw))!important;
        }
    }
    @media (max-width:767px) { 
        body, p{
            font-size:calc( (<?= $text_body_size ?>px / 1.5) + (((<?= $text_body_size ?>/3)/7.67) * 1vw))!important;
        }
    } */


    a {
        color: <?= $text_link_color ?>!important;
    }
    a:hover {
        color: <?= $text_link_hover_color ?>!important;
    }
        
    .text_menu_color, .header-container .header-menu #main-menu > li{ 
        color: <?= $text_menu_color ?> !important; 
    }
    .text_menu_hover_color, 
    .fixed-header .header-container .header-menu #main-menu > li.active a, 
    .fixed-header .header-container .header-menu #main-menu > li:hover a {
        color: <?= $text_menu_hover_color ?> !important;
    }

    /* Popup Search */
    #fullpage-search .search-box {
        max-width: 1200px;
        width:80%;
    }

    /* Header Menu */

    .text_menu_font, .header-container .header-menu #main-menu li, .header-container .header-menu #main-menu li a {
        <?php if($text_menu_size) { ?>
            font-size:calc( (<?= $text_menu_size ?>px / 1.1) + (((<?= $text_menu_size ?>/11)/19.2) * 1vw))!important;
        <?php } ?>
    }
    /* Responsive font */

/* ============================ Product Related ============================*/
     /* wishlist */
    .product-wishlist .fa {
        color: <?= $config_primary_color ?> !important; 
    }
    .product-block{
        background:#<?= $theme_default_product_box_background; ?>!important;
        border:<?= $theme_default_product_box_border; ?>!important;
    }
    .product_countdown_box > div {
        background-color: <?= $config_primary_color ?>!important 
    }
/* 
    @media (min-width:541px) { 
        body:not(.cke_editable) h2:not(.swal2-title):not([style]) {
            font-size:calc(<?= $text_h2_size ?>/7.67 * 1vw)!important;
        }
    }
    @media (min-width:768px) { 
        body:not(.cke_editable) h2:not(.swal2-title):not([style]) {
            font-size:calc(<?= $text_h2_size ?>/11 * 1vw)!important;
        }
    }
    @media (min-width:992px) { 
        body:not(.cke_editable) h2:not(.swal2-title):not([style]) {
            font-size:calc(<?= $text_h2_size ?>/19.2 * 1vw)!important;
        }
    } */


    /* checkout facebook button */
    body .dsl-button, body .dsl-button:hover {
        color:#fff!important;
    }

    ul.custom-tabs > li {
        padding:0 5px;
    }

    ul.custom-tabs > li a {
        border: 2px solid #000!important; 
        padding:10px 2vw;
    }
    ul.custom-tabs > li a:hover, ul.custom-tabs > li.active a {
        background: #000!important; 
        color:#fff !important; 
    }

    .testimonial_layout_2 .testimonial .fa-quote-right {
        color: <?= $config_primary_color ?>!important 
    }



    /* dropdown fix */
    .fixed-header .header-container .header-menu #main-menu li > ul > li a {
        background-color: transparent !important;
    }
    .fixed-header .header-container .header-menu #main-menu li > ul > li {
        margin-right: 0 !important;
    }
    .fixed-header .header-container .header-menu #main-menu li > ul > li.active a,
    .fixed-header .header-container .header-menu #main-menu li > ul > li:not(.active) a {
        color: #000 !important;
        border-radius: 0px !important;
    }
    .fixed-header .header-container .header-menu #main-menu li > ul {
        background-color:#fff;
    }
    
    .fixed-header .header-container .header-menu #main-menu li > ul > li.active a,
    .fixed-header .header-container .header-menu #main-menu li > ul > li:not(.active) a:hover {
        background-color: <?= $config_primary_color ?> !important;
        color: <?= $text_submenu_hover_color ?> !important;
    }
    /* dropdown fix */
    .text_category_menu_color, .sticky-wrap .category-container .wrapper ul > li > a {
        color: <?= $text_category_menu_color ?> !important;
    }
    .text_category_menu_hover_color, .sticky-wrap .category-container .wrapper ul > li > a.active, .sticky-wrap .category-container .wrapper ul > li:hover > a {
        color: <?= $text_category_menu_hover_color ?> !important;
    }
    .text_h2_color, .ctgr-title h3, body:not(.cke_editable) h2:not(.swal2-title):not([style]){
        color: <?= $text_h2_color ?> !important;
    }
    .text_h3_color, .cart-header-text,  .text-color-primary  {
        color: <?= $text_h3_color ?> !important;
    }
    /* .text_p_light_color, body .cart-buttons .btn-primary:not(.btn-mi), #enquiry .btn-primary, #cart .btn-primary {
        color: <?= $text_p_light_color ?> !important;
    } */
    .text_p_dark_color {
        color: <?= $text_p_dark_color ?> !important;
    }
    .text_product_title_color, #product-filter-detect .product-gutter .product-block .product-name .product-title {
        color: <?= $text_product_title_color ?> !important;
    }
    .text_p_theme_color, p{
        color: <?= $text_body_color ?> !important;
    }
    footer .text_p_theme_color, footer p{
        color: <?= $config_footer_text_color ?> !important;
    }
    
    /* Font Family */
    /* .text_menu_font, .header-container .header-menu #main-menu li { font-family: <?= $text_menu_font ?> !important; } */
    .text_category_menu_font, .sticky-wrap .category-container .wrapper ul li a, body #side-categories .group .item a, body #side-manufacturer label, body #side_filter label{
        font-family: <?= $text_category_menu_font ?> !important;
        color: <?= $text_category_menu_color ?> !important;
    }
    
    /* .text_menu_hover_font, .fixed-header .header-container .header-menu #main-menu li.active a, .fixed-header .header-container .header-menu #main-menu li:hover a {
        font-family: <?= $text_menu_hover_font ?> !important;
    } */
/*     
    .text_menu_hover_font, .fixed-header .header-container .header-menu #main-menu li.active ul a, .fixed-header .header-container .header-menu #main-menu ul li:hover a {
        font-family: <?= $text_submenu_hover_font ?> !important;
    }
   
    /* .text_category_menu_hover_font, .sticky-wrap .category-container .wrapper ul li a.active, .sticky-wrap .category-container .wrapper ul li:hover a {
        font-family: <?= $text_category_menu_hover_font ?> !important;
    } */
    .text_h2_font, .ctgr-title h3 { 
        font-family: <?= $text_h2_font ?> !important;
    }
    .text_h3_font , .cart-header-text{
        font-family: <?= $text_h3_font ?> !important;
    }
    .text_p_light_font, body .cart-buttons .btn-primary:not(.btn-mi), #enquiry .btn-primary, #cart .btn-primary {
        font-family: <?= $text_p_light_font ?> !important;
    }
    .text_p_dark_font {
        font-family: <?= $text_p_dark_font ?> !important;
    }
    .text_product_title_font, #product-filter-detect .product-gutter .product-block .product-name .product-title {
        font-family: <?= $text_product_title_font ?> !important;
    }
    .text_p_theme_font {
        font-family: <?= $text_p_theme_font ?> !important;
    }
/* 
    .cart-dorpdown-footer .btn.btn-primary {
        font-size: 10px !important;
    } */


    /* article */
 

    /* .text_menu_hover_font, .fixed-header .header-container .header-menu #main-menu li.active a, .fixed-header .header-container .header-menu #main-menu li:hover a {
        <?php if($text_menu_hover_size) { ?>
            font-size: <?= $text_menu_hover_size ?>px !important;
        <?php } ?>
    } */
    .text_category_menu_font, .sticky-wrap .category-container .wrapper ul li a,body #side-categories .group .item a, body #side-manufacturer label,body #side_filter label{
        <?php if($text_category_menu_size) { ?>
            font-size: <?= $text_category_menu_size ?>px !important;
        <?php } ?>
    }
    .text_category_menu_hover_font, .sticky-wrap .category-container .wrapper ul li a.active, .sticky-wrap .category-container .wrapper ul li:hover a {
        <?php if($text_category_menu_hover_size) { ?>
            font-size: <?= $text_category_menu_hover_size ?>px !important;
        <?php } ?>
    }

    .text_p_light_font {
        <?php if($text_p_light_size) { ?>
            font-size: <?= $text_p_light_size ?>px !important;
        <?php } ?>
    }
    .text_p_dark_font {
        <?php if($text_p_dark_size) { ?>
            font-size: <?= $text_p_dark_size ?>px !important;
        <?php } ?>
    }
    .text_product_title_font, #product-filter-detect .product-gutter .product-block .product-name .product-title {
        <?php if($text_product_title_size) { ?>
            font-size: <?= $text_product_title_size ?>px !important;
        <?php } ?>
    }
    .text_p_theme_font {
        <?php if($text_p_theme_size) { ?>
            font-size: <?= $text_p_theme_size ?>px !important;
        <?php } ?>
    }



    /*casper*/

    <?php if($theme_default_product_category_layout_setting == 1){ ?>

        .product-category .item-header{
            font-size:24px;
            padding: 15px 0!important;
        }
        .product-category .list-group-item{
            color:<?= $text_h2_color ?>;
            font-weight: bold;
            padding:0;
            background-color:transparent;
        }
        #side_filter.panel{
            background-color:transparent;
        }
        #side-manufacturer .list-group-item:not(.item-header) {
            padding: 0!important;
        }
        /*.product-category .list-group-item label,
        .product-category .list-group label{
            color:#6c6c6c;
        }
        .product-category #side-categories .side-categories-level-1+.side-categories-level-1 {
            border-top: 0;
        }*/
        #side-categories .group .item.active+.sub {
            border-top: 0!important;
        }
        #side-categories .group .item .toggle {
            border-left: 0!important;
        }
        /*#side-categories .group:not(:last-child) {
            border-bottom: 0!important;
        }*/


        #side-categories .caret, #articles-column-left .list-group-item .toggle .caret {
            display: none;
        }
    
        .product-category .side-categories-level-1 .item.level-1,
        .product-category .side-categories-level-1 .item.level-2{
            border:<?= $theme_default_product_category_level_one_border; ?>!important;
        }

        #side-categories .level-1.pointer:after,
        #side-categories .level-2.pointer:after,
        #side-categories .level-3.pointer:after,
        #articles-column-left .news-ctgr .list-group-item .toggle:after {
            content: '\f067';
            font-family: 'FontAwesome';
            color:#<?= $theme_default_product_category_text_level_one; ?>;
            font-size: 14px;
            position: absolute;
            right: 20px;
            top: 25%;
            color: #000;
            -webkit-transition: all 0.3s;
            -o-transition: all 0.3s;
            transition: all 0.3s;
            -webkit-transform: rotate(-90deg);
            -ms-transform: rotate(-90deg);
            transform: rotate(-90deg);
        }

        #side-categories .item.level-1:hover .item.level-1.pointer:after,
        #side-categories .item.level-2:hover .item.level-2.pointer:after,
        #side-categories .item.level-3:hover .item.level-3.pointer:after {
            color:#<?= $theme_default_product_category_text_level_one_hover; ?>!important;
        }

        #side-categories .item.level-1.active .item.level-1.pointer:after,
        #side-categories .item.level-2.active .item.level-2.pointer:after,
        #side-categories .item.level-3.active .item.level-3.pointer:after,
        #articles-column-left .news-ctgr .list-group-item.active .toggle:after {
            content: '\f068';
            color:#<?= $theme_default_product_category_text_level_one_hover; ?>!important;
            -webkit-transition: all 0.3s;
            -o-transition: all 0.3s;
            transition: all 0.3s;
            -webkit-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        #side-categories .group:not(:last-child) {
            border-bottom: 0!important;
        }
        /*level 1*/
        .product-category .side-categories-level-1 .group>.level-1 a{
            padding: <?= $theme_default_product_category_level_one_padding; ?>!important;
        }

        #side-categories .item.level-1{
            background-color:#<?= $theme_default_product_category_level_one; ?>;
            margin: <?= $theme_default_product_category_level_one_margin; ?>!important;
            border-radius:<?= $theme_default_product_category_level_one_radius; ?>!important;
            outline:none;
        }
        #side-categories .item.level-1 a{
            color:#<?= $theme_default_product_category_text_level_one; ?>!important;
        }

        #side-categories .item.level-1:hover,
        #side-categories .item.level-1.active{
            background-color:#<?= $theme_default_product_category_level_one_hover; ?>!important;
        }

        #side-categories .item.level-1:hover a,
        #side-categories .item.level-1.active a{
            color:#<?= $theme_default_product_category_text_level_one_hover; ?>!important;
        }

        /*level 2*/
        #side-categories .item.level-2 a{
            padding:<?= $theme_default_product_category_level_two_padding; ?>!important;
        }

        #side-categories .item.level-2{
            background-color:#<?= $theme_default_product_category_level_two; ?>;
            border-radius:<?= $theme_default_product_category_level_one_radius; ?>!important;
            outline:none;
            margin: <?= $theme_default_product_category_level_one_margin; ?>!important;
        }

        #side-categories .item.level-2 a{
            color:#<?= $theme_default_product_category_text_level_two; ?>!important;
        }

        #side-categories .item.level-2:hover,
        #side-categories .item.level-2.active{
            background-color:#<?= $theme_default_product_category_level_two_hover; ?>;
            color:#<?= $theme_default_product_category_text_level_two_hover; ?>!important;
        }
        
        #side-categories .item.level-2:hover a,
        #side-categories .item.level-2.active a{
            color:#<?= $theme_default_product_category_text_level_two_hover; ?>!important;
        }

        /*level 3*/
        #side-categories .item.level-3 a{
            color:#000;
            padding:<?= $theme_default_product_category_level_three_padding; ?>!important;
        }

        #side-categories .item.level-3:hover,
        #side-categories .item.level-3.active,
        #side-categories .item.level-3:hover a,
        #side-categories .item.level-3.active a,
        #side-categories .item.level-3:hover .caret,
        #side-categories .item.level-3.active .caret{
            color:#000!important;
            text-decoration: underline;
        }

        #side-categories .item.level-4 a{
            padding:<?= $theme_default_product_category_level_four_padding; ?>!important;
        }

        #side_filter .list-group{
            border-top: 1px solid #d0d0d0;
            margin-top:20px;
        }

        #side-price{
            border-top: 1px solid #d0d0d0;
        }
        /*#side-price .price-container{
            display:none!important;
        }
        
        .product-category .menu_label {
            color: #000;
            font-family:"Montserrat";
            font-weight:600;
        }
        
        .product-category .input-group-text{
            color:#000;
        }
        #side-categories,
        #side-manufacturer,
        #side_filter,
        #side-price{
            background-color:#fff;
        }
        #side-categories>div,
        #side-manufacturer>div,
        #side_filter>div,
        #side_filter>div>div,
        #side-price>div{
            background-color:#fff;
        }*/
        /*#side_filter .list-group-item {
            padding: 7px 15px;
        }*/
        /*#side-price .list-group-item {
            padding: 10px 15px;
            margin-bottom: 15px;
        }
        #side_filter>div, #side_filter>div>div, #side-price>div {
            background-color: transparent;
        }
        #side-categories, #side-manufacturer, #side_filter, #side-price {
            background-color: transparent;
        }*/


    <?php }else{ ?>

        .section-space.max-offset.category{
            padding:0;
            overflow: initial;
        }

        #side-categories .toggle {
            display: none!important;
        }

        /*level 1*/
        .product-category .side-categories-level-1 .group>.level-1 a{
            padding: <?= $theme_default_product_category_level_one_padding; ?>!important;
        }

        #side-categories .item.level-1 a{
            color:#<?= $theme_default_product_category_text_level_one; ?>!important;
        }

        
        <?php if($theme_default_product_category_layout_setting == 2){?>
            
            #side-categories .list-group-item.item-header{
                display:none!important;
            }

            #side-categories .list-group-item{
                display:flex!important;
                border-bottom: <?= $theme_default_product_category_level_one_border; ?>!important;
                padding:0;
            }

            #side-categories .item.level-1 a:hover,
            #side-categories .item.level-1.active a{
                color:#<?= $theme_default_product_category_text_level_one_hover; ?>!important;
                border-bottom:1px solid #<?= $theme_default_product_category_text_level_one_hover; ?>!important;
                font-weight: bold;
            }
            
            #side-categories{
                width:100%;
            }
            #filter-groups  #side-manufacturer,
            #filter-groups  #side_filter .list-group{
                margin:0 15px 0 0;
            }
        <?php } ?>
        <?php if($theme_default_product_category_layout_setting == 3){ ?>
            #side-categories{
                margin-right:15px!important;
            }
            #side-categories .list-group-item.item-header{
                border: 1px solid black;
                padding: 10px 45px 10px 30px;
                display: block;
            }
            #side-categories .list-group-item.item-header:after{
                font-family: 'FontAwesome';
                content: "\f078";
                position: absolute;
                right: 10px;
                font-size: 12px;
            }
            #side-categories .list-group-item{
                display: none;
            }
            #side-categories .list-group-item:not(.item-header).active{
                display: block;
                border: 1px solid black;
                margin-top: 10px;
                position: absolute;
                z-index: 10;
            }
            /*#filter-groups  #side_filter .list-group:not(:first-child){
                margin:0 15px 0 15px;
            }*/
            #filter-groups  #side-manufacturer,
            #filter-groups  #side_filter .list-group{
                margin:0 15px 0 0;
            }
            #side-categories .item.level-1 a:hover{
                color: #<?= $theme_default_product_category_text_level_one_hover; ?>!important;
            }
        <?php } ?>

        /*filter*/
        #filter-groups #side_filter{
            display:flex;
        }
        #filter-groups #side-price{
            margin:0 15px 0 0;
        }
        #filter-groups #side-manufacturer .list-group-item,
        #filter-groups #side_filter .list-group .list-group-item,
        #filter-groups #side-price .list-group-item{
            display:none;
        }
        #filter-groups #side-manufacturer .list-group-item.item-header,
        #filter-groups #side_filter .list-group .list-group-item.item-header,
        #filter-groups #side-price .list-group-item.item-header{
            border: <?= $theme_default_product_category_level_one_border; ?>;
            padding:10px 45px 10px 30px;
            display:block;
        }

        #filter-groups #side-manufacturer .list-group-item.item-header:after,
        #filter-groups #side_filter .list-group .list-group-item.item-header:after,
        #filter-groups #side-price .list-group-item.item-header:after{
            font-family: 'FontAwesome';
            content: "\f078";
            position: absolute;
            right: 10px;
            font-size: 12px;
            top: 50%;
            transform: translateY(-50%);
        }
        
        #filter-groups #side-categories .list-group-item.item-header.active:after,
        #filter-groups #side-manufacturer .list-group-item.item-header.active:after,
        #filter-groups #side_filter .list-group .list-group-item.item-header.active:after,
        #filter-groups #side-price .list-group-item.item-header.active:after {
            content: "\f077";
        }

        #filter-groups #side-manufacturer .list-group-item:not(.item-header).active,
        #filter-groups #side_filter .list-group .list-group-item:not(.item-header).active,
        #filter-groups #side-price .list-group-item:not(.item-header).active{
            display: block;
            border: <?= $theme_default_product_category_level_one_border; ?>;
            margin-top: 10px;
            position:absolute;
            z-index: 10;
        }

        #filter-groups .list-group-item.active, 
        #filter-groups .list-group-item.active:focus, 
        #filter-groups .list-group-item.active:hover {
            color: #000;
            background-color: #fff;
            border: 1px solid black;
            font-weight:bold;
        }

        #filter-groups{
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
        }

        #side-price .list-group-item.item-header{
            width:110px
        }
        #side-price .list-group-item{
            width:300px
        }

        #filter-groups .form-group{
            margin-bottom:14px;
        }

        #filter-groups .form-group select{
            border: <?= $theme_default_product_category_level_one_border; ?>;
            padding: 10px 45px 10px 30px!important;
            height: 42px;
        }
        #filter-groups .row{
            padding:0;
        }
        #filter-groups .filter-view{
            padding-top:6px;
        }
        #filter-groups .col-md-auto{
            margin:0 15px 0 0;
        }
        #product-filter-replace .filters-wrap{
            display:none;
        }
        @media (max-width: 767px){
            #filter-groups .filters-wrap{
                display:none;
            }
            #filter-groups {
                display: block;
            }
            #side-categories .list-group-item{
                display:block!important;
            }
            #filter-groups #side-manufacturer .list-group-item.item-header, 
            #filter-groups #side_filter .list-group .list-group-item.item-header, 
            #filter-groups #side-price .list-group-item.item-header {
                border: none;
                padding: 10px 15px;
                font-weight:bold;
            }
            #filter-groups #side-manufacturer,
            #filter-groups #side_filter{
                display:block;
            }
            #filter-groups #side-manufacturer .list-group-item.item-header:after, 
            #filter-groups #side_filter .list-group .list-group-item.item-header:after, 
            #filter-groups #side-price .list-group-item.item-header:after{
                content:"";
            }
            #filter-groups #side-manufacturer .list-group-item, 
            #filter-groups #side_filter .list-group .list-group-item, 
            #filter-groups #side-price .list-group-item{
                display:block;
            }
            #product-filter-replace .filters-wrap{
                display:block;
            }
            #side-categories .list-group-item.item-header{
                display: block!important;
                border: 0;
                padding: 10px 15px;
                font-weight:bold;
            }
            #side-categories .list-group-item.item-header:after {
                content: "";
            }
        }
    <?php } ?>



        @media (min-width: 1200px){
            .product-category #product-filter-detect .product-view>.product-gutter {
                width: calc(100% / <?= $theme_default_product_category_listing?>);
            }
        }
        
        .product-category #product-filter-detect .product-view.rows>.product-gutter {
            width: 100%;
        }




        /* Filter */
        #side-manufacturer label:hover,
        #side_filter label:hover {
            font-weight:bold;
        }

        #side-price .list-group-item:not(.item-header) {
            padding-top: 0!important;
        }
        
        /*Create a custom checkbox*/
        .product-category .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 20px;
            width: 20px;
            /*background-color:#<?= $theme_default_product_category_level_one; ?>;*/
            background-color:transparent;
            border:1px solid #<?= $theme_default_product_category_price_color; ?>!important;
        }
        
        /*When the checkbox is hover, add a blue background*/
        .product-category .container input:hover ~ .checkmark {
            background-color:#<?= $theme_default_product_category_level_one_hover; ?>;
        } 

        /*When the checkbox is checked, add a blue background*/
        .product-category .container input:checked ~ .checkmark {
            background-color:#<?= $theme_default_product_category_level_one_hover; ?>;
        }
        /*Create the checkmark/indicator (hidden when not checked)*/
        .product-category .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }
        /*Show the checkmark when checked*/
        .product-category .container input:checked ~ .checkmark:after {
            display: block;
        }
        /*Style the checkmark/indicator*/
        .product-category .container .checkmark:after {
            left:7px;
            top: 3px;
            width: 5px;
            height: 10px;
            border: solid #<?= $theme_default_product_category_text_level_one_hover; ?>;
            border-width: 0 3px 3px 0;
            -webkit-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            transform: rotate(45deg);
        }
        /*Style the checkmark/indicator*/
        .product-category .container .color_checkmark:after {
            width: 10px;
            height: 20px;
            left: 13px;
            top: 7px;
        }
        #side-manufacturer label,
        #side_filter label{
            padding-left:30px!important;
        }

        #side-manufacturer label input,
        #side_filter label input {
            display:none!important;
        }

        /* price box */
        #side-price .ui-slider-range,
        #side-price .ui-slider-handle{
            background: #<?= $theme_default_product_category_price_color; ?>!important;
        }
        
        #side-price #max,
        #side-price #min {
            color: #<?= $theme_default_product_category_price_color; ?>!important;
        }


    #side-categories .group .item a:hover,
    #side-categories .group .item .toggle:hover {
        background-color:transparent!important;
    }

    @media (min-width: 992px){
        .col-md-auto{
            width:auto!important;
        }
    }
    .filters-wrap{
        justify-content: flex-end;
    }

    .fa-th-large:before,
    .fa-navicon:before, .fa-reorder:before, .fa-bars:before{
        color:<?= $config_primary_color; ?>;
    }

    .special-sticker,
    .sticker{
        min-width: 90px !important;
        display: inline-block;
        position: relative;
        left: 0 !important;
        right: auto !important;
        text-align: center;
        font-weight: 500;
        padding: 2px 10px !important;
        margin: 15px !important;
        font-size: 12px;
    }

    
    /*.product-block .out_of_stock{
        top: auto;
        bottom:5px;
        left: 50%;
        transform: translateX(-50%);
        margin: 0px;
    }*/

    .product-block .product-name a{
        font-size:calc(12px + (17 - 12) * (100vw - 320px) / (1920 - 320));
        color: black;
        font-weight: bold;
    }
    <?php if(!$theme_default_product_box_category){ ?>
        .product-block .product-category{
            display:none;
        }
    <?php } ?>
    <?php if(!$theme_default_product_box_brand){ ?>
        .product-block .product-brand{
            display:none;
        }
    <?php } ?>
    .product-block .product-name{
        padding:7px 0px 7px!important;
        /*max-height:65px;
        overflow:hidden;*/
    }
    
    <?php if($theme_default_product_align == 1){ ?>
        .product-block .product-category,
        .product-block .product-brand{
            padding-top:7px;
            text-align:left;
            color: #000000;
        }
        
        .product-block .product-name,
        .product-block .product-details {
            text-align: left;
        }

        .product-block .product-details .price{
            color: black;
        }
        .product-block .product-details .price .price-old{
            color: black;
            text-decoration: line-through;
        }
        .product-block .product-details .price .price-special{
            color: red;
        }

        /*product info layout 1*/
        .product-block .product-details,
        .product-block .cart-buttons{
            width:50%;
        }
        .product-gutter .cart-buttons{
            display: flex;
            justify-content: flex-end;
        }
        .product-block .product-inputs{
            margin: auto 0 0;
        }
        .product-block .price_button{
            /*margin: auto 0 0;*/
            padding-top:5px;
        }
        /*@media screen and (max-width: 767px) {
            .product-block .product-details, .product-block .cart-buttons {
                width: 100%;
                text-align:center;
            }
        }*/
    <?php }else{ ?>
        .product-block .product-category,
        .product-block .product-brand{
            padding-top:7px;
            text-align:center;
            color: #000000;
        }

        .product-block .product-details {
            margin:auto auto 0!important;
        }

        .product-block .product-details .price{
            color: black;
        }
        .product-block .product-details .price .price-old{
            color: black;
            text-decoration: line-through;
        }
        .product-block .product-details .price .price-special{
            color: red;
        }

        /*product info layout 1*/
        .product-block .product-details,
        .product-block .cart-buttons{
            width:100%;
        }
        .product-block .cart-buttons{
            display: flex;
            justify-content: center;
            margin:10px 0!important;
        }
        
        .product-block .product-inputs{
            margin:auto 0 0;
        }
        .product-block .price_button{
            /*margin:auto auto 0;*/
        }

    <?php } ?>
    
    .product-category #column-left{
        padding-right:50px;
    }
    
    @media screen and (max-width: 1200px) {
        .product-category #column-left{
            padding-right:0px;
        }
    }

    .quickcheckout-checkout .redeem{
        background: <?= $config_primary_color ?>;
        color: #fff;
        border: 0px;
        padding: 5px 10px;
        margin: 10px 0;
        float: left!important;
    }
    .checkout_step{
        list-style: none;
        display:flex;
        flex-wrap:wrap;
        flex-direction: row;
        padding-left:0px;
        margin-bottom: 20px;
    }
    .checkout_step li{
        padding: 8px 10px;
        padding-right: 20px;
        margin-right: 24px;
        border: 0px solid #bfbfbf;
        border-right: 0;
        position: relative;
        background-color: #dddddd;
        color: #000;
        font-weight: bold;
        font-size: 16px;
    }
    .checkout_step li.active{
        background-color:<?= $config_primary_color ?>;
        color:#fff;
    }
    .checkout_step li:after {
        content: "";
        width: 0px;
        height: 0;
        position: absolute;
        border-top: 17.5px solid transparent;
        border-bottom: 17.5px solid transparent;
        border-left: 12px solid #dddddd;
        top: 0;
        right: -12px;
    }
    .checkout_step li.active:after {
        border-left: 12px solid <?= $config_primary_color ?>;
    }
    .checkout_step li:before {
        content: "";
        width: 0px;
        height: 0;
        position: absolute;
        border-top: 18.5px solid #dddddd;
        border-bottom: 18.5px solid #dddddd;
        border-left: 12px solid transparent;
        top: 0;
        left: -12px;
    }
    .checkout_step li.active:before {
        border-top: 18.5px solid <?= $config_primary_color ?>;
        border-bottom: 18.5px solid <?= $config_primary_color ?>;
    }
    .product-block .product-category,
    .product-block .product-brand,
    .product-block .product-name,
    .product-block .product-inputs,
    .product-block .price_button{
        padding-left:<?= $theme_default_product_box_padding; ?>!important;
        padding-right:<?= $theme_default_product_box_padding; ?>!important;
    }
    
    <?php if(!$theme_default_product_box_padding){ ?>
        .product-block .btn-group.product-button{
            /* display:none; */
        }
    <?php } ?>
    <?php if($theme_default_product_box_hover){ ?>
        .product-block .btn-group.product-button{
            display:block;
        }
        .product-gutter .cart-buttons .btn{
            display:none;
        }
    <?php }else{ ?>
        .product-block .btn-group.product-button{
            /* display:none; */
        }
        .product-gutter .cart-buttons .btn{
            display:block;
        }
    <?php } ?>

    @media screen and (max-width: 767px) {
        <?php if($theme_default_product_box_hover){ ?>
            .product-block .btn-group.product-button{
                display:none;
            }
            .product-gutter .cart-buttons .btn{
                display:block;
            }
        <?php }else{ ?>
            .product-block .btn-group.product-button{
                display:block;
            }
            .product-gutter .cart-buttons .btn{
                display:none;
            }
        <?php } ?>
        .checkout_step {
            flex-direction: column;
        }
        .checkout_step li {
            margin-top:15px;
            margin-right: 0px;
        }
        .checkout_step li.active:after {
            border-top: 10px solid <?= $config_primary_color ?>;
        }
        .checkout_step li:after {
            content: "";
            width: 0px;
            height: 0;
            position: absolute;
            border-right: 15px solid white;
            border-left: 15px solid white!important;
            border-top: 12px solid #dddddd;
            top:auto;
            bottom: -27px;
            right: 50%;
            transform: translateX(50%);
        }
        .checkout_step li:last-child:after {
            content: "";
            width: 0px;
            height: 0;
            position: absolute;
            border-right: 0 solid white;
            border-left: 0 solid white!important;
            border-top: 0 solid #dddddd;
            top:auto;
            bottom: -27px;
            right: 50%;
            transform: translateX(50%);
        }
        .checkout_step li:before {
            content: "";
            width: 0px;
            height: 0;
            position: absolute;
            border-top: 0 solid #dddddd;
            border-bottom: 0 solid #dddddd;
            border-left: 0 solid white;
            top: 0;
            left: 0;
        }
    }
</style>
<script>
    $(document).ready(function(){
        check_button();
        <?php if($theme_default_product_align == 1){ ?>
            $(window).on('resize', function(){
                check_button();
            });
        <?php } ?>

        <?php if($theme_default_product_category_layout_setting == 2 || $theme_default_product_category_layout_setting == 3){ ?>
            $(document).on('click','.list-group-item.item-header',function(){
                
                if($(this).hasClass('active')){
                    $(this).next('.list-group-item').removeClass('active');
                    $(this).removeClass('active');
                }else{
                    
                    $('.list-group-item').removeClass('active');
                    $('.list-group-item.item-header').removeClass('active');

                    $(this).next('.list-group-item').addClass('active');
                    $(this).addClass('active');
                }

                
                $('#min').html('$' + $("#slider-price").slider('values', 0)).position({
                    my: 'center top',
                    at: 'center bottom',
                    of: $('#slider-price span:eq(0)'),
                    offset: "0, 10"
                });
                

                $('#max').html('$' + $("#slider-price").slider('values', 1)).position({
                    my: 'center top',
                    at: 'center bottom',
                    of: $('#slider-price span:eq(1)'),
                    offset: "0, 10"
                });
            });
        <?php } ?>
        function check_button(){
            var width = window.innerWidth
            || document.documentElement.clientWidth
            || document.body.clientWidth;
            if(width < 768){
                $('.product-block .btn-cart').html('<i class="fa fa-shopping-cart"></i>');
            }
        }
    });
    
    $(window).load(function(){
        $('.abjust_sticker').css('top',$('.sticker').outerHeight()+10+"px");
    })
</script>