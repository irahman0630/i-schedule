<?php
session_start();
include "header.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
}

$user_id = $_SESSION['user_id'];
$client->setRedirectUri('http://localhost/i-schedule/invite.php');

// retrieve list of meetings for the user's session
$sql = "SELECT title, meeting_id FROM meeting WHERE organizer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$meetings = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // process invite form submission
    $meeting_id = $_POST['meeting_id'];
    $email = $_POST['email'];
  
      // retrieve meeting details
      $sql = "SELECT title, meeting_link, description, start_time, end_time FROM meeting WHERE meeting_id = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $meeting_id);
      $stmt->execute();
      $result = $stmt->get_result();
      $meeting = $result->fetch_assoc();
      $stmt->close();
  
      // retrieve user details
      $sql = "SELECT user_id FROM user WHERE email = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $result = $stmt->get_result();
      $recipient = $result->fetch_assoc();
      $stmt->close();
  
      $recipient_id = $recipient['user_id'];
      $sender_id = $user_id;
      $created_at = date("Y-m-d H:i:s");
      $updated_at = date("Y-m-d H:i:s");

      $sql = "INSERT INTO invitation (meeting_id, sender_id, recipient_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("sssss", $meeting_id, $sender_id, $recipient_id, $created_at, $updated_at);
      $stmt->execute();
      $stmt->close();
      
      $sql = "INSERT INTO notification (recipient_id, meeting_id, created_at, updated_at) VALUES (?, ?, ?, ?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ssss", $recipient_id, $meeting_id, $created_at, $updated_at);
      $stmt->execute();
      $stmt->close();

      // Display success message
        $success_message = "Invitation sent successfully!";
  }

?>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">i-Schedule</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Send Meeting Invitation</h5>
                        <?php if (isset($success_message)) { ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo $success_message; ?>
                            </div>
                        <?php } ?>
                        <?php if (isset($error_message)) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $error_message; ?>
                            </div>
                        <?php } ?>
                        <form method="POST">
                            <div class="mb-3">
                            <label for="meeting_id" class="form-label">Meeting:</label>
                            <select id="meeting_id" name="meeting_id" class="form-control">
                                <?php foreach ($meetings as $meeting): ?>
                                <option value="<?php echo $meeting['meeting_id']; ?>"><?php echo $meeting['title']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            </div>
                            <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Send Invite</button>
                            <a href="dashboard.php" class="btn btn-secondary">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
