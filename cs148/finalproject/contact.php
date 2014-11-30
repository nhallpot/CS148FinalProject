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
                    <h1>Contact Noah Hall-Potvin </h1>
                    <!-- put text here -->
                    <?php
// Initialize variables
//  Here we set the default values that we want our form to display

                    $debug = false;

                    if (isset($_GET["debug"])) { // this just helps me out if you have it
                        $debug = true;
                    }

                    if ($debug)
                        print "<p>DEBUG MODE IS ON</p>";


// this would be the full url of your form
// See top.php for variable declartions
                    $yourURL = $domain . $phpSelf;

                    $firstName = "";
                    $lastName = "";
                    $email = "";
                    $gender = "Male";
                    $wouldYouUse = "Yes";
                    $adminEmail = "nhallpot@uvm.edu";

                    //checkbox initializers

                    $integrating = false;
                    $code = false;
                    $advice = false;
                    $noReason = false;

                    $firstNameERROR = false;
                    $lastNameERROR = false;
                    $emailERROR = false;




                    if (isset($_POST["btnSubmit"])) {

                        if (!securityCheck()) {
                            $msg = "<p>Sorry you cannot access this page. ";
                            $msg.= "Security breach detected and reported</p>";
                            die($msg);
                        }

                        //check for errors
                        include ("lib/validationFunctions.php");
                        $errorMsg = array();

                        $dataRecord = array();

                        $firstName = htmlentities($_POST["txtFirstName"], ENT_QUOTES, "UTF-8");
                        $lastName = htmlentities($_POST["txtLastName"], ENT_QUOTES, "UTF-8");
                        $email = htmlentities($_POST["txtEmail"], ENT_QUOTES, "UTF-8");

                        if (isset($_POST["chkIntegrating"])) {
                            $integrating = true;
                        } else {
                            $integrating = false;
                        }
                        if (isset($_POST["chkCode"])) {
                            $code = true;
                        } else {
                            $code = false;
                        }
                        if (isset($_POST["chkAdvice"])) {
                            $advice = true;
                        } else {
                            $advice = false;
                        }
                        if (isset($_POST["chkNone"])) {
                            $noReason = true;
                        } else {
                            $noReason = false;
                        }

                        $wouldYouUse = htmlentities($_POST["radWouldYouUse"], ENT_QUOTES, "UTF-8");

                        $dataRecord[] = $email;
                        $dataRecord[] = $firstName;
                        $dataRecord[] = $lastName;
                        $dataRecord[] = $wouldYouUse;

                        // sent through html entities to be safe
                        if (isset($_POST["chkIntegrating"])) {
                            $dataRecord[] = htmlentities($_POST["chkIntegrating"], ENT_QUOTES, "UTF-8");
                        } else {
                            $dataRecord[] = null;
                        }
                        if (isset($_POST["chkCode"])) {
                            $dataRecord[] = htmlentities($_POST["chkCode"], ENT_QUOTES, "UTF-8");
                        } else {
                            $dataRecord[] = null;
                        }
                        if (isset($_POST["chkAdvice"])) {
                            $dataRecord[] = htmlentities($_POST["chkAdvice"], ENT_QUOTES, "UTF-8");
                        } else {
                            $dataRecord[] = null;
                        }
                        if (isset($_POST["chkNone"])) {
                            $dataRecord[] = htmlentities($_POST["chkNone"], ENT_QUOTES, "UTF-8");
                        } else {
                            $dataRecord[] = null;
                        }

                        // Test first name for empty and valid characters
                        // Test last name for empty and valid characters    
                        // test email for empty and valid format
                        // NOTE: i removed required attribute and set this input type=text instead 
                        // of type=email so i can check my php code.
                        if ($email == "") {
                            $errorMsg[] = "Please enter your email address";
                            $emailERROR = true;
                        } elseif (!verifyEmail($email)) {
                            $errorMsg[] = "Your email address appears to be incorrect.";
                            $emailERROR = true;
                        }
                        // Test anything else
                        if ($firstName == "") {
                            $errorMsg[] = "Please enter your first name";
                            $firstNameERROR = true;
                        }
                        if ($lastName == "") {
                            $errorMsg[] = "Please enter your last name";
                            $firstNameERROR = true;
                        }

                        if (!$errorMsg) {
                            if ($debug)
                                print "<p>Form is valid</p>";


                            //  In this block I am just putting all the forms information
                            //  into a variable so I can print it out on the screen
                            //
        //  the substr function removes the 3 letter prefix
                            //  preg_split('/(?=[A-Z])/',$str) add a space for the camel case
                            //  see: http://stackoverflow.com/questions/4519739/split-camelcase-word-into-words-with-php-preg-match-regular-expression

                            $message = '<h2>Your information.</h2>';

                            foreach ($_POST as $key => $value) {
                                if ($key != "btnSubmit") {
                                    $message .= "<p>";

                                    $camelCase = preg_split('/(?=[A-Z])/', substr($key, 3));

                                    foreach ($camelCase as $one) {
                                        $message .= $one . " ";
                                    }
                                    $message .= " = " . htmlentities($value, ENT_QUOTES, "UTF-8") . "</p>";
                                }
                            }

                            // Save to the database
                            print_r($dataRecord);
                            $dataEntered = false;
                            try {
                                $thisDatabase->db->beginTransaction();

                                $query = 'INSERT INTO tblContact (pmkEmail,fldFirstName,fldLastName,fldWouldYouUse,fldInterested1,fldInterested2,fldInterested3,fldInterested4) values (?,?,?,?,?,?,?,?) ';

                                if ($debug) {
                                    print "<p>sql " . $query;
                                    print"<p><pre>";
                                    print_r($dataRecord);
                                    print"</pre></p>";
                                }
                                $results = $thisDatabase->insert($query, $dataRecord);
                                // all sql statements are done so lets commit to our changes
                                $dataEntered = $thisDatabase->db->commit();

                                if ($debug)
                                    print "<p>transaction complete ";
                            } catch (PDOExecption $e) {
                                $thisDatabase->db->rollback();
                                if ($debug)
                                    print "Error!: " . $e->getMessage() . "</br>";
                                $errorMsg[] = "There was a problem with accpeting your data please contact us directly.";
                            }
                            // mail the forms information to the person who filled it out
                            // if you want a copy you need to add yourself to the bcc
                            // in mailMessage.php

                            include_once('lib/mailMessage.php');
                            //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
                            //
                            // SECTION: 2g Mail to user
                            //
                            // Process for mailing a message which contains the forms data
                            // the message was built in section 2f.
                            $to = $adminEmail; // the person who filled out the form
                            $cc = $email;
                            $bcc = "";
                            $from = "Inventory Management System";
                            $subject = "Do not reply to this email!";
                            $mailed = sendMail($to, $cc, $bcc, $from, $subject, $message);
                        } // ends form is valid
                    } // ends if form was submitted. We will be adding more information ABOVE this
                    ?>
                    <article id ="main">

                        <?php
