<?php
include "top.php";
/* ##### Step one
*
* create your database object using the appropriate database username
*/
require_once('../bin/myDatabase.php');

$dbUserName = get_current_user() . '_reader';
$whichPass = "r"; //flag for which one to use.
$dbName = strtoupper(get_current_user()) . '_UVM_Courses';

$thisDatabase = new myDatabase($dbUserName, $whichPass, $dbName);
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
$subject = "";
$number = "";
$building = "";
$startTime="";
$professor="";
$typeOfClass ="";


//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1d form error flags
//
// Initialize Error Flags one for each form element we validate
// in the order they appear in section 1c.
$subjectError=  false;
$numberError = false;
$buildingError = false;
$startTimeError = false;
$professorError = false;
$typeOfClassError = false;

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
    $subject = htmlentities($_SERVER['txtSubject'], ENT_QUOTES, "UTF-8");
    $number = htmlentities($_SERVER['txtNumber'], ENT_QUOTES, "UTF-8");
    $building = htmlentities($_SERVER['lstBuilding'], ENT_QUOTES, "UTF-8");
    $startTime = htmlentities($_SERVER['txtStart'], ENT_QUOTES, "UTF-8");
    $professor = htmlentities($_SERVER['txtProfessor'], ENT_QUOTES, "UTF-8");
    $typeOfClass = htmlentities($_SERVER['lstTypeOfClass'], ENT_QUOTES, "UTF-8");
    
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2b Sanitize (clean) data 
    // remove any potential JavaScript or html code from users input on the
    // form. Note it is best to follow the same order as declared in section 1c.
    $subject = filter_var($_POST["txtSubject"], FILTER_SANITIZE_STRING);
    $number = filter_var($_POST["txtNumber"], FILTER_SANITIZE_STRING);
    $building = filter_var($_POST["lstBuilding"], FILTER_SANITIZE_STRING);
    $startTime = filter_var($_POST["txtStart"], FILTER_SANITIZE_STRING);
    $professor = filter_var($_POST["txtProfessor"], FILTER_SANITIZE_STRING);
    $typeOfClass = filter_var($_POST["lstTypeOfClass"], FILTER_SANITIZE_STRING);

    
    
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

//    if ($email == "") {
//        $errorMsg[] = "Please enter your email address";
//        $emailERROR = true;
//    } elseif (!verifyEmail($email)) {
//        $errorMsg[] = "Your email address appears to be incorrect.";
//        $emailERROR = true;
//    }
      
      if (verifyNumeric($professor)){
          $errorMsg[]= "There are no teachers with numbers in their name. Try again";
          $professorError = true;
      }

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2d Process Form - Passed Validation
    
    // Process for when the form passes validation (the errorMsg array is empty)
    //
    if (!$errorMsg) {
        if ($debug)
            print "<p>Form is valid</p>";

        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // SECTION: 2e Save Data
        // This is where we build the query
      
        //Build query
        $query  = 'select concat(tblCourses.fldDepartment," ",tblCourses.fldCourseNumber) as Course, 
                tblSections.fldCRN as CRN,
                concat(tblTeachers.fldFirstName," ",tblTeachers.fldLastName) as Professor,
                concat(tblSections.fldMaxStudents-tblSections.fldNumStudents) as "Seats Available",
                fldSection as Section,
                fldType as Type,
                fldStart as Start,
                fldStop as Stop,
                fldDays as Days,
                fldBuilding as Building,
                fldRoom as Room ';
        $query .= "FROM tblCourses, tblSections, tblTeachers ";
        $query .= 'WHERE pmkCourseId=fnkCourseId 
                   and fnkTeacherNetid=pmkNetId ';
        $query .= 'and fldDepartment like ? ';
        $query .= 'and fldCourseNumber like ? ';
        $query .= 'and fldBuilding like ? ';
        $query .= 'and fldStart like ? ';
        $query .= 'and fldType like ? ';
        $query .= 'and tblTeachers.fldLastName like ?';
        

        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // SECTION: 2f Create message
        //
        // build a message to display on the screen in section 3a and to mail
          // **************** PRINT RESULTS ******************
        // gets the field names from the associative array




               
      
    } // end form is valid
}
 // ends if form was submitted.

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
        include "nav.php";

        // print $thisDatabase;
         $data = array($subject ."%",$number ."%",$building ."%",$startTime ."%",$typeOfClass ."%",$professor ."%");
         $keys = array_keys($row);
        
////        PUT CODE FROM Q01.PHP
  /* ##### Step three
     * Execute the query

     *      */
    $results = $thisDatabase->select($query,$data);

    
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

        
        
        
        
}      // to the person filling out the form (section 2g).
           
     else {


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
                <legend>Class Search for the Upcoming Semester</legend>
                

                <fieldset class="wrapperTwo">
                    <legend>Enter whatever you want, and any class meeting your criteria will come  up!</legend>

                    <fieldset class="contact">
                    
                        
                        <label for="txtSubject" >Subject
                            <input type="text" id="txtSubject" name="txtSubject"
                                   value="<?php print $subject; ?>"
                                   tabindex="120" maxlength="45" placeholder="Enter a subject like: CS"
                                   <?php if ($subjectError) print 'class="mistake"'; ?>
                                   onfocus="this.select()" 
                                   >
                        </label>
                        <label for="txtNumber" >Number
                            <input type="text" id="txtNumber" name="txtNumber"
                                   value="<?php print $number; ?>"
                                   tabindex="220" maxlength="5" placeholder="Enter a course number like: 148"
                                   <?php if ($numberError) print 'class="mistake"'; ?>
                                   onfocus="this.select()" 
                                   >
                        </label>
                        
                        <label for="lstBuilding">Building
                            <select id="lstBuilding"
                                    name="lstBuilding"
                                    tabindex ="320"
                                    value = <?php print $building;?> >
                                
                            <?php
                            $results = $thisDatabase->select("SELECT fldBuilding FROM tblSections GROUP BY fldBuilding");
                            foreach ($results as $row)
                            {
                             print "<option value=\"$row[0]\">$row[0]</option>\n";
                            }
                            ?>
                            </select>
                        </label>
                        <label for="txtStart" >Start Time
                            <input type="text" id="txtStart" name="txtStart"
                                   value="<?php print $startTime; ?>"
                                   tabindex="420" maxlength="8" placeholder="Enter a start time like 12:50"
                                   <?php if ($startTimeError) print 'class="mistake"'; ?>
                                   onfocus="this.select()" 
                                   >
                        </label>
                        <label for="txtProfessor" >Professor
                            <input type="text" id="txtProfessor" name="txtProfessor"
                                   value="<?php print $professor; ?>"
                                   tabindex="500" maxlength="20" placeholder="Enter a professor's last name like: Erickson"
                                   <?php if ($professorError) print 'class="mistake"'; ?>
                                   onfocus="this.select()" 
                                   >
                        </label>                        
                        <label for="lstTypeOfClass">Type of Class
                            <select id="lstTypeOfClass"
                                    name="lstTypeOfClass"
                                    tabindex ="520"
                                    value = <?php print $typeOfClass;?> >
                                <option selected value></option>\n
                            <?php
                            $results = $thisDatabase->select("SELECT fldType FROM tblSections group by fldType");
                            foreach ($results as $row)
                            {
                             print "<option value=\"$row[0]\">$row[0]</option>\n";
                            }
                            ?>
                            </select>
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

<?php include "footer.php"; ?>

</body>
</html>