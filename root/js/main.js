var xhr, map, route, routeColor,
	markers = [],
	bartKey = "MW9S-E7SL-26DU-VV8V";



function initialize() {
	var mapOptions = {
	center: new google.maps.LatLng(37.807885,-122.283804),
	zoom: 10,
	mapTypeId: google.maps.MapTypeId.ROADMAP
			};
	map = new google.maps.Map(document.getElementById("map_canvas"),
	mapOptions);
}
      
function routeId() {
	var id = document.getElementById("select_route");
	route = id.options[id.selectedIndex].id;
	var color = document.getElementById("select_route");
	routeColor = color.options[color.selectedIndex].value;
}

function createHttpRequest() {
	try	{	
		xhr = new XMLHttpRequest();
		return xhr;
		}
		catch (e)
		{
			//assume IE6
			try	{
			xhr = new activeXBbject("microsoft.XMLHTTP");
			return xhr;
			}
			catch (e)	{
				var map = document.getElementById("map_canvas");
				map.innerHTML = "";
				var p = document.createElement("p");
				p.appendChild(document.createTextNode("Unable to create an XMLHttpRequest object"));
				map.appendChild(p);
			}
		}
}


function getRouteStations(callback) {
	xhr = createHttpRequest();
	var url ="http://api.bart.gov/api/route.aspx?cmd=routeinfo&route="+route+"&key="+bartKey;
				 xhr.onreadystatechange = function () {
					 if (xhr.readyState == 4 && xhr.status == 200) {
					 var doc = xhr.responseXML;
					 var routeStations={};
  					 var config=doc.getElementsByTagName("station");
					 	for (i=0;config.length>i;i++) {
						var	currentStation = config[i].childNodes[0].nodeValue;
							var lat = stations[currentStation].lat;
							var lng = stations[currentStation].lng;
							var name = stations[currentStation].name;
							routeStations[currentStation] = {lat: lat, lng: lng, name: name, abbr: currentStation}
						} //end for loop
							 return callback(routeStations);
					 } //end readyState && status
					 
				 } // end onreadystatechange
				  xhr.open("GET",url,true);
				 xhr.send(null);
}



function newRoute(){
    getRouteStations(addTheseParamaters);
		function addTheseParamaters(routeStations){
						// Set polyline
							var polylineCoordinates = [];
							var polylineNames = [];
							var polylineAbbr = [];
							//Polyline array
						  for (var key in routeStations) {
							  polylineCoordinates.push(new google.maps.LatLng(routeStations[key].lat, routeStations[key].lng));
							  polylineNames.push(routeStations[key].name);
							  polylineAbbr.push(routeStations[key].abbr);
							}
		//If polyline has already been defined, set new coordinates	and delete old markers
	    if(typeof polylinePath !== 'undefined') {
			function clearMarkers() {
					function setAllMap(map) {
				  for (var i = 0; i < markers.length; i++) {
					markers[i].setMap(map);
					  }
											}
				  setAllMap(null);
								}
		//Clear Exsiting markers
		 clearMarkers();
		 
		//Set a new polyline
        polylinePath.setPath(polylineCoordinates);
        polylinePath.setOptions({strokeColor: routeColor});
		}
		//If polyline has not been defined, set new coordinates
		else {
		    polylinePath = new google.maps.Polyline({
            path: polylineCoordinates,
            strokeColor: routeColor,
            strokeOpacity: 1.0,
            strokeWeight: 3
        }); 
        polylinePath.setMap(map);
			}
			// End new polyline

	 //Set markers && infowindow
    var infowindow = new google.maps.InfoWindow();
    var marker, i;	 			
    for (i = 0; i < polylineCoordinates.length; i++) {  
      marker = new google.maps.Marker({
        position: polylineCoordinates[i],
		title: polylineNames[i],
		icon: "http://www.geostations.com/img/steamtrain.png",
        map: map
      });
	  markers.push(marker);	  	  
	        google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent("<div id=\""+polylineAbbr[i]+"\" class=\"infowindow\"><img id=\"loader\" src=\"http://www.geostations.com/root/img/ajax-loader-infowindow.gif\"></div>");
          infowindow.open(map, marker);
		        google.maps.event.addListenerOnce(infowindow,"domready", function(){
     			 getStationInfo(polylineAbbr[i],polylineNames[i]);
            });
          }
       })(marker, i));
	 }//end polylineCoordinates loop (adding markers loop)
   }//end addTheseParamaters
}//end newRotue
//add infowindow content
function getStationInfo(id,name) {
	var xhr = createHttpRequest();
	var url = "http://api.bart.gov/api/etd.aspx?cmd=etd&orig="+id+"&key="+bartKey
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && xhr.status == 200) {
			document.getElementById(id).innerHTML = "";
			var doc = xhr.responseXML;
  				 var timeNode = doc.getElementsByTagName("time");
				 var currentTime = timeNode[0].childNodes[0].nodeValue;
				var etdNode = doc.getElementsByTagName("etd");
				if (etdNode.length == 0) {
					var table = document.createElement("table");
					var tr = table.insertRow(0);
					var td = tr.insertCell(0);
					td.appendChild(document.createTextNode(name))
						var td = tr.insertCell(1);
						td.appendChild(document.createTextNode(currentTime))
							var tr2 = table.insertRow(1);
							var td2 = tr2.insertCell(0);
							td2.style.paddingTop='20px';
							td2.appendChild(document.createTextNode('No trains available at this time.'))
							document.getElementById(id).appendChild(table);
					}
					else {
					for (var i=0;i<etdNode.length;i++) {
						var table = document.createElement("table");
						var tr = table.insertRow(0);
						var td = tr.insertCell(0);
						td.style.width = "150px";
						td.style.fontWeight = "bold";
						var destination = etdNode[i].childNodes[0].firstChild.nodeValue;
						td.appendChild(document.createTextNode("Destination: "+destination))
						document.getElementById(id).appendChild(table);
						var estimate = etdNode[i].getElementsByTagName("estimate");
							for (var j=0;j<estimate.length;j++) {
								var tr = table.insertRow(-1);
								var td = tr.insertCell(0);
								var minutes = estimate[j].childNodes[0].firstChild.nodeValue;
								td.appendChild(document.createTextNode("Minutes: "+minutes))
									var td2 = tr.insertCell(-1);
									td2.style.paddingRight = "25px";
									var platform = estimate[j].childNodes[1].firstChild.nodeValue;
									td2.appendChild(document.createTextNode("Platform: "+platform))
										var td3 = tr.insertCell(-1);
										var color = estimate[j].childNodes[5].firstChild.nodeValue;
										td3.style.backgroundColor = color;
										td3.style.paddingLeft = "15px";
						}//end nested loop
					var table = document.createElement("table");
					}//end loop
				}//end else
		}//end readyState		
	}//end readystatechange
	xhr.open("GET",url,true);
	xhr.send(null);
}//end getStationInfo

