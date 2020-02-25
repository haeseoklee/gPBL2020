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



<div id="result"></div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script>

    const genderOption = document.getElementById('gender');
    const maritalOption = document.getElementById('marital');
    let myOptions = {};
   
    window.onload = () => {
        genderOption.addEventListener('change', genderOptionHandler);
        maritalOption.addEventListener('change', maritalOptionHandler);
        // getAverageWTData({
        //     'method': 'GET',
        //     'data': {}
        // });
        getDataWithOptions({'method': 'GET', 'myOptions': {}}); 
    }

    const getAverageWTData = ({method, myOptions}) => {
        sendAjax({
            'url': '/api/leaves/average_wt',
            'method': method,
            'data': myOptions,
            'fn': showLeavesWithAverageWT
        })
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


    const showLeavesWithAverageWT = () => {

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
                    <th>average working time</th>
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
