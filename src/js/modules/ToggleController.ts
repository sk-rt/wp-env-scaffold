/**
 * @example
 * <button data-toggle-control="targetid">TOGGLE</button>
 * <div data-toggle-id="targetid">
 * </div>
 *
 */
import addListener, { RemoveListener } from '../utils/eventHandler';
export interface ToggleParams {
  nameSpace: string;
  activeClass: string;
  onShow: (targetToggleID?: string, targetEl?: HTMLElement) => void;
  onHide: (targetToggleID?: string, targetEl?: HTMLElement) => void;
}
export enum ToggleActions {
  SHOW,
  HIDE,
  TOGGLE,
}
export default class ToggleController {
  params: ToggleParams;
  removeListeners: RemoveListener[] = [];
  toggleControlSelector: string;
  toggleActionSelector: string;
  constructor(params: Partial<ToggleParams>) {
    this.params = {
      nameSpace: 'toggle',
      activeClass: 'is-active',
      onShow: () => {},
      onHide: () => {},
      ...params,
    };
    this.toggleControlSelector = `data-${this.params.nameSpace}-control`;
    this.toggleActionSelector = `data-${this.params.nameSpace}-action`;
    this.removeListeners = this.init();
  }
  init(): RemoveListener[] {
    const targetEls = document.querySelectorAll(`[${this.toggleControlSelector}]`);
    return [].slice.call(targetEls).map((element: Element) => {
      return addListener(
        element,
        'click',
        () => {
          const targetID = element.getAttribute(this.toggleControlSelector);
          const action = ((_action) => {
            switch (_action) {
              case 'SHOW':
                return ToggleActions.SHOW;
              case 'HIDE':
                return ToggleActions.HIDE;
              default:
                return ToggleActions.TOGGLE;
            }
          })(element.getAttribute(this.toggleActionSelector));

          if (targetID) {
            this.action(targetID, action);
          }
        },
        false
      );
    });
  }
  destroy() {
    if (this.removeListeners) {
      this.removeListeners.forEach((f) => f());
    }
  }
  action(targetToggleID: string, mehtods: ToggleActions) {
    const targetEls = document.querySelectorAll(
      `[data-${this.params.nameSpace}-id=${targetToggleID}]`
    );
    [].slice.call(targetEls).forEach((element: HTMLElement) => {
      const addClass =
        element.getAttribute(`data-${this.params.nameSpace}-class`) || this.params.activeClass;
      const isShown = element.classList.contains(addClass);
      switch (mehtods) {
        case ToggleActions.SHOW:
          element.classList.add(addClass);
          element.setAttribute('aria-hidden', 'false');
          this.params.onShow(targetToggleID, element);
          break;
        case ToggleActions.HIDE:
          element.setAttribute('aria-hidden', 'true');
          element.classList.remove(addClass);
          this.params.onHide(targetToggleID, element);
          break;
        default:
          if (isShown) {
            element.setAttribute('aria-hidden', 'true');
            element.classList.remove(addClass);
            this.params.onHide(targetToggleID, element);
          } else {
            element.setAttribute('aria-hidden', 'false');
            element.classList.add(addClass);
            this.params.onShow(targetToggleID, element);
          }
      }
    });
  }
}
