<?php
/*
Author: Eddie Machado
URL: http://themble.com/bones/

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, ect.
*/

// LOAD BONES CORE (if you remove this, the theme will break)
require_once( 'library/bones.php' );

// CUSTOMIZE THE WORDPRESS ADMIN (off by default)
require_once( 'library/admin.php' );

/*********************
LAUNCH BONES
Let's get everything up and running.
*********************/

function bones_ahoy() {

  //Allow editor style.
  add_editor_style( get_stylesheet_directory_uri() . '/library/css/editor-style.css' );

  // launching operation cleanup
  add_action( 'init', 'bones_head_cleanup' );
  // A better title
  add_filter( 'wp_title', 'rw_title', 10, 3 );
  // remove WP version from RSS
  add_filter( 'the_generator', 'bones_rss_version' );
  // remove pesky injected css for recent comments widget
  add_filter( 'wp_head', 'bones_remove_wp_widget_recent_comments_style', 1 );
  // clean up comment styles in the head
  add_action( 'wp_head', 'bones_remove_recent_comments_style', 1 );
  // clean up gallery output in wp
  add_filter( 'gallery_style', 'bones_gallery_style' );

  // enqueue base scripts and styles
  add_action( 'wp_enqueue_scripts', 'bones_scripts_and_styles', 999 );
  // ie conditional wrapper

  // launching this stuff after theme setup
  bones_theme_support();

  // cleaning up random code around images
  add_filter( 'the_content', 'bones_filter_ptags_on_images' );
  // cleaning up excerpt
  add_filter( 'excerpt_more', 'bones_excerpt_more' );

} /* end bones ahoy */

// let's get this party started
add_action( 'after_setup_theme', 'bones_ahoy' );


/************* OEMBED SIZE OPTIONS *************/

if ( ! isset( $content_width ) ) {
	$content_width = 640;
}

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'bones-thumb-600', 600, 150, true );
add_image_size( 'bones-thumb-300', 300, 100, true );

/*
to add more sizes, simply copy a line from above
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 100 sized image,
we would use the function:
<?php the_post_thumbnail( 'bones-thumb-300' ); ?>
for the 600 x 150 image:
<?php the_post_thumbnail( 'bones-thumb-600' ); ?>

You can change the names and dimensions to whatever
you like. Enjoy!
*/

add_filter( 'image_size_names_choose', 'bones_custom_image_sizes' );

function bones_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'bones-thumb-600' => __('600px by 150px'),
        'bones-thumb-300' => __('300px by 100px'),
    ) );
}

/*
The function above adds the ability to use the dropdown menu to select
the new images sizes you have just created from within the media manager
when you add media to your content blocks. If you add more image sizes,
duplicate one of the lines in the array and name it according to your
new image size.
*/

/************* THEME CUSTOMIZE *********************/

/* 
  A good tutorial for creating your own Sections, Controls and Settings:
  http://code.tutsplus.com/series/a-guide-to-the-wordpress-theme-customizer--wp-33722
  
  Good articles on modifying the default options:
  http://natko.com/changing-default-wordpress-theme-customization-api-sections/
  http://code.tutsplus.com/tutorials/digging-into-the-theme-customizer-components--wp-27162
  
  To do:
  - Create a js for the postmessage transport method
  - Create some sanitize functions to sanitize inputs
  - Create some boilerplate Sections, Controls and Settings
*/

function bones_theme_customizer($wp_customize) {
  // $wp_customize calls go here.
  //
  // Uncomment the below lines to remove the default customize sections 

  // $wp_customize->remove_section('title_tagline');
  // $wp_customize->remove_section('colors');
  // $wp_customize->remove_section('background_image');
  // $wp_customize->remove_section('static_front_page');
  // $wp_customize->remove_section('nav');

  // Uncomment the below lines to remove the default controls
  // $wp_customize->remove_control('blogdescription');
  
  // Uncomment the following to change the default section titles
  // $wp_customize->get_section('colors')->title = __( 'Theme Colors' );
  // $wp_customize->get_section('background_image')->title = __( 'Images' );
}

