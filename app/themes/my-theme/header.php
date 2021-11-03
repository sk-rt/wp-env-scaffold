<?php use App\CustomTags as Tags; ?>
<!DOCTYPE html>
<html lang="ja" class="no-js">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
<?php get_template_part('template-parts/common/head');?>
</head>
<body <?php body_class(); ?>>
<header id="header" class="l-header">
   <div class="l-header__inner">
      <h1 class="l-header__site-name">
         <a href="<?php echo home_url(); ?>" title="<?php bloginfo('name');?>"><?php bloginfo('name');?></a>
      </h1>
      <button type="button" class="l-header__drawer-button" aria-label="Menu" data-drawer-nav-control="drawer">
         <div class="l-header__drawer-button__inner"><span></span></div>
      </button>
      <nav class="l-header__nav l-header-nav" data-drawer-nav-id="drawer">
         <ul class="l-header-nav__content">
         <?php $nav_list = Tags\get_global_nav_list();?>
            <?php foreach ($nav_list as $nav): ?>
                  <li class="l-header-nav__item <?=(!empty($nav['sub-items'])) ? 'has-sub-nav' : ''?> is-<?=$nav['name']?>" 
                  <?=(!empty($nav['sub-items'])) ? 'tabindex="0" role="button"' : ''?>>
                     <?php if ($nav['permalink']): ?>
                     <a href="<?=$nav['permalink'];?>" class="l-header-nav__link" data-nav-slug="<?=$nav['nav-slug'];?>" <?=$nav['disabled'] ? 'disabled' : ''?> >
                        <?=$nav['label'];?>
                     </a>
                     <?php else: ?>
                     <span class="l-header-nav__link is-no-link" data-nav-slug="<?=$nav['nav-slug'];?>">
                        <?=$nav['label'];?>
                        <?php if (!empty($nav['sub-items'])): ?>
                        <span class="c-icon-angle--bottom l-header-nav__link__icon"></span>
                        <?php endif;?>
                     </span>
                     <?php endif;?>
                     <?php if (!empty($nav['sub-items'])): ?>
                        <div class="l-header-nav__submenu">
                              <?php foreach ($nav['sub-items'] as $sub_item): ?>
                              <a href="<?=$sub_item['permalink'];?>"
                              class="l-header-nav__submenu__item"
                              <?=$nav['disabled'] ? 'disabled' : ''?>>
                                 <?=$sub_item['label'];?>
                              </a>
                              <?php endforeach;?>
                        </div>
                     <?php endif;?>
                  </li>

            <?php endforeach;?>
         </ul>
      </nav>
   </div>
</header>
<div id="pageWrapper" class="l-page-wrapper">
