<div class="l-page-content">
    <div class="u-gutter--lg u-container--lg">
    <?php if (have_posts()): ?>
        <div class="c-card-list">
            <?php while (have_posts()): the_post();
                get_template_part('template-parts/loop/card');
            endwhile;?>
        </div>
        <?php get_template_part('template-parts/common/pager');?>
    <?php else: get_template_part('template-parts/content/archive-none'); endif;?>
    </div>
</div>