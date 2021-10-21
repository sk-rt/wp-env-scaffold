#  Boilerplate for WordPress website development

[wp-env](https://www.npmjs.com/package/@wordpress/env) + frontend   webpack(TypeScript/scss)

## Configuration

Edit [.wp-env.json](./.wp-env.json)  
Doc [@wordpress/env#wp-env-json](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-env/#wp-env-json)


## Usage

### Starting WordPress container

```sh
yarn && yarn wp-env:start
```


### Setup WordPress

- Install languege
- Activete theme & plugins
- Update wp_options

Edit [wp-setup.config.js](./wp-setup.config.js)

```sh
yarn wp-env:setup
```

### Stating frontend development server (Webpack)

```
yarn dev
```


### Production build

frontend build & dist theme

```
yarn build
```

### WP-CLI

```sh
yarn wp:cli {command}
# example
yarn wp:cli --info
yarn wp:cli user list
```
