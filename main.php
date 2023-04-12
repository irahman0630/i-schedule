<?php
session_start();
include "header.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
}

$user_id = $_SESSION["user_id"];
$email = $_SESSION["email"];

if (isset($_POST["logout"])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
}

?>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="">i-Schedule</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <form method="POST">
                            <button type="submit" name="logout" class="btn btn-primary">Log Out</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <i class="fas fa-calendar-plus fa-3x"></i>
                            <h5 class="card-title">Create Meeting</h5>
                            <p class="card-text">Create a new meeting with a unique code and invite participants.</p>
                            <a href="create_meeting.php" class="btn btn-primary">Create</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <i class="fas fa-users fa-3x"></i>
                            <h5 class="card-title">Join Meeting</h5>
                            <p class="card-text">Join an existing meeting by entering the unique code.</p>
                            <a href="#" class="btn btn-primary">Join</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                        <h5 class="card-title">Invite Participants</h5>
                        <p class="card-text">Invite participants to a scheduled meeting by entering their email addresses.</p>
                        <form>
                            <div class="mb-3">
                            <label for="email-input" class="form-label">Email Address:</label>
                            <input type="email" class="form-control" id="email-input">
                            </div>
                            <button type="submit" class="btn btn-primary">Invite</button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</body>

                   
