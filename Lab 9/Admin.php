<?php
include 'Header.php';
include 'Menu.php';
include 'MySQLConnectionInfo.php';
include 'password.php';

// Your PHP logic for admin login goes here
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    // $password = $_POST['AdminCode'];

    // Use the PDO connection and validate the login credentials
    try {
        $stmt = $pdo->prepare("SELECT * FROM Employee WHERE EmailAddress = ? AND AdminCode = 999");
        $stmt->execute([$email]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin) {
            // Valid admin found, verify the password
            if ($password === $admin['Password']) {
                // Valid admin login, store admin information in session
                $_SESSION['admin'] = $admin;

                // Redirect to SelectAccount.php
                header("Location: SelectAccount.php");
                exit();
            } else {
                $error = "Invalid email or password. Please try again.";
            }
        } else {
            $error = "Invalid email or password. Please try again.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<div style="margin: 20px;">
    <h2>Admin Login</h2>
    <?php
    if (isset($error)) {
        echo "<p style='color: red;'>$error</p>";
    }
    ?>
    <form action="Admin.php" method="POST">
        <label for="email">Email Address:</label>
        <input type="email" name="email" required><br>
        
        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <input type="submit" value="Login">
    </form>
</div>

<?php
include 'Footer.php';
?>