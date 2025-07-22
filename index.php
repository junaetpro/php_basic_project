<?php
include "Db.php";

if (!isset($_COOKIE["user"])) {
    header("location: Log.php");
    exit();
}

$email = $_COOKIE["user"];

// Get user data from database
$sql = "SELECT username, number, profile_img FROM users WHERE email = '$email'";
$result = mysqli_query($conn, $sql);

// Fetch data
if ($result && mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    $username = $row["username"];
    $number = $row["number"];
    $profile_img= $row["profile_img"];
} else {
    $email = "Not found";
    $number = "Not found";
    $profile_img= "img not set";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="Style.css">
</head>
<body>

    <section class="home_section">
        <div class="menu_area">
            <a href="logout.php">Log Out</a>
        </div>
        <div class="user_info">
            <div class="profile_img_box"><img src="img/<?php echo $profile_img;  ?>" alt="profile img"></div>
            <h1>User Name: <?php echo $username ?></h1>
            <h3>User Email: <?php echo $email ?></h3>
            <h3>User Contact: <?php echo $number ?></h3>
        </div>
        <div class="btn_src">
            <a href="Insert.php">Add Data</a>
            <form action="" method="POST">
                <input type="text" name="src" id="" placeholder="Search data ..." class="input">
                <input type="submit" name="search_data" id="" value="Search" class="btn">
            </form>
        </div>
        <div class="show_data">
            <h2>All Data</h2>
        </div>


        <?php


        if (isset($_GET['delete'])) {
            $id = $_GET['delete'];
            $conn->query("DELETE FROM products WHERE id=$id");
            echo "
            <div class='alert_box'>
                <h1 style='color:red;'>data delete successful </h1>
                <button>Close</button>
            </div>
            ";
            
        }


        $search = $_POST['src'] ?? '';

        if ($search != '') {
            $searchEscaped = mysqli_real_escape_string($conn, $search);
            $sql = "SELECT * FROM products WHERE name LIKE '%$searchEscaped%'" ;
            echo "<h4 style=color:#fff;>Search Results for: <i>" . htmlspecialchars($search) . "</i></h4>";
        } else {
            $sql = "SELECT * FROM products";
        }

        $result = mysqli_query($conn, $sql);
        if($result->num_rows>0){
            echo "<table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>image</th>
                <th>price</th>
                <th>Description</th>
                <th>Action</th>
            </tr>";
            while($row = $result->fetch_assoc()){
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td><img src='img/{$row['image']}' alt='Product Image' width='100'></td>
                        <td>{$row['price']}</td>
                        <td>{$row['description']}</td>
                        <td>
                            <a href='?delete={$row['id']}' onclick='return confirm(\"Are you sure?\")'>Delete</a> |
                            <a href='Pupdate.php?update_id={$row['id']}'>Update</a>
                        </td>
                    </tr>";
            }
            echo "</table>";
        }else {
            echo "No data found.";
        }
        mysqli_close($conn);
        ?>
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