<?php 
$post_type = get_post_type();
$post_type_archive_link = get_post_type_archive_link($post_type);

?>
<div class="c-post-navi">
	<div class="c-post-navi__inner">
        <?php if (get_previous_post()): ?>
            <a href="<?php echo get_permalink(get_previous_post()->ID); ?>" class="c-post-navi__item is-prev">
                <i class="c-icon-angle--left"></i>
                <span class="u-font-featured">Prev</span>
            </a>
        <?php else:?>
            <span class='c-post-navi__item is-prev is-disabled'>
                <i class="c-icon-angle--left"></i>
                <span class="u-font-featured">Prev</span>
            </span>
        <?php endif; ?>
        <a href="<?php echo $post_type_archive_link; ?>" class="c-post-navi__backtolist u-font-featured">
           All
        </a>
        <?php if (get_next_post()): ?>
            <a href="<?php echo get_permalink(get_next_post()->ID); ?>" class="c-post-navi__item is-next">
                <span class="u-font-featured">Next</span>
                <i class="c-icon-angle--right"></i>
            </a>
        <?php else:?>
            <span class='c-post-navi__item is-next is-disabled'>
                <span class="u-font-featured">Next</span>
                <i class="c-icon-angle--right"></i>
            </span>
        <?php endif; ?>
	</div>
</div>
