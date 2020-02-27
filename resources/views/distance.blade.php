<!DOCTYPE html>
<html>
​
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <div id="msg"></div>
   
    <script>
        const outputElement = document.getElementById('output_csv');
        let result = {
            calc_result: []
        };
        
        function initMap() {
            var directionsService = new google.maps.DirectionsService();
            var directionsRenderer = new google.maps.DirectionsRenderer();
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 7,
                center: { lat: 21.028880000000072, lng: 105.85464000000007 }
            });
            directionsRenderer.setMap(map);
            sendAjax({
                url: '/distance/address',
                method: 'GET',
                data: {},
                fn: (res) => {
                        const array = [];
                        let time = 0;
                        res.forEach((data, idx) => {
                            array.push(new Promise( (resolve, reject) => {
                                setTimeout(() => calculateAndDisplayRoute(directionsService, directionsRenderer, data, idx), time + idx*2000);
                            }));
                        });
                        Promise.all(array).then(() => {console.log(result)});
                    }
            })
            
            
        }
        
        function calculateAndDisplayRoute(directionsService, directionsRenderer, data, idx) {
            directionsService.route(
                {
                    origin: {
                        query: data['address']
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
                        const str  = `
                        {
                            'employee_number': ${data['employee_number']},
                            'distance': '${directionsData.distance.text}',
                            'duration': '${directionsData.duration.text}'
                        },
                        <br>
                        `;
                        document.getElementById('msg').innerHTML += str;
                        console.log(idx + ' ' + str);
                        result['calc_result'].push( {
                            'employee_number': data['employee_number'],
                            'distance': directionsData.distance.text,
                            'duration': directionsData.duration.text
                        });
                    } else {
                        result['calc_result'].push( {
                            'employee_number': data['employee_number'],
                            'distance': 'None',
                            'duration': 'None'
                        });
                    }
                }
            );
        }

        const sendAjax = ({url, method, data, fn}) => {
            const dat =  JSON.stringify(data);
            const xhr = new XMLHttpRequest();
            xhr.open(method, url);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector("meta[name='csrf-token']").getAttribute("content"));
            xhr.send(dat);

            xhr.addEventListener('load', () => {
                const result = JSON.parse(xhr.responseText);
                fn(result);
            });
        }
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA9rh4FmeVK_QlU02QOWlSsciYp1AuvA00&language=en&callback=initMap">
    </script>
</body>
</html>