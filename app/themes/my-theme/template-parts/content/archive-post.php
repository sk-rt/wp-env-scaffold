<div class="l-page-content">
    <div class="u-gutter--lg u-container--md">
    <?php if (have_posts()): ?>
        <div class="c-post-list">
            <?php while (have_posts()): the_post();
                get_template_part('template-parts/loop/post');
            endwhile;?>
        </div>
        <?php get_template_part('template-parts/common/pager');?>
    <?php else: get_template_part('template-parts/content/archive-none'); endif;?>
    </div>
</div>