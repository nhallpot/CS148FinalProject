<?php
/**
                * create your database object using the appropriate database username
                */
                require_once('../bin/myDatabase.php');

                $dbUserName = get_current_user() . '_writer';
                $whichPass = "w"; //flag for which one to use.
                $dbName = strtoupper(get_current_user()) . '_Final_Project';

                $thisDatabase = new myDatabase($dbUserName, $whichPass, $dbName);
?>