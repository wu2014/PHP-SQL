<?php
    header('Content-Type: text/xml');
    echo '<?xml version="1.0" encoding="utf-8" ?>';
    $builddate = gmdate(DATE_RSS, time());
    // database connection includes
    require_once('./includes/connectvars.inc.php');
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
?>

<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom"> 
    <channel>
        <title> RSS feed of vehicle types</title>
        <link>http://yinyuan.esy.es/Yinyuan_Final_Project/index.php</link>
        <atom:link href="<?=$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'] ?>" ref="self" type="application/rss+xml" />
        <description>RSS feed for learning PHP</description>
        <language>en-us</language>

<?php
    $query = "SELECT * FROM productlines";
    $result = mysqli_query($dbc, $query);

    while ($newArray = mysqli_fetch_array($result)) { // loop through and print out records
        $product_line_code = $newArray['productLineCode'];
    	$product_line = $newArray['productLine'];
    	$text_description = $newArray['textDescription'];
        $html_description = $newArray['htmlDescription'];
    	$image = $newArray['image'];
        $date_added = $newArray['dateAdded'];
        $pubdate = date(DATE_RSS, strtotime($date_added));
?>  
    <item>
        <title><?php echo "$product_line"; ?></title>
        <description><?php echo "$text_description"; ?></description>
        <link>http://yinyuan.esy.es/Yinyuan_Final_Project/product.php?pid=<?=$product_line_code ?></link>
        <guid isPermaLink="false">http://yinyuan.esy.es/Yinyuan_Final_Project/product.php?pid=<?=$product_line_code ?></guid>
        <pubDate><?=$pubdate ?></pubDate>
    </item>
      
<?php
    }      
?>
    </channel>
</rss>        