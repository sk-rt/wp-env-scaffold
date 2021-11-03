
<?php use App\CustomTags as Tags; ?>
<div class="p-top-main">
    <section class="p-top-hero">
        <h2><?php bloginfo( "description" );?></h2>
    </section>
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
    <section class="p-top-news u-gutter--lg">
        <div class="p-top-news__inner ">
            <div class="p-top-news__header">
                <h2 class="p-top-news__title c-heading--md">News</h2>
                <a href="<?php echo Tags\get_blog_home_url(); ?>" class="p-top-news__link"><span>More</span><i class="c-icon-angle--right"></i></a>
            </div>
            <div class="p-top-news__list c-post-list">
                <?php foreach ($news_list as $post): setup_postdata($post);
                    get_template_part("template-parts/loop/post"); 
                endforeach;
                wp_reset_postdata();?>
            </div>
        </div>

    </section>
    <?php endif;?>
    
</div>