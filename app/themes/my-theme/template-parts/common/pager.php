<?php
/**
 * 一覧ページャー
 */
global $wp_rewrite;
$paginate_base = get_pagenum_link(1);
if (strpos($paginate_base, '?') || ! $wp_rewrite->using_permalinks()):
	$paginate_format = '';
	$paginate_base = add_query_arg('paged', '%#%');
else:
	$paginate_format = (substr($paginate_base, -1 ,1) == '/' ? '' : '/') .
	user_trailingslashit('page/%#%/', 'paged');;
	$paginate_base .= '%_%';
endif;
if($wp_query->max_num_pages > 1):
$pager_arr = paginate_links( array(
	'base' => $paginate_base,
	'format' => $paginate_format,
	'total' => $wp_query->max_num_pages,
	// 'total' => 99,
	'mid_size' => 1,
	'end_size' =>1,
	'type'=> 'array',
	'current' => ($paged ? $paged : 1),
	'prev_text'=> '<i class="c-icon-angle--left" aria-label="Prev"></i>',
	'next_text'=> '<i class="c-icon-angle--right" aria-label="Next"></i>'
));
?>
<nav class="c-pager">
    <div class="c-pager__count">
        <?php echo ($paged ? $paged : 1)."/".$wp_query->max_num_pages; ?>
    </div>
	<div class="c-pager__container">
	<?php foreach($pager_arr as $link):?>
	<?php echo $link ?>
	<?php endforeach; ?>
	</div>
</nav>
<?php endif; ?>
