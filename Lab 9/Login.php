<?php
include 'Header.php';
include 'Menu.php';
include 'MySQLConnectionInfo.php';
include 'password.php';
// Your PHP logic for user login goes here
//SG and lcl usr
$host = 'localhost';
$username = 'ubefx31mqcyen'; 
$password = 'eug7n1krawjy';
$database = 'lab9webprogramming';
session_start();

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Use the existing PDO connection and validate the login credentials
        try {
            $stmt = $pdo->prepare("SELECT * FROM Employee WHERE EmailAddress = ? AND Password = ?");
            $stmt->execute([$email, $password]); // Assuming the passwords are stored in plain text in the database

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Valid login, store user information in session
                $_SESSION['user'] = $user;

                // Redirect to ViewAllEmployees.php
                header("Location: ViewAllEmployees.php");
                exit();
            } else {
                $error = "Invalid email or password. Please try again.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<div style="margin: 20px;">
    <h2>Login</h2>
    <?php
    if (isset($error)) {
        echo "<p style='color: red;'>$error</p>";
    }
    ?>
    <form action="Login.php" method="POST">
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