<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="description" content="">
   <meta name="author" content="">
   <title>Book Template</title>

   <link rel="shortcut icon" href="../../assets/ico/favicon.png">   

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

<?php include 'includes/book-header.inc.php';?>
<?php include 'includes/database.inc.php'; ?>

<?php
// Initialize $books array
$books = [];

// Build the base query
$query = "SELECT * FROM Books WHERE 1";

// Check if a category filter is set
if (isset($_GET['category'])) {
    $category = mysqli_real_escape_string($connection, $_GET['category']);
    $query .= " AND SubcategoryID = '$category'";
}

// Check if an imprint filter is set
if (isset($_GET['imprint'])) {
    $imprint = mysqli_real_escape_string($connection, $_GET['imprint']);
    $query .= " AND ImprintID = '$imprint'";
}

// Check if a status filter is set
if (isset($_GET['status'])) {
    $status = mysqli_real_escape_string($connection, $_GET['status']);
    $query .= " AND ProductionStatusID = '$status'";
}

// Check if a binding filter is set
if (isset($_GET['binding'])) {
    $binding = mysqli_real_escape_string($connection, $_GET['binding']);
    $query .= " AND BindingTypeID = '$binding'";
}

// Execute the final query
$result = mysqli_query($connection, $query);

// Check if the query was successful
if (!$result) {
    die("Database query failed." . mysqli_error($connection)); 
}

// Fetch the books
while ($row = mysqli_fetch_assoc($result)) {
    $books[] = $row;
}

// Free the result set
mysqli_free_result($result);
?>

<div class="container">
    <div class="row">  <!-- start main content row -->
        <div class="col-md-2">  <!-- start left navigation rail column -->
            <?php include 'includes/book-left-nav.inc.php'; ?>
        </div>  <!-- end left navigation rail --> 

        <div class="col-md-6">  <!-- start main content column -->
            <!-- book panel - Catalog  -->
            <div class="panel panel-danger spaceabove">           
                <div class="panel-heading"><h4>Catalog</h4></div>
                <table class="table">
                    <tr>
                        <th>Cover</th>
                        <th>ISBN</th>
                        <th>Title</th>
                    </tr>
                    
                    <?php foreach ($books as $book) : ?>
                        <tr>
                            <td><?php echo isset($book['CoverImage']) ? $book['CoverImage'] : 'N/A'; ?></td>
                            <td><?php echo isset($book['ISBN10']) ? $book['ISBN10'] : 'N/A'; ?></td>
                            <td><a href='book-details.php?ID=<?php echo isset($book['ID']) ? $book['ID'] : ''; ?>'><?php echo isset($book['Title']) ? $book['Title'] : 'N/A'; ?></a></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>           
        </div>
        
        <div class="col-md-2">  <!-- start left navigation rail column -->
            <div class="panel panel-info spaceabove">
                <div class="panel-heading"><h4>Categories</h4></div>
                <ul class="nav nav-pills nav-stacked">
                    <?php
                    // Fetch categories from the database
                    $categoryQuery = "SELECT * FROM Subcategories";
                    $categoryResult = mysqli_query($connection, $categoryQuery);

                    // Check if the query was successful
                    if (!$categoryResult) {
                        die("Database query failed." . mysqli_error($connection));
                    }

                    $counter = 0;

                    // Loop through the retrieved categories and display them
                    while ($category = mysqli_fetch_assoc($categoryResult)) {
                        echo "<li><a href='book-list.php?category=" . (isset($category['ID']) ? $category['ID'] : '') . "'>" . (isset($category['SubcategoryName']) ? $category['SubcategoryName'] : 'N/A') . "</a></li>";

                        // Increment the counter
                        $counter++;

                        // Break out of the loop when the counter reaches 20
                        if ($counter >= 20) {
                            break;
                        }
                    }

                    // Release the result set
                    mysqli_free_result($categoryResult);
                    ?>
                </ul>
            </div>
        </div>

        <div class="col-md-2">  <!-- start left navigation rail column -->
            <div class="panel panel-info spaceabove">
                <div class="panel-heading"><h4>Imprints</h4></div>
                <ul class="nav nav-pills nav-stacked">
                    <?php
                    // Fetch imprints from the database
                    $imprintQuery = "SELECT * FROM Imprints";
                    $imprintResult = mysqli_query($connection, $imprintQuery);

                    // Check if the query was successful
                    if (!$imprintResult) {
                        die("Database query failed." . mysqli_error($connection));
                    }

                    // Loop through the retrieved imprints and display them
                    while ($imprint = mysqli_fetch_assoc($imprintResult)) {
                        echo "<li><a href='book-list.php?imprint=" . (isset($imprint['ID']) ? $imprint['ID'] : '') . "'>" . (isset($imprint['Imprint']) ? $imprint['Imprint'] : 'N/A') . "</a></li>";
                    }

                    // Release the result set
                    mysqli_free_result($imprintResult);
                    ?>
                </ul>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading"><h4>Status</h4></div>
                <ul class="nav nav-pills nav-stacked">
                    <?php
                    // Fetch status options from the database
                    $statusQuery = "SELECT * FROM ProductionStatuses";
                    $statusResult = mysqli_query($connection, $statusQuery);

                    // Check if the query was successful
                    if (!$statusResult) {
                        die("Database query failed." . mysqli_error($connection));
                    }

                    // Loop through the retrieved status options and display them
                    while ($status = mysqli_fetch_assoc($statusResult)) {
                        echo "<li><a href='book-list.php?status=" . (isset($status['ID']) ? $status['ID'] : '') . "'>" . (isset($status['ProductionStatus']) ? $status['ProductionStatus'] : 'N/A') . "</a></li>";
                    }

                    // Release the result set
                    mysqli_free_result($statusResult);
                    ?>
                </ul>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading"><h4>Binding</h4></div>
                <ul class="nav nav-pills nav-stacked">
                    <?php
                    // Fetch binding options from the database
                    $bindingQuery = "SELECT * FROM BindingTypes";
                    $bindingResult = mysqli_query($connection, $bindingQuery);

                    // Check if the query was successful
                    if (!$bindingResult) {
                        die("Database query failed." . mysqli_error($connection));
                    }

                    // Loop through the retrieved binding options and display them
                    while ($binding = mysqli_fetch_assoc($bindingResult)) {
                        echo "<li><a href='book-list.php?binding=" . (isset($binding['ID']) ? $binding['ID'] : '') . "'>" . (isset($binding['BindingType']) ? $binding['BindingType'] : 'N/A') . "</a></li>";
                    }

                    // Release the result set
                    mysqli_free_result($bindingResult);
                    ?>
                </ul>
            </div>
        </div>
    </div>  <!-- end main content row -->
</div>   <!-- end container -->

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="bootstrap3_bookTheme/assets/js/jquery.js"></script>
<script src="bootstrap3_bookTheme/dist/js/bootstrap.min.js"></script>
<script src="bootstrap3_bookTheme/assets/js/holder.js"></script>
</body>
</html>

<?php
// Close the database connection
mysqli_close($connection);
?>
