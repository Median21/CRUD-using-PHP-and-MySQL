<?php
    include("database.php");

    $sanitized_email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $sanitized_pw = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {        
        try {
            $sql = "SELECT * FROM user WHERE email = '$sanitized_email'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_all($result, MYSQLI_ASSOC);

                foreach ($row as $key) {
                    if (password_verify($sanitized_pw, $key["password"])) {
                        echo "Correct credentials";
                    } else {
                        echo "Incorrect username/password";
                    }
                }
            } else {
                echo "Incorrect username/password";
            }
        } catch (mysqli_sql_exception) {
            echo "Incorrect credentials";
        }
        
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="login.css">
        <title>Document</title>
    </head>
    <body>
        <form action="login.php" method="post">
            <div class="login-field">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email">
            </div>
            <div class="login-field">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password">
            </div>
            <button>Login</button>

        </form>
    </body>
    </html>
</body>
</html>