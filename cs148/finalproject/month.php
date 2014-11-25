<?php
include 'top.php';
include 'jquery.php'
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
                    <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>

                <?php
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
                /**
                * create your database object using the appropriate database username
                */
                require_once('../bin/myDatabase.php');

                $dbUserName = get_current_user() . '_writer';
                $whichPass = "w"; //flag for which one to use.
                $dbName = strtoupper(get_current_user()) . '_Final_Project';

                $thisDatabase = new myDatabase($dbUserName, $whichPass, $dbName);
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

                // used for building email message to be sent and displayed
                $mailed = false;
                $messageA = "";


                //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
                //
                // SECTION: 2 Process for when the form is submitted
                //
                if (isset($_POST["btnSubmit"])) {
              
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
                                <fieldset class="wrapperTwo">
                                    <legend>This information will be passed on to the Inventory/System Administrator</legend>
                                    <fieldset class="contact">

                                        <label for="lstMonth">Month of Count
                                        <select id="lstMonth"
                                                name="lstMonth"
                                                tabindex ="100">
                                                <option selected value='January'>January</option>
                                                <option selected value='February'>February</option>
                                                <option selected value='March'>March</option>
                                                <option selected value='April'>April</option>
                                                <option selected value='May'>May</option>
                                                <option selected value='June'>June</option>
                                                <option selected value='July'>July</option>
                                                <option selected value='August'>August</option>
                                                <option selected value='September'>September</option>
                                                <option selected value='October'>October</option>
                                                <option selected value='November'>November</option>
                                                <option selected value><?php print $month?></option>
                                        </select>
                                        </label>
                                        
                                        
                                        
                                        
                                        
                                        <label for="txtEmail" class="required">Email
                                            <input type="text" id="txtEmail" name="txtEmail"
                                                   value="<?php print $email; ?>"
                                                   tabindex="800" maxlength="45" placeholder="Enter a valid email address"
                                                   <?php if ($emailERROR) print 'class="mistake"'; ?>
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
                        
                </article>
                    
                <!-- pull info from tblItem -->
                <?php
                // print $thisDatabase;
                        //Build query
                $query = 'select fldItemName as "Item Name",fldTotalOnHand as "Total On Hand",fldDepartment as "Department" ';
                $query .= "FROM tblItem ";
                $query .= 'WHERE fldApproved=1 '; // We just want to show the items that have been confirmed by an admint
                //$query .= 'and fldDepartment like ? ';
                $query .= 'order by pmkItemId';
                //$data = array($subject ."%",$number ."%",$building ."%",$startTime ."%",$typeOfClass ."%",$professor ."%");
                $keys = array_keys($row);

                ////        PUT CODE FROM Q01.PHP
                /* ##### Step three
                * Execute the query

                *      */

                $results = $thisDatabase->select($query);


                /* ##### Step four
                * prepare output and loop through array

                *      */
                $numberRecords = count($results);

                print "<h2>Number of courses that meet your criteria: " . $numberRecords . "</h2>";


                print "<table>";

                $firstTime = true;

                /* since it is associative array display the field names */
                foreach ($results as $row) {
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
                print "</table>";
                ?>
                </div>
            </div>
        </div>
        
    
    </div>
        <!-- /#page-content-wrapper -->
    
    

</div>  
    </body>
</html>