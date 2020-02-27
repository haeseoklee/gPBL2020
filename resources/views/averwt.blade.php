<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Average Work Time</title>
</head>
<body>

<div id="canvas-holder" style="width:60%; margin: auto; text-align:center">
    
    <h2>Average Work Time (both)</h2>
    <canvas id="1"></canvas>
    <h2>Average Work Time (leaves)</h2>
    <canvas id="2"></canvas>
    <h2>Average Work Time (without leaves)</h2>
    <canvas id="3"></canvas>
    
</div>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script>
    let averageWTConfig = {
        "1": {
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
                title: {
                    fontSize: 22,
                    display: true,
                    text: 'Custom Chart Title'
                },
                responsive: true
            }
        },
        "2": {
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
                title: {
                    fontSize: 22,
                    display: true,
                    text: 'Custom Chart Title'
                },
                responsive: true
            }
        },
        "3": {
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
                title: {
                    fontSize: 22,
                    display: true,
                    text: 'Custom Chart Title'
                },
                responsive: true
            }
        },
    }
    


    window.onload = () => {
        getData({'method': 'POST', 'myOptions': {'option': 'both'}})
        getData({'method': 'POST', 'myOptions': {'option': 'leaves'}})
        getData({'method': 'POST', 'myOptions': {'option': 'without-leaves'}})
        
    }

    const getData = ({method, myOptions}) => {
        sendAjax({
            url: '/api/averwt',
            method: method,
            data: myOptions,
            fn: showAverwt
        })
    }

    const showAverwt = (result, data) => {
        const res = JSON.parse(result);
        const dat = JSON.parse(data);
        let chartId = '1';
        if (dat['option'] === 'both'){
            chartId = '1';
        } else if (dat['option'] === 'leaves'){
            chartId = '2';
        } else {
            chartId = '3';
        }
        drawAverageWTPieChart({
            res: res,
            chartId: chartId
        });
    }

    const drawAverageWTPieChart = ({res, chartId}) => {
        let num = 0;
        let total = 0;
        res = res.filter((emp, idx) => {
            total += emp.average_worktime != null ? +emp.average_worktime.split(':')[0] : 0;
            num += 1;
            return emp.average_worktime != null
        });
        const ten = res.filter((emp, idx) => +emp.average_worktime.split(':')[0] >= 10).length;
        const nine = res.filter((emp, idx) => +emp.average_worktime.split(':')[0] == 9).length;
        const eight = res.filter((emp, idx) => +emp.average_worktime.split(':')[0] == 8).length;
        const seven = res.filter((emp, idx) => +emp.average_worktime.split(':')[0] == 7).length;
        const sixOrLess = res.filter((emp, idx) => +emp.average_worktime.split(':')[0] <= 6).length;
        const ctx = document.getElementById(chartId).getContext('2d');
        averageWTConfig[chartId].data.datasets[0].data = [ten, nine, eight, seven, sixOrLess];
        averageWTConfig[chartId].options.title.text = `${(total / num).toFixed(3)} hours`;
        new Chart(ctx, averageWTConfig[chartId]);
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
        fn(result, dat);
      });
   }


</script>
</html>