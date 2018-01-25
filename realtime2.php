<html><head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title> - jsFiddle demo</title>
  <style type="text/css">
  .coord {
    margin: 20px;
    font-size: 36px
  }
  </style>


<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript">//<![CDATA[

  var apiGeolocationSuccess = function(position) {
      alert("API geolocation success!\n\nlat = " + position.coords.latitude + "\nlng = " + position.coords.longitude);
  };

  var tryAPIGeolocation = function() {
      jQuery.post( "https://www.googleapis.com/geolocation/v1/geolocate?key=AIzaSyBnvsNbQDmtmlPIG422XIkbb_E8d66HLyU", function(success) {
          apiGeolocationSuccess({coords: {latitude: success.location.lat, longitude: success.location.lng}});
      })
          .fail(function(err) {
              alert("API Geolocation error! \n\n"+err);
          });
  };

  var browserGeolocationSuccess = function(position) {
  //    alert("Browser geolocation success!\n\nlat = " + position.coords.latitude + "\nlng = " + position.coords.longitude);
  document.getElementById('result').innerHTML = position.coords.latitude + ", " + position.coords.longitude;
  };

  var browserGeolocationFail = function(error) {
      switch (error.code) {
          case error.TIMEOUT:
              alert("Browser geolocation error !\n\nTimeout.");
              break;
          case error.PERMISSION_DENIED:
              if(error.message.indexOf("Only secure origins are allowed") == 0) {
                  tryAPIGeolocation();
              }
              break;
          case error.POSITION_UNAVAILABLE:
              // dirty hack for safari
              if(error.message.indexOf("Origin does not have permission to use Geolocation service") == 0) {
                  tryAPIGeolocation();
              } else {
                  alert("Browser geolocation error !\n\nPosition unavailable.");
              }
              break;
      }
  };

  var tryGeolocation = function() {
      if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(
              browserGeolocationSuccess,
              browserGeolocationFail,
              {maximumAge: 50000, timeout: 20000, enableHighAccuracy: true});
      }
  };

  tryGeolocation();

</script>


</head>
<body>
    <p id="geolocation">Watching geolocation...</p>
    <p>&nbsp;</p>
    <div id="result" class="coord"></div>

</body></html>
