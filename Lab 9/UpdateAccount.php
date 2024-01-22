<?php
include 'Header.php';
include 'Menu.php';
include 'MySQLConnectionInfo.php';

$host = 'localhost';
$username = 'ubefx31mqcyen';
$password = 'eug7n1krawjy';
$database = 'lab9webprogramming';
session_start();

// Debug: Output session information
echo "Session ID: " . session_id() . "<br>";
echo "Session Status: " . session_status() . "<br>";
echo "Admin Session: " . (isset($_SESSION['admin']) ? 'Yes' : 'No') . "<br>";
// Check if admin is not logged in, redirect to Admin.php
// // Ensure admin session is active
// session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: Admin.php");
    exit();
}

// Initialize success message
$successMessage = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Handle form submission for updating employee information
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employeeId = $_POST['employeeId'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $emailAddress = $_POST['emailAddress'];

    // Use the existing PDO connection and validate the login credentials
    try {
        $stmt = $pdo->prepare("UPDATE Employee SET FirstName = ?, LastName = ?, EmailAddress = ? WHERE EmployeeId = ?");
        $stmt->execute([$firstName, $lastName, $emailAddress, $employeeId]);

        // Check if the update was successful
        $rowsAffected = $stmt->rowCount();
        if ($rowsAffected > 0) {
            // Set success message only if the update affected rows
            $successMessage = "Successfully updated account!";
        } else {
            $successMessage = "No changes made to the account.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Retrieve employee information for the selected EmployeeId
if (isset($_GET['employeeId'])) {
    $employeeId = $_GET['employeeId'];
    try {
        $stmt = $pdo->prepare("SELECT * FROM Employee WHERE EmployeeId = ?");
        $stmt->execute([$employeeId]);
        $employee = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if the employee is found before displaying the form
        if (!$employee) {
            echo "<p>Employee not found.</p>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>

<div style="margin: 20px;">
    <h2>Update Employee Account</h2>

    <?php
    if (!empty($successMessage)) {
        echo "<p style='color: green;'>$successMessage</p>";
    }
    ?>

    <?php if (isset($employee)): ?>
        <form action="UpdateAccount.php" method="POST">
            <input type="hidden" name="employeeId" value="<?= $employee['EmployeeId'] ?>">

            <label for="firstName">First Name:</label>
            <input type="text" name="firstName" value="<?= $employee['FirstName'] ?>" required><br>

            <label for="lastName">Last Name:</label>
            <input type="text" name="lastName" value="<?= $employee['LastName'] ?>" required><br>

            <label for="emailAddress">Email Address:</label>
            <input type="email" name="emailAddress" value="<?= $employee['EmailAddress'] ?>" required><br>

            <!-- Add other fields as needed -->

            <button type="submit">Update Account</button>
        </form>
    <?php endif; ?>
</div>

<?php
include 'Footer.php';
?>