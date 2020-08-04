# Fractal styleguide template loader for PHP and Handlebars

Use [Fractal Styleguide](https://fractal.build/) in your PHP project.

1. Create the component's mapping file using [Fractal's API](https://fractal.build/api/).

```javascript
const path = require('path');
const fs = require('fs');

function exportPaths() {
    const map = {};
    for (let item of fractal.components.flatten()) {
        map[`@${item.handle}`] = path.relative(process.cwd(), item.viewPath);
    }
    fs.writeFileSync('components-map.json', JSON.stringify(map, null, 2), 'utf8');
}

fractal.components.on('updated', function(){
    exportPaths();
});

fractal.cli.command('pathmap', function(opts, done){
    exportPaths();
    done();
});
```

2. Load the renderer library.
```php
$view_engine = new Renderer(
    get_template_directory() . '/component-library/',
    get_template_directory_uri() . '/component-library/assets'
);

// In some template file
$view_engine->render('@fractal-component-handle', ['data_prop' => 'value']);
```

Note: components-map.json should be in the same directory of the first argument passed to Renderer()

## Credits

[rodger](https://github.com/rogden)
[allmarkedup](https://github.com/allmarkedup)

## More info

(https://github.com/frctl/fractal/issues/190)[https://github.com/frctl/fractal/issues/190]