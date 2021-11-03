<?php get_header();?>
<?php
$post_type = get_post_type() ? get_post_type() : get_query_var( 'post_type' );
$post_type_name = '';
if ($post_type && $post_type_obj = get_post_type_object($post_type)) {
    $post_type_name = esc_html($post_type_obj->label);
}
?>
<main class="l-page-main">
    <div class="l-page-header u-gutter--lg">
        <h3 class="l-page-header__title">
            <?php the_archive_title();?>
        </h3>
    </div>
    <?php  get_template_part('template-parts/content/archive-' . $post_type); ?>

</main>
<?php get_footer();?>
