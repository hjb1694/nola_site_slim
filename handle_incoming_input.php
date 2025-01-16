<?php 

function handle_incoming_input($data) {
    $data = trim($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>