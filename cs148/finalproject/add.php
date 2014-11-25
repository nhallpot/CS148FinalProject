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

                //%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
                //
                // SECTION: 1 Initialize variables
                //
                // SECTION: 1a.
                // variables for the classroom purposes to help find errors.
                $debug = false;
                if (isset($_GET["debug"])) { // ONLY do this in a classroom environment
                    $debug = false;
                }
                if ($debug)
                    print "<p>DEBUG MODE IS ON</p>";


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
                $department = "";
                $itemName = "";
                $totalOnHand="";
                

                //%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
                //
                // SECTION: 1d form error flags
                //
                // Initialize Error Flags one for each form element we validate
                // in the order they appear in section 1c.
                $departmentError = false;
                $itemNameError = false;
                $totalOnHandError = false;

                //%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
                //
                // SECTION: 1e misc variables
                //
                // create array to hold error messages filled (if any) in 2d displayed in 3c.
                $errorMsg = array();

                // used for building email message to be sent and displayed
                $mailed = false;
                $messageA = "";
                $messageB = "";
                $messageC = "";



                //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
                //
                // SECTION: 2 Process for when the form is submitted
                //
                if (isset($_POST["btnSubmit"])) {
                //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
                //
                // SECTION: 2a Security
                //
                    if (!securityCheck(true)) {
                        $msg = "<p>Sorry you cannot access this page. ";
                        $msg.= "Security breach detected and reported</p>";
                        die($msg);
                    }


                //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
                //
                // SECTION: 2b Sanitize (clean) data
                // remove any potential JavaScript or html code from users input on the
                // form. Note it is best to follow the same order as declared in section 1c.
                    $department = filter_var($_POST["txtDepartment"], FILTER_SANITIZE_STRING);
                    $itemName = filter_var($_POST["txtItemName"], FILTER_SANITIZE_STRING);
                    $totalOnHand = filter_var($_POST["txtTotalOnHand"], FILTER_SANITIZE_STRING);

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


                    if ($department == "") {
                        $errorMsg[] = "Please a department";
                        $departmentError = true;
                    }
                    if ($itemName == ""){
                        $errorMsg[] = "Please enter an item name";
                        $itemNameError = true;
                    } 
                    if ($totalOnHand == ""){
                        $errorMsg[] = "Please enter the total on hand for the item";
                        $totalOnHandError = true;
                    } 

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
                            require_once('../bin/myDatabase.php');

                            $dbUserName = get_current_user() . '_writer';
                            $whichPass = "w"; //flag for which one to use.
                            $dbName = strtoupper(get_current_user()) . '_Final_Project';
                            $thisDatabase = new myDatabase($dbUserName, $whichPass, $dbName);            
                            $thisDatabase->db->beginTransaction();
                            $query = 'INSERT INTO tblItem (fldDepartment,fldItemName,fldTotalOnHand) values (?,?,?)';

                            $data = array($department,$itemName,$totalOnHand);
                            if ($debug) {
                                print "<p>sql " . $query;
                                print"<p><pre>";
                                print_r($data);
                                print"</pre></p>";
                            }
                            $results = $thisDatabase->insert($query, $data);

                            $primaryKey = $thisDatabase->lastInsert();
                            if ($debug)
                                print "<p>pmk= " . $primaryKey;

                // all sql statements are done so lets commit to our changes
                            $dataEntered = $thisDatabase->db->commit();
                            $dataEntered = true;
                            if ($debug)
                                print "<p>transaction complete ";
                        } catch (PDOExecption $e) {
                            $thisDatabase->db->rollback();
                            if ($debug)
                                print "Error!: " . $e->getMessage() . "</br>";
                            $errorMsg[] = "There was a problem with accpeting your data please contact us directly.";
                        }
                        // If the transaction was successful, give success message
                        if ($dataEntered) {
                            if ($debug)
                                print "<p>data entered now prepare keys ";
                            //#################################################################
                            // create a key value for confirmation

                            $query = "SELECT fldDateJoined FROM tblRegister WHERE pmkRegisterId=" . $primaryKey;
                            $results = $thisDatabase->select($query);


                            $key2 = $primaryKey;

                         
                            if ($debug)
                                print "<p>key 2: " . $key2;


                            //#################################################################
                            //
                            //Put forms information into a variable to print on the screen
                            //

                            $messageA = '<h2>Someone has tried to add an item to the inventory:.</h2>';

                            $messageB = "<p>Click this link to confirm an additon: ";
                            $messageB .= '<a href="' . $domain . $path_parts["dirname"] . '/confirmation.php?w=' . $key2 . '">Confirm Addition</a></p>';
                            $messageB .= "<p>or copy and paste this url into a web browser: ";
                            $messageB .= $domain . $path_parts["dirname"] . '/confirmation.php?w=' . $key2 . "</p>";

                            $messageC .= "<p><b>Email Address:</b><i>   " . $email . "</i></p>";

                            //##############################################################
                            //
                            // email the form's information
               
                            //
                            // This email is the admin email
                            $email="nhallpot@uvm.edu";
                            
                            $to = $email; // the person who filled out the form
                            $cc = "";
                            $bcc = "";
                            $from = "Inventory Management System";
                            $subject = "This is auto-generated, do NOT reply!";

                            $mailed = sendMail($to, $cc, $bcc, $from, $subject, $messageA . $messageB . $messageC);
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
                // to display the form.
                    if (isset($_POST["btnSubmit"]) AND empty($errorMsg)) { // closing of if marked with: end body submit
                        print "<h1>Your Request has ";
                        if (!$mailed) {
                            print "not ";
                        }
                        print "been processed</h1>";
                        print "<p>A copy of the request has ";
                        if (!$mailed) {
                            print "not ";
                        }
                        print "been sent</p>";
                        print "<p>to your System Administrator</p>";
                    } else {
                //####################################
                //
                // SECTION 3b Error Messages
                //
                // display any error messages before we print out the form
                        if ($errorMsg) {
                            print '<div id="errors">';
                            print "<ol>\n";
                            foreach ($errorMsg as $err) {
                                print "<li>" . $err . "</li>\n";
                            }
                            print "</ol>\n";
                            print '</div>';
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
                                <legend>Register Today</legend>
                                <fieldset class="wrapperTwo">
                                    <legend>Are you ready for CRUD?</legend>
                                    <fieldset class="contact">
                                        <legend>Contact Information</legend>

                                        <label for="txtDepartment">Department
                                        <input type="text" id="txtDepartment" name="txtDepartment"
                                               value="<?php print $department; ?>"
                                               tabindex="118" maxlength="25" placeholder="Enter the department"
                                               <?php if ($departmentError) print 'class="mistake"'; ?>
                                               onfocus="this.select()"
                                               >
                                        </label>
                                        <label for="txtItemName" >Item Name
                                            <input type="text" id="txtItemName" name="txtItemName"
                                                   value="<?php print $itemName; ?>"
                                                   tabindex="120" maxlength="25" placeholder="Enter the Item's name"
                                                   <?php if ($itemNameError) print 'class="mistake"'; ?>
                                                   onfocus="this.select()"
                                                   >
                                        </label>
                                        <label for="txtTotalOnHand" >Total On Hand
                                            <input type="text" id="txtTotalOnHand" name="txtTotalOnHand"
                                                   value="<?php print $totalOnHand; ?>"
                                                   tabindex="122" maxlength="4" placeholder=""
                                                   <?php if ($totalOnHandError) print 'class="mistake"'; ?>
                                                   onfocus="this.select()"
                                                   >
                                        </label>
                                    </fieldset> <!-- ends contact -->
                                </fieldset> <!-- ends wrapper Two -->
                                <fieldset class="buttons">
                                    <legend></legend>
                                    <input type="submit" id="btnSubmit" name="btnSubmit" value="Register" tabindex="900" class="button">
                                </fieldset> <!-- ends buttons -->
                            </fieldset> <!-- Ends Wrapper -->
                        </form>
                        <?php
                    } // end body submit
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