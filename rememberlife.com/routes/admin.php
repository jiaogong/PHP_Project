<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$dir = 'admin/';

// inlet
include_once $dir.'inlet.php';

// rotationSixMin
include_once $dir.'homeShow.php';


// adminUser
include_once $dir.'adminUser.php';


// blogContent
include_once $dir.'blogContent.php';

// blogType
include_once $dir.'blogType.php';