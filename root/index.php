<?php
include('../model/model.php');
?>
<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <title>GeoStations San Francisco</title>
    <link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
    <link href='css/styles.css' rel='stylesheet' type='text/css'>
    <link href='lib/chosen_v1.0.0/chosen.min.css' rel='stylesheet' type='text/css'>
    <meta name="description" content="Choose your route to display each station's geolocation. Click on a station to view information on next departing trains.">
    <meta name="keywords" content="san francisco, san francisco transit, san francisco transport, transit, transport, bart, station, stations, geostation, geostations">
</head>
<body onload="initialize();">
    <div id="header">
        <div id="clock">
            <script type="text/javascript"
            src="http://localtimes.info/clock.php?continent=North America&country=United States&province=California&city=San Francisco&cp1_Hex=000000&cp2_Hex=FFFFFF&cp3_Hex=000000&fwdt=76&ham=1&hbg=1&hfg=0&sid=0&mon=0&wek=0&wkf=0&sep=0&widget_number=107">
            </script>
        </div>
           <ul id="headers">
           <li><h1>GeoStations: San Francisco</h1></li>
           <li><h3>Real-Time Transit</h3></li>
           </ul>
    </div>
    <div class="floats" id="select_div">
                    <form>
                    <select id="select_route" class="chosen" onChange="routeId();newRoute();">
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
    
    <div id="footer">
        <ul>
              <li>Real time estimates provided by the <a href="http://api.bart.gov/docs/overview/index.aspx">Real BART API</a></li>
              <li>&bull;</li>
              <li>The site assumes no changes to origins or destinations of main routes</li>
              <li>&bull;</li>
              <li>Inspired by <a href="https://www.cs75.net/Projects">CS75 project2</a></li>
              <li> &bull;</li>
              <li>Source code available on <a href="https://github.com/YSUser/GeoStations">GitHub.</a></li>
        </ul>
    </div>

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript" src="lib/chosen_v1.0.0/chosen.jquery.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>
<script type="text/javascript" src="js/stations.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("body").height($(window).height() - ($("body").offset().top + ($("body").outerHeight(true) - $("body").height())));
		$(".chosen").chosen({width: "266px",disable_search: true});
		$(".floats").css("display","block");
		$("#info_div").hover(function() {
            $(".chosen-container-single").toggleClass("select_hover");
        });
		$(window).resize(function(){
			$("body").height($(window).height() - ($("body").offset().top + ($("body").outerHeight(true) - $("body").height())))
		  });
	});
</script>
</body>
</html>
