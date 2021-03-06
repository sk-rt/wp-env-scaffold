const webpack = require('webpack');
const path = require('path');
const wpConfig = require('./.wp-env.json');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const ESLintPlugin = require('eslint-webpack-plugin');

const environment = process.env.NODE_ENV || 'development';
const isDevelopment = environment === 'development';
const themePath = wpConfig.themes[0];

module.exports = {
  entry: {
    main: `${__dirname}/src/js/main.ts`,
    'admin-editor': `${__dirname}/src/js/admin-editor.ts`,
  },
  target: 'web',
  mode: isDevelopment ? environment : 'production',
  devtool: isDevelopment ? 'inline-source-map' : false,
  resolve: {
    extensions: ['.ts', '.tsx', '.js'],
  },
  output: {
    path: path.resolve(__dirname, themePath),
    publicPath: themePath,
    filename: 'js/[name].js',
  },
  module: {
    rules: [
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
      {
        test: /\.svg$/,
        use: [
          {
            loader: 'svg-sprite-loader',
          },
        ],
      },
    ],
  },
  plugins: [
    new ESLintPlugin({
      extensions: ['.ts', '.js'],
      fix: true,
    }),

    new webpack.DefinePlugin({
      NODE_ENV: JSON.stringify(environment),
    }),
    new MiniCssExtractPlugin({
      filename: 'css/[name].css',
    }),
    new BrowserSyncPlugin({
      proxy: `localhost:${wpConfig.port}`,
      files: ['app/themes/**/*.php'],
    }),
  ],
};
