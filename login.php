<?php
include "header.php";
?>

<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">Log in to i-Schedule</h3>
                        <form method="post">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="email" aria-describedby="emailHelp" required>
                                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" required>
                            </div>
                            <button type="submit" id="login-button" class="btn btn-primary d-block mx-auto"><i class="fas fa-sign-in-alt"></i> Log in</button>
                        </form>
                        <hr>
                        <p class="text-center mb-0">Don't have an account? <a href="signup.php">Sign up</a></p>
                        <button class="btn btn-secondary mt-3" id="back-btn"><i class="fas fa-arrow-left"></i> Back</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    document.getElementById("login-button").addEventListener("click", function(event) {
        event.preventDefault();
        var email = document.getElementById("email").value;
        var password = document.getElementById("password").value;

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "submit_login.php", true);
        xhr.onreadystatechange = function() {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                if (this.responseText === "success") {
                    window.location.href = "main.php";
                } else {
                    alert("Invalid email or password.");
                }
            }
        };
        var data = new FormData();
        data.append("email", email);
        data.append("password", password);
        xhr.send(data);
    });

    document.getElementById("back-btn").addEventListener("click", function() {
        window.location.href = "index.php";
    });
</script>
