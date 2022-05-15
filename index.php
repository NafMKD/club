<?php 

//header('location: public/');

include __DIR__ . '/vendor/autoload.php';

use App\Model\User;

$d = User::findAll();

var_dump($d);