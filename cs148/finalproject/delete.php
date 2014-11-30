<?php
include 'top.php';
include 'connectToDatabase.php';
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
                    /* the purpose of this page is to display a form to allow a person to register
                     * the form will be sticky meaning if there is a mistake the data previously 
                     * entered will be displayed again. Once a form is submitted (to this same page)
                     * we first sanitize our data by replacing html codes with the html character.
                     * then we check to see if the data is valid. if data is valid enter the data 
                     * into the table and we send and dispplay a confirmation email message. 
                     * 
                     * if the data is incorrect we flag the errors.
                     * 
                     * Written By: Robert Erickson robert.erickson@uvm.edu
                     * Last updated on: October 17, 2014
                     * 
                     * 
                      -- --------------------------------------------------------
                      --
                      -- Table structure for table `tblRegister`
                      --

                      CREATE TABLE IF NOT EXISTS `tblRegister` (
                      `pmkRegisterId` int(11) NOT NULL AUTO_INCREMENT,
                      `fldEmail` varchar(65) DEFAULT NULL,
                      `fldDateJoined` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                      `fldConfirmed` tinyint(1) NOT NULL DEFAULT '0',
                      `fldApproved` tinyint(4) NOT NULL DEFAULT '0',
                      PRIMARY KEY (`pmkRegisterId`)
                      ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

                     * I am using a surrogate key for demonstration, 
                     * email would make a good primary key as well which would prevent someone
                     * from entering an email address in more than one record.
                     */
                    print "<h1> Are you sure you want to delete this entry from the database? </h1>";
                    //%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
                    
                // SECTION: 1 Initialize variables
                    $update = false;
                    // SECTION: 1a.
                    // variables for the classroom purposes to help find errors.
                    $debug = true;
                    if (isset($_GET["debug"])) { // ONLY do this in a classroom environment
                        $debug = false;
                    }
                    if ($debug)
                        print "<p>DEBUG MODE IS ON</p>";
                        
                    $data = array();
                    $data2 = array();

                    //%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
                    //
                // SECTION: 1b Security
                    //
                // define security variable to be used in SECTION 2a.
                    $yourURL = $domain . $phpSelf;

                    //%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
                    //
                // SECTION: 1c form variables
                    //
                // Initialize variables one for each form element
                    // in the order they appear on the form
                    if (isset($_GET["id"])) {
                        $pmkItemId = htmlentities($_GET["id"], ENT_QUOTES, "UTF-8");
                        $query = 'SELECT fldDepartment, fldItemName, fldTotalOnHand, fldSector, fldColumn, fldRow ';
                        $query .= 'FROM tblItem,tblLocation WHERE pmkItemId = fnkItemId';

                        $results = $thisDatabase->select($query, array($pmkItemId));

                        $department = $results[0]["fldDepartment"];
                        $itemName = $results[0]["fldItemName"];
                        $totalOnHand = $results[0]["fldTotalOnHand"];
                        $sector = $results[0]["fldSector"];
                        $column = $results[0]["fldColumn"];
                        $rowLocation = $results[0]["fldRow"];

                    } 

                $data = array($pmkItemId);
                $keys = array_keys($row);                
                if ($debug)
                {
                    print_r($data);
                    print "Query" . $query;
                }
		print "<div id=itemTable>";
                $numberRecords = count($results);

                $results2 = $thisDatabase->select($query,$data);


                print "<table>";

                $firstTime = true;

    /* since it is associative array display the field names */
                    foreach ($results2 as $row) {
                        if ($firstTime) {
                            print "<thead><tr>";
                            $keys = array_keys($row);
                            foreach ($keys as $key) {
                                if (!is_int($key)) {
                                    print "<th>" . $key . "</th>";
                                }
                            }
                            print "</tr>";
                            $firstTime = false;
                        }

                        /* display the data, the array is both associative and index so we are
                         *  skipping the index otherwise records are doubled up */
                        print "<tr>";
                        foreach ($row as $field => $value) {
                            if (!is_int($field)) {
                                print "<td>" . $value . "</td>";
                            }
                        }
                        print "</tr>";
                    }
                    print "</table>";
                    print "</div>";


                    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
                    //
                // SECTION: 2 Process for when the form is submitted
                    //
                if (isset($_POST["btnSubmit"])) {
                        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
                        //
                // SECTION: 2a Security
                        //
//                    if (!securityCheck(true)) {
//                            $msg = "<p>Sorry you cannot access this page. ";
//                            $msg.= "Security breach detected and reported</p>";
//                            die($msg);
//                        }
//
                        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
                        //
                        //
                // SECTION: 2b Sanitize (clean) data
                        // remove any potential JavaScript or html code from users input on the
                        // form. Note it is best to follow the same order as declared in section 1c.
                        $pmkItemId = htmlentities($_POST["hidItemId"], ENT_QUOTES, "UTF-8");
                   

                        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
                        //
                // SECTION: 2c Validation
                        //
                // Validation section. Check each value for possible errors, empty or
                        // not what we expect. You will need an IF block for each element you will
                        // check (see above section 1c and 1d). The if blocks should also be in the
                        // order that the elements appear on your form so that the error messages
                        // will be in the order they appear. errorMsg will be displayed on the form
                        // see section 3b. The error flag ($emailERROR) will be used in section 3c.


                        

                        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
                        //
                // SECTION: 2d Process Form - Passed Validation
                        //
                // Process for when the form passes validation (the errorMsg array is empty)
                        //
                    if (!$errorMsg) {
                            if ($debug)
                                print "<p>Form is valid</p>";

                            //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
                            //
// SECTION: 2e Save Data
//

                            $dataEntered = false;
                            try {
                                $thisDatabase->db->beginTransaction();
                                $data = array($pmkItemId);
                                $data2 = array($pmkItemId);
                                $query = 'DELETE FROM tblItem where pmkItemId = ?';
                                $query2 = 'DELETE FROM tblLocation where fnkItemId = ?';
                                if($debug)
                                {
                                    print_r($data);
                                    print "Query 1:".$query;
                                    print "Query 2:".$query2;
                                }

                                $results = $thisDatabase->delete($query, $data);
                                $results2 = $thisDatabase->delete($query2, $data2);

                        
                                $dataEntered = $thisDatabase->db->commit();
                                
                                if($dataEntered)
                                    print "data has been committed";
                                if ($debug)
                                    print "<p>transaction complete ";
                                
                                
                            } catch (PDOExecption $e) {
                                
                                $thisDatabase->db->rollback();
                                
                                if ($debug)
                                    print "Error!: " . $e->getMessage() . "</br>";
                                
                                $errorMsg[] = "There was a problem with accpeting your data please contact your System Admin directly.";
                            }
                            // If the transaction was successful, give success message
                            if ($dataEntered) {
                                if ($debug)
                                    print "<p>data entered now prepare keys ";
                                //#################################################################
                                // create a key value for confirmation

                                $query = "SELECT fldDepartment,fldItemName,fldTotalOnHand FROM tblItem WHERE pmkItemId=" . $primaryKey;
                                
                                $results = $thisDatabase->select($query);
                                $key2 = $primaryKey;
                                if($update)
                                    $key2 = $pmkItemId;


                                if ($debug)
                                    print "<p>key 2: " . $key2;


                              
                            } //data entered  
                        } // end form is valid
                    } // ends if form was submitted.
                    //#############################################################################
                    //
                // SECTION 3 Display Form
                    //
                ?>
                    <article id="main">
                        <?php
                        //####################################
                        //
                // SECTION 3a.
                        //
                //
                //
                //
                // If its the first time coming to the form or there are errors we are going
                        // to display the form

                        if (isset($_POST["btnSubmit"]) AND empty($errorMsg)) { // closing of if marked with: end body submit
                            
                            print "<h1>Your Item has been deleted from inventory </h1>";
                        
                            }
                            //####################################
                            //
                // SECTION 3c html Form
                            //
                        /* Display the HTML form. note that the action is to this same page. $phpSelf
                              is defined in top.php
                              NOTE the line:
                              value="<?php print $email; ?>
                              this makes the form sticky by displaying either the initial default value (line 35)
                              or the value they typed in (line 84)
                              NOTE this line:
                              <?php if($emailERROR) print 'class="mistake"'; ?>
                              this prints out a css class so that we can highlight the background etc. to
                              make it stand out that a mistake happened here.
                             */
                            ?>
                            <form action="<?php print $phpSelf; ?>"
                                  method="post"
                                  id="frmRegister">
                                <fieldset class="wrapper">
                                    <legend></legend>
                                    <fieldset class="wrapperTwo">
                                        <input type="hidden" id="hidItemId" name="hidItemId"
                                               value="<?php print $pmkItemId; ?>"
                                               >               
                                        </fieldset> <!-- ends contact -->
                                    </fieldset> <!-- ends wrapper Two -->
                                    <fieldset class="buttons">
                                        <legend></legend>
                                        <input type="submit" id="btnSubmit" name="btnSubmit" value="Delete Item" tabindex="900" class="button">
                                    </fieldset> <!-- ends buttons -->
                                </fieldset> <!-- Ends Wrapper -->
                            </form>
                            <?php
                        
                        ?>
                    </article>



                    <?php
                    if ($debug)
                        print "<p>END OF PROCESSING</p>";
                    ?>

                    <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>
                </div>
            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->



</div>    

<?php
include 'jquery.php';
?>


</body>
</html>