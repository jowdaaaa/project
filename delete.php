<?php
session_start();
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

$sql = "DELETE FROM `user_status` WHERE `username` = '".$_COOKIE['username']."'";

if ($conn->query($sql) === TRUE) {
    echo '<html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Account Deleted</title>
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
            <p class="success-message">Deleting Account...</p>
        </body>
    </html>';
    echo '<meta http-equiv="refresh" content="3;url=http://judahpaulovinas.mywebcommunity.org/finals/register.html" />';
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
