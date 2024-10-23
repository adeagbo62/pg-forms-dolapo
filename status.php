<?php 

$conn = mysqli_connect("localhost", "root", "", "pg forms");
if(!$conn){
    echo "Connection failed ". mysqli_connect_error();
}

$sql = "SELECT studentName, matricNo, deptPgComment, hod_comment FROM students where deptPgComment is NOT NULL ";
$result = mysqli_query($conn, $sql);
$students = mysqli_fetch_all($result, MYSQLI_ASSOC);


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Status Table</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .txt{
            color: green;
            font-weight: bold;
        }
        .pend{
            color: blue;
            font-weight: bold;
        }
        .danger{
            color: purple;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h2>Student Status Table</h2>

<table>
    <tr>
        <th rowspan="2">Student Name</th>
        <th colspan="5">Status</th>
    </tr>
    <tr>
        <th>HOD</th>
        <th>College Rep</th>
        <th>College Dean</th>
        <th>Sub. Dean</th>
        <th>Dean (SPS)</th>
    </tr>

    <tr class="table-element">
        
    </tr>
</table>




<script>
    const students = <?php echo json_encode($students)?>;
    const updateTable = (name, hod,collegeRep,collegeDean,subDean,dean) =>{
        const table = document.querySelector("table");
        const row = document.createElement("tr");
        const nameCell = document.createElement("td");
        const hodCell = document.createElement("td");
        const collegeRepCell = document.createElement("td");
        const collegeDeanCell = document.createElement("td");
        const subDeanCell = document.createElement("td");
        const deanCell = document.createElement("td");

        //update the content of the cells 
        nameCell.textContent = name;
        hodCell.innerHTML = hod? "<span class=\"txt\">Endorsed<span>" : "<span class=\"danger\">Pending</span>";
        collegeRepCell.textContent = collegeRep;
        collegeDeanCell.textContent = collegeDean;
        subDeanCell.textContent = subDean;
        deanCell.textContent = dean;

        //update the row with the new values of the cells
        row.append(nameCell, hodCell, collegeRepCell, collegeDeanCell, subDeanCell, deanCell);

        //add the row to the table
        table.appendChild(row);
    }

    students.forEach((student)=>{
        updateTable(student.studentName, student.hod_comment,"","","","");        
    })
</script>
</body>
</html>
