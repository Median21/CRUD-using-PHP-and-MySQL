<?php
    include("database.php");

    $sanitized_email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
    $sanitized_password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    $hash = password_hash($sanitized_password, PASSWORD_DEFAULT);
    
    //CREATE
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
        try {
            $sql = "INSERT INTO user (email, password)
                    VALUES ('$sanitized_email', '$hash')";
            mysqli_query($conn, $sql);
            echo "User registered <br>";
        } catch (mysqli_sql_exception) {
            echo "User already registered <br>";
        }
    }
    
    //DELETE
   if (isset($_GET["id"])) {
        $id = $_GET['id'];
        $sql = "DELETE FROM user WHERE id = $id";
        mysqli_query($conn, $sql);
        echo "User deleted";
   }

   //UPDATE
    $editmode = $_GET["edit"];
    $editID = $_GET["editID"];
   
    $new_email = filter_input(INPUT_POST, "new_email", FILTER_SANITIZE_EMAIL);

   
   if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
        $sql = "UPDATE user SET email = '$new_email' WHERE id = '$editID'";
        mysqli_query($conn, $sql);
    }


   //READ
    $sql = "SELECT * FROM user";
    $result = mysqli_query($conn, $sql);
    $row = "";

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Crud Challenge</title>
</head>
<body>
    <h1>Inventory System</h1>
    <form action="index.php" method="post">
        <div class="form-input">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
        </div>

        <div class="form-input">    
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
        </div>
            <button name="register">Register</button>
    </form>

    
        <table>
            <caption>USERS</caption>
            <tr class="columns">
                <th>ID</th>
                <th>Email</th>
                <th>Registration Date</th>
                <th>Action</th>
            </tr>
            <?php
            if ($row && !$editmode) {
                foreach($row as $key) {
                    echo 
                    "<tr>
                        <td>{$key['id']}</td>
                        <td>{$key['email']}</td>
                        <td>{$key['reg_date']}</td>
                        <td><a href='?id={$key['id']}'><button>DELETE</button></a></td>
                        <td><a href='?edit=true&editID={$key['id']}'><button>EDIT</button></a></td>
                    </tr>";
                }
            } elseif ($row && $editmode) {
                foreach($row as $key) {
                    if ($editID == $key['id']) {
                        echo 
                        "<tr>
                            <form action='index.php?editID={$key['id']}' method='post'>
                                <td>{$key['id']}</td>
                                <td><input type='email' value={$key['email']} name='new_email' required></input></td>
                                <td><input value={$key['reg_date']}></input></td>
                                <td><a href='?id={$key['id']}'><button type='button'>DELETE</button></a></td>
                                <td><a href='?edit=true&editID={$key['id']}'><button name='update'>UPDATE</button></a></td>
                            </form>
                        </tr>";
                    } else {  
                        echo 
                        "<tr>
                            <td>{$key['id']}</td>
                            <td>{$key['email']}</td>
                            <td>{$key['reg_date']}</td>
                            <td><a href='?id={$key['id']}'><button>DELETE</button></a></td>
                            <td><a href='?edit=true&editID={$key['id']}'><button>EDIT</button></a></td>
                        </tr>";
                    }
            }
            } else {
                echo "No users found";
            }
               
            ?>
        </table>
   
</body>
</html>