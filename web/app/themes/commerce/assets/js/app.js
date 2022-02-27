
import SingleProductAjax from "./components/SingleProductAjax";
import Checkout from "./components/Checkout";


import ReplaceObfuscatedEmailAddresses from "./components/ReplaceObfuscatedEmailAddresses";
import AnimateOnPageLinks from "./components/AnimateOnPageLinks";
import initSal from './utils/sal'


// Initialise our components on jQuery.ready…
jQuery(function ($) {
    ReplaceObfuscatedEmailAddresses.init();
    AnimateOnPageLinks.init();
});

initSal.init()

new SingleProductAjax()
new Checkout()