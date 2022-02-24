<?php

namespace Commerce\Config;

use Commerce\PostType\Example;

class CustomPostTypes
{
    public static function register($filter = 'init', $priority = 10)
    {
        add_action($filter, function(){
            $dir = new \DirectoryIterator(get_stylesheet_directory() . '/app/PostType');

            foreach ($dir as $dirinfo) {

                if (!$dirinfo->isDot() && !in_array($dirinfo->getFilename(), ['CustomPostType.php', 'Example.php']) ) {
                    $filename = $dirinfo->getFilename();

                    $filename = str_replace('.php', '', $filename);

                    $class = "\\Commerce\\PostType\\{$filename}";

                    $class::register();
                }
            }
        }, $priority);
    }
}
