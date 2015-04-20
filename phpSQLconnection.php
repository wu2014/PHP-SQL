<?php
    $host = "mysql.hostinger.co.uk";
    $dbname = "u931984913_dbwyy";
    $dbuser = "u931984913_wyy";
    $pwd = "123456Wd";
    $dbc = 0;
    $dbc = mysqli_connect($host, $dbuser, $pwd, $dbname)
        or die('Cannot connect to database');
    $query = "SELECT customerNumber, customerName, city, country FROM customers ORDER BY customerNumber ASC LIMIT 20"; 
    $result = mysqli_query($dbc, $query) 
        or die('Error querying database'); 
?>    
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Lesson 2</title>
    </head>
    <body>
        <h1>Customers</h1>
        <table border="1">
            <tr>
                <td>Customer ID</td>
                <td>Customer Name</td>
                <td>City</td>
                <td>Country</td>
            </tr>
            <?php
                $row_count = 1;
                while ($row = mysqli_fetch_array($result)) {
                    $customer_number = $row['customerNumber'];
                    $customer_name = $row['customerName'];
                    $city = $row['city'];
                    $country = $row['country'];
                    $row_count ++;
                    if ($row_count % 2 == 0) {
                        echo "<tr>
                            <td bgcolor = 'aqua'>$customer_number</td>
                            <td bgcolor = 'aqua'>$customer_name</td>
                            <td bgcolor = 'aqua'>$city</td>
                            <td bgcolor = 'aqua'>$country</td>
                        </tr>";  
                    } else {
                        echo "<tr>
                            <td>$customer_number</td>
                            <td>$customer_name</td>
                            <td>$city</td>
                            <td>$country</td>
                        </tr>";
                    } // end if/else       
                } // end while loop   
            ?>    
        </table>
    </body>
</html>
<?php
    mysqli_close($dbc);
?>
