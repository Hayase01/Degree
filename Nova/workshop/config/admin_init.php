<?php

require_once __DIR__ . '/init.php';

if (!isAdmin()) {
    header('Location: ../log.php');
    exit;
}