// Here we display any errors that were on the form

                        print '<div id="errors">';

                        if ($errorMsg) {
                            echo "<ol>\n";
                            foreach ($errorMsg as $err) {
                                echo "<li>" . $err . "</li>\n";
                            }
                            echo "</ol>\n";
                        }

                        print '</div>';

//  In this block  display the information that was submitted and do not 
//  display the form.

                        if (isset($_POST["btnSubmit"]) AND empty($errorMsg)) {  // closing of if marked with: end body submit
                            print "<h1>We have ";

                            if (!$mailed) {
                                echo "not ";
                            }

                            echo "recieved your information!</h1>";

                            print "<p>Thank you for coming! </p>";
                        } else {

// display the form, notice the closing } bracket at the end just before the 
// closing body tag
                            ?>
                            <p>Fill out the following form to reach the web-master:</p>

                            <form action="<?php print $phpSelf; ?>" 
                                  method="post"
                                  id="frmRegister">

                                <fieldset class="contact">
                                    <legend>Contact Information</legend>
                                    <label for="txtEmail" >Email
                                        <input type="text" id="txtEmail" name="txtEmail" value="<?php echo $email; ?>"
                                               tabindex="120" maxlength="45"
                                               placeholder="Please enter a valid email"
                                               onfocus="this.select()"  ></label>

                                    <label for="txtFirstName">First Name
                                        <input type="text" id="txtFirstName" name="txtFirstName" 
                                               value="<?php echo $firstName; ?>"
                                               tabindex="122" maxlength="30"
                                               placeholder="First Name"
                                               onfocus="this.select()" ></label>

                                    <label for="txtLastName" > Last Name
                                        <input type="text" id="txtLastName" name="txtLastName" 
                                               value="<?php echo $lastName; ?>"
                                               tabindex="124" maxlength="45"
                                               placeholder="Last Name"
                                               onfocus="this.select()" ></label>        
                                </fieldset>

                                <fieldset>
                                    <legend>Would you use this Inventory Management System?</legend>
                                    <label><input type="radio" id="radFreshamn" name="radWouldYouUse" 
                                        <?php if ($wouldYouUse == "Yes") echo 'checked="checked"'; ?>
                                                  value="Yes"
                                                  tabindex="204">Yes</label>

                                    <label><input type="radio" id="radSophomore" name="radWouldYouUse" 
                                        <?php if ($wouldYouUse == "Maybe") echo 'checked="checked"'; ?>
                                                  value="Maybe"
                                                  tabindex="206">Maybe</label>  

                                    <label><input type="radio" id="radJunior" name="radWouldYouUse" 
                                        <?php if ($wouldYouUse == "No") echo 'checked="checked"'; ?>
                                                  value="No"
                                                  tabindex="208">No</label>    

                                </fieldset>

                                <fieldset class="checkbox">
                                    <legend>Why are you interested? :</legend>
                                    <label><input type="checkbox" id="chkIntegrating" name="chkIntegrating" value="Integrating"
                                        <?php if ($integrating) echo 'checked="checked"'; ?>
                                                  tabindex="260"> Integrating into our company. </label>

                                    <label><input type="checkbox" id="chkCode" name="chkCode" value="Code"
                                        <?php if ($code) echo 'checked="checked"'; ?>
                                                  tabindex="262" > Want to know how the code works. </label>

                                    <label><input type="checkbox" id="chkAdvice" name="chkAdvice" value="Advice"
                                        <?php if ($advice) echo 'checked="checked"'; ?>
                                                  tabindex="264" > Looking for advice in designing inventory system.</label> 

                                    <label><input type="checkbox" id="chkNone" name="chkNone" value="None"
                                        <?php if ($noReason) echo 'checked="checked"'; ?>
                                                  tabindex="266" > No particular reason.</label>  
                                </fieldset>

                                <fieldset>					
                                    <input type="submit" id="btnSubmit" name="btnSubmit" value="Submit" 
                                           tabindex="991" class="button">

                                    <input type="reset" id="btnReset" name="btnReset" value="Reset Form" 
                                           tabindex="993" class="button">
                                </fieldset>

                            </form>

                            <?php
                        }
                        if ($debug)
                            print"<p>END OF PROCESSING</p>";
                        print"</article>";
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