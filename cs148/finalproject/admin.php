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
                                        /* %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
                     * the purpose of this page is to display a list of poets sorted 
                     * 
                     * Written By: Robert Erickson robert.erickson@uvm.edu
                     * Last updated on: November 20, 2014
                     */
// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
                    $admin = true;
                    $debug = true;

                    print "<article>";
// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
// prepare the sql statement
                    $orderBy = "ORDER BY pmkItemId";

                     $query = 'SELECT fldDepartment, fldItemName, fldTotalOnHand, fldSector, fldColumn, fldRow ';
                     $query .= 'FROM tblItem,tblLocation WHERE pmkItemId = fnkItemId ' .$orderBy;

                    if ($debug)
                        print "<p>sql " . $query;

                    $items = $thisDatabase->select($query);

                    if ($debug) {
                        print "<pre>";
                        print_r($items);
                        print "</pre>";
                    }

// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
// print out the results
                    print "<ol>\n";

                    foreach ($items as $item) {

                        print "<li>";
                        if ($admin) {
                            print '<a href="add.php?id=' . $item["pmkItemId"] . '">[Edit]</a> ';
                            print '<a href="add.php?id=' . $item["pmkItemId"] . '">[Delete]</a> ';
                            }
                        print $item['fldDepartment'] . " " . $item['fldItemName'] . " " . $item['fldTotalOnHand'] . " " . $item['fldSector'] . " " . $item['fldColumn'] . " " . $item['fldRow'] . "</li>\n";
                    }
                    print "</ol>\n";
                    print "</article>";
                    
                    
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