<?php get_header(); ?>

<?php if (have_posts()) :  while ( have_posts() ) : the_post(); ?>
<?php 
$post_type = get_post_type();
$post_type_name = esc_html(get_post_type_object($post_type)->label );
?>
<div class="l-page-main">
    <div class="l-page-header">
        <h3 class="l-page-header__title">
        <?php echo $post_type_name; ?>
        </h3>
    </div>
    <div class="l-page-content u-gutter--lg">
        <div id="post-<?php the_ID();?>" class="c-article u-container--sm">
            <article class="c-article__inner">
                <div class="c-article__header">
                    <h1 class="c-article__title">
                        <?php the_title();?>
                    </h1>
                    <div class="c-article__meta ">
                        <time class="c-article__date" datetime="<?php the_time('c');?>" >
                            <?php echo esc_html(get_the_date()); ?>
                        </time>
                    </div>
                </div>
                <div class="c-article__eyecatch">
                    <?php if (has_post_thumbnail()):
                        the_post_thumbnail('medium', array('alt' => esc_attr(get_the_title())));
                    else: ?>
                    <?php endif;?>
                </div>
                <div class="c-article__content c-content">
                    <?php the_content() ?>
                </div>
            </article>
            <?php  get_template_part("template-parts/common/single-post-nav");  ?>
        </div>
    </div>
</div>
<?php endwhile; endif; ?>
<?php get_footer(); ?>
