<?php use App\CustomTags as Tags; ?>
<footer class="l-footer">
    <a href="#" aria-label="Page Top"><i class="c-icon-angle--top"></i></a>
    <div class="l-footer__inner">
        <h2 class="l-footer__author">
            <a href="https://github.com/sk-rt/docker-wordpress-theme-dev"  target="_blank" rel="noopener noreferrer">
            @sk-rt
            </a>
        </h2>
        <nav class="l-footer__nav l-footer-nav" data-drawer-nav-id="drawer">
        <?php $nav_list = Tags\get_global_nav_list();?>
            <a href="<?=home_url()?>" class="l-footer-nav__link" >
                Top
            </a>
            <?php foreach ($nav_list as $nav): ?>
                <?php if ($nav['permalink']): ?>
                <a href="<?=$nav['permalink'];?>" class="l-footer-nav__link" <?=$nav['disabled'] ? 'disabled' : ''?> >
                <?=$nav['label'];?>
                </a>
                <?php else: ?>
                <span class="l-footer-nav__link is-no-link">
                    <?=$nav['label'];?>
                </span>
                <?php endif;?>
            <?php endforeach;?>
        </nav>
    </div>
</footer>
</div><!--/#pageWrapper -->

<?php wp_footer(); ?>
</body>
</html>
