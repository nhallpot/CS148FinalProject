<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <p>Extra example source code</p>
<?php
//Initialize: SECTION 1c.
$comments="";

//Sanitize: SECTION 2c.
$comments = htmlentities($_POST["txtComments"], ENT_QUOTES, "UTF-8");
$dataRecord[] = $comments;

//Error check: SECTION 2d.
// similar to text boxes
?>

<fieldset  class="textarea">					
    <label for="txtComments" class="required">Comments</label>
    <textarea id="txtComments" 
              name="txtComments" 
              tabindex="200"
    <?php if ($emailERROR) print 'class="mistake"'; ?>
              onfocus="this.select()" 
              style="width: 25em; height: 4em;" ><?php print $comments; ?></textarea>
              <!-- NOTE: no blank spaces inside the text area -->
</fieldset>

<?php
//Initialize: SECTION 1c.
$gender="Female";

//Sanitize: SECTION 2c.
$gender = htmlentities($_POST["radGender"], ENT_QUOTES, "UTF-8");
$dataRecord[] = $gender;

//Error check: SECTION 2d.
// none if you set a default value
?>
<fieldset class="radio">
    <legend>What is your gender?</legend>
    <label><input type="radio" 
                  id="radGenderMale" 
                  name="radGender" 
                  value="Male"
                  <?php if ($gender == "Male") print 'checked' ?>
                  tabindex="330">Male</label>
    <label><input type="radio" 
                  id="radGenderFemale" 
                  name="radGender" 
                  value="Female"
                  <?php if ($gender == "Female") print 'checked' ?>
                  tabindex="340">Female</label>
</fieldset>

<?php
//Initialize: SECTION 1c.
$hiking = true;    // checked
$kayaking = false; // not cehcked

//Sanitize: SECTION 2c.
if (isset($_POST["chkHiking"])) {
    $hiking = true;
} else {
    $hiking = false;
}
$dataRecord[] = $hiking; 

/* or you could do this 
if (isset($_POST["chkHiking"])) {
    $hiking = true;
    $dataRecord[] = htmlentities($_POST["chkHiking"], ENT_QUOTES, "UTF-8"); 
} else {
    $hiking = false;
    $dataRecord[] = ""; 
}
 * 
 * // same for kayaking
*/


if (isset($_POST["chkKayaking"])) {
    $kayaking = true;
} else {
    $kayaking = false;
}
$dataRecord[] = $kayaking;

//Error check: SECTION 2d.
// none if you set a default value
?>

<fieldset class="checkbox">
    <legend>Do you like (check all that apply):</legend>
    <label><input type="checkbox" 
                  id="chkHiking" 
                  name="chkHiking" 
                  value="Hiking"
                  <?php if ($hiking) print " checked "; ?>
                  tabindex="420"> Hiking</label>

    <label><input type="checkbox" 
                  id="chkKayaking" 
                  name="chkKayaking" 
                  value="Kayaking"
                  <?php if ($kayaking)  print " checked "; ?>
                  tabindex="430"> Kayaking</label>
</fieldset>

<?php
//Initialize: SECTION 1c.
$mountain = "Camels Hump";    // pick the option

//Sanitize: SECTION 2c.
$mountain = htmlentities($_POST["lstMountains"],ENT_QUOTES,"UTF-8");
$dataRecord[] = $mountain;

//Error check: SECTION 2d.
// none if you set a default value
?>
<fieldset  class="listbox">	
    <label for="lstMountains">Favorite Mountain</label>
    <select id="lstMountains" 
            name="lstMountains" 
            tabindex="520" >
        <option <?php if($mountain=="HayStack Mountain") print " selected "; ?>
            value="HayStack Mountain">HayStack Mountain</option>
        
        <option <?php if($mountain=="Camels Hump") print " selected "; ?>
            value="Camels Hump">Camels Hump</option>
        
        <option <?php if($mountain=="Laraway Mountain") print " selected "; ?>
            value="Laraway Mountain">Laraway Mountain</option>
    </select>
</fieldset>
    </body>
</html>