<!-- ######################     Main Navigation   ########################## -->
<nav class="navigation">
            <ul>
            <?php
            if ($path_parts['filename'] == "home") {
                print"\t" . '<li class="activePage">Home</li>' . "\n";
            } else {
                print"\t" . '<li><a href="home.php">Home</a></li>' . "\n";
            }
            if ($path_parts['filename'] == "info") {
                print"\t\t" . '<li class="activePage">Information</li>' . "\n";
            } else {
                print"\t\t" . '<li><a href="info.php">Information</a></li>' . "\n";
            }
            if ($path_parts['filename'] == "schedule") {
                print"\t\t" . '<li class="activePage">Schedule</li>' . "\n";
            } else {
                print"\t\t" . '<li><a href="schedule.php">Schedule</a></li>' . "\n";
            }
            if ($path_parts['filename'] == "goalSheet") {
                print"\t\t" . '<li class="activePage">Goal Sheets</li>' . "\n";
            } else {
                print"\t\t" . '<li><a href="goalSheet.php">Goal Sheets</a></li>' . "\n";
            }
            if ($path_parts['filename'] == "media") {
                print"\t\t" . '<li class="activePage">Media</li>' . "\n";
            } else {
                print"\t\t" . '<li><a href="media.php">Media</a></li>' . "\n";
            }
            if ($path_parts['filename'] == "contact") {
                print"\t\t" . '<li class="activePage">Contact Us</li>' . "\n";
            } else {
                print"\t\t" . '<li><a href="contact.php">Contact Us</a></li>' . "\n";
            }
            ?>
            </ul>
</nav>
