<html>
<body>
<h1>Assigns</h1>
<ul>
    @foreach ($assigns as $ass)
        <li>
        id: {{ $ass->id }} <br>
        yearmonth: {{ $ass->yearmonth }} <br>
        employee number: {{ $ass->employee_number }} <br>
        location: {{ $ass->location }} <br>
        grade: {{ $ass->grade }} <br>
        skills: {{ $ass->skills }} <br>
        division: {{ $ass->division }}
         </li>
         <hr>
    @endforeach
</ul>
<script>
    

</script>
</body>
</html>
