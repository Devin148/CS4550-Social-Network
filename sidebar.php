<?php
$sidebar_user = getUser($_SESSION['email']);
$sidebar_image_loc = $sidebar_user->getImageLoc();
?>

<div id="sidebar">
    <ul>
        <a <?php echo "href=\"profile.php?email=" . $_SESSION['email'] . "\""; ?>>
            <li><div class="profile">
                    <img <?php echo "src=\"$sidebar_image_loc\""; ?> />
                </div>
                Profile
            </li>
        </a>
        <a href="newsfeed.php"><li><i class="fui-new-16 nav-fui"></i>Newsfeed</li></a>
        <a href="friends.php"><li><i class="fui-man-16 nav-fui"></i>Following</li></a>
        <a href="coops.php"><li><i class="fui-heart-16 nav-fui"></i>Co-ops</li></a>
        <!-- <a href="settings.php"><li><i class="fui-settings-16 nav-fui"></i>Settings</li></a> -->
        <a href="logout.php"><li><i class="fui-cross-16 nav-fui"></i>Logout</li></a>
    </ul>
</div>