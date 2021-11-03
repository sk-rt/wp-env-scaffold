'use strict';

import '../scss/main.scss';

// generate SVG Sprite
import '../assets/svg/icon_arrow.svg';
import '../assets/svg/icon_external.svg';
import '../assets/svg/icon_pdf.svg';
import '../assets/svg/icon_search.svg';

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
