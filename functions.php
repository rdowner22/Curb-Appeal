<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Curb Appeal', 'curb-appeal' ) );
define( 'CHILD_THEME_URL', 'http://www.agentevolution.com/shop/curb-appeal/' );
define( 'CHILD_THEME_VERSION', '1.0.11' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'curb-appeal', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'curb-appeal' ) );

//* Add Theme Support
add_theme_support( 'equity-top-header-bar' );
add_theme_support( 'equity-after-entry-widget-area' );

//* Add rectangular size image for featured posts/pages
add_image_size( 'featured-post', '700', '370', true);

//* Create additional color style options
add_theme_support( 'equity-style-selector', array(
	'curb-appeal-blue'    => __( 'Blue', 'curb-appeal' ),
	'curb-appeal-red'     => __( 'Red', 'curb-appeal' ),
	'curb-appeal-purple'  => __( 'Purple', 'curb-appeal' ),
	'curb-appeal-aqua'    => __( 'Aqua', 'curb-appeal' ),
	'curb-appeal-custom'  => __( 'Use Customizer', 'curb-appeal' ),
) );

//* Add dark body class if selected in customizer
add_filter( 'body_class', 'curb_appeal_body_class' );
function curb_appeal_body_class( $classes ) {
	if ( get_theme_mod( 'primary_tone' ) ) {
	    $classes[] = 'dark';
	}
	return $classes;
}

//* Load fonts 
add_filter( 'equity_google_fonts', 'curb_appeal_fonts' );
function curb_appeal_fonts( $equity_google_fonts ) {
	$equity_google_fonts = 'Roboto:300,300italic,400|Oswald:300,400';
	return $equity_google_fonts;
}

// Add class to body for easy theme identification.
add_filter( 'body_class', 'add_theme_body_class' );
function add_theme_body_class( $classes ) {
	$classes[] = 'home-theme--curb-appeal';
	return $classes;
}

//* Load backstretch.js
add_action( 'wp_enqueue_scripts', 'curb_appeal_register_scripts' );
function curb_appeal_register_scripts() {
	wp_enqueue_script( 'jquery-backstretch', get_stylesheet_directory_uri() . '/lib/js/jquery.backstretch.min.js', array('jquery'), '2.0.4', true);

	//* Enable sticky header if checked in customizer
	if ( get_theme_mod('enable_sticky_header') == true  && !wp_is_mobile() ) {
		wp_enqueue_script( 'sticky-header', get_stylesheet_directory_uri() . '/lib/js/sticky-header.js', array('jquery'), '1.0', true);
	}

	// Fix for mobile nav menu behavior
	wp_enqueue_script( 'mobile-nav-menu-fix', get_stylesheet_directory_uri() . '/lib/js/mobile-nav-menu-fix.js', null, true);
}

/**
 * Menu_fix_css function.
 *
 * Corrects menu behavior on mobile devices.
 */
function menu_fix_css() {
	echo '<style type="text/css">@media only screen and (max-width: 1139px){.top-bar-section ul .menu-item-has-children .mobile-nav-link-overlay{position:absolute;left:0;top:0;width:55%;height:100%;opacity:0;}}</style>';
}
add_action( 'wp_head', 'menu_fix_css' );

//* Output backstretch call with custom or default image to wp_footer
add_action('wp_footer', 'curb_appeal_backstretch_js', 9999);
function curb_appeal_backstretch_js() {

	//* Return early if no background is checked in post options
	if ( !is_home() && equity_get_custom_field( '_equity_disable_single_post_background' ) == true )
		return;

	$background_url = equity_get_custom_field( '_equity_single_post_background' );

	// use default if no background image set
	if ( ! $background_url || is_home() ) {
		$background_url = get_theme_mod('default_background_image', get_stylesheet_directory_uri() . '/images/bkg-default.jpg' );
	}
	?>
	
	<script>jQuery.backstretch("<?php echo $background_url; ?>");</script>
	<?php
}

