<?php

namespace Commerce\Taxonomy;

use Commerce\Taxonomy\CustomTaxonomy;

class ProductMaterial extends CustomTaxonomy
{
    protected static $taxonomyName = 'product_material';

    protected static $singularName = 'Product Material';

    protected static $pluralName = 'Product Materials';

    protected static $objectType = array(
        'product',
    );
}
