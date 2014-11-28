<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Assignment 6.0</title>
        <meta charset="utf-8">
        <meta name="author" content="Noah Hall-Potvin">
        <meta name="description" content="A php app that performs inventory counts">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!--[if lt IE 9]>
        <script src="//html5shim.googlecode.com/sin/trunk/html5.js"></script>
        <![endif]-->

        <link rel="stylesheet" href="bootstrap.css" type="text/css" media="screen">
        <link rel="stylesheet" href="bootstrap.min.css" type="text/css" media="screen">
        <link rel="stylesheet" href="custom.css" type="text/css" media="screen">
        <link rel="stylesheet" href="simple-sidebar.css" type="text/css" media="screen">
       
<!--        <style type="text/css">

            table{
                border: medium #000080 solid;
                border-collapse: collapse;
                width: 90%;
                margin: auto;
                max-width: 600px;
            }

            td, th {
                border: thin #000080 solid;
                border-collapse: collapse;
            }

            tr:nth-child(even) {
                background-color: lightcyan;
            }

            tr:nth-child(odd){
                background-color: whitesmoke;
            }
        </style>-->
        <?php
        $debug = false;

// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// PATH SETUP
//
//  $domain = "https://www.uvm.edu" or http://www.uvm.edu;

        $domain = "http://";
        if (isset($_SERVER['HTTPS'])) {
            if ($_SERVER['HTTPS']) {
                $domain = "https://";
            }
        }

        $server = htmlentities($_SERVER['SERVER_NAME'], ENT_QUOTES, "UTF-8");

        $domain .= $server;

        $phpSelf = htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES, "UTF-8");

        $path_parts = pathinfo($phpSelf);

        if ($debug) {
            print "<p>Domain" . $domain;
            print "<p>php Self" . $phpSelf;
            print "<p>Path Parts<pre>";
            print_r($path_parts);
            print "</pre>";
        }

// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// inlcude all libraries
//

        require_once('lib/security.php');

        if ($path_parts['filename'] == "month"||$path_parts['filename'] == "year"||$path_parts['filename'] == "admin"||$path_parts['filename'] == "contact"||$path_parts['filename'] == "add") {
            include "lib/validation-functions.php";
            include "lib/mail-message.php";
        }
        ?>	

    </head>
    <!-- ################ body section ######################### -->

    <?php
    print '<body>';
    //id="' . $path_parts['filename'] . '"
    ?>
