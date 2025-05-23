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
        #collegeDeanComment{
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
.student-section, .departmental-pg, .collegeRep-section, .collegeDean-section{
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
    <title>College Dean - Comment</title>
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
            <h1>HOD Comments</h1>
            <div class="hod-comment">

            </div>
        </div>
        <div class="collegeRep-section">
            <h1>College Representative Comments</h1>
            <div class="collegeRep-comment">

            </div>
        </div>
        <div class="collegeDean-section">
            <h1>College Dean Comments</h1>
            <div class="collegeDean-comment">

            </div>
        </div>

        
        <div class="subDean-section">
            <h1>Sub Dean comment section</h1>
            <form action="">
                <label for="subDean-comment">Enter your comment </label><br>
                <textarea name="subDeanComment" id="subDeanComment" placeholder="type here..."></textarea>
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
        const hodComment = document.querySelector(".hod-comment");
        const collegeRepComment = document.querySelector(".collegeRep-comment");
        const collegeDeanComment = document.querySelector(".collegeDean-comment");
        const getStudent = async()=>{
            const response = await fetch(`getPgCommentt.php?studentId=${studentId}`);
            const student = await response.json();
            console.log(student);
            
            studentName.textContent = student.studentName;
            matricNo.textContent = student.matricNo;
            programme.textContent = student.programme;
            college.textContent = student.college;
            departmentalPg.textContent = student.deptPgComment;
            hodComment.textContent = student.hod_comment;
            collegeRepComment.textContent = student.college_rep_comment;
            collegeDeanComment.textContent = student.college_dean_comment;
        }
        getStudent();

    const submitBtn = document.querySelector(".submit");
    submitBtn.addEventListener("click", async function(){
        const subDeanComment = document.querySelector("#subDeanComment").value;
        try{
            const response = await fetch("submitSubDean.php", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                subDeanComment: subDeanComment,
                studentId: studentId
            })
        });
        const data = await response.json();
        if(data.success){
            alert("successful")
        }else{
            alert("unsuccessful: "+ data.message)
        }
    } catch(error){
        console.error('Error:', error);
        alert('An error occurred while updating.');
    }
    
    window.location.href = `subDean.php`
    })
    </script>
</body>
</html>