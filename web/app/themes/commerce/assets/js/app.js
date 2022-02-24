// you can import modules from the theme lib or even from
// NPM packages if they support it…
import ExampleComponent1 from "./components/ExampleComponent1";
import SingleProductAjax from "./components/SingleProductAjax";
import Checkout from "./components/Checkout";

// you can also require modules if they support it…
const ExampleModule2 = require('./components/example-2');

// Some convenient tools to get you started…
import ReplaceObfuscatedEmailAddresses from "./components/ReplaceObfuscatedEmailAddresses";
import AnimateOnPageLinks from "./components/AnimateOnPageLinks";


// Initialise our components on jQuery.ready…
jQuery(function ($) {
    // ExampleComponent1.init();
    // ExampleModule2.init();
    ReplaceObfuscatedEmailAddresses.init();
    AnimateOnPageLinks.init();
});

new SingleProductAjax()
new Checkout()