//* Add sticky header wrap markup
add_action( 'equity_before_header', 'curb_appeal_sticky_header_open', 1 );
add_action( 'equity_after_header', 'curb_appeal_sticky_header_close' );
function curb_appeal_sticky_header_open() {
	echo '<div class="sticky-header">';
}
function curb_appeal_sticky_header_close() {
	echo '</div><!-- end .sticky-header -->';
}

//* Filter off canvas nav toggle icon
add_filter( 'equity_off_canvas_toggle_text', 'picture_perfect_off_canvas_toggle_text' );
function picture_perfect_off_canvas_toggle_text() {
	$toggle_text = '<i class="fas fa-search"></i><span class="hide">Search Menu</span>';
	return $toggle_text;
}

//* Filter listing scroller widget prev/next links
add_filter( 'listing_scroller_prev_link', 'child_listing_scroller_prev_link');
function child_listing_scroller_prev_link( $listing_scroller_prev_link_text ) {
	$listing_scroller_prev_link_text = __( '<i class=\"fas fa-caret-left\"></i><span>Prev</span>', 'curb-appeal' );
	return $listing_scroller_prev_link_text;
}
add_filter( 'listing_scroller_next_link', 'child_listing_scroller_next_link');
function child_listing_scroller_next_link( $listing_scroller_next_link_text ) {
	$listing_scroller_next_link_text = __( '<i class=\"fas fa-caret-right\"></i><span>Next</span>', 'curb-appeal' );
	return $listing_scroller_next_link_text;
}
//* Filter IDX listing carousel widget prev/next links
add_filter( 'idx_listing_carousel_prev_link', 'child_idx_listing_carousel_prev_link');
function child_idx_listing_carousel_prev_link( $idx_listing_carousel_prev_link_text ) {
	$idx_listing_carousel_prev_link_text = __( '<i class=\"fas fa-caret-left\"></i><span>Prev</span>', 'curb-appeal' );
	return $idx_listing_carousel_prev_link_text;
}
add_filter( 'idx_listing_carousel_next_link', 'child_idx_listing_carousel_next_link');
function child_idx_listing_carousel_next_link( $idx_listing_carousel_next_link_text ) {
	$idx_listing_carousel_next_link_text = __( '<i class=\"fas fa-caret-right\"></i><span>Next</span>', 'curb-appeal' );
	return $idx_listing_carousel_next_link_text;
}
//* Filter Equity page carousel widget prev/next links
add_filter( 'equity_page_carousel_prev_link', 'child_equity_page_carousel_prev_link');
function child_equity_page_carousel_prev_link( $equity_page_carousel_prev_link_text ) {
	$equity_page_carousel_prev_link_text = __( '<i class=\"fas fa-caret-left\"></i><span>Prev</span>', 'curb-appeal' );
	return $equity_page_carousel_prev_link_text;
}
add_filter( 'equity_page_carousel_next_link', 'child_equity_page_carousel_next_link');
function child_equity_page_carousel_next_link( $equity_page_carousel_next_link_text ) {
	$equity_page_carousel_next_link_text = __( '<i class=\"fas fa-caret-right\"></i><span>Next</span>', 'curb-appeal' );
	return $equity_page_carousel_next_link_text;
}

//* Set default footer widgets to 3
if ( get_theme_mod( 'footer_widgets' ) == '' ) {
	set_theme_mod( 'footer_widgets', 3 );
}

