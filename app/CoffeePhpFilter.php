<?php

namespace app;

use Assetic\Asset\AssetInterface;
use Assetic\Filter\FilterInterface;

class CoffeePhpFilter implements FilterInterface {

    public $options = array();

    public function __construct($options = array()) {
        $this->options = $options;
    }

    public function filterLoad(AssetInterface $asset) {
        // derp
    }

    public function filterDump(AssetInterface $asset) {
        $content = $asset->getContent();

        // Compiler::compile doesn't like empty strings

        try {
            if (trim($content)) {
                $this->options['filename'] = $asset->getSourcePath();
                $content = \CoffeeScript\Compiler::compile($content, $this->options);
            }
        } catch (Exception $e) {
            $content = $e->getMessage();
        }

        $asset->setContent($content);
    }

}
