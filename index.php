<?php
include "header.php";
session_start();
?>

<style>
.jumbotron {
    background-color: #007BFF;
}
</style>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">i-Schedule</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php
                    if (isset($_SESSION["user_id"])) {
                        echo '<li class="nav-item"><a class="btn btn-primary" href="dashboard.php">Dashboard</a></li>';
                    } else {
                        echo '<li class="nav-item"><button class="btn btn-primary" id="login-btn">Log In</button></li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4">Welcome to i-Schedule</h1>
            <p class="lead">A simple yet powerful scheduler app that helps you manage your tasks and events.</p>
            <?php
            if (!isset($_SESSION["user_id"])) { ?>
            <button class="btn btn-primary btn-lg" id="get-started-btn">Get Started</button>
            <?php } ?>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <i class="fas fa-list fa-3x"></i>
                        <h5 class="card-title">Easy Scheduling</h5>
                        <p class="card-text">Create and manage your events and tasks easily with i-Schedule.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <i class="fas fa-users fa-3x"></i>
                        <h5 class="card-title">Affiliation</h5>
                        <p class="card-text">Join as a student, teacher or business when creating your profile.</p>
                        </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <i class="fas fa-envelope fa-3x"></i>
                        <h5 class="card-title">Collaboration</h5>
                        <p class="card-text">Invite your team to meetings created on i-Schedule.</p>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer mt-auto py-3 bg-light">
    <div class="container">
        <span class="text-muted">&copy; 2023 i-Schedule. All rights reserved.</span>
    </div>
    </footer>
</body>

<script>
    document.getElementById("login-btn").addEventListener("click", function() {
        window.location.href = "login.php";
    });
    document.getElementById("get-started-btn").addEventListener("click", function() {
        window.location.href = "signup.php";
    });
</script>

