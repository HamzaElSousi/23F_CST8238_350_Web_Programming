<?php
include 'Header.php';
include 'Menu.php';
include 'MySQLConnectionInfo.php';
                //TODO: if not admin, don't allow sql injection. 
                
// Your PHP logic for selecting an account goes here
$host = 'localhost';
$username = 'ubefx31mqcyen';
$password = 'eug7n1krawjy';
$database = 'lab9webprogramming';
session_start();

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

// Handle CRUD operations if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete'])) {
        // Handle delete operation
        $employeeId = $_POST['employeeId'];
        try {
            $stmt = $pdo->prepare("DELETE FROM Employee WHERE EmployeeId = ?");
            $stmt->execute([$employeeId]);
            // Redirect or display success message
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } elseif (isset($_POST['update'])) {
        // Handle update operation
        // You can redirect to another page or include an update form here
        // For simplicity, let's redirect to an update form (UpdateAccount.php)
        $employeeId = $_POST['employeeId'];
        header("Location: UpdateAccount.php?employeeId=$employeeId");
        exit();
    } elseif (isset($_POST['create'])) {
        // Handle create operation
        // You can redirect to another page or include a create form here
        // For simplicity, let's redirect to a create form (CreateAccount.php)
        header("Location: CreateAccount.php");
        exit();
    }
}

// Retrieve employee accounts for display
try {
    $stmt = $pdo->prepare("SELECT * FROM Employee");
    $stmt->execute();
    $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<div style="margin: 20px;">
    <h2>Select Employee Account</h2>
    
    <!-- Display employee accounts -->
    <table border="1">
        <tr>
            <th>EmployeeId</th>
            <th>FirstName</th>
            <th>LastName</th>
            <th>EmailAddress</th>
            <!-- Add other columns as needed -->
            <th>Action</th>
        </tr>
        <?php foreach ($employees as $employee): ?>
            <tr>
                <td><?= $employee['EmployeeId'] ?></td>
                <td><?= $employee['FirstName'] ?></td>
                <td><?= $employee['LastName'] ?></td>
                <td><?= $employee['EmailAddress'] ?></td>
                <!-- Add other columns as needed -->
                <td>
                    <form action="SelectAccount.php" method="POST">
                        <input type="hidden" name="employeeId" value="<?= $employee['EmployeeId'] ?>">
                        <button type="submit" name="delete">Delete</button>
                        <button type="submit" name="update">Update</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <!-- Create new employee account form -->
    <form action="SelectAccount.php" method="POST">
        <button type="submit" name="create">Create New Account</button>
    </form>
</div>

<?php
include 'Footer.php';
?>