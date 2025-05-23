<?php 
set_time_limit(300); // 300 seconds

$conn = mysqli_connect("localhost", "root", "","pg forms");

if(!$conn){
    echo "Connection failed: " . mysqli_connect_error();
}

// Fetch unendorsed students
$sql = "SELECT s.id, s.studentName, s.matricNo 
        FROM students s 
        LEFT JOIN endorsements e ON s.matricNo = e.matricNo 
        WHERE s.deptPgComment IS NOT NULL AND e.matricNo IS NULL";
$result = mysqli_query($conn, $sql);
$students = mysqli_fetch_all($result, MYSQLI_ASSOC);
//echo json_encode($students);
// Get the matricNo from the query parameter

mysqli_free_result($result);
mysqli_close($conn);
?> 


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Red+Hat+Text:ital,wght@0,300..700;1,300..700&display=swap');
        section{
            width: 70%;
            margin: auto;
            font-family: "Red Hat Text";
        }

        .header-1{
            text-align: center;
            color: rebeccapurple;
            font-family: "Red Hat Text" !important;
        }
        #hod{
            color: purple;
        }
        .student-section{
            display: flex;
            flex-direction: column;
        }
        .student-section-header, .student-section-content{
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            
        }
        .student-section-header{
            padding-bottom: .5rem;
            border-bottom: 1px solid black;
        }
        .student-section-header div{
            font-weight: bold;
            text-transform: uppercase;
        }
        .endorse-btn{
            background-color: purple;
            padding: .5rem .3rem .5rem .3rem;
            color: white;
            border-radius: 5px;
        }
        .endorse-btn:active{
            transform: scale(0.99);
        }
    </style>
    <title>HOD - Homepage</title>
</head>
<body>
    <div class="header-1">
        <img src="image/covenant-university-logo-desktop.png" alt="">
        <h1>Consent and Quality Attestation Form (FORM N) - HOD</h1>                
    </div>
    <section>
        <h1>Welcome, <span id="hod"><i>Dr. Bola Ahmed Tinubu</i></span></h1>
        <div class="student-div">
            <h2><u>Pending(<span id="num"></span>)</u></h2>
            <div class="student-section">
                <div class="student-section-header">
                    <div class="num">S/N</div>
                    <div class="student-name-container">Name</div>
                    <div class="matricNo-container">Matric number</div>
                    <div class="action">Action</div>
                </div>
            </div>
        </div>
    </section>



    <script>
    
        
        const studentDiv = document.querySelector(".student-div");
        const num = document.querySelector("#num");
       
        let students = <?php echo json_encode($students) ?>;
        
        num.textContent = students.length;
        students.map((student, index)=>{
            studentSection = document.querySelector(".student-section");
            const studentBox = document.createElement("div");
            studentBox.className = "student-section-content"
            const numb = document.querySelector(".num");
            const studentNameContainer = document.querySelector(".student-name-container");
            const matricNoContainer = document.querySelector(".matricNo-container");
            const action = document.querySelector(".action");
            const endorseBtn = document.createElement("p");
            endorseBtn.className = "endorse-btn";
            endorseBtn.style.cursor = "pointer";
            endorseBtn.id = student["matricNo"];
            const studentName = document.createElement("p");
            const studentMatric = document.createElement("p");
            const number = document.createElement("p");
            number.textContent = ++index;
            //console.log(index++);
            
            studentName.textContent = student["studentName"];
            studentMatric.textContent = student["matricNo"];
            endorseBtn.textContent = "Click to endorse";
            studentBox.appendChild(number);
            studentBox.appendChild(studentName);
            studentBox.appendChild(studentMatric);
            studentBox.appendChild(endorseBtn);
            studentSection.appendChild(studentBox)
        })
    

    const boxes = document.querySelectorAll(".endorse-btn");
        boxes.forEach((box)=>{
            box.addEventListener("click", function(){
                const studentId = box.id;
                console.log(studentId);
                
                localStorage.setItem("studentId", studentId);
                window.location.href = `hod.php?id=${studentId}`;
            });
        })

    </script>
</body>
</html>