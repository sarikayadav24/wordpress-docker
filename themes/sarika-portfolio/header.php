<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="site-header" id="site-header">
    <div class="container">
        <div class="header-inner">

            <!-- Logo / Name -->
            <div class="site-logo">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <?php bloginfo( 'name' ); ?>
                </a>
            </div>

            <!-- Navigation -->
            <nav class="site-nav" id="site-nav">
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'menu_class'     => '',
                    'container'      => false,
                    'fallback_cb'    => function() {
                        // Fallback to hardcoded links if no menu is assigned in WP admin
                        echo '<ul>';
                        echo '<li><a href="' . esc_url( home_url( '/' ) ) . '#about">About</a></li>';
                        echo '<li><a href="' . esc_url( home_url( '/' ) ) . '#skills">Skills</a></li>';
                        echo '<li><a href="' . esc_url( home_url( '/' ) ) . '#projects">Projects</a></li>';
                        echo '<li><a href="' . esc_url( home_url( '/contact' ) ) . '">Contact</a></li>';
                        echo '</ul>';
                    },
                ) );
                ?>
            </nav>

            <!-- Hamburger for mobile -->
            <button class="nav-toggle" id="nav-toggle" aria-label="Toggle navigation">
                <span></span>
                <span></span>
                <span></span>
            </button>

        </div>
    </div>
</header>
