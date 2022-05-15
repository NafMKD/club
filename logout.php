<?php 
session_start();
include __DIR__ . '/vendor/autoload.php';

\App\Account::logout();

header('Location: index.php');