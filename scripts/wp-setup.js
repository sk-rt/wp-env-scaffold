/**
 * WordPress Setup
 */

/* eslint-disable no-console */
/* eslint-disable no-prototype-builtins */

const { execSync } = require('child_process');
const setUpConfig = require('../wp-setup.config');
console.log(setUpConfig);
if (typeof setUpConfig !== 'object') {
  console.error('No config');
  return;
}

const runWpCli = (command = '') => {
  try {
    const result = execSync(`wp-env run cli wp ${command}`);
    console.log(result.toString());
  } catch (error) {
    console.log(`[ERROR]`, error);
  }
};

if (setUpConfig && setUpConfig.hasOwnProperty('lang')) {
  console.log('Install language');
  runWpCli(`language core install ${setUpConfig.lang}`);
  runWpCli(`language core activate ${setUpConfig.lang}`);
}

if (setUpConfig && setUpConfig.hasOwnProperty('theme')) {
  console.log('Activate theme');
  runWpCli(`theme activate ${setUpConfig.theme}`);
}

if (setUpConfig && setUpConfig.hasOwnProperty('options')) {
  console.log('Update wp options');
  const options = setUpConfig.options;
  Object.keys(options).forEach((optionName) => {
    runWpCli(`option update ${optionName} ${options[optionName]}`);
  });
}
