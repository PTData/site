/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */

import 'bootstrap';
import $ from 'jquery';
import 'fontawesome';
import './styles/bootstrap.min.css';
import './styles/app.css';
import './styles/fontawesome/css/fontawesome.css';
import './styles/fontawesome/css/brands.css';
import './styles/fontawesome/css/solid.css';


$( document ).ready(function() {
    console.log( "ready, not!" );
});


console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
/*
$( document ).ready(function() {
    console.log( "ready!" );
});
*/