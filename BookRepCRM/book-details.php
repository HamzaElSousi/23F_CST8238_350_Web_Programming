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

<?php
include 'includes/book-header.inc.php';
include 'includes/database.inc.php';

// Initialize $book variable
$book = [];

// Check if the 'id' parameter is present in the query string
if (isset($_GET['ID'])) {
    // Get the book ID from the query string
    $bookId = mysqli_real_escape_string($connection, $_GET['ID']);

    // Debug statement to check if ID is received
    // echo "Book ID: $bookId";

    // Fetch book data from the database based on the book ID
    $query = "SELECT * FROM Books WHERE ID = '$bookId'";
    $result = mysqli_query($connection, $query);

    // Debugging
    var_dump($book);

    // Check if the query was successful
    if ($result) {
        // Check if any rows were returned
        if (mysqli_num_rows($result) > 0) {
            // Fetch the book details
            $book = mysqli_fetch_assoc($result);

            // Now, fetch authors for the book from the BookAuthors table
            $authorQuery = "SELECT Authors.FirstName, Authors.LastName
                            FROM Authors
                            JOIN BookAuthors ON Authors.ID = BookAuthors.AuthorId
                            WHERE BookAuthors.BookId = '$bookId'";

            $authorResult = mysqli_query($connection, $authorQuery);

            // Check if the query was successful
            if ($authorResult) {
                // Fetch and store the authors in an array
                $authors = [];
                while ($authorRow = mysqli_fetch_assoc($authorResult)) {
                    $authors[] = $authorRow['FirstName'] . ' ' . $authorRow['LastName'];
                }

                // Assign the authors array to the $book array
                $book['Authors'] = implode(', ', $authors);

                // Free the result set
                mysqli_free_result($authorResult);
            } else {
                // Query for authors failed
                echo "Database query failed: " . mysqli_error($connection);
            }
        } else {
            // No results found for the given book ID
            echo "No book found with ID: $bookId";
        }

        // Free the result set for book details
        mysqli_free_result($result);
    } else {
        // Query for book details failed
        echo "Database query failed: " . mysqli_error($connection);
    }
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-2">
            <?php include 'includes/book-left-nav.inc.php'; ?>
        </div>
        <div class="col-md-10">
            <div class="panel panel-danger spaceabove">
                <div class="panel-heading">
                    <h4>Book Details</h4>
                </div>

                <table class="table">
                    <tr>
                        <th>Cover</th>
                        <td>
                            <?php
                            // Construct the file path for the cover image
                            $coverImagePath = "images/tinysquare/{$book['ISBN10']}.jpg";

                            // Check if the file exists
                            if (file_exists($coverImagePath)) {
                                // Display the cover image
                                echo "<img src='$coverImagePath' alt='Cover Image' class='img-responsive'>";
                            } else {
                                // Display a default image or a placeholder if the file doesn't exist
                                echo "<img src='images/tinysquare/default.jpg' alt='Default Image' class='img-responsive'>";
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Title</th>
                        <td><em><a href='book-details.php?ID=<?php echo $bookId; ?>'><?php echo isset($book['Title']) ? $book['Title'] : 'N/A'; ?></a></em></td>
                    </tr>
                    <tr>
                        <th>Authors</th>
                        <td><?php echo isset($book['Authors']) ? $book['Authors'] : 'N/A'; ?></td>
                    </tr>
                    <tr>
                        <th>ISBN-10</th>
                        <td><?php echo isset($book['ISBN10']) ? $book['ISBN10'] : 'N/A'; ?></td>
                    </tr>
                    <tr>
                        <th>ISBN-13</th>
                        <td><?php echo isset($book['ISBN13']) ? $book['ISBN13'] : 'N/A'; ?></td>
                    </tr>
                    <tr>
                        <th>Copyright Year</th>
                        <td><?php echo isset($book['CopyrightYear']) ? $book['CopyrightYear'] : 'N/A'; ?></td>
                    </tr>
                    <tr>
                        <th>Instock Date</th>
                        <td><?php echo isset($book['LatestInstockDate']) ? $book['LatestInstockDate'] : 'N/A'; ?></td>
                    </tr>
                    <tr>
                        <th>Trim Size</th>
                        <td><?php echo isset($book['TrimSize']) ? $book['TrimSize'] : 'N/A'; ?></td>
                    </tr>
                    <tr>
                        <th>Page Count</th>
                        <td><?php echo isset($book['PageCountsEditorialEst']) ? $book['PageCountsEditorialEst'] : 'N/A'; ?></td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td><?php echo isset($book['Description']) ? $book['Description'] : 'N/A'; ?></td>
                    </tr>
                    <tr>
                        <th>Sub Category</th>
                        <td><?php echo isset($book['SubcategoryID']) ? $book['SubcategoryID'] : 'N/A'; ?></td>
                    </tr>
                    <tr>
                        <th>Imprint</th>
                        <td><?php echo isset($book['ImprintID']) ? $book['ImprintID'] : 'N/A'; ?></td>
                    </tr>
                    <tr>
                        <th>Binding Type</th>
                        <td><?php echo isset($book['BindingTypeID']) ? $book['BindingTypeID'] : 'N/A'; ?></td>
                    </tr>
                    <tr>
                        <th>Production Status</th>
                        <td><?php echo isset($book['ProductionStatusID']) ? $book['ProductionStatusID'] : 'N/A'; ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="bootstrap3_bookTheme/assets/js/jquery.js"></script>
<script src="bootstrap3_bookTheme/dist/js/bootstrap.min.js"></script>
<script src="bootstrap3_bookTheme/assets/js/holder.js"></script>
</body>

</html>

<?php
// Close the database connection
mysqli_close($connection);
?>
