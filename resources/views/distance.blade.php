<!DOCTYPE html>
<html>
​
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Directions Service</title>
    <style>
        /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
        #map {
            height: 80%;
            width: 1000px;
        }
​
        /* Optional: Makes the sample page fill the window. */
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
​
<body>
    <div id="output_csv"></div>
    <div id="map"></div>
    <button type="button" onclick="calculateAndDisplayRoute();">Search</button>
    <div id="msg">Hey</div>
    
    <script>
        const outputElement = document.getElementById('output_csv');
        let　response;
​
        function getCsvData(dataPath, callbackfn) {
            const request = new XMLHttpRequest();
            request.addEventListener('load', (event) => {
                response = event.target.responseText;
                filteredData = response.match(/"[^"]*"/g);
                // console.log(filteredData)
                callbackfn(filteredData);
            });
            request.open('GET', dataPath, true);
            request.send();
        }
        
        
​
        function initMap() {
            var directionsService = new google.maps.DirectionsService();
            var directionsRenderer = new google.maps.DirectionsRenderer();
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 7,
                center: { lat: 21.028880000000072, lng: 105.85464000000007 }
            });
            directionsRenderer.setMap(map);
            
            getCsvData('./distance.csv', function (res) {
                const array = [];
                res.forEach(function(home, idx) {
                    array.push(new Promise( function (resolve, reject) {
                        calculateAndDisplayRoute(directionsService, directionsRenderer, home);
                    }));
                });
                Promise.all(array);
            });
​
            
        }
​
        function calculateAndDisplayRoute(directionsService, directionsRenderer, home) {
            directionsService.route(
                {
                    origin: {
                        query: home
                    },
                    destination: {
                        query: "3D Vietnam Creative Center Building, 3 Duy Tan Street, Cau Giay District, Hanoi, Vietnam"
                    },
                    travelMode: 'DRIVING'
                },
                function (response, status) {
                    if (status === 'OK') {
                        directionsRenderer.setDirections(response);
                        var directionsData = response.routes[0].legs[0];
                        document.getElementById('msg').innerHTML = "";
                        document.getElementById('msg').innerHTML += " Driving distance is " + directionsData.distance.text + " (" + directionsData.duration.text + ").";
                        console.log(" Driving distance is " + directionsData.distance.text + " (" + directionsData.duration.text + ").");
                    } else {
                        window.alert('Directions request failed due to ' + status);
                    }
                });
        }
​
        
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA9rh4FmeVK_QlU02QOWlSsciYp1AuvA00&callback=initMap">
    </script>
</body>
​
</html>