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
                    //* %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
                    // * the purpose of this page is to display a list of poets sorted 
                    print "<h1> Here are all of the items approved by the System Admin. </h1>";
                    print "<h2> If you don't see your item, it is because the System Admin hasn't approved it yet. </h2>";
                    
                    //Build query
                    $query = 'select pmkItemId as "Item ID", fldItemName as "Item Name",fldTotalOnHand as "Total On Hand",fldDepartment as "Department" ';
                    $query .= "FROM tblItem ";
                    $query .= 'WHERE fldApproved=1 '; // We just want to show the items that have been confirmed by an admint
                    //$query .= 'and fldDepartment like ? ';
                    $query .= 'order by pmkItemId';
                    //$data = array($subject ."%",$number ."%",$building ."%",$startTime ."%",$typeOfClass ."%",$professor ."%");
                    $keys = array_keys($row);
                    print "<div id=itemTable>";
                    $numberRecords = count($results);

                    $results = $thisDatabase->select($query);


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
                    print "</div>";


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