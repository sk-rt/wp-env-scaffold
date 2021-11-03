/**
 * アニメートスクロール
 */
import addListener, { RemoveListener } from '../utils/eventHandler';
import smoothscroll from 'smoothscroll-polyfill';
smoothscroll.polyfill();

export interface SmoothScrollOptions {
  offset: number;
  delay: number;
  behavior: ScrollBehavior;
}
/**
 * イベント初期化
 * @param anchorSelector
 * @param options
 */
const _defOptions: SmoothScrollOptions = {
  offset: 0,
  delay: 0,
  behavior: 'smooth',
};
export const smoothScroll = (
  anchorSelector: string = 'a[href^="#"]',
  options?: Partial<SmoothScrollOptions>
) => {
  const initialOptions: SmoothScrollOptions = {
    ..._defOptions,
    ...options,
  };

  const scrollToElement = getScrollToEl(initialOptions);
  const removeListeners: RemoveListener[] = [].slice
    .call(document.querySelectorAll(anchorSelector))
    .map((element: HTMLElement) => {
      return addListener(
        element,
        'click',
        (event) => {
          event.preventDefault();
          let href = element.getAttribute('href');
          if (href === '#' || !href) href = 'body';
          const delay = Number(element.getAttribute('data-scroll-delay') || initialOptions.delay);
          const offset = Number(
            element.getAttribute('data-scroll-offset') || initialOptions.offset
          );
          scrollToElement(href, {
            offset: offset,
            delay: delay,
            behavior: initialOptions.behavior,
          });
        },
        false
      );
    });
  return {
    destroy: () => removeListeners.forEach((r) => r()),
    scrollToElement: scrollToElement,
    options: options,
  };
};

export const getScrollToEl = (defOptions: SmoothScrollOptions = _defOptions) => {
  return (target: string | HTMLElement, options?: Partial<SmoothScrollOptions>) => {
    const _options = { ...defOptions, ...options };
    const targetEl =
      typeof target === 'string' ? document.querySelector<HTMLElement>(target) : target;
    if (!targetEl) return;
    const offsetTop = targetEl.getBoundingClientRect().top + window.pageYOffset + _options.offset;
    setTimeout(() => {
      window.scrollTo({
        top: offsetTop,
        behavior: _options.behavior,
      });
    }, _options.delay);
    return false;
  };
};
