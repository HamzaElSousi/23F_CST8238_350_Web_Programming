<?php
include 'Header.php';
include 'Menu.php';
include 'MySQLConnectionInfo.php';

// Your PHP logic for handling the final update goes here
$host = 'localhost';
$username = 'ubefx31mqcyen';
$password = 'eug7n1krawjy';
$database = 'lab9webprogramming';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: Admin.php");
    exit();
}

// Retrieve employee information for the updated EmployeeId
if (isset($_GET['employeeId'])) {
    $employeeId = $_GET['employeeId'];
    try {
        $stmt = $pdo->prepare("SELECT * FROM Employee WHERE EmployeeId = ?");
        $stmt->execute([$employeeId]);
        $updatedEmployee = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if the updated employee is found
        if (!$updatedEmployee) {
            echo "<p>Updated employee not found.</p>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<div style="margin: 20px;">
    <h2>Update Complete</h2>
    
    <?php if (isset($updatedEmployee)): ?>
        <p>Account successfully updated!</p>
        
        <!-- Display the updated employee information -->
        <p><strong>Employee ID:</strong> <?= $updatedEmployee['EmployeeId'] ?></p>
        <p><strong>First Name:</strong> <?= $updatedEmployee['FirstName'] ?></p>
        <p><strong>Last Name:</strong> <?= $updatedEmployee['LastName'] ?></p>
        <p><strong>Email Address:</strong> <?= $updatedEmployee['EmailAddress'] ?></p>
        
        <!-- Add other fields as needed -->

        <!-- Button to navigate to index.php -->
        <a href="index.php"><button>Back to Index</button></a>
    <?php endif; ?>
</div>

<?php
include 'Footer.php';
?>