//* Register widget areas
equity_register_widget_area(
	array(
		'id'          => 'home-search',
		'name'        => __( 'Home Search', 'curb-appeal' ),
		'description' => __( 'This is the Search section of the Home page at the top. Recommended to use the Equity IDX Search widget.', 'curb-appeal' ),
	)
);
equity_register_widget_area(
	array(
		'id'           => 'home-top',
		'name'         => __( 'Home Top', 'curb-appeal' ),
		'description'  => __( 'This is the top section of the Home page below the search. Recommended to use a icon box shortcodes inside column shortcodes followed by the Equity - IDX Property Carousel.', 'curb-appeal' ),
	)
);
equity_register_widget_area(
	array(
		'id'          => 'home-middle-left',
		'name'        => __( 'Home Middle Left', 'curb-appeal' ),
		'description' => __( 'This is the Middle Left section of the Home page. Recommended to use a text widget for a welcome statement.', 'curb-appeal' ),
	)
);
equity_register_widget_area(
	array(
		'id'          => 'home-middle-right',
		'name'        => __( 'Home Middle Right', 'curb-appeal' ),
		'description' => __( 'This is the Middle Right section of the Home page. Recommended to use a custom menu with icons for search links.', 'curb-appeal' ),
	)
);
equity_register_widget_area(
	array(
		'id'          => 'home-bottom-map',
		'name'        => __( 'Home Bottom Map', 'curb-appeal' ),
		'description' => __( 'This is the bottom, full-width section of the Home page. Recommended to use an IDX Map search widget.', 'curb-appeal' ),
	)
);
equity_register_widget_area(
	array(
		'id'          => 'home-bottom-left',
		'name'        => __( 'Home Bottom Left', 'curb-appeal' ),
		'description' => __( 'This is the Bottom Left section of the Home page. Recommended to use a Text widget with a testimonial.', 'curb-appeal' ),
	)
);
equity_register_widget_area(
	array(
		'id'          => 'home-bottom-right',
		'name'        => __( 'Home Bottom Right', 'curb-appeal' ),
		'description' => __( 'This is the Bottom Right section of the Home page. Recommended to use the Equity Featured Post widget.', 'curb-appeal' ),
	)
);

//* Home page - define home page widget areas for welcome screen display check
add_filter('equity_theme_widget_areas', 'curb_appeal_home_widget_areas');
function curb_appeal_home_widget_areas($active_widget_areas) {
	$active_widget_areas = array( 'home-search' );
	return $active_widget_areas;
}

//* Home page - markup and default widgets
function equity_child_home() {
	?>

	<div class="home-search">
		<div class="row">
			<div class="columns small-12">
			<?php equity_widget_area( 'home-search' ); ?>
			</div><!-- end .columns .small-12 -->
		</div><!-- .end .row -->
	</div><!-- end .home-search -->

	<div class="home-top">
		<div class="row">
			<div class="columns small-12">
			<?php equity_widget_area( 'home-top' ); ?>
			</div><!-- end .columns .small-12 -->
		</div><!-- .end .row -->
	</div><!-- end .home-top -->

	<div class="home-middle bg-alt">
		<div class="row">
			<div class="home-middle-left columns small-12 medium-8 large-8">
			<?php equity_widget_area( 'home-middle-left' ); ?>
			</div><!-- end .home-middle-left -->
			<div class="home-middle-right columns small-12 medium-4 large-4">
			<?php equity_widget_area( 'home-middle-right' ); ?>
			</div><!-- end .home-middle-right -->
		</div><!-- .end .row -->
	</div><!-- end .home-middle -->

	<div class="home-map">
		<div class="row">
			<div class="columns small-12">
			<?php equity_widget_area( 'home-bottom-map' ); ?>
			</div><!-- end .columns .small-12 -->
		</div><!-- .end .row -->
	</div><!-- end .home-map -->

	<div class="home-bottom">
		<div class="row">
			<div class="home-bottom-left columns small-12 medium-4 large-4">
			<?php equity_widget_area( 'home-bottom-left' ); ?>
			</div><!-- end .home-bottom-left -->
			<div class="home-bottom-right columns small-12 medium-8 large-8">
			<?php equity_widget_area( 'home-bottom-right' ); ?>
			</div><!-- end .home-bottom-right -->
		</div><!-- .end .row -->
	</div><!-- end .home-bottom -->

<?php
}

//* Includes

# Theme Customizatons
require_once get_stylesheet_directory() . '/lib/customizer.php';

# Custom metaboxes
require_once get_stylesheet_directory() . '/lib/metaboxes.php';