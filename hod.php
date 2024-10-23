<?php
$conn = mysqli_connect("localhost", "root", "","pg forms");

if(!$conn){
    echo "Connection failed: " . mysqli_connect_error();
}
$matricNo = isset($_GET['id']) ? $_GET['id'] : '';
echo $matricNo;
// Check if matricNo is not empty

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="HOD-style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Red+Hat+Text:ital,wght@0,300..700;1,300..700&display=swap" rel="stylesheet">
    <style>
        #hod-comment{
            width: 75%;
            height: 100px;
        }
        .submit{
            padding: .5rem 1rem .5rem 1rem;
            margin-top: .5rem;
            border: 1px solid transparent;
            background-color: green;
            width:80px;
            cursor: pointer;
            border-radius: 10px;
        }
        .header{
    text-align: center;
}
.student-section, .departmental-pg, .hod-section{
    border: 2px solid purple;
    border-radius: 10px;
    padding-left: 3rem;
    padding-bottom: 2rem;
    margin-bottom: 3rem;
    box-shadow: 7px 10px 26px 0px rgba(2, 0, 2, 0.2);
    -webkit-box-shadow: 7px 10px 26px 0px rgba(0, 0, 0, 0.2);
    -moz-box-shadow: 7px 10px 26px 0px rgba(0, 0, 0, 0.2);
}

.student-section .student{
    font-size: 130%;
    font-weight: 600;
    margin-bottom: 1.5rem;
    display: flex;
    justify-content: space-between;
    padding-right: 3rem;
}
.studentName, .matricNo, .programme, .college{
    color: purple;
}
    
    </style>
    <title>HOD section</title>
</head>
<body>
    <section class="preview">
        <div class="header">
            <img src="image/covenant-university-logo-desktop.png" alt="">
            <h1>Consent and Quality Attestation Form (FORM N)</h1>                
        </div>
        <div class="student-section">
            <h1>Student Details</h1>
            <div>
                <div class="student name-section">
                    <div>Name:</div>
                    <div class="studentName"></div>
                </div>
                <div class="student matric-section">
                    <div>Matric number:</div>
                    <div class="matricNo"></div>
                </div>
                <div class="student programme-section">
                    <div>Programme:</div>
                    <div class="programme"></div>
                </div>
                <div class="student college-section">
                    <div>College:</div>
                    <div class="college"></div>
                </div>
            </div>
        </div>
        <div class="departmental-pg">
            <h1>Departmental PG Co-ordinator Comments</h1>
            <div class="departmental-pg-comment">

            </div>
        </div>
        <div class="hod-section">
            <h1>HOD comment section</h1>
            <form action="">
                <label for="hod-comment">Enter your comment </label><br>
                <textarea name="hod-comment" id="hod-comment" placeholder="type here..."></textarea>
            </form>
            <div class="submit">Submit</div>
        </div>
        
    </section>


    <script>
        const studentId = "<?php echo $matricNo ?>";
        const studentName = document.querySelector(".studentName");
        const matricNo = document.querySelector(".matricNo");
        const programme = document.querySelector(".programme");
        const college = document.querySelector(".college");
        const departmentalPg = document.querySelector(".departmental-pg-comment");
        const getStudent = async()=>{
            const response = await fetch(`getPgCommentt.php?studentId=${studentId}`);
            const student = await response.json();
            console.log(student);
            
            studentName.textContent = student.studentName;
            matricNo.textContent = student.matricNo;
            programme.textContent = student.programme;
            college.textContent = student.college;
            departmentalPg.textContent = student.deptPgComment;
        }
        getStudent();

    const submitBtn = document.querySelector(".submit");
    submitBtn.addEventListener("click", async function(){
        const hodComment = document.querySelector("#hod-comment").value;
        try{
            const response = await fetch("submitHod.php", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                hodComment: hodComment,
                studentId: studentId
            })
        });
        const data = await response.json();
        if(data.success){
            alert("successful")
        }else{
            alert("unsuccessful: "+ data.message)
        }
        if(studentId){
            <?php 
        $endorse_sql = "INSERT INTO endorsements (matricNo) VALUES ('$matricNo')";
        mysqli_query($conn, $endorse_sql);  
        
        ?>
        }else{
            console.log("holae")
        }
    } catch(error){
        console.error('Error:', error);
        alert('An error occurred while updating.');
    }
    
    window.location.href = `hodPage.php`
    })
    </script>
</body>
</html>