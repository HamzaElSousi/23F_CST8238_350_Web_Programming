
<!DOCTYPE html>
   <html lang="en">
   <head>
      <meta http-equiv="Content-Type" content="text/html; 
      charset=UTF-8" />
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

   // Include database connection file
   include 'includes/database.inc.php';

   // Determine the sort order from the query string parametera
   $sortColumn = isset($_GET['sort']) ? $_GET['sort'] : 'lastName';
   $sortOrder = isset($_GET['order']) && $_GET['order'] === 'desc' ? 'desc' : 'asc';

   // Handle search query
   $search = isset($_GET['search']) ? $_GET['search'] : '';
   $searchCondition = $search ? "AND (first_name LIKE '%$search%' OR last_name LIKE '%$search%' OR email LIKE '%$search%')" : '';

   // If no sorting is specified in the query string, set default sorting to alphabetical by last name in ascending order
   if ($sortColumn === 'default') {
      $sortColumn = 'lastName';
      $sortOrder = 'asc';
   }

   // Check if a search query is present
   if ($search) {
      $searchTerm = mysqli_real_escape_string($connection, $search);
      $query = "SELECT * FROM Customers WHERE 
               (firstName LIKE '%$searchTerm%' OR lastName LIKE '%$searchTerm%' OR email LIKE '%$searchTerm%') 
               ORDER BY $sortColumn $sortOrder";
   } else {
      // No search query, retrieve all Customers
      $query = "SELECT * FROM Customers ORDER BY $sortColumn $sortOrder";
   }

   $result = mysqli_query($connection, $query);

   // // Fetch customer data from the database
   // $query = "SELECT * FROM Customers ORDER BY $sortColumn $sortOrder";
   // $result = mysqli_query($connection, $query);

   // Check if the query was successful
   if (!$result) {
      die("Database query failed." . mysqli_error($connection)); 
   }

   ?>
      
   <div class="container">
      <div class="row">  <!-- start main content row -->

         <div class="col-md-2">  <!-- start left navigation rail column -->
            <?php include 'includes/book-left-nav.inc.php'; ?>
         </div>  <!-- end left navigation rail --> 

         <div class="col-md-8">  <!-- start main content column -->         
            <!-- book panel  -->
            <div class="panel panel-danger spaceabove">           
               <div class="panel-heading">
                  <h4><a href="book-details.php?id=<?php echo isset($row['bookid']) ? $row['bookid'] : ''; ?>">Catalog</a></h4>
                  <?php echo $search ? " - Filtered by: $search" : ''; ?>
                  <?php
                  // If a search term is present, display the "Remove Filter" button
                  if ($search) {
                     echo '<a href="?sort=' . $sortColumn . '&order=' . $sortOrder . '" class="btn btn-default btn-xs">Remove Filter</a>';
                  }
                  ?>
               </div>
               <table class="table">
                  <tr>
                        <th><a href="?sort=lastName">Name <?php echo sortIcon('lastName', $search); ?></a></th>
                        <th><a href="?sort=email">Email <?php echo sortIcon('email', $search); ?></a></th>
                        <th><a href="?sort=address">Address <?php echo sortIcon('address', $search); ?></a></th>
                        <th><a href="?sort=city">City <?php echo sortIcon('city', $search); ?></a></th>
                        <th><a href="?sort=country">Country <?php echo sortIcon('country', $search); ?></a></th>
                        <th><a href="?sort=phone">Phone <?php echo sortIcon('phone', $search); ?></a></th>
                  </tr>
                  <?php
                        // Loop through the retrieved data and display it in the table
                        while ($row = mysqli_fetch_assoc($result)) {
                           echo "<tr>";
                           echo "<td>{$row['firstName']} {$row['lastName']}</td>";
                           echo "<td>{$row['email']}</td>";
                           echo "<td>{$row['address']}</td>";
                           echo "<td>{$row['city']}</td>";
                           echo "<td>{$row['country']}</td>";
                           echo "<td>{$row['phone']}</td>";
                           echo "</tr>";
                        }

                        // Release the result set
                        mysqli_free_result($result);
                  ?>
               </table>
            </div>           
         </div>
         
         <!-- start left navigation rail column -->
         <!-- <div class="col-md-2">  
            <div class="panel panel-info spaceabove">
               <div class="panel-heading"><h4>Categories</h4></div>
                  <ul class="nav nav-pills nav-stacked">

                  </ul> 
            </div>
            
            <div class="panel panel-info">
               <div class="panel-heading"><h4>Imprints</h4></div>
               <ul class="nav nav-pills nav-stacked">

               </ul>
            </div>         
         </div>  -->  
         <!-- end left navigation rail --> 


         </div>  <!-- end main content column -->
      </div>  <!-- end main content row -->
   </div>   <!-- end container -->
      

   <?php
   // Function to generate sort icons
   function sortIcon($column)
   {
      $sortColumn = isset($_GET['sort']) ? $_GET['sort'] : 'default';
      $sortOrder = isset($_GET['order']) && $_GET['order'] === 'desc' ? 'desc' : 'asc';
      $search = isset($_GET['search']) ? $_GET['search'] : '';

      if ($column === $sortColumn) {
         $nextOrder = $sortOrder === 'asc' ? 'desc' : 'asc';
         return '<a href="?sort=' . $column . '&order=' . $nextOrder . '&search=' . urlencode($search) . '" style="text-decoration:none;">' .
               ' <span class="glyphicon glyphicon-arrow-' . ($sortOrder === 'asc' ? 'up' : 'down') . '" aria-hidden="true"></span></a>';
      } else {
         return '<a href="?sort=' . $column . '&order=asc&search=' . urlencode($search) . '" style="text-decoration:none;">' .
               '<span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span></a>';
      }
   }
   ?>
      
      
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