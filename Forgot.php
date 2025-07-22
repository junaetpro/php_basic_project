<?php
include "Db.php";
session_start();

$email = "";
$question = "";
$showQAForm = false;
$errorMsg = "";

// Step 1: Check email and fetch security question
if (isset($_POST["check_email"])) {
    $email = $_POST["email"];
    $_SESSION["reset_email"] = $email;

    $stmt = $conn->prepare("SELECT question FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($question);

    if ($stmt->fetch()) {
        $showQAForm = true;
    } else {
        echo "
            <div class='alert_box'>
                <h1 style='color:red;'>email not found </h1>
                <button>Close</button>
            </div>
            ";
    }

    $stmt->close();
}

// Step 2: Verify answer
if (isset($_POST["submit_answer"])) {
    $email = $_SESSION["reset_email"];
    $answer = $_POST["Answer"];

    $stmt = $conn->prepare("SELECT answer FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($correct_answer);

    if ($stmt->fetch()) {
        if (strtolower(trim($answer)) == strtolower(trim($correct_answer))) {
            header("Location: ResetPass.php");
            exit();
        } else {
            echo "
            <div class='alert_box'>
                <h1 style='color:red;'> answer not correct </h1>
                <button>Close</button>
            </div>
            ";
            $showQAForm = false;
        }
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<section class="forgot_section bg">
    <div class="box">
        <h1 class="page_title">Forgot Password</h1>

        <?php if (!empty($errorMsg)) echo "<p style='color:red;'>$errorMsg</p>"; ?>

        <!-- EMAIL CHECK FORM -->
        <form action="" method="POST" class="d1_form" <?php if ($showQAForm) echo "style='display:none;'"; ?>>
            <label for="email">Email</label>
            <input type="text" name="email" id="email" placeholder="Email here..." value="<?= htmlspecialchars($email) ?>">

            <div class="btn_area">
                <input type="submit" name="check_email" value="Check Email" class="btn active">
                <a href="Log.php" class="btn">Log In</a>
                <a href="Registration.php" class="btn">Sign up</a>
            </div>
        </form>

        <!-- SECURITY QUESTION FORM -->
        <?php if ($showQAForm): ?>
        <form action="" method="POST" class="form2_QA d1_form">
            <label for="question">Question</label>
            <input type="text" name="question" id="question" value="<?= htmlspecialchars($question) ?>" disabled>

            <label for="Answer">Answer</label>
            <input type="text" name="Answer" id="Answer" placeholder="Your answer here...">

            <div class="btn_area">
                <input type="submit" name="submit_answer" value="Submit" class="btn active">
                <a href="Log.php" class="btn">Log In</a>
                <a href="Registration.php" class="btn">Sign up</a>
            </div>
        </form>
        <?php endif; ?>
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
