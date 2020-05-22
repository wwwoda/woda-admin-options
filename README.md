# WordPress Plugin - Woda Admin Options

> Create an carbon fields options page and expose the container to other plugins

This plugin utilizes the [Carbon Fields](https://carbonfields.net/) WordPress custom fields library. Read the [documentation](https://docs.carbonfields.net/) to understand how you can use it to create custom options pages and fields.

## Installation

You can install the plugin by uploading it in the WordPress Admin or via `composer`.

```bash
composer require woda/wp-admin-options
```

If you installed the plugin via `composer` you will have to initialize it yourself to be able to use it. Add this to your theme's function file

```php
Woda\WordPress\AdminOptions\Init::init();
```

## Configure

```php
add_filter('woda_admin_options_settings', static function($settings) {
    return [
            // (string) The text to be displayed in the title tags of the page when the menu is selected.
            'containerLabel' => __('Admin Options', 'textdomain'),
            // (string) The URL to the icon to be used for this menu.
            // * Pass an SVG which will be base64-encoded automatically for you
            // * Pass a base64-encoded SVG using a data URI, which will be colored to match the color scheme. This should begin with 'data:image/svg+xml;base64,'.
            // * Pass the name of a Dashicons helper class to use a font icon, e.g. 'dashicons-chart-pie'.
            // * Pass 'none' to leave div.wp-menu-image empty so an icon can be added via CSS.
            'containerIcon' => 'dashicons-carrot',
        ];
}, 10, 1);
```

## Useage

### Add a new options page under the main options page

```php
use Carbon_Fields\Container;

add_action('carbon_fields_register_fields', static function (): void {
    $container = Woda\WordPress\AdminOptions\Core\Container::getContainer();
    Container::make('theme_options', 'New Options')
        ->set_page_parent($container);
});
```

### Add fields to the main options page

```php
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', static function (): void {
    $container = Woda\WordPress\AdminOptions\Core\Container::getContainer();
    $container->add_fields( array(
        Field::make( 'color', 'crb_background_color', __( 'Background Color' ) ),
        Field::make( 'image', 'crb_background_image', __( 'Background Image' ) ),
    ) );
});
```

## Docs

- [Carbon Fields](https://carbonfields.net/)
  - [Documentation](https://docs.carbonfields.net/)
  - [Theme Options](https://docs.carbonfields.net/#/containers/theme-options)
