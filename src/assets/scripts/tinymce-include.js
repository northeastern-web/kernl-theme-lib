(function() {

  // List of file includes
  var podsIncludes;

  // Catch the wp ajax request
  jQuery.post(
    ajaxurl,
    {
      'action': 'includes_request',
      'data':   'includes_request_id'
    },
    function(response) {
      podsIncludes = response;
    }
  );
})();

