 <?php

    $db_name = 'GrupoCelfix';
    $db_host = '';
    $db_port = '';
    $db_user = '';
    $db_pass = '';

    $conn = new PDO("mysql:dbname=$db_name;host=$db_host;port=$db_port", $db_user, $db_pass);
    
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
