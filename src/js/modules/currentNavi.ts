/***********************************


ナビにカレントclass追加


************************************/
export const currentNavi = () => {
  const canonical = location.pathname;
  const navAttr = `data-nav-slug`;
  const navElms: HTMLElement[] = [].slice.call(document.querySelectorAll(`[${navAttr}]`));
  if (navElms.length === 0 || canonical === (window as any).WP_HOME) {
    return;
  }
  navElms.forEach((elm) => {
    if (canonical.match(elm.getAttribute(navAttr) || '')) {
      elm.classList.add('is-current');
    } else {
      elm.classList.remove('is-current');
    }
  });
};
