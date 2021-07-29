

<div class="p-top-main">
    <?php if (have_posts()) :  while ( have_posts() ) : the_post(); ?>
    <section class="p-top-content">
        <?php the_content() ?>
    </section>
    <?php endwhile; endif; ?>


    <?php

    /* News */
    $news_arg = array(
        'post_type' => 'post',
        'posts_per_page' => 4,
    );
    $news_list = get_posts($news_arg);

    ?>
    <?php if ($news_list): ?>
    <section id="recentNews" class="p-top-news u-gutter--lg">
        <div class="p-top-news__inner ">
            <div class="p-top-news__header">
                <h2 class="p-top-news__title c-heading-featured">
                News
                </h2>
                <a href="<?php echo util_get_blog_home_url(); ?>" class="p-top-news__link u-font-featured"><span>More</span><i class="c-icon-angle--right"></i></a>
            </div>
                
            <div class="p-top-news__list">
                <?php foreach ($news_list as $post): setup_postdata($post);
                    get_template_part("template-parts/loop/post"); 
                endforeach;
                wp_reset_postdata();?>
            </div>
        </div>

    </section>
    <?php endif;?>
    
</div>