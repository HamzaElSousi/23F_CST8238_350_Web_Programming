<?php
include 'Header.php';
include 'Menu.php';
include 'MySQLConnectionInfo.php';
$host = 'localhost';
$username = 'ubefx31mqcyen';
$password = 'eug7n1krawjy';
$database = 'lab9webprogramming';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Your PHP logic for viewing all employees goes here

    // Check if the user is logged in
    session_start();
    if (!isset($_SESSION['user'])) {
        header("Location: Login.php");
        exit();
    }

    try {
        // Use the PDO connection to fetch all employees from the Employee table
        $stmt = $pdo->prepare("SELECT * FROM Employee");
        $stmt->execute();
        $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

?>

<div style="margin: 20px;">
    <h2>All Employees</h2>
    <?php
    if (count($employees) > 0) {
        echo '<table border="1" style="width:100%; border-collapse: collapse; margin-bottom: 20px;">';
        echo '<tr>';
        foreach ($employees[0] as $key => $value) {
            if ($key != 'Password' && $key != 'AdminCode') {
                echo '<th>' . $key . '</th>';
            }
        }
        echo '</tr>';

        foreach ($employees as $employee) {
            echo '<tr>';
            foreach ($employee as $key => $value) {
                if ($key != 'Password' && $key != 'AdminCode') {
                    echo '<td>' . $value . '</td>';
                }
            }
            echo '</tr>';
        }

        echo '</table>';
    } else {
        echo '<p>No employees found.</p>';
    }
    ?>
</div>

<?php
include 'Footer.php';
?>
