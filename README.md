By default, all administrators can access the options page.

Limit users' access to the options page by defining allowed email domains. 
```
add_filter('woda_super_admin_allowed_email_domains', static function($addresses) {
    $addresses[] = 'woda.at';
    return $addresses;
}, 10, 1);
```

You can tweak and extend the Carbon Fields container like this
```
add_action('carbon_fields_register_fields', static function () {
    $container = Woda\WordPress\AdminOptions\Manager::getContainer();
    if (isset($container)) {
        $container
            ->set_icon('dashicons-carrot')
            ->add_fields( array(
                Carbon_Fields\Field::make('text', Woda\WordPress\AdminOptions\Manager::prefixOptionName('custom_option'), 'Custom Option')
            ) );
    }
});
```
