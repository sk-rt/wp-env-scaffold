/**
 * 不要なembedを削除
 */
wp.domReady(() => {
  // console.log(wp.blocks.getBlockVariations('core/embed').map((variation) => variation.name));
  const allowedEmbedVariation = [
    'youtube',
    'vimeo',
    'twitter',
    'facebook',
    'instagram',
    'wordpress',
  ];
  wp.blocks.getBlockVariations('core/embed').forEach((variation) => {
    if (allowedEmbedVariation.indexOf(variation.name) !== -1) return;
    wp.blocks.unregisterBlockVariation('core/embed', variation.name);
  });
});
