<?php
include "Db.php";

if (!isset($_COOKIE["user"])) {
    header("location: Log.php");
    exit();
}


if (isset($_GET['update_id'])) {
    $id = (int)$_GET['update_id'];
    $result = $conn->query("SELECT * FROM products WHERE id = $id");
    if ($result->num_rows === 1){
        $row = $result->fetch_assoc();
        $image = $row['image'];
    }else {
        echo "User not found.";
        exit();
    }

}else {
    echo "No ID provided.";
    header("Location: index.php");
    exit();
}



if (isset($_POST['update'])){
    $PName= $_POST["PName"];
    $price= $_POST["price"];
    $description=$_POST["description"];

    if (!empty($_FILES['image']['name'])) {
        $newImage = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "img/" . $newImage);
        $imageToSave = $newImage;
    } else {
        $imageToSave = $image; // ✅ use previous image if no new one
    }
        
    $sql = "UPDATE products SET name='$PName', image='$imageToSave', price='$price', description='$description' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {

        header("Location: index.php"); // 
        exit();
    } else {
        echo "
        <div class='alert_box'>
            <h1 style='color:green'>not updated</h1>
            <button>close</button>
        </div>";
    }

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
            <input type="text" name="PName" id="Name" value="<?php echo $row['name']; ?>">

            <label for="Image">Product Image</label>
            <p style="color:#fff">Current Image: <?php echo $row['image']; ?></p>
            <img src="img/<?php echo $row['image']; ?>" alt="Product Image" width="100">
            <input type="file" name="image" id="Image">

            <label for="price">Product Price ($)</label>
            <input type="number" name="price" id="price" value="<?php echo $row['price']; ?>">

            <label for="description">description</label>
            <textarea name="description" id="description" style=" height: 150px;"><?php echo $row['description']; ?></textarea>

            <div class="btn_area">
                <input type="submit" name="update" id="" value="update" class="btn active">

                <a href="index.php" class="btn">Dashboard</a>
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