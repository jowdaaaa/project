<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($_POST['password'] == "" || $_POST['password_confirm'] == "" || $_POST['password_current'] == "" || $_POST['name'] == "") {
        echo "All fields are required!";
    } else if ($_POST['password'] != $_POST['password_confirm']) {
        echo "Password and confirmed password did not match!";
    } else {

        $host = "fdb1032.awardspace.net";
        $username = "4361256_finals";
        $password = "JudahPau0112";
        $dbname = "4361256_finals";

        // Create connection
        $conn = new mysqli($host, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $_hashed_password = md5($_POST['password_current']);
        $_hashed_pass = md5($_POST['password']);

        $sql = "SELECT * FROM `user_status` WHERE `username` =  '" . $_COOKIE['username'] . "' AND `password` = '" . $_hashed_password . "'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            $sql = "UPDATE `user_status` SET `password` = '" . $_hashed_pass . "', `name` = '" . $_POST['name'] . "' WHERE `username` = '" . $_COOKIE['username'] . "'";
            $result = $conn->query($sql);
            setcookie('name', $_POST['name'], time() + (86400 * 30));

            // Show loading screen with success message below the icon
            echo '<html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Account Updated</title>
                        <style>
                            body {
                                display: flex;
                                flex-direction: column;
                                align-items: center;
                                justify-content: center;
                                height: 100vh;
                                background-color: #282c35;
                                color: #fff;
                                margin: 0;
                            }

                            .loader {
                                border: 8px solid #f3f3f3;
                                border-top: 8px solid #3498db;
                                border-radius: 50%;
                                width: 50px;
                                height: 50px;
                                animation: spin 1s linear infinite;
                            }

                            @keyframes spin {
                                0% { transform: rotate(0deg); }
                                100% { transform: rotate(360deg); }
                            }

                            .success-message {
                                margin-top: 10px;
                                font-family: \'Silkscreen\', sans-serif;
                            }
                        </style>
                    </head>
                    <body>
                        <div class="loader"></div>
                        <p class="success-message">Updating Account...</p>
                    </body>
                </html>';

            // Redirect after 3 seconds
            echo '<meta http-equiv="refresh" content="3;url=http://judahpaulovinas.mywebcommunity.org/finals/welcome.php" />';
        } else {
            // Redirect after 3 seconds
            echo '<meta http-equiv="refresh" content="3;url=http://judahpaulovinas.mywebcommunity.org/finals/update.html" />';
            echo "Incorrect current password!";
        }

        $conn->close();
    }
}
?>
