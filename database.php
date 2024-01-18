<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "urban_mobility_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Process Home Section (Registration)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['home_submit'])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];

    $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";
    $conn->beginTransaction();
    $conn->exec($sql);
    $conn->commit();

            echo "Registration successful!";
}
    

// Process Parking Spaces Section
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['parking_submit'])) {
    $space_id = $_POST["space_id"];
    $is_available = $_POST["is_available"];

    $sql = "INSERT INTO parking_spaces (space_id, is_available) VALUES ('$space_id', '$is_available')";
    $conn->beginTransaction();
    $conn->exec($sql);
    $conn->commit();

        echo "Parking space data submitted successfully!";
        $sql = "SELECT * FROM parking_spaces WHERE space_id = '$space_id'";
        $result = $conn->query($sql);

        echo "<h3>Parking Space Information</h3>";
        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "Space ID: " . $row["space_id"] . " - Available: " . $row["is_available"] . "<br>";
            }
        } else {
            echo "No information available for Space ID: $space_id";
        }
}
// Process Traffic Data Section
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['traffic_submit'])) {
    $location = $_POST["location"];
    $traffic_intensity = $_POST["traffic_intensity"];

    $sql = "INSERT INTO traffic_data (location, traffic_intensity) VALUES ('$location', '$traffic_intensity')";
    $conn->beginTransaction();
    $conn->exec($sql);
    $conn->commit();

        echo "Traffic data submitted successfully!";
    $sql = "SELECT * FROM traffic_data WHERE location = '$location'";
        $result = $conn->query($sql);

        echo "<h3>Traffic Data Information</h3>";
        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "Location: " . $row["location"] . " - Traffic Intensity: " . $row["traffic_intensity"] . "<br>";
            }
        } else {
            echo "No information available for Location: $location";
        }
}
?>