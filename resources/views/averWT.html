<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
　<title>The number of people in different grade and their average work time</title> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<style>
  .grade {
    display: inline-block;
    width: 49%;
  }
  .full{
    width: 50%;
    margin: 10px auto;

  }
  h5{
    margin: 10px auto;
  }
</style>
</head>
<body>
  <canvas id="myBarChart"></canvas>
<br><br><br><br><br>
  <div class="grade">
    <canvas id="PieChartIntern" ></canvas>
  </div>
  <div class="grade">
    <canvas id="PieChartParttime" ></canvas>
  </div>
  <div class="full">
    <canvas id="PieChartFulltime" ></canvas>
  </div>
  <br><br>
  <h5>
  <canvas id="PieChartTotal" ></canvas>
  </h5>
<script>
  Chart.plugins.register({afterDatasetsDraw: function (chart, easing) {
      var ctx = chart.ctx;
    
      chart.data.datasets.forEach(function (dataset, i) {
        var dataSum = 0;
        dataset.data.forEach(function (element){
          dataSum += element;
        });
    
        var meta = chart.getDatasetMeta(i);
        if (!meta.hidden) {
          meta.data.forEach(function (element, index) {
            ctx.fillStyle = 'rgb(0, 0, 0)';
            
            var fontSize = 16;
            var fontStyle = 'normal';
            var fontFamily = 'Verdana';
            ctx.font = Chart.helpers.fontString(fontSize, fontStyle, fontFamily);
    
            var labelString = chart.data.labels[index];
            var dataString = (Math.round(dataset.data[index] / dataSum * 1000)/10).toString() + "%";
    
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
    
            var padding = 5;
            var position = element.tooltipPosition();
            ctx.fillText(dataString, position.x, position.y + (fontSize / 2) - padding);
          });
        }
      });
    }
    
});

  var dataLabelPlugin = {afterDatasetsDraw: function (chart, easing) {
        var ctx = chart.ctx;

        chart.data.datasets.forEach(function (dataset, i) {
            var meta = chart.getDatasetMeta(i);
            if (!meta.hidden) {
                meta.data.forEach(function (element, index) {
                    ctx.fillStyle = 'rgb(0, 0, 0)';

                    var fontSize = 25;
                    var fontStyle = 'normal';
                    var fontFamily = 'Verdana';
                    ctx.font = Chart.helpers.fontString(fontSize, fontStyle, fontFamily);

                    var dataString = dataset.data[index].toString();

                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';

                    var padding = 5;
                    var position = element.tooltipPosition();
                    ctx.fillText(dataString, position.x, position.y - (fontSize / 2) - padding);
                });
            }
        });
    }
    
  };
  
  var ctx = document.getElementById("myBarChart");
  var ctx1 = document.getElementById("PieChartIntern");
  var ctx2 = document.getElementById("PieChartParttime");
  var ctx3 = document.getElementById("PieChartFulltime");
  var ctx4 = document.getElementById("PieChartTotal");
  var myBarChart = new Chart(ctx, {
    type: 'bar',
    data:{
      labels: ["<6","6~9","9~10",">10"],
      datasets: [
        {
          label: 'Intern',  
          data: [13,8,3,0],
          backgroundColor: [ 
              "#ff0000",
              "#ff0000",
              "#ff0000",
              "#ff0000",
              "#ff0000"] 
        },{
          label: 'parttime', 
          data: [13, 20,5,1],
          backgroundColor: [              
              "#ff00ff",
              "#ff00ff",
              "#ff00ff",
              "#ff00ff",
              "#ff00ff"]
        },{
          label: 'fulltime',
          data: [4,18,171,83],
          backgroundColor: [              
              "#0000ff",
              "#0000ff",
              "#0000ff",
              "#0000ff",
              "#0000ff"]
        }
      ]
    },
    options: {
      
      title: {
        display: true, 
        text: 'The number of leaved employees in different grade and their average work time', 
        fontSize:40
      },
      scales: { 
        yAxes: [{ 
          scaleLabel: {             
          display: true,          
          labelString: 'number' ,
          fontSize:40
        },ticks: {
            suggestedMax: 100, 
            suggestedMin: 0,
            stepSize: 10
          }
        }],xAxes: [{        
        scaleLabel: {             
          display: true,          
          labelString: 'work time',
          fontSize:40
        },
        ticks: {
          suggestedMin: 0,
          suggestedMax: 12,
          stepSize: 2,
          callback: function(value, index, values){
            return  value +  'h'
          }
        }
      }]
      },
    },
      plugins: [dataLabelPlugin],
  });


var PieChartIntern = new Chart(ctx1, {
    type: 'pie',
    data: {
      labels: ["<6","6~9","9~10",">10"],
      datasets: [{
          backgroundColor: [
              "aqua",
              "purple",
              "silver",
              "yellow"
          ],
          data: [13,8,3,0]
      }]
    },
    options: {
      title: {
        display: true,
        text: 'Intern',
        fontSize:35
      }
    }
  });

  var PieChartParttime = new Chart(ctx2, {
    type: 'pie',
    data: {
      labels: ["<6","6~9","9~10",">10"],
      datasets: [{
          backgroundColor: [
              "aqua",
              "purple",
              "silver",
              "yellow"
          ],
          data: [13,20,5,1]
      }]
    },
    options: {
      title: {
        display: true,
        text: 'Parttime',
        fontSize:35
      }
    }
  });

  var PieChartFulltime = new Chart(ctx3, {
    type: 'pie',
    data: {
      labels: ["<6","6~9","9~10",">10"],
      datasets: [{
          backgroundColor: [
              "aqua",
              "purple",
              "silver",
              "yellow"
          ],
          data: [4,18,171,83]
      }]
    },
    options: {
      title: {
        display: true,
        text: 'Fulltime',
        fontSize:35
      }
    }
  });
  
  var PieChartTotal = new Chart(ctx4, {
    type: 'pie',
    data: {
      labels: ["<6","6~9","9~10",">10"],
      datasets: [{
          backgroundColor: [
              "aqua",
              "purple",
              "silver",
              "yellow"
          ],
          data: [30,46,179,84]
      }]
    },
    options: {
      title: {
        display: true,
        text: 'Total',
        fontSize:35
      }
    },
      plugins: [dataLabelPlugin],
  });

  </script>
</body>
</html>