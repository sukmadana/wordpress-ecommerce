<?php

namespace Commerce\Taxonomy;

use Commerce\Taxonomy\CustomTaxonomy;

class ProductColor extends CustomTaxonomy
{
    protected static $taxonomyName = 'product_color';

    protected static $singularName = 'Product Color';

    protected static $pluralName = 'Product Colors';

    protected static $objectType = array(
        'product'
    );
}
