<?php get_header(); ?>

<main class="page-content">
    <div class="container">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <div class="page-inner">
                <h1 class="page-title"><?php the_title(); ?></h1>
                <div class="page-body">
                    <?php the_content(); ?>
                </div>
            </div>
        <?php endwhile; endif; ?>
    </div>
</main>

<?php get_footer(); ?>
