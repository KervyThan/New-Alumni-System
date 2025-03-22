<?php
include "../config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST["first_name"];
    $middle_name = $_POST["middle_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $course = $_POST["course"];
    $batch = $_POST["batch"];
    $year_graduated = $_POST["year_graduated"];
    $alumni_id = $_POST["alumni_id"];
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash password

    $query = "INSERT INTO users (alumni_id, username, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $alumni_id, $username, $password);
    
    if ($stmt->execute()) {
        echo "<script>alert('Signup successful!'); window.location='login.php';</script>";
    } else {
        echo "<script>alert('Error during signup!');</script>";
    }
}
?>
