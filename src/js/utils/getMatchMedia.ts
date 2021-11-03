/**
 * メディアクエリ
 * @example
 * ``const mediaQuery = getMatchMedia();
 *      if (mediaQuery.matches) {
 *          // do somthing
 *      } else {
 *          // do somthing
 *       }
 *      mediaQuery.addListener( () => {
 *          // do somthing
 *      })``
 */

export const SP_WIDTH = 767;
export default function getMatchMedia(mediaMaxWidth = SP_WIDTH): MediaQueryList | undefined {
  if (typeof window.matchMedia !== 'function') return;
  return window.matchMedia('screen and (max-width: ' + mediaMaxWidth + 'px)');
}
