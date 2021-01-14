<?php
if (empty($_SESSION['crsftoken'])) {
    $_SESSION['crsftoken'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['crsftoken'];