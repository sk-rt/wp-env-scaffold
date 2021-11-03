/**
 * Element to String
 */
export const domToString = (element: HTMLElement) => {
  return element.outerHTML;
};
/**
 * String to Element
 */
export const stringToElement = (htmlString: string, wrapperTag = 'div') => {
  const wrapperEl = document.createElement(wrapperTag);
  wrapperEl.innerHTML = htmlString;
  return wrapperEl;
};

export const isVissible = (targetElement: HTMLElement) => {
  // 先祖要素がdisplay: none
  if (targetElement.offsetParent === null) {
    return false;
  }
  const style = getComputedStyle(targetElement);
  // 先祖要素かその要素が visibility: hidden;
  // console.log(targetElement.getAttribute('name'));
  // console.log({ display: style.display, visibility: style.visibility });
  if (style.display === 'none' || style.visibility === 'hidden') {
    return false;
  }
  return true;
};
