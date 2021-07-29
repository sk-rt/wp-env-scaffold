<?php get_header(); ?>
<?php if (have_posts()) :  while ( have_posts() ) : the_post(); ?>
<article class="l-page-main">
    <div class="l-page-header">
        <h1 class="l-page-header__title">
            <?php the_title();?>
        </h1>
    </div>
    <div class="l-single-page-content">
        <?php the_content() ?>
    </div>
</article>
<?php endwhile; endif; ?>
<?php get_footer(); ?>
