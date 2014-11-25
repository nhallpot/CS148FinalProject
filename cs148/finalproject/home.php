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
                    <h1>Welcome To Noah Hall-Potvin's</h1>
                    <h2>Inventory Management System</h2>
                    <!-- put text here -->
                    <?php
                    $user = htmlentities($_SERVER["REMOTE_USER"], ENT_QUOTES, "UTF-8");
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