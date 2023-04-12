<?php
include "header.php"
?>

<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="card-title mb-4">Create your i-Schedule account</h3>
                        <form>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="email" aria-describedby="emailHelp" required>
                                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirm-password" class="form-label">Confirm password</label>
                                <input type="password" class="form-control" id="confirm-password" required>
                            </div>
                            <div id="error-message" style="display: none; color: red;"></div>
                            <br>
                            <button type="submit" id="submit-button" class="btn btn-primary d-block mx-auto"><i class="fas fa-user-plus"></i> Sign up</button>
                        </form>
                        <hr>
                        <p class="text-center mb-0">Already have an account? <a href="login.php">Log in</a></p>
                        <button class="btn btn-secondary mt-3" id="back-btn"><i class="fas fa-arrow-left"></i> Back</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
  var email = document.getElementById("email").value;
  var password1 = document.getElementById("password");
  var password2 = document.getElementById("confirm-password");
  var submitButton = document.getElementById("submit-button");

  submitButton.addEventListener("click", function(event) {
    event.preventDefault();

    var email = document.getElementById("email").value;

    if (password1.value !== password2.value) {
      const errorMessage = document.getElementById("error-message");
      errorMessage.innerHTML = "Passwords do not match.";
      errorMessage.style.display = "block";
    } else {
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "submit_signup.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function() {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
          if (this.responseText.indexOf("success") !== -1) {
            window.location.href = "login.php";
          } else {
            alert(this.responseText);
          }
        }
      };
      xhr.send("email=" + encodeURIComponent(email) +
        "&password=" + encodeURIComponent(password1.value));
    }
  });


  document.getElementById("back-btn").addEventListener("click", function() {
    window.location.href = "index.php";
  });
</script>


