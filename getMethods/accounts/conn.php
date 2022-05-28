<?php

$connect = new mysqli('localhost', 'root', '', 'rightbank_db_v4');

if ($connect) {

} else {
    echo "Connection Failed";
    exit();
}
