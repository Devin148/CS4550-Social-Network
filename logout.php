<?php

// Start the session
session_start();
// Kill the session
session_destroy();
// Redirect to front page
header("Location: index.php");
exit();