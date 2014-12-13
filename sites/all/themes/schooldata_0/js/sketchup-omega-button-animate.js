// JavaScript Document

(function($, Drupal) {
// Magic incantation line 1. The Drupal.behaviors. is mandatory,
// the viewsUiPreview is arbitrary.
Drupal.behaviors.viewsUiPreview = {
  // Magic incantation line 2.
  attach: function (context, settings) {
    // #preview-submit is a selector and context must be
    // passed into jQuery so for an AJAX request only the
    // new content is used.


  function moveMapToBerlin(map){
  map.setCenter({lat:52.5159, lng:13.3777});
  map.setZoom(14);
}





/**
 * Boilerplate map initialization code starts below:
 */

//Step 1: initialize communication with the platform
var platform = new H.service.Platform({
  app_id: 'DemoAppId01082013GAL',
    app_code: 'AJKnXv84fjrb0KIHawS0Tg',
    useCIT: true
});
var defaultLayers = platform.createDefaultLayers();

//Step 2: initialize a map  - not specificing a location will give a whole world view.
var map = new H.Map(document.getElementById('map'),
  defaultLayers.normal.map);

//Step 3: make the map interactive
// MapEvents enables the event system
// Behavior implements default interactions for pan/zoom (also on mobile touch environments)
var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));

// Create the default UI components
var ui = H.ui.UI.createDefault(map, defaultLayers);

// Now use the map as required...
moveMapToBerlin(map);


  }
}
})(jQuery, Drupal);
