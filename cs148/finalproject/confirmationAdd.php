<?php
include 'top.php';
?>
<div id="wrapper">
    <div id="sidebar-wrapper">
        <!-- the div below will go below the logo and contain site navigation -->
            <?php
            include 'nav.php';
            ?>

    </div>
    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                <?php
                /* the purpose of this page is to accept the hashed date joined and primary key  
                 * as passed into this page in the GET format.
                 * 
                 * I retrieve the date joined from the table for this person and verify that 
                 * they are the same. After which i update the confirmed field and acknowlege 
                 * to the user they were successful. Then i send an email to the system admin 
                 * to approve their membership 
                 * 
                 * Written By: Robert Erickson robert.erickson@uvm.edu
                 * Last updated on: October 17, 2014
                 * 
                 * 
                 */

                include "top.php";

                print '<article id="main">';

                print '<h1>Registration Confirmation</h1>';

                //%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
                //
                // SECTION: 1 Initialize variables
                //
                // SECTION: 1a.
                // variables for the classroom purposes to help find errors.
                $debug = false;
                if (isset($_GET["debug"])) { // ONLY do this in a classroom environment
                   $debug = true;
                }
                if ($debug)
                    print "<p>DEBUG MODE IS ON</p>";
                //%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%

                $adminEmail = "nhallpot@uvm.edu";
                $message = "<p>I am sorry but this project cannot be confrimed at this time. Please call (802) 656-1234 for help in resolving this matter.</p>";


                //##############################################################
                //
                // SECTION: 2 
                // 
                // process request

                if (isset($_GET["w"])) {
                    $key2 = htmlentities($_GET["w"], ENT_QUOTES, "UTF-8");


                    //##############################################################
                    // get the membership record 
                    require_once('../bin/myDatabase.php');

                    $dbUserName = get_current_user() . '_writer';
                    $whichPass = "w"; //flag for which one to use.
                    $dbName = strtoupper(get_current_user()) . '_Final_Project';
                    $thisDatabase = new myDatabase($dbUserName, $whichPass, $dbName);            


                    $query = "SELECT fldItemName,fldTotalOnHand,fldDepartment FROM tblItem WHERE pmkItemId = ?";
                    $data = array($key2);
                    //print_r($data);
                    //print_r($query);

                    $results = $thisDatabase->select($query, $data);

                    if ($debug) {
                        print "<p><pre>";
                        print_r($results);
                        print "</pre></p>";
                    }
                    //##############################################################
                        if ($debug)
                            print "<h1>Confirmed</h1>";

                        $query = "UPDATE tblItem set fldApproved=1 WHERE pmkItemId = ? ";
                        $results = $thisDatabase -> insert($query, $data);

                        if ($debug) {
                            print "<p>Query: " . $query;
                            print "<p><pre>";
                            print_r($results);
                            print_r($data);
                            print "</pre></p>";
                        }
     
                } // ends isset get q
                if($debug){
                    print "end of php";
                }
                print "<p> You have approved a new record into the database.</p>";
                ?>
                </div>


<?php
if ($debug)
    print "<p>END OF PROCESSING</p>";
    include 'jquery.php';
?>
</article>

</body>
</html>