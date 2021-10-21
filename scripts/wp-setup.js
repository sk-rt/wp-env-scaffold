/**
 * WordPress Setup
 */

/* eslint-disable no-console */
/* eslint-disable no-prototype-builtins */

const { execSync } = require('child_process');
const readlineSync = require('readline-sync');

const setUpConfig = require('../wp-setup.config');
if (typeof setUpConfig !== 'object') {
  console.error('No config');
  return;
}

const runWpCli = (command = '') => {
  try {
    const result = execSync(`yarn wp:cli ${command}`);
    console.log(result.toString());
  } catch (error) {
    console.log(`[ERROR]`, error.toString());
  }
};

if (setUpConfig.lang) {
  if (readlineSync.keyInYN(`Install languge? "${setUpConfig.lang}"`)) {
    runWpCli(`language core install ${setUpConfig.lang}`);
    runWpCli(`site switch-language ${setUpConfig.lang}`);
  }
}

if (setUpConfig.theme) {
  if (readlineSync.keyInYN(`Activate theme? "${setUpConfig.theme}" `)) {
    runWpCli(`theme activate ${setUpConfig.theme}`);
  }
}

if (setUpConfig.plugins) {
  if (readlineSync.keyInYN(`Activete plugins? "${setUpConfig.plugins.join(',')}"`)) {
    const plugins = setUpConfig.plugins;
    plugins.forEach((plugin) => {
      runWpCli(`plugin install ${plugin} --activate`);
    });
  }
}

if (setUpConfig.options) {
  if (readlineSync.keyInYN(`Update wp options?`)) {
    const options = setUpConfig.options;
    Object.keys(options).forEach((optionName) => {
      runWpCli(`option update ${optionName} ${options[optionName]}`);
    });
  }
}
