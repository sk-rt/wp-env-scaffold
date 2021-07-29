<?php get_header();?>
<?php
$post_type = get_query_var('post_type');
$post_type_name = '';
if ($post_type && $post_type_obj = get_post_type_object($post_type)) {
    $post_type_name = esc_html($post_type_ob->label);
}
?>
<main class="l-page-main">
    <div class="l-page-header">
        <h3 class="l-page-header__title">
            <?php the_archive_title();?>
        </h3>
    </div>
    <div class="l-page-content u-gutter--lg">
        <div class="u-container--md">
        <?php if (have_posts()): ?>
            <div class="c-postlist">
                <?php while (have_posts()): the_post();
                    get_template_part('template-parts/loop/' . $post_type);
                endwhile;?>
            </div>
            <?php get_template_part('template-parts/common/pager');?>
            <?php else: get_template_part('template-parts/content/none'); endif;?>
        </div>
    </div>

</main>
<?php get_footer();?>
