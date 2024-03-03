<?php
// Teacher I'm very sorry for the delay, I had some problems. It won't happen again <3
$db_info = array(
    "address" => "localhost",
    "username" => "root",
    "password" => ""
);

$db_conn = new mysqli($db_info['address'], $db_info['username'], $db_info['password']);
if ($db_conn->connect_error) {
    exit("db connection error");
}

$query = "CREATE DATABASE IF NOT EXISTS `test_db`;";
if ($db_conn->query($query) === true) {
    $query = "USE `test_db`;"; $db_conn->query($query);
    $query = "CREATE TABLE IF NOT EXISTS `users` (
        `id` INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `username` TEXT NOT NULL,
        `first_name` TEXT NOT NULL,
        `last_name` TEXT NOT NULL,
        `email` TEXT,
        `is_email_verified` BOOLEAN NOT NULL DEFAULT FALSE,
        `is_admin` BOOLEAN NOT NULL
        ) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4"; // I preffer InnoDB for compatibility
    if ($db_conn->query($query) === true) { // Comment if inserted before
        $query = "INSERT INTO `users` (`username`, `first_name`, `last_name`, `email`, `is_admin`) VALUES
            ('MalinoRev','Arash','Heidari','malinorev@gmail.com',false),
            ('Mohammad77','Mamad','Hosseini','mamad77@gmail.com',false),
            ('AhmadLOO','Ahmad','Zoghi','to_mano_emtehan_kon@gmail.com',true);";
        if ($db_conn->query($query) === true) { exit("done!"); } else { exit("can not insert the data"); }
    } else { exit("can not create the table"); }
} else { exit("can not create the database"); }

$data = file_get_contents("php://input");
$data_json = json_decode($data); // add , true if not working on your php engine version
if ($_GET['type'] == 'register') {
    $username = $data_json->username;
    $first_name = $data_json->first_name;
    $last_name = $data_json->last_name;
    $email = $data_json->email;
    $query = "INSERT INTO `users` (`username`, `first_name`, `last_name`, `email`, `is_admin`) VALUES('$username','$first_name','$last_name','$email',false);";
    if ($db_conn->query($query) === true) { exit("done!"); } else { exit("can not register"); }
}
if ($_GET['type'] == 'unregister') {
    $username = $data_json->username;
    $query = "DELETE FROM `users` WHERE `username` = '$username'";
    if ($db_conn->query($query) === true) { exit("done!"); } else { exit("can not unregister"); }
}

$db_conn->close();
?>