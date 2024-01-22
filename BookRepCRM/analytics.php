<?php

// Include database connection file
include 'includes/database.inc.php';

// Define the number of rows per page
$rowsPerPage = 10;

// Get the current page number from the URL, default to 1
$pageNumber = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the offset for the SQL query
$offset = ($pageNumber - 1) * $rowsPerPage;

// Query 1: Get all authors with pagination
$queryAuthors = "SELECT * FROM authors LIMIT $offset, $rowsPerPage";
$resultAuthors = executeQuery($queryAuthors, $connection);

// Query 2: Get all website visits with pagination
$queryWebsiteVisits = "SELECT * FROM websitevisits LIMIT $offset, $rowsPerPage";
$resultWebsiteVisits = executeQuery($queryWebsiteVisits, $connection);

// Query 3: Get all customers with pagination
$queryCustomers = "SELECT * FROM customers LIMIT $offset, $rowsPerPage";
$resultCustomers = executeQuery($queryCustomers, $connection);

// Close the database connection
mysqli_close($connection);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Analytics</title>

    <link rel="shortcut icon" href="assets/ico/favicon.png">

    <!-- Google fonts used in this theme -->
    <link href='http://fonts.googleapis.com/css?family=Roboto+Slab:400,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic,700italic' rel='stylesheet' type='text/css'>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap3_bookTheme/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme CSS -->
    <link href="bootstrap3_bookTheme/theme.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
   <script src="bootstrap3_bookTheme/assets/js/html5shiv.js"></script>
   <script src="bootstrap3_bookTheme/assets/js/respond.min.js"></script>
   <![endif]-->
</head>

<body>

    <?php include 'includes/book-header.inc.php'; ?>

    <div class="container">
        <div class="row">

            <div class="col-md-2">
                <?php include 'includes/book-left-nav.inc.php'; ?>
            </div>

            <div class="col-md-10">
                <div class="panel panel-primary spaceabove">
                    <div class="panel-heading">
                        <h4>Analytics</h4>
                    </div>

                    <!-- Display authors -->
                    <div>
                        <h5>Authors</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <!-- Adjust column names based on your database structure -->
                                    <th>ID</th>
                                    <th>Name</th>
                                    <!-- Add more columns if needed -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = $resultAuthors->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['ID'] . "</td>";
                                    echo "<td>" . $row['FirstName'] . "</td>";
                                    echo "<td>" . $row['LastName'] . "</td>";
                                    echo "<td>" . $row['Institution'] . "</td>";
                                    // Add more cells if needed
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Display website visits -->
                    <div>
                        <h5>Website Visits</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <!-- Adjust column names based on your database structure -->
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>IP Address</th>
                                    <th>Country Code</th>
                                    <!-- Add more columns if needed -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = $resultWebsiteVisits->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['dateViewed'] . "</td>";
                                    echo "<td>" . $row['ip_address'] . "</td>";
                                    echo "<td>" . $row['countryCode'] . "</td>";
                                    // Add more cells if needed
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Display customers -->
                    <div>
                        <h5>Customers</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <!-- Adjust column names based on your database structure -->
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Name</th>
                                    <!-- Add more columns if needed -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = $resultCustomers->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['ID'] . "</td>";
                                    echo "<td>" . $row['firstName'] . "</td>";
                                    echo "<td>" . $row['lastName'] . "</td>";
                                    echo "<td>" . $row['lastName'] . "</td>";
                                    echo "<td>" . $row['phone'] . "</td>";
                                    echo "<td>" . $row['countryCode'] . "</td>";
                                    // Add more cells if needed
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="bootstrap3_bookTheme/assets/js/jquery.js"></script>
    <script src="bootstrap3_bookTheme/dist/js/bootstrap.min.js"></script>
    <script src="bootstrap3_bookTheme/assets/js/holder.js"></script>
</body>

</html>

<?php

// Function to execute a query and return the result
function executeQuery($query, $connection)
{
    $result = $connection->query($query);

    if (!$result) {
        die("Error executing query: " . $connection->error);
    }

    return $result;
}
?>