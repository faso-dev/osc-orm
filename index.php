<?php

use FSDV\DB\DB;

require_once __DIR__.'/vendor/autoload.php';

$query = DB::select()->from('user')->getQuery()->getSQLQuery();

var_dump($query);
