<?php
function pracolek_enqueue_styles() {
    $parent_style = 'parent-style';

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style )
    );
}
add_action( 'wp_enqueue_scripts', 'pracolek_enqueue_styles' );

function pracolek_body_classes( $classes ) {

	global $post;
	$post_type = isset( $post ) ? $post->post_type : false;

	// Check whether we're singular.
	if ( is_singular() ) {
		$classes[] = 'singular';
	}

	// Check whether the current page should have an overlay header.
	if ( is_page_template( array( 'templates/template-cover.php' ) ) ) {
		$classes[] = 'overlay-header';
	}
	if ( is_page_template( array( 'templates/template-full-cover.php' ) ) ) {
		$classes[] = 'overlay-header';
	}

	// Check whether the current page has full-width content.
	if ( is_page_template( array( 'templates/template-full-width.php' ) ) ) {
		$classes[] = 'has-full-width-content';
	}
    if ( is_page_template( array( 'templates/template-full-cover.php' ) ) ) {
		$classes[] = 'has-full-width-content';
	}

	// Check for enabled search.
	if ( true === get_theme_mod( 'enable_header_search', true ) ) {
		$classes[] = 'enable-search-modal';
	}

	// Check for post thumbnail.
	if ( is_singular() && has_post_thumbnail() ) {
		$classes[] = 'has-post-thumbnail';
	} elseif ( is_singular() ) {
		$classes[] = 'missing-post-thumbnail';
	}

	// Check whether we're in the customizer preview.
	if ( is_customize_preview() ) {
		$classes[] = 'customizer-preview';
	}

	// Check if posts have single pagination.
	if ( is_single() && ( get_next_post() || get_previous_post() ) ) {
		$classes[] = 'has-single-pagination';
	} else {
		$classes[] = 'has-no-pagination';
	}

	// Check if we're showing comments.
	if ( $post && ( ( 'post' === $post_type || comments_open() || get_comments_number() ) && ! post_password_required() ) ) {
		$classes[] = 'showing-comments';
	} else {
		$classes[] = 'not-showing-comments';
	}

	// Check if avatars are visible.
	$classes[] = get_option( 'show_avatars' ) ? 'show-avatars' : 'hide-avatars';

	// Slim page template class names (class = name - file suffix).
	if ( is_page_template() ) {
		$classes[] = basename( get_page_template_slug(), '.php' );
	}

	// Check for the elements output in the top part of the footer.
	$has_footer_menu = has_nav_menu( 'footer' );
	$has_social_menu = has_nav_menu( 'social' );
	$has_sidebar_1   = is_active_sidebar( 'sidebar-1' );
	$has_sidebar_2   = is_active_sidebar( 'sidebar-2' );

	// Add a class indicating whether those elements are output.
	if ( $has_footer_menu || $has_social_menu || $has_sidebar_1 || $has_sidebar_2 ) {
		$classes[] = 'footer-top-visible';
	} else {
		$classes[] = 'footer-top-hidden';
	}

	// Get header/footer background color.
	$header_footer_background = get_theme_mod( 'header_footer_background_color', '#ffffff' );
	$header_footer_background = strtolower( '#' . ltrim( $header_footer_background, '#' ) );

	// Get content background color.
	$background_color = get_theme_mod( 'background_color', 'f5efe0' );
	$background_color = strtolower( '#' . ltrim( $background_color, '#' ) );

	// Add extra class if main background and header/footer background are the same color.
	if ( $background_color === $header_footer_background ) {
		$classes[] = 'reduced-spacing';
	}

	return $classes;

}

add_filter( 'body_class', 'twentytwenty_body_classes' );

?>