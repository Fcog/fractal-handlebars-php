<?php

namespace FractalHandlebars;

use Handlebars\Loader;

class FractalMapLoader implements Loader {

    /**
     * An array of @handle => component path mappings
     * @var array
     */
    private $componentMap;

    /**
     * The path to the component library directory
     * @var string
     */
    private $componentLibPath;

    public function __construct( $componentLibPath, $componentMapFile ) {
        $this->componentLibPath = $componentLibPath;
        $this->componentMap = $this->loadMap( $componentMapFile );
    }

    private function loadMap( $componentMapFile ) {
        $fileContents = file_get_contents( $componentMapFile );

        return json_decode( $fileContents, true );
    }

    public function load( $name ) {
        if ( isset( $this->componentMap[$name] ) ) {
            return file_get_contents( $this->componentLibPath . '/' . $this->componentMap[$name] );
        }

        throw new \RuntimeException(
            "Can not find the $name template"
        );
    }
}
