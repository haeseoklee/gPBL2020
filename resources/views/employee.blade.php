<html>
<body>
<h1>Employees</h1>
<ol>
    @foreach ($employees as $emp)
        <li>
         employee number: {{ $emp->employee_number }} <br> 
         name: {{$emp->name}} <br>
         birthday: {{ $emp->birthday }} <br>
         hometown: {{ $emp->hometown }} <br>
         address: {{ $emp->address }} <br>
         join date: {{ $emp->join_date }}
         </li>
    @endforeach
</ol>
<script>
    

</script>
</body>
</html>
