<?php
add_action( 'after_setup_theme', 'wp_learn_setup_theme', 11);

function wp_learn_setup_theme() {
    add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );
}

add_filter( 'the_content', 'wp_learn_amend_content' );
function wp_learn_amend_content( $content ) {
    $additional_content = '<!-- wp:paragraph --><p>Filtered through <i>the_content</i></p><!-- /wp:paragraph -->';
    $content            = $content . $additional_content;

    return $content;
}

add_filter( 'get_the_excerpt', 'wp_learn_amend_the_excerpt', 12, 2 );
function wp_learn_amend_the_excerpt( $post_excerpt, $post ) {
    $additional_content = '<p>'. $post->post_title . ' Verified by Search Engine</p>';
    $post_excerpt       = $post_excerpt . $additional_content;

    return $post_excerpt;
}