
<?php
if(isset($_COOKIE["user"])){
    header("location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <section class="log_section bg">
        <div class="box">
            <h1 class="page_title">Log In</h1>
        <form action="" method="POST" class="d1_form">
            <label for="email">Your Email</label>
            <input type="text" name="email" id="email" Placeholder="Email Here ...">

            <label for="password">password</label>
            <input type="password" name="password" id="password" Placeholder="Password Here ...">

            <div class="btn_area">
                <input type="submit" name="" id="" value="Log In" class="btn active">
                <a href="Registration.php" class="btn">Sign Up</a>
                <a href="forgot.php" class="btn">Forgot Password</a>
            </div>
        </form>
        </div>
    </section>

<?php

include "Db.php";

if($_SERVER["REQUEST_METHOD"]==="POST"){
    $email= $_POST["email"];
    $password= $_POST["password"];

    if(!empty($email) && !empty($password)){
        $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) === 1) {
            setcookie("user", $email, time()+1800, "/");
            header("Location: index.php");
            exit;

        } else {
            echo "
            <div class='alert_box'>
                <h1 style='color:red;'>Invalid username or password </h1>
                <button>Close</button>
            </div>
            ";
        }

    }else {
        echo "
        <div class='alert_box'>
            <h1 style='color:red;'>Please fill all fields</h1>
            <button>Close</button>
        </div>
        ";
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