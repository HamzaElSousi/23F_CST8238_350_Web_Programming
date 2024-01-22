    <?php include('Header.php'); ?>
    <?php include('Menu.php'); ?>

    <div class="content">
        <h2>Product Information</h2>

        <?php
        // Sub-Task 1: Create the $Product array
        $Product = array(
            "Category" => array(
                "Printer" => array(
                    array(
                        "Brand" => "Epson",
                        "Quantity" => 100,
                        "Price" => 2500
                    ),
                    array(
                        "Brand" => "Canon",
                        "Quantity" => 100,
                        "Price" => 3000
                    ),
                    array(
                        "Brand" => "Xerox",
                        "Quantity" => 500,
                        "Price" => 2000
                    ),
                ),
                "Laptop" => array(
                    array(
                        "Brand" => "Apple",
                        "Quantity" => 200,
                        "Price" => 2000
                    ),
                    array(
                        "Brand" => "HP",
                        "Quantity" => 300,
                        "Price" => 1500
                    ),
                    array(
                        "Brand" => "Toshiba",
                        "Quantity" => 100,
                        "Price" => 1200
                    ),
                ),
                "TV" => array(
                    array(
                        "Brand" => "Samsung",
                        "Quantity" => 500,
                        "Price" => 1200
                    ),
                    array(
                        "Brand" => "LG",
                        "Quantity" => 500,
                        "Price" => 1050
                    ),
                    array(
                        "Brand" => "Sony",
                        "Quantity" => 200,
                        "Price" => 1000
                    ),
                ),
                // Add more products as needed
            )
        );

        // Sub-Task 2: Display the structure of the $Product array
        echo "<h3>Product Array Structure:</h3>";
        var_dump($Product);

        // Sub-Task 3: Display the elements of the $Product array
        echo "<h3>Product Array Elements:</h3>";
        foreach ($Product['Category'] as $category => $products) {
            echo "<h4>$category</h4>";
            foreach ($products as $product) {
                foreach ($product as $key => $value) {
                    echo "$key: $value<br>";
                }
                echo "<br>";
            }
        }

        // Sub-Task 4: Display the elements of the $Product array in a table format
        echo "<h3>Product Table:</h3>";
        echo "<table border='1'>";
        echo "<tr><th>Category</th><th>Brand</th><th>Quantity</th><th>Price</th></tr>";
        foreach ($Product['Category'] as $category => $products) {
            foreach ($products as $product) {
                echo "<tr>";
                echo "<td>$category</td>";
                echo "<td>{$product['Brand']}</td>";
                echo "<td>{$product['Quantity']}</td>";
                echo "<td>{$product['Price']}</td>";
                echo "</tr>";
            }
        }
        echo "</table>";
        ?>
    </div>

    <?php include('Footer.php'); ?>
</body>

</html>
