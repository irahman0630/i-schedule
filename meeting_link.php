<?php
session_start();
include "header.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
}

$meeting_link = $_GET['link'];

?>

<div class="container">
    <h1>Meeting Link</h1>
    <p>Here's the link to join the meeting:</p>
    <p><a href="<?php echo $meeting_link; ?>"><?php echo $meeting_link; ?></a></p>
</div>
