<?php
add_action( 'after_setup_theme', 'wp_learn_setup_theme');

function wp_learn_setup_theme() {
    add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );
}