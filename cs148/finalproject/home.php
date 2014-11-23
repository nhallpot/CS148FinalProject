<?php
include 'top.php';
?>
<div id="wrapper">
    <div id="sidebar-wrapper">
        <!-- div with navigable logo -->
        <div id="topLeft">
            <?php
            // Put an image here for a logo
            ?>
        </div>
        <!-- the div below will go below the logo and contain site navigation -->
        <div id="leftSide">
            <?php
            include 'nav.php';
            ?>
        </div>
    </div>

    <div id="page-content-wrapper">
        <!-- the div below will float to the left of the topOfPage -->
        <div id="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <?php
                    include 'header.php'
                    ?>
                </div>
            </div>

        </div>

    
    
    <div id="bottom">
        <!-- in case you want to put something on the bottom -->
        <?php
        include 'footer.php';
        ?>
    </div>
    </div>    
</div>

    </body>
</html>