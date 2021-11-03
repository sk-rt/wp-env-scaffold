'use strict';

import '../scss/style.scss';
import { drawer } from './modules/drawer';
import { smoothScroll } from './modules/smoothScroll';
import { currentNavi } from './modules/currentNavi';

document.addEventListener(
  'DOMContentLoaded',
  () => {
    main();
  },
  false
);

const main = () => {
  drawer();
  smoothScroll();
  currentNavi();
};
