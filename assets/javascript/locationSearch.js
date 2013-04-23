$(document).ready(function(){
  // Autocomplete
  $('#location-search').autocomplete({
    serviceUrl: 'http://tagmosphere.be/wall/autocompleteLocation'
  });
});
