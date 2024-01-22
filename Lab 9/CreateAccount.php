
<?php
include 'Header.php';
include 'Menu.php';

// Assuming you have already established a PDO connection $pdo
// Replace these placeholders with your actual database connection details
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the form data when submitted
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $emailAddress = $_POST['emailAddress'];
    $telephoneNumber = $_POST['telephoneNumber'];
    $socialInsuranceNumber = $_POST['socialInsuranceNumber'];
    $password = $_POST['password']; // Store the plain text password
    $designation = $_POST['designation'];
    $adminCode = ($designation == 'ITDeveloper') ? 111 : 999;

    // Hash the password before storing it in the database
    //$password = password_hash($rawPassword, PASSWORD_DEFAULT);

    // Perform database insertion here
    try {
        $stmt = $pdo->prepare("INSERT INTO Employee (FirstName, LastName, EmailAddress, TelephoneNumber, 
            SocialInsuranceNumber, Password, Designation, AdminCode) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->execute([$firstName, $lastName, $emailAddress, $telephoneNumber, $socialInsuranceNumber,
            $password, $designation, $adminCode]);

        // Redirect to ViewAllEmployees.php after successful insertion
        header("Location: ViewAllEmployees.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!-- HTML form for creating an employee account -->
<div>
    <h2>Create Employee Account</h2>
    <form method="POST" action="">
        <!-- Add input fields for all the columns in the Employee table -->
        <label for="firstName">First Name:</label>
        <input type="text" name="firstName" required><br>

        <label for="lastName">Last Name:</label>
        <input type="text" name="lastName" required><br>

        <label for="emailAddress">Email Address:</label>
        <input type="email" name="emailAddress" required><br>

        <label for="telephoneNumber">Telephone Number:</label>
        <input type="tel" name="telephoneNumber"><br>

        <label for="socialInsuranceNumber">Social Insurance Number:</label>
        <input type="text" name="socialInsuranceNumber"><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <label for="designation">Designation:</label>
        <select name="designation" required>
            <option value="ITDeveloper">IT Developer</option>
            <option value="Manager">Manager</option>
        </select><br>

        <input type="submit" value="Create Account">
    </form>
</div>

<?php
include 'Footer.php';
?>

