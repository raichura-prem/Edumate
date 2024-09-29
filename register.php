<?php
$servername = "sql8.freemysqlhosting.net";
$username = "sql8734201";
$password = "bk3RZ62lba";
$dbname = "sql8734201";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"));
date_default_timezone_set('Asia/Kolkata');

if(isset($data->name) && isset($data->email) && isset($data->password)) {
    $name = $data->name;
    $email = $data->email;
    $password = $data->password;
    $last_login = date('d-m-Y H:i');

    $checkQuery = "SELECT * FROM student_register WHERE email='$email'";
    $result = $conn->query($checkQuery);

    if($result->num_rows > 0) {
        echo json_encode(array("success" => false, "message" => "Email already registered"));
    } else {
        $query = "INSERT INTO student_register (s_name, s_email, s_password, s_last_login) VALUES ('$name', '$email', '$password', '$last_login')";
        
        if ($conn->query($query) === TRUE) {
            echo json_encode(array("success" => true, "message" => "Registration successful"));
        } else {
            echo json_encode(array("success" => false, "message" => "Registration failed"));
        }
    }
} else {
    echo json_encode(array("success" => false, "message" => "Incomplete data"));
}

$conn->close();
?>
