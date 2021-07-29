const webpack = require('webpack');
const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const wpConfig = require('./.wp-env.json');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const environment = process.env.NODE_ENV || 'development';
const isDevelopment = environment === 'development';
const themePath = wpConfig.themes[0];
const themeName = ((themePath) => {
  const pathList = themePath.split('/');
  return pathList[pathList.length - 1] || pathList[pathList.length - 2];
})(themePath);

module.exports = {
  entry: {
    main: `${__dirname}/src/js/main.ts`,
  },
  target: 'web',
  mode: isDevelopment ? environment : 'production',
  devtool: isDevelopment ? 'inline-source-map' : false,
  resolve: {
    extensions: ['.ts', '.tsx', '.js'],
  },
  output: {
    path: isDevelopment
      ? path.resolve(__dirname, themePath)
      : path.resolve(__dirname, 'dist/', themeName),
    publicPath: themePath,
    filename: 'js/[name].js',
  },
  module: {
    rules: [
      {
        enforce: 'pre',
        test: /\.ts?$/,
        use: [
          {
            loader: 'eslint-loader',
            options: {
              fix: true,
              failOnError: true,
            },
          },
        ],
      },
      {
        test: /\.ts|js$/,
        use: [
          {
            loader: 'babel-loader',
            options: {
              presets: ['@babel/preset-env'],
            },
          },
          { loader: 'ts-loader' },
        ],
        exclude: [/node_modules\/(?!(swiper|dom7|axios|has-flag|supports-color)\/).*/],
      },
      {
        test: /\.(sa|sc|c)ss$/,
        use: [
          MiniCssExtractPlugin.loader,
          {
            loader: 'css-loader',
            options: {
              sourceMap: isDevelopment,
              url: false,
              importLoaders: 2,
            },
          },
          {
            loader: 'postcss-loader',
            options: {
              sourceMap: isDevelopment,
              postcssOptions: {
                plugins: [require('autoprefixer')],
              },
            },
          },
          {
            loader: 'sass-loader',
            options: {
              sourceMap: isDevelopment,
            },
          },
        ],
      },
    ],
  },
  plugins: [
    new webpack.DefinePlugin({
      NODE_ENV: JSON.stringify(environment),
    }),
    new MiniCssExtractPlugin({
      filename: 'css/style.css',
    }),
    new BrowserSyncPlugin({
      proxy: `localhost:${wpConfig.port}`,
      files: ['app/themes/**/*.php'],
    }),
  ],
};
