#  Boilerplate for WordPress website development

wp-env + webpack(TypeScript/Scss)

## Configuration

Edit [.wp-env.json](./.wp-env.json)  
Doc [@wordpress/env#wp-env-json](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-env/#wp-env-json)


## Usage

### Starting WordPress container

```
yarn && yarn wp-env:start
```


### Setup WordPress

Edit [wp-setup.config.js](./wp-setup.config.js)
```
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
yarn wp-env:cli {command}
# example
yarn wp-env:cli --info
yarn wp-env:cli user list
```
