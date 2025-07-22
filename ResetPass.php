<?php
session_start();
include "Db.php";
$email= $_SESSION["reset_email"];
if (!$email) {

    header("Location: Forgot.php");
    exit();
}

if(isset($_POST['setpass'])){
    $Npass= $_POST["Password1"];
    $RNpass= $_POST["Password2"];

    if($Npass === $RNpass){
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $Npass, $email);
        if ($stmt->execute()) {
            // ✅ On success, destroy session and redirect to login
            session_destroy();
            header("Location: Log.php?msg=reset_success");
            exit();
        } else {
            echo "
            <div class='alert_box'>
                <h1 style='color:red;'>Database update failed</h1>
                <button>Close</button>
            </div>
            ";
        }
    }else{
        echo "
            <div class='alert_box'>
                <h1 style='color:red;'> password not match </h1>
                <button>Close</button>
            </div>
            ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <section class="reset_section bg">
        <div class="box">
            <h1 class="page_title">Reset Password</h1>
        <form action="" method="POST" class="d1_form">
            <label for="Password1">new Password</label>
            <input type="password" name="Password1" id="Password1" Placeholder="password Here ...">

            <label for="password2">retype new password</label>
            <input type="password" name="Password2" id="password2" Placeholder="retype Password Here ...">

            <div class="btn_area">
                <input type="submit" name="setpass" id="" value="Set Password" class="btn active">
                <a href="Log.php" class="btn">Log In</a>
                <a href="Registration.php" class="btn">Sign up</a>
            </div>
        </form>
        </div>
    </section>


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