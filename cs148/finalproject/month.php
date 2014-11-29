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
                    <h1>Begin Your Month Count</h1>
             
                    <!-- First form here -->
                    <?php
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
                    $month = "";
                    //%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
                    //
                    // SECTION: 1d form error flags
                    //
                    // Initialize Error Flags one for each form element we validate
                    // in the order they appear in section 1c.
                    $monthError = false;
                    //%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
                    //
                    // SECTION: 1e misc variables
                    //
                    // create array to hold error messages filled (if any) in 2d displayed in 3c.
                    $errorMsg = array();
                    // array used to hold form values that will be written to a CSV file
                    $dataRecord = array();
                    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
                    //
                    // SECTION: 2 Process for when the form is submitted
                    //
                    if (isset($_POST["btnDisplayInventory"])) {
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
                        $month = $_POST["radMonth"];
                        $dataRecord[] = $firstName;
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
                        if ($month == "") {
                            $errorMsg[] = "Please select a month!";
                            $monthError = true;
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
                            // This is where we will print the table matching the correct items
                            
                           
                            //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
                            //
                            // SECTION: 2f Create message
                            
                            //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
                            //
                            // SECTION: 2g Mail to user
                            
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
                        // If its the first time coming to the form or there are errors we are going
                        // to display the form.
                        if (isset($_POST["btnDisplayInventory"]) AND empty($errorMsg)) { // closing of if marked with: end body submit
                            
                        } else {
                            //####################################
                            //
        // SECTION 3b Error Messages
                            //
        // display any error messages before we print out the form
                            if ($errorMsg) {
                               
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
                            
                            // SECTION: Create the new form (similar to edit)
                             // end form is valid
                            }// Ends if form is submitted
                            
                            ?> <!-- End of first form -->
                            <form action="<?php print $phpSelf; ?>"
                              method="post"
                              id="frmSelectMonth">
                            <fieldset class="wrapper">
                                <fieldset class="wrapperTwo">
                                    <legend>Select the Month of Your Count</legend>
                                    <fieldset class="contact">

                                        <label for="btnMonth">Month of Count

                                            <input id='radJanuary' type="radio" name="radMonth" value="January" >January
                                            <input id='radFebruary' type="radio" name="radMonth" value="February" >February
                                            <input id='radMarch' type="radio" name="radMonth" value="March" >March
                                            <input id='radApril' type="radio" name="radMonth" value="April" >April
                                            <input id='radMay' type="radio" name="radMonth" value="May" >May
                                            <input id='radJune' type="radio" name="radMonth" value="June" >June
                                            <input id='radJuly' type="radio" name="radMonth" value="July" >July
                                            <input id='radAugust' type="radio" name="radMonth" value="August" >August
                                            <input id='radSeptember' type="radio" name="radMonth" value="September" >September
                                            <input id='radOctober' type="radio" name="radMonth" value="October" >October
                                            <input id='radNovember' type="radio" name="radMonth" value="November" >November

                                        </label>

                                    </fieldset> <!-- ends contact -->

                                </fieldset> <!-- ends wrapper Two -->

                                <fieldset class="buttons">

                                    <input type="submit" id="btnDisplayInventory" name="btnDisplayInventory" value="Display Inventory" tabindex="900" class="button">

                                </fieldset> <!-- ends buttons -->
                            </fieldset> <!-- Ends Wrapper -->
                        </form>



                </div>
            </div>
        </div>

        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>
        <?php
        include 'jquery.php'; // this is for front end stuff
        ?>
    </div>
    <!-- /#page-content-wrapper -->



</div>  
</body>
</html>