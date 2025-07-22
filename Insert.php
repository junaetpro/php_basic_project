<?php
include "Db.php";

if (!isset($_COOKIE["user"])) {
    header("location: Log.php");
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <section class="insert_section bg">
        <div class="box">
        <h1 class="page_title">Data Insert</h1>
        <form action="" method="POST" class="d1_form" enctype="multipart/form-data">
            <label for="Name">Product Name</label>
            <input type="text" name="PName" id="Name" Placeholder="Product Name Here ...">

            <label for="Image">Product Image</label>
            <input type="file" name="image" id="Image">

            <label for="price">Product Price ($)</label>
            <input type="number" name="price" id="price" Placeholder="price Here ...">

            <label for="description">description</label>
            <textarea name="description" id="description"   Placeholder="description Here ..." style=" height: 150px;"></textarea>

            <div class="btn_area">
                <input type="submit" name="submit" id="" value="Publish" class="btn active">

                <a href="index.php" class="btn">Dashboard</a>
            </div>
        </form>
        </div>
    </section>

<?php

if(isset($_POST["submit"])){
    $PName= $_POST["PName"];
    $price= $_POST["price"];
    $description=$_POST["description"];

    if (!empty($_FILES['image']['name'])) {
        $newImage = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "img/" . $newImage);
        $imageToSave = $newImage;
    } else {
        $imageToSave = ""; // ✅ use previous image if no new one
    }

    $sql= "insert into products(name, image, price, description) values ('$PName', '$imageToSave', '$price', '$description')";
    

    if(!empty($PName) && !empty($imageToSave) && !empty($price) ){
        if(mysqli_query($conn, $sql)){
        echo "
        <div class='alert_box'>
            <h1 style='color:green'>data saved</h1>
            <button>close</button>
        </div>";
        }
    }else{
        echo "
        <div class='alert_box'>
            <h1 style='color:green'>information missing</h1>
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