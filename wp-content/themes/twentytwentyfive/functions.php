<?php
add_action( 'after_setup_theme', 'wp_learn_setup_theme');

function wp_learn_setup_theme() {
    add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );
}

add_filter( 'the_content', 'wp_learn_amend_content' );
function wp_learn_amend_content( $content ) {
    $additional_content = '<!-- wp:paragraph --><p>Filtered through <i>the_content</i></p><!-- /wp:paragraph -->';
    $content            = $content . $additional_content;

    return $content;
}