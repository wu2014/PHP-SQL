<?php
    // The function is to fill a two dimension array for drawing chart
    function fill_graph_array ($creditLimit_array) {
        $bar1 = $bar2 = $bar3 = $bar4 = $bar5 = 0;
        for ($i = 0; $i < count($creditLimit_array); $i++) {
            if ($creditLimit_array[$i] == 0) { 
                $bar1++;
            } else if ($creditLimit_array[$i] < 50001) {
                $bar2++;
            } else if ($creditLimit_array[$i] < 75001) {
                $bar3++;
            } else if ($creditLimit_array[$i] < 100001) {
                $bar4++;
            } else {
                $bar5++;
            }
        } // end for loop 

        $filled_chart_array = array (
            array ("0", $bar1),
            array ("1 to 50000", $bar2),
            array ("50001 to 75000", $bar3),
            array ("75001 to 100000", $bar4),
            array ("greater than 100000", $bar5)
        );
        return $filled_chart_array;
    } //  function fill_graph_array  

    // To make graph scale
    function make_graph_scale ($total_numbers) {
        $scale_max = round (($total_numbers / 5) + 20);
        return $scale_max;
    } // function make_graph_scale
    
    // custom function to draw a bar graph given a data set, maximum value, and image filename
    function draw_bar_graph($width, $height, $data, $max_value, $filename) {
        // Create the empty graph image
        $img = imagecreatetruecolor($width, $height);

        // Set a white background with black text and gray graphics
        $bg_color = imagecolorallocate($img, 255, 255, 255);       // white
        $text_color = imagecolorallocate($img, 255, 255, 255);     // white
        $bar_color = imagecolorallocate($img, 0, 0, 0);            // black
        $border_color = imagecolorallocate($img, 192, 192, 192);   // light gray

        // Fill the background
        imagefilledrectangle($img, 0, 0, $width, $height, $bg_color);
        // Draw the bars
        $bar_width = $width / ((count($data) * 2) + 1);
        for ($i = 0; $i < count($data); $i++) {
           imagefilledrectangle($img, ($i * $bar_width * 2) + $bar_width, $height,
              ($i * $bar_width * 2) + ($bar_width * 2), $height - (($height / $max_value) * $data[$i][1]), $bar_color);
           imagestringup($img, 5, ($i * $bar_width * 2) + ($bar_width), $height - 5, $data[$i][0], $text_color);
        }

        // Draw a rectangle around the whole thing
        imagerectangle($img, 0, 0, $width - 1, $height - 1, $border_color);

        // Draw the range up the left side of the graph
        for ($i = 0; $i <= $max_value; $i+= 5) {
            imagestring($img, 5, 0, $height - ($i * ($height / $max_value)), $i, $bar_color);
        }

        // Write the graph image to a file
        imagepng($img, $filename, 5);
        imagedestroy($img);
    } // End of draw_bar_graph() function

    // This function builds navigational page links based on the current page and the number of pages
    function generate_page_links($user_selected, $cur_page, $num_pages) {
        $page_links = '';

        // If this page is not the first page, generate the "previous" link
        if ($cur_page > 1) {
            $page_links .= '<a href="' . '?userselected=' . $user_selected . '&page=' . ($cur_page - 1) . '"><-</a> ';
        }
        else {
            $page_links .= '<- ';
        }

        // Loop through the pages generating the page number links
        for ($i = 1; $i <= $num_pages; $i++) {
            if ($cur_page == $i) {
                $page_links .= ' ' . $i;
            } else {   
                $page_links .= ' <a href="' . '?userselected=' . $user_selected . '&page=' . $i . '"> ' . $i . '</a>';
            }
        }

        // If this page is not the last page, generate the "next" link
        if ($cur_page < $num_pages) {
            $page_links .= ' <a href="' . '?userselected=' . $user_selected . '&page=' . ($cur_page + 1) . '">-></a>';
        } else {
            $page_links .= ' ->';
        }
        return $page_links;
    }
?>    
