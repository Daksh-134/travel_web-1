<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection parameters (Replace with your own)
    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "final_db";

    // Create a database connection
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve user input
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];

    // You should perform input validation and sanitation here

    // Hash the password (use a strong hashing algorithm)
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert the user data into the database
    $sql = "INSERT INTO users (user_id, password, email, first_name, last_name) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $username, $hashed_password, $email, $firstname, $lastname);

    if ($stmt->execute()) {
        // Registration successful
        echo "Registration successful!";
    } else {
        // Registration failed
        echo "Error: " . $stmt->error;
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
} else {
    // Redirect to the signup page if the form is not submitted
    header("Location: signup.html");
    exit();
}
?>