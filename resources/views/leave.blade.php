<html>
<head>

<meta name="csrf-token" content="{{ csrf_token() }}">

<body>
<h1>Leaves</h1>

<label>Male/Female:</label>

<select id="gender">
  <option value="">-</option>
  <option value="male">Male</option>
  <option value="female">Female</option>
</select>

<div id="result"></div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script>

   const genderOption = document.getElementById('gender');     
   const url = '/api/leaves';
   let myOptions = {
       'gender': '',
   };
    
   
    window.onload = () => {
        genderOption.addEventListener('change', genderOptionHandler);
        getDataWithOptions({'method': 'GET'}); 
    }

    const getDataWithOptions = ({method}) => {

        sendAjax({
            'url': url,
            'method': method,
            'data': myOptions,
            'fn': showLeaves
        });
    }

   
    const genderOptionHandler = () => {
        const option = genderOption.options[genderOption.selectedIndex].value;   
        let value = '';
        console.log(option);
        if (option === ''){
            value = ''; 
        }else if (option === 'male'){
            value = 'Male';
        }else if (option === 'female'){
            value = 'Female';
        }
        myOptions = {
            ...myOptions,
            'gender': value
        };
        getDataWithOptions({'method': 'POST'});
    }

  
    const showLeaves = (result) => {
         
        const div = document.querySelector('#result');
        const res = JSON.parse(result);
        const list = `
            <ul>
                ${res.map((leave, idx) => {
                    return `<li>
                            employee number: ${leave.employee_number} <br>
                            name: ${leave.name} <br>
                            gender: ${leave.gender} <br>
                            last position: ${leave.last_position} <br>
                            period: ${leave.period} <br>
                            marital status: ${leave.marital_status} <br>
                            reason type: ${leave.reason_type} <br>
                            reason note: ${leave.reason_note} <br>
                            </li>`
                    }).join(' ')}
            </ul>
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
