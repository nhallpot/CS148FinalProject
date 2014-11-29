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
                    <h1>Begin Your Month Count</h1>
                    <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>

                <?php
                include 'jquery.php';// this is for front end stuff

                ?>
                      <!-- pull info from tblItem -->
                <?php
                // print $thisDatabase;
                        //Build query
                $query = 'select pmkItemId as "Item ID", fldItemName as "Item Name",fldTotalOnHand as "Total On Hand",fldDepartment as "Department",fnkItemMonthCount as "Month To Be Counted" ';
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

                    ?>
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
                                        
                                        </select>
                                        </label>
                                    
                                    </fieldset> <!-- ends contact -->
                                    
                                </fieldset> <!-- ends wrapper Two -->
                                
                                <fieldset class="buttons">
                                                                       
                                    <input type="submit" id="btnDisplayInventory" name="btnDisplayInventory" value="Display Inventory" tabindex="900" class="button">
                                    
                                </fieldset> <!-- ends buttons -->
                            </fieldset> <!-- Ends Wrapper -->
                        </form>
                        
                </article>
                    
              
                </div>
            </div>
        </div>
        
    
    </div>
        <!-- /#page-content-wrapper -->
    
    

</div>  
    </body>
</html>