<?php
include('../model/model.php');
?>
<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <title>Mobile GeoStations San Francisco</title>
    <link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
    <link href='css/styles.css' rel='stylesheet' type='text/css'>
    <meta name="description" content="Choose your route to display each station's geolocation. Click on a station to view information on next departing trains.">
    <meta name="keywords" content="san francisco, san francisco transit, san francisco transport, transit, transport, bart, station, stations, geostation, geostations">
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-47223925-1', 'geostations.com');
  ga('send', 'pageview');
</script>
</head>
<body onload="initialize();">
    <div id="header">
    	<ul id="headers">
           <li><h3>GeoStations: San Francisco</h3></li>
           <li><h4>Real-Time Transit</h4></li>
        </ul>
    </div>
    <div class="floats" id="select_div">
                    <form>
                    <select id="select_route" onChange="routeId();newRoute();">
                    <option id="0">Choose Your Route</option>
                    <?php
                      foreach ($routes=get_routes() as $row)
                        {
                        foreach ($row as $column => $key)
                                {
                                    if ($column == 'number')
                                        echo '<option id="'.$key;
                                    elseif ($column == 'color')
                                        echo '" value="'.$key.'">';
                                    elseif ($column == 'name')
                                        echo $key.'</option>';
                                }
                        }
                      ?>
                      </select>
                      </form>
    </div>
    <div class="floats" id="info_div">
        <p>Choose your route to display each station's geolocation.<br>
        Click on a station to view information on next departing trains.</p>
        <button onClick="$('#info_div').css('display','none');");>OK</button>
    </div>
    
    <div id="map_canvas_wrapper">
                <div id="map_canvas">
                    <noscript id="noscript"><p>Please enable javascript to enjoy the site's full functionality.</p></noscript>
                </div>
    </div>
    
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>
<script type="text/javascript" src="js/stations.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("body").height($(window).height() - ($("body").offset().top + ($("body").outerHeight(true) - $("body").height())));
		$(".floats").css("display","block");
		$(window).resize(function(){
			$("body").height($(window).height() - ($("body").offset().top + ($("body").outerHeight(true) - $("body").height())))
		  });
	});
</script>
</body>
</html>
