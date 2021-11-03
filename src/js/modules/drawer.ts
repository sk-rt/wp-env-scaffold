import ToggleController from './ToggleController';
export const drawer = () => {
  const toggleDrawer = new ToggleController({
    nameSpace: 'drawer-nav',
    activeClass: 'is-open',
  });
  toggleDrawer.params.onShow = (targetToggleID) => {
    document.body.classList.add(`is-${targetToggleID}-shown`);
  };
  toggleDrawer.params.onHide = (targetToggleID) => {
    document.body.classList.remove(`is-${targetToggleID}-shown`);
  };

  return toggleDrawer;
};
