<?php get_header(); ?>
<div class="l-page-main">
    <div class="l-page-header">
        <h1 class="l-page-header__title">
            404 Not Found
        </h1>
    </div>
    <div class="p-404 l-page-content u-gutter--lg">
    <div class="u-container--sm">
        <h2 class="p-404__title">
            ページが見つかりませんでした。
        </h2>
        <div class="p-404__content">
            <a href="<?php echo home_url() ?>/" class="c-button is-lg">
                トップ
                <span class="c-button__icon is-angle is-left" aria-hidden="true">
                    <i class="c-icon-angle--left"></i>
                </span>
            </a>
        </div>
    </div>
</div>

</div>
<?php get_footer(); ?>