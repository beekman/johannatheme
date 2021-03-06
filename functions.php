<?php
/*
Author: Ben Beekman
URL: http://benbeekman.com/web

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, ect.
*/

/************* INCLUDE NEEDED FILES ***************/

/*
1. library/johanna.php
    - head cleanup (remove rsd, uri links, junk css, ect)
    - enqueueing scripts & styles
    - theme support functions
    - custom menu output & fallbacks
    - related post function
    - page-navi function
    - removing <p> from around images
    - customizing the post excerpt
    - custom google+ integration
    - adding custom fields to user profiles
*/
require_once('library/johanna.php'); // if you remove this, johannatheme will break
/*
2. library/custom-post-type.php
    - an example custom post type
    - example custom taxonomy (like categories)
    - example custom taxonomy (like tags)
*/
// require_once('library/custom-post-type.php'); // you can disable this if you like
/*
3. library/admin.php
    - removing some default WordPress dashboard widgets
    - an example custom dashboard widget
    - adding custom login css
    - changing text in footer of admin
*/
require_once('library/admin.php'); // this comes turned off by default
/*
4. library/translation/translation.php
    - adding support for other languages
*/
// require_once('library/translation/translation.php'); // this comes turned off by default

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'gallery-1000', 1000, 660, true );
add_image_size( 'johanna-thumb-600', 600, 400, true );
add_image_size( 'johanna-thumb-300', 300, 200, true );
/*
to add more sizes, simply copy a line from above
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 300 sized image,
we would use the function:
<?php the_post_thumbnail( 'johanna-thumb-300' ); ?>
for the 600 x 400 image:
<?php the_post_thumbnail( 'johanna-thumb-600' ); ?>

You can change the names and dimensions to whatever
you like. Enjoy!
*/

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function johanna_register_sidebars() {
    register_sidebar(array(
        'id' => 'sidebar1',
        'name' => __('Sidebar 1', 'johannatheme'),
        'description' => __('The first (primary) sidebar.', 'johannatheme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widgettitle">',
        'after_title' => '</h4>',
    ));


    register_sidebar(array(
        'id'            => 'under-posts',
        'name'          => __( 'Under Posts and Pages', 'johannatheme' ),
        'description'   => __( 'Appears in the main column below posts and pages on pages using the Page then Widgets template.', 'johannatheme' ),
        'class'         => 'under_post',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widgettitle">',
        'after_title' => '</h4>',
    ));

      //To call the sidebar in your template, you can just copy
    //the sidebar.php file and rename it to your sidebar's id.
    //So using the above example, it would be:
    //sidebar-under_posts.php
} // don't remove this bracket!

/************* COMMENT LAYOUT *********************/

// Comment Layout
function johanna_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
    <li <?php comment_class(); ?>>
        <article id="comment-<?php comment_ID(); ?>" class="clearfix">
            <header class="comment-author vcard">
                <?php
                /*
                    this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
                    echo get_avatar($comment,$size='32',$default='<path_to_url>' );
                */
                ?>
                <!-- custom gravatar call -->
                <?php
                    // create variable
                    $bgauthemail = get_comment_author_email();
                ?>
                <img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5($bgauthemail); ?>?s=32" class="load-gravatar avatar avatar-48 photo" height="32" width="32" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
                <!-- end custom gravatar call -->
                <?php printf(__('<cite class="fn">%s</cite>', 'johannatheme'), get_comment_author_link()) ?>
                <time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__('F jS, Y', 'johannatheme')); ?> </a></time>
                <?php edit_comment_link(__('(Edit)', 'johannatheme'),'  ','') ?>
            </header>
            <?php if ($comment->comment_approved == '0') : ?>
                <div class="alert alert-info">
                    <p><?php _e('Your comment is awaiting moderation.', 'johannatheme') ?></p>
                </div>
            <?php endif; ?>
            <section class="comment_content clearfix">
                <?php comment_text() ?>
            </section>
            <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
        </article>
    <!-- </li> is added by WordPress automatically -->
<?php
} // don't remove this bracket!

/************* SEARCH FORM LAYOUT *****************/

// Search Form
function johanna_wpsearch($form) {
    $form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
    <label class="screen-reader-text" for="s">' . __('Search for:', 'johannatheme') . '</label>
    <input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="'.esc_attr__('Search the Site...','johannatheme').'" />
    <input type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'" />
    </form>';
    return $form;
} // don't remove this bracket!


?>
