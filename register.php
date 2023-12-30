<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['username'] == "" || $_POST['password'] == "" || $_POST['password_confirm'] == "" || $_POST['name'] == "") {
        // Show error message for empty fields
        echo '<html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Registration Error</title>
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

                        .error-message {
                            margin-top: 20px;
                            font-family: \'Silkscreen\', sans-serif;
                            font-size: 20px;
                            color: #ff0000; /* Error message color */
                        }
                    </style>
                </head>
                <body>
                    <p class="error-message">All fields are required!</p>
                </body>
            </html>';
    } else if ($_POST['password'] != $_POST['password_confirm']) {
        // Show error message for password mismatch
        echo '<html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Registration Error</title>
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

                        .error-message {
                            margin-top: 20px;
                            font-family: \'Silkscreen\', sans-serif;
                            font-size: 20px;
                            color: #ff0000; /* Error message color */
                        }
                    </style>
                </head>
                <body>
                    <p class="error-message">Password and confirmed password did not match!</p>
                </body>
            </html>';
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

        $_hashed_password = md5($_POST['password']);

        $sql = "INSERT INTO user_status (`username`, `password`, `name`, `status`, `datetime`) VALUES ('" . $_POST['username'] . "', '" . $_hashed_password . "', '" . $_POST['name'] . "', '" . $_POST['status'] . "', NOW())";

        if ($conn->query($sql) === TRUE) {
            // Show loading screen with success message
            echo '<html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Registration Successful</title>
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
                                margin-top: 20px;
                                font-family: \'Silkscreen\', sans-serif;
                                font-size: 20px;
                            }
                        </style>
                    </head>
                    <body>
                        <div class="loader"></div>
                        <p class="success-message">Creating Account...</p>
                    </body>
                </html>';

            // Redirect after 3 seconds
            echo '<meta http-equiv="refresh" content="3;url=http://judahpaulovinas.mywebcommunity.org/finals/login.html" />';
        } else {
            // Show error message for database error
            echo '<html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Registration Error</title>
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

                            .error-message {
                                margin-top: 20px;
                                font-family: \'Silkscreen\', sans-serif;
                                font-size: 20px;
                                color: #ff0000; /* Error message color */
                            }
                        </style>
                    </head>
                    <body>
                        <p class="error-message">Error: ' . $sql . '<br>' . $conn->error . '</p>
                    </body>
                </html>';
        }

        $conn->close();
    }
}
?>
