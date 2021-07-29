
<a id="post-<?php the_ID();?>"
    href="<?php the_permalink();?>"
    <?php post_class('c-post-item ');?> >
   
    <div class="c-post-item__inner">
        <div class="c-post-item__meta">
            <time class="c-post-item__meta__date" datetime="<?php the_time('c');?>" >
                <?php echo esc_html(get_the_date()); ?>
            </time>
        </div>
        <div class="c-post-item__content">
            <h4 class="c-post-item__heading">
                <?php the_title();?>
            </h4>
        </div>
    </div>
</a>
