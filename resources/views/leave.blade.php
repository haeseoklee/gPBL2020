<html>
<body>
<h1>Leaves</h1>

<canvas id="myChart"></canvas>

<ul>
    @foreach ($leaves as $lev)
        <li>
        id: {{ $lev->id }} <br>
        employee number: {{ $lev->employee_number }} <br>
        name: {{ $lev->name }} <br>
        gender: {{ $lev->gender }} <br>
        last position: {{ $lev->last_position }} <br>
        period: {{ $lev->period }} <br>
        material status: {{ $lev->material_status }} <br>
        reason type: {{ $lev->reason_type }} <br>
        reason note: {{ $lev->reason_note }}
         </li>
         <hr>
    @endforeach
</ul>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
            type: 'bar',
                // The data for our dataset
            data: {
                labels: ['Male', 'Female'],
                datasets: [{
                     label: 'My First dataset',
                     backgroundColor: 'rgb(255, 99, 132)',
                     borderColor: 'rgb(255, 99, 132)',
                     data: [ {{ $male_num }}, {{ $female_num }}]
                }] 
                },
                // Configuration options go here
            options: {}
            });

</script>
</body>
</html>
