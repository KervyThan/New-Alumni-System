<?php
session_start();
include "../config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $alumni_id = trim($_POST["ID"]);
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    // Query to get user details along with the course
    $query = "SELECT users.*, alumni_details.course 
              FROM users 
              JOIN alumni_details ON users.alumni_id = alumni_details.alumni_id
              WHERE users.alumni_id = ? AND users.username = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $alumni_id, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password
        if ($password == $user['password']) {
            // Store session variables
            $_SESSION["user_id"] = $user["user_id"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["course"] = $user["course"];  // Store the course (academic program)

            // Redirect based on the course
            if ($user['course'] == 'BSCS') {
                header("Location: ../views/bscs.php");  // Redirect to BSCS dashboard
                exit();
            } elseif ($user['course'] == 'IT') {
                header("Location: ../views/it.php");  // Redirect to IT dashboard
                exit();
            } elseif ($user['course'] == 'ACT') {
                header("Location: ../views/act.php");  // Redirect to ACT dashboard
                exit();
            } elseif ($user['course'] == 'Dean') {
                header("Location: ../views/dean.php");  // Redirect to ACT dashboard
                exit();
            } elseif ($user['course'] == 'Registrar') {
                header("Location: ../views/registrar.php");  // Redirect to ACT dashboard
                exit();
            } else {
                // Fallback redirection if the course is not recognized
                header("Location: ../homepage.php");
                exit();
            }
        } else {
            echo "<script>alert('Invalid password!');</script>";
        }
    } else {
        echo "<script>alert('No user found!');</script>";
    }
}
?>
