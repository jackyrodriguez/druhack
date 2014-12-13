<?php

/*Function for getting rest API from JSON*/
function httpGet($url)
{
    $ch = curl_init();  
 
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
//  curl_setopt($ch,CURLOPT_HEADER, false); 
    $output=curl_exec($ch);
 
    curl_close($ch);
    return $output;
}
 
 /** API CODE
 
	you can get the code from developer.here.com
 
 */
$parse_data = httpGet("http://api.data.gov.ph/catalogue/api/action/datastore_search?resource_id=7fe09aa9-e7d5-4e8b-8c25-0aa20cdc74cc&limit=5");
  //$parse_data = httpGet("dev.schooldata.com/json/school");

$parse_data_array = json_decode($parse_data, true);

/*Array of JSON data*/
echo "<pre>";
//var_dump($parse_data_array['result']['fields']);
echo "<hr>";
//var_dump($parse_data_array['result']['records']);
//var_dump($parse_data_array['result']['records']['3']["School_Name"]);
echo "</pre>"; 
$research = $parse_data_array['result']['records']['3']["School_Name"]." ".$parse_data_array['result']['records']['3']['Province'];
echo $research;
?>

<!-- Start Here maps HTML JS codes-->
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="initial-scale=1.0, width=device-width" />
  <link rel="stylesheet" type="text/css"
    href="http://js.api.here.com/v3/3.0/mapsjs-ui.css" />
  <script type="text/javascript" charset="UTF-8"
    src="http://js.api.here.com/v3/3.0/mapsjs-core.js"></script>
  <script type="text/javascript" charset="UTF-8"
    src="http://js.api.here.com/v3/3.0/mapsjs-service.js"></script>
  <script type="text/javascript" charset="UTF-8"
    src="http://js.api.here.com/v3/3.0/mapsjs-mapevents.js"></script>
  <script type="text/javascript"  charset="UTF-8"
    src="http://js.api.here.com/v3/3.0/mapsjs-ui.js"></script>
</head>
<body>
  <div id="map" style="width: 100%; height: 400px; background: grey" />
  <script  type="text/javascript" charset="UTF-8" >
    
/**
 * Calculates and displays the address details of  200 S Mathilda Ave, Sunnyvale, CA
 * based on a free-form text
 *
 *
 * A full list of available request parameters can be found in the Geocoder API documentation.
 * see: http://developer.here.com/rest-apis/documentation/geocoder/topics/resource-geocode.html
 *
 * @param   {H.service.Platform} platform    A stub class to access HERE services
 */
function geocode(platform) {
  var geocoder = platform.getGeocodingService(),
    geocodingParameters = {
      searchText: '<?php echo $research;?>'
    };

  geocoder.geocode(
    geocodingParameters,
    onSuccess,
    onError
  );
}
/**
 * This function will be called once the Geocoder REST API provides a response
 * @param  {Object} result          A JSONP object representing the  location(s) found.
 *
 * see: http://developer.here.com/rest-apis/documentation/geocoder/topics/resource-type-response-geocode.html
 */
function onSuccess(result) {
  var locations = result.Response.View[0].Result;
 /*
  * The styling of the geocoding response on the map is entirely under the developer's control.
  * A representitive styling can be found the full JS + HTML code of this example
  * in the functions below:
  */
  addLocationsToMap(locations);
  // ... etc.
}

/**
 * This function will be called if a communication error occurs during the JSON-P request
 * @param  {Object} error  The error message received.
 */
function onError(error) {
  alert('Ooops!');
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

//Step 2: initialize a map - this map is centered over California
var map = new H.Map(document.getElementById('map'),
  defaultLayers.normal.map,{
  center: {lat:14.58865,lng:120.98453},
  zoom: 15
});

//Step 3: make the map interactive
// MapEvents enables the event system
// Behavior implements default interactions for pan/zoom (also on mobile touch environments)
var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));

// Create the default UI components
var ui = H.ui.UI.createDefault(map, defaultLayers);

// Hold a reference to any infobubble opened
var bubble;

/**
 * Opens/Closes a infobubble
 * @param  {H.geo.Point} position     The location on the map.
 * @param  {String} text              The contents of the infobubble.
 */
function openBubble(position, text){
 if(!bubble){
    bubble =  new H.ui.InfoBubble(
      position,
      {content: text});
    ui.addBubble(bubble);
  } else {
    bubble.setPosition(position);
    bubble.setContent(text);
    bubble.open();
  }
}


/**
 * Creates a series of H.map.Markers for each location found, and adds it to the map.
 * @param {Object[]} locations An array of locations as received from the
 *                             H.service.GeocodingService
 */
function addLocationsToMap(locations){
  var group = new  H.map.Group(),
    position,
    i;

  // Add a marker for each location found
  for (i = 0;  i < locations.length; i += 1) {
    position = {
      lat: locations[i].Location.DisplayPosition.Latitude,
      lng: locations[i].Location.DisplayPosition.Longitude
    };
    marker = new H.map.Marker(position);
    marker.label = locations[i].Location.Address.Label;
    group.addObject(marker);
  }

  group.addEventListener('tap', function (evt) {
    map.setCenter(evt.target.getPosition());
    openBubble(
       evt.target.getPosition(), evt.target.label);
  }, false);

  // Add the locations group to the map
  map.addObject(group);
  map.setCenter(group.getBounds().getCenter());
}

// Now use the map as required...
geocode(platform);

  </script>
</body>
</html>