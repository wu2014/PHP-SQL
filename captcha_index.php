<?php
    $user_string = $_GET['ustring'];
    $image_width = 200;
    $image_height = 50;

    // create the image
    $img = imagecreatetruecolor($image_width, $image_height);

    // setup colors for use
    $bg_color = imagecolorallocate($img, 201, 151, 0); // gold
    $font_color = imagecolorallocate($img, 128, 128, 128); // gray
    $line_color = imagecolorallocate($img, 255, 255, 255); // white
    $pixel_color = imagecolorallocate($img, 255, 0, 0); // red
    // Fill the background
    imagefilledrectangle($img, 0, 0, $image_width, $image_height, $bg_color);

    // Add random lines
    for ($i = 0; $i < rand(5, 10); $i++) {
    	imageline($img, 0, rand() % $image_height, $image_width, rand() % $image_height, $line_color);
    }
    
    // Add random dots
    for ($i = 0; $i < rand(50, 100); $i++) {
    	imagesetpixel($img, rand() % $image_width, rand() % $image_height, $pixel_color);
    }

    // Draw user number
    $first_angle = rand(0, 20);
    for ($i = 0; $i < 5; $i++) {
        $final_user_string = str_split($user_string)[$i];
        imagettftext($img, 40, $first_angle + 10 * $i, 10 + 40 * $i, $image_height - 5, $font_color, './Courier New Bold.ttf', $final_user_string);
    }
    
    // Output image
    header("Content-type: image/png");
    imagepng($img);

    // System clean up
    imagedestroy($img);
?>    
