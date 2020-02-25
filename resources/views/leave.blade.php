<html>

<head>
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
table, th, td {
  max-width:100%;
  white-space:nowrap;
  border: 1px solid black;
  border-collapse: collapse;
}
</style>
</head>


<body>

<h1>Leaves</h1>

<div style="position: fixed; top: 100px; right: 16px; background-color:white">

    <label>Male/Female:</label>
    <select id="gender">
    <option value="">-</option>
    <option value="Male">Male</option>
    <option value="Female">Female</option>
    </select>

    <label>Single/Married:</label>
    <select id="marital">
    <option value="">-</option>
    <option value="Single">Single</option>
    <option value="Merried">Married</option>
    </select>
</div>



<div id="canvas-holder" style="width:60%; margin: auto; text-align:center">
    <h2>Gender</h2>
    <canvas id="chart-area"></canvas>
    <h2>Average Work Time</h2>
    <canvas id="chart-area2"></canvas>
</div>
<br>

<div id="result"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script>

    const genderOption = document.getElementById('gender');
    const maritalOption = document.getElementById('marital');
    let myOptions = {};
    let genderConfig = {
        type: 'pie',
        data: {
            datasets: [{
                data: [],
                backgroundColor: [
                    'rgb(54, 162, 235)',
                    'rgb(255, 99, 132)',
                ],
                label: 'Average Work Time'
            }],
            labels: [
                'Male',
                'Female',
            ]
        },
        options: {
            responsive: true
        }
    }
    let averageWTConfig = {
        type: 'pie',
        data: {
            datasets: [{
                data: [],
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                ],
                label: 'Average Work Time'
            }],
            labels: [
                '10 hours',
                '9 hours',
                '8 hours',
                '7 hours',
                '6 hours or less'
            ]
        },
        options: {
            responsive: true
        }
    }

    window.onload = () => {

        genderOption.addEventListener('change', genderOptionHandler);
        maritalOption.addEventListener('change', maritalOptionHandler);
        getDataWithOptions({'method': 'GET', 'myOptions': {}}); 
    }

    const getDataWithOptions = ({method, myOptions}) => {
        console.log(myOptions);
        sendAjax({
            'url': '/api/leaves',
            'method': method,
            'data': myOptions,
            'fn': showLeaves
        });
    }

    const genderOptionHandler = () => {
        const value = genderOption.options[genderOption.selectedIndex].value;
        myOptions = {
            ...myOptions,
            'gender': value
        };
        getDataWithOptions({'method': 'POST', 'myOptions': myOptions});
    }

    const maritalOptionHandler = () => {
        const value = maritalOption.options[maritalOption.selectedIndex].value;   
        myOptions = {
            ...myOptions,
            'marital': value
        };
        getDataWithOptions({'method': 'POST', 'myOptions': myOptions});
    }
  
    const showLeaves = (result) => {
         
        const div = document.querySelector('#result');
        const res = JSON.parse(result);
        const list = `
            <table>
                <tr>
                    <th> total num </th>
                </tr> 

                <tr>
                    <td> ${res.length}</td>
                </tr>
            </table>

            <br>

            <table>
                <tr>
                    <th>id</th>
                    <th>employee number</th>
                    <th>name</th>
                    <th>gender</th>
                    <th>average work time</th>
                    <th>last position</th>
                    <th>period</th>
                    <th>marital status</th>
                    <th>reason type</th>
                    <th>reason note</th>
                </tr>
                

                ${res.map((leave, idx) => {
                    return `<tr>
                                <td> ${idx} </td>
                                <td> ${leave.employee_number} </td>
                                <td> ${leave.name} </td>
                                <td> ${leave.gender} </td>
                                <td> ${leave.average_worktime} </td>
                                <td> ${leave.last_position} </td>
                                <td> ${leave.period} </td>
                                <td> ${leave.marital_status} </td>
                                <td> ${leave.reason_type} </td>
                                <td> ${leave.reason_note} </td>
                            </tr>
                            `
                    }).join(' ')}
            </table>
        `
        div.innerHTML = list;
        drawGenderPieChart(res);
        drawAverageWTPieChart(res);
    }

    const drawGenderPieChart = (res) => {
        const male = res.filter((leave, idx) => leave.gender.includes('Male')).length;
        const female = res.filter((leave, idx) => leave.gender.includes('Female')).length;
        const ctx = document.getElementById('chart-area').getContext('2d');
        genderConfig.data.datasets[0].data = [male, female];
        if (!window.genderPie){
            window.genderPie = new Chart(
                ctx, 
                genderConfig
            );
        }else{
            window.genderPie.update();
        }
    }

    const drawAverageWTPieChart = (res) => {
        const ten = res.filter((leave, idx) => +leave.average_worktime.split(':')[0] == 10).length;
        const nine = res.filter((leave, idx) => +leave.average_worktime.split(':')[0] == 9).length;
        const eight = res.filter((leave, idx) => +leave.average_worktime.split(':')[0] == 8).length;
        const seven = res.filter((leave, idx) => +leave.average_worktime.split(':')[0] == 7).length;
        const sixOrLess = res.filter((leave, idx) => +leave.average_worktime.split(':')[0] <= 6).length;
        const ctx = document.getElementById('chart-area2').getContext('2d');
        averageWTConfig.data.datasets[0].data = [ten, nine, eight, seven, sixOrLess];
        if (!window.avwtPie){
            window.avwtPie = new Chart(
                ctx, 
                averageWTConfig
            );
        }else{
            window.avwtPie.update();
        }
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
</body>
</html>
