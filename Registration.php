

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <section class="registration_section bg">
        <div class="box">
            <h1 class="page_title">Registration</h1>
        <form action="" method="POST" class="d1_form" enctype="multipart/form-data">
            <label for="username">User Name</label>
            <input type="text" name="username" id="username" Placeholder="User Name Here ...">

            <label for="email">Email</label>
            <input type="text" name="email" id="email" Placeholder="Email Here ...">

            <label for="number">number</label>
            <input type="number" name="number" id="number" Placeholder="number Here ...">

            <label for="Image">Profile Photo</label>
            <input type="file" name="image" id="Image">

            <label for="password">password</label>
            <input type="password" name="password1" id="password" Placeholder="Password Here ...">

            <label for="password">Retype password</label>
            <input type="password" name="password2" id="password" Placeholder="Password Here ...">

            <label for="Question">Select Question</label>
            <select name="question" id="question">
                <option value="" disabled selected>Select a question</option>
                <option value="your father name">What is your father name?</option>
                <option value="your mother name">What is your mother name</option>
            </select>

            <label for="Answer">Answer</label>
            <input type="text" name="Answer" id="Answer" Placeholder="Answer Here ...">
            

            <div class="btn_area">
                <input type="submit" name="submit" id="" value="Sing Up" class="btn active">
                <a href="Log.php" class="btn">Log In</a>
            </div>
        </form>
        </div>
    </section>

    

<?php
include "Db.php";

if(isset($_POST["submit"])){
    $username= $_POST["username"];
    $email= $_POST["email"];
    $number= $_POST["number"];
    $password1 = $_POST["password1"];
    $password2 = $_POST["password2"];
    $question= $_POST["question"];
    $answer= $_POST["Answer"];

    if (!empty($_FILES['image']['name'])) {
        $newImage = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "img/" . $newImage);
        $imageToSave = $newImage;
    } else {
        $imageToSave = ""; // ✅ use previous image if no new one
    }
    
    $sql= "insert into users(username, profile_img, email, number, password, question, answer) values ('$username', '$imageToSave', '$email', '$number', '$password1', '$question', '$answer')";

    if($password1 === $password2){
        if(mysqli_query($conn, $sql)){
        echo "
        <div class='alert_box'>
            <h1 style='color:green'>data saved please log in now</h1>
            <button>close</button>
        </div>";
        }
    }else{
        echo "
        <div class='alert_box'>
            <h1 style='color:green'>password not match</h1>
            <button>close</button>
        </div>";
    }
}
?>


<script>
document.addEventListener("DOMContentLoaded", function () {
    const closeBtn = document.querySelector(".alert_box button");
    if (closeBtn) {
        closeBtn.addEventListener("click", function () {
            this.parentElement.style.display = "none";
        });
    }
});

</script>

</body>
</html>