add_action( 'customize_register', 'bones_theme_customizer' );

/*
This is a modification of a function found in the
twentythirteen theme where we can declare some
external fonts. If you're using Google Fonts, you
can replace these fonts, change it in your scss files
and be up and running in seconds.
*/
function bones_fonts() {
  wp_enqueue_style('');
}

add_action('wp_enqueue_scripts', 'bones_fonts');

// Enable support for HTML5 markup.
	add_theme_support( 'html5', array(
		'search-form',
	) );

/*
are_we_live() is a function for testing our environment. 
@returns true if on production server false if not
*/

function are_we_live(){
  $current_server = $_SERVER['HTTP_HOST']; 

  if ( $current_server == 'arts.vcu.edu' ){
    return true;
  } else {
    return false;
  }
}

// Custom walker for Skips theme to spit out anchors instead of permalinks for child pages
class skips_walker extends Walker_Page {
  function start_lvl( &$output, $depth = 0, $args = array() ) {
      $indent = str_repeat("\t", $depth);
      $output .= "\n$indent<ul class='children'>\n";
  }

  function end_lvl( &$output, $depth = 0, $args = array() ) {
      $indent = str_repeat("\t", $depth);
      $output .= "$indent</ul>\n";
  }

  function start_el( &$output, $page, $depth = 0, $args = array(), $current_page = 0 ) {
      if ( $depth )
          $indent = str_repeat("\t", $depth);
      else
          $indent = '';
      
      extract($args, EXTR_SKIP);
      $css_class = array('page_item', 'page-item-'.$page->ID);
      if ( !empty($current_page) ) {
          $_current_page = get_post( $current_page );
          if ( in_array( $page->ID, $_current_page->ancestors ) )
              $css_class[] = 'current_page_ancestor';
          if ( $page->ID == $current_page )
              $css_class[] = 'current_page_item';
          elseif ( $_current_page && $page->ID == $_current_page->post_parent )
              $css_class[] = 'current_page_parent';
      }
      elseif ( $page->ID == get_option('page_for_posts') ) {
          $css_class[] = 'current_page_parent';
      }
      
      $css_class = implode( ' ', apply_filters( 'page_css_class', $css_class, $page, $depth, $args, $current_page ) );
      
      if ($page->post_parent){          
          // figure out the parent such that we will get the right links even if we are not in family tree
          $ancestors=get_post_ancestors($page->ID);
          $root=count($ancestors)-1;
          $parent = $ancestors[$root];
          $permalink = get_permalink($parent);

        $output .= $indent . '<li class="' . $css_class . '"><a class="smoothScroll" href="' . $permalink . '#page-item-' . $page->ID . '">' . $link_before . apply_filters( 'the_title', $page->post_title, $page->ID ) . $link_after . '</a>';
      } else {
        $output .= $indent . '<li class="' . $css_class . '"><a class="smoothScroll" href="' . get_permalink($page->ID) . '">' . $link_before . apply_filters( 'the_title', $page->post_title, $page->ID ) . $link_after . '</a>';
      }
      
      if ( !empty($show_date) ) {
          if ( 'modified' == $show_date )
              $time = $page->post_modified;
          else
              $time = $page->post_date;
              
          $output .= " " . mysql2date($date_format, $time);
      }
  }

  function end_el( &$output, $page, $depth = 0, $args = array() ) {
      $output .= "</li>\n";
  }
}

function style_guide_index( $query ) {
    if ( $query->is_home() && $query->is_main_query() ) {
        $query->set( 'post_type', 'page' );
        $query->set( 'posts_per_page', 500 );
    }
}
add_action( 'pre_get_posts', 'style_guide_index' );

/* DON'T DELETE THIS CLOSING TAG */ ?>
