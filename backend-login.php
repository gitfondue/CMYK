<?php

function db_connect() {

    $result = new mysqli('localhost', 'coloring', 'book', 'coloring');


    if (!$result) {

        echo 'Could not connect to database server';
            exit;
    }

    else {

        return $result;
    }
}

?>
