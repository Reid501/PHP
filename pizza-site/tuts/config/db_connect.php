<?php

    // Connect to database
    $conn = mysqli_connect('localhost', 'alex', 'luna51', 'als_pizza');

    // Check Connection
    if(!$conn) {
        echo "Connection Error: " . mysqli_connect_error(); 
    }

?>