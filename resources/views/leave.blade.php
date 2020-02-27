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
    <br>
    <h2>Average Work Time</h2>
    <canvas id="chart-area2"></canvas>
    <br>
    <h2>Age</h2>
    <canvas id="chart-area3"></canvas>
    <br>
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
                label: 'Gender'
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

    let ageConfig = {
        type: 'bar',
        data: {
            labels: ['20 ↓', '20-24', '25-29', '30-34', '35-39', '40-44', '45-49', '50 ↑'],
			datasets: [{
				label: 'the number of people',
				backgroundColor: 'rgb(75, 192, 192)',
				borderColor: 'rgb(75, 192, 192)',
				borderWidth: 1,
				data: []
			}]
        },
        responsive: true,
        legend: {
            position: 'top',
        },
        title: {
            display: true,
            text: 'Age'
        }
    }

    window.onload = () => {

        genderOption.addEventListener('change', genderOptionHandler);
        maritalOption.addEventListener('change', maritalOptionHandler);
        getDataWithOptions({'method': 'GET', 'myOptions': {}}); 
    }

    const getDataWithOptions = ({method, myOptions}) => {
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
                    <th>birthday</th>
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
                                <td> ${leave.birthday} </td>
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
        drawAgeBarChart(res);
    }

    const drawGenderPieChart = (res) => {
        const male = res.filter((leave, idx) => leave.gender.includes('Male')).length;
        const female = res.filter((leave, idx) => leave.gender.includes('Female')).length;
        const ctx = document.getElementById('chart-area').getContext('2d');
        genderConfig.data.datasets[0].data = [male, female];
        if (!window.genderPie){
            window.genderPie = new Chart(ctx, genderConfig);
        }else{
            window.genderPie.update();
        }
    }

    const drawAverageWTPieChart = (res) => {
        const ten = res.filter((leave, idx) => +leave.average_worktime.split(':')[0] >= 10).length;
        const nine = res.filter((leave, idx) => +leave.average_worktime.split(':')[0] == 9).length;
        const eight = res.filter((leave, idx) => +leave.average_worktime.split(':')[0] == 8).length;
        const seven = res.filter((leave, idx) => +leave.average_worktime.split(':')[0] == 7).length;
        const sixOrLess = res.filter((leave, idx) => +leave.average_worktime.split(':')[0] <= 6).length;
        const ctx = document.getElementById('chart-area2').getContext('2d');
        averageWTConfig.data.datasets[0].data = [ten, nine, eight, seven, sixOrLess];
        if (!window.avwtPie){
            window.avwtPie = new Chart(ctx, averageWTConfig);
        }else{
            window.avwtPie.update();
        }
    }

    const drawAgeBarChart = (res) => {
        ageData = {
            section1: 0,
            section2: 0,
            section3: 0,
            section4: 0,
            section5: 0,
            section6: 0,
            section7: 0,
            section8: 0,
        }
        res.forEach((val, idx) => {
            if (val.birthday){
                const age = 2020 - Number(val.birthday.split('-')[0]);
                if (age < 20) ageData.section1 += 1
                else if (20 <= age && age <= 24 ) ageData.section2 += 1
                else if (25 <= age && age <= 29 ) ageData.section3 += 1
                else if (30 <= age && age <= 34 ) ageData.section4 += 1
                else if (35 <= age && age <= 39 ) ageData.section5 += 1
                else if (40 <= age && age <= 44 ) ageData.section6 += 1
                else if (45 <= age && age <= 50 ) ageData.section7 += 1
                else ageData.section8 += 1
            }
        })
        const ctx = document.getElementById('chart-area3').getContext('2d');
        ageConfig.data.datasets[0].data = Object.values(ageData);
        if (!window.ageBarChart){
            window.ageBarChart = new Chart(ctx, ageConfig);
        } else {
            window.ageBarChart.update();
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
