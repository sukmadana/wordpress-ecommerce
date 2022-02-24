<?php

namespace Commerce\Config;

use Commerce\Taxonomy\Example;

class CustomTaxonomies
{
    public static function register($filter = 'init', $priority = 10)
    {
        add_action($filter, function(){
            $dir = new \DirectoryIterator(get_stylesheet_directory() . '/app/Taxonomy');

            foreach ($dir as $dirinfo) {

                if (!$dirinfo->isDot() && !in_array($dirinfo->getFilename(), ['CustomTaxonomy.php', 'Example.php']) ) {
                    $filename = $dirinfo->getFilename();

                    $filename = str_replace('.php', '', $filename);

                    $class = "\\Commerce\\Taxonomy\\{$filename}";

                    $class::register();
                }
            }
        }, $priority);
    }
}
