<?php
    $questionTypes = array();
    $questionTypes = $vars['questionTypes'];
    header('Content-Type: application/json');
    echo json_encode($questionTypes);
?>
