<?php 
    function clean_input($data) {
        $data = trim($data);
        // function removes backslashes
        $data = stripslashes($data);
        // Convert special characters to HTML entities.
        $data = htmlspecialchars($data);
        return $data;
    }
?>  
