<?php
// Connect to your database (modify these settings as needed)
$host = "localhost";
$username = "root";
$password = "";
$database = "final_db";




// Create a connection to the database
$mysqli = new mysqli($host, $username, $password, $database);

// Check the connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Retrieve data from the HTML form
if (isset($_POST['id']) && isset($_POST['Destination']) && isset($_POST['date']) && isset($_POST['child']) && isset($_POST['adults'])) {
    $user_id = $_POST['id'];
    $location_name = $_POST['Destination'];
    $check_in_date = $_POST['date'];
    $num_children = $_POST['child'];
    $num_adults = $_POST['adults'];


    // Fetch destination details from the database
    $stmt = $mysqli->prepare("SELECT location_name, price_adults, price_children FROM destinations WHERE location_name = ?");
    $stmt->bind_param("s", $location_name);
    $stmt->execute();
    $result = $stmt->get_result();
    $destinationData = $result->fetch_assoc();

    // Calculate the total price
    $adultPrice = $destinationData["price_adults"] * $num_adults;
    $childPrice = $destinationData["price_children"] * $num_children;
    $totalPrice = $adultPrice + $childPrice;


    // SQL query to insert data into the "bookings" table
    $sql = "INSERT INTO bookings (user_id, location_name, check_in_date, num_children, num_adults) VALUES ('$user_id', '$location_name', '$check_in_date', '$num_children', '$num_adults')";

    if ($mysqli->query($sql) === TRUE) {

        // Redirect to confirmation.php with the success message and total price in the URL
        header("Location: confirmation.php?message=Booking inserted successfully! Total Price: $totalPrice");
        exit();

        echo "Booking inserted successfully!";

    } else {
        echo "Error: " . $sql . "<br>" . $mysqli->error;
    }

    // Close the database connection
    $mysqli->close();
} else {
    echo "Form data is incomplete. Please fill out all the required fields.";
}
?>