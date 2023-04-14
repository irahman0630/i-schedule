<?php
session_start();
include "header.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
}

$user_id = $_SESSION["user_id"];
$email = $_SESSION["email"];
$client->setRedirectUri('http://localhost/i-schedule/create_meeting.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $meeting_name = $_POST['meeting_name'];
    $meeting_date = $_POST['meeting_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $meeting_description = $_POST['meeting_description'];

    $start = $meeting_date . 'T' . $start_time . ':00-07:00'; 
    $end = $meeting_date . 'T' . $end_time . ':00-07:00'; 

    $sql = "INSERT INTO meeting (organizer_id, title, description, start_time, end_time, created_at, updated_at)
    VALUES (?, ?, ?, ?, ?, NOW(), NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $user_id, $meeting_name, $meeting_description, $start, $end);
    $stmt->execute();
    $stmt->close();

    $conference = new Google_Service_Calendar_ConferenceData();
    $create_request = new Google_Service_Calendar_CreateConferenceRequest();
    $conference_solution = new Google_Service_Calendar_ConferenceSolutionKey();
    $conference_solution->setType("hangoutsMeet");
    $create_request->setConferenceSolutionKey($conference_solution);
    $create_request->setRequestId($meeting_name);
    $conference->setCreateRequest($create_request);
    
    if (isset($_GET['code'])) {
        $client->authenticate($_GET['code']);
        $access_token = $client->getAccessToken();
        $calendar_service = new Google_Service_Calendar($client);
        $calendar_event = new Google_Service_Calendar_Event(array(
            'summary' => $meeting_name,
            'description' => $meeting_description,
            'start' => array(
              'dateTime' => $start,
              'timeZone' => 'America/New_York',
            ),
            'end' => array(
              'dateTime' => $end,
              'timeZone' => 'America/New_York',
            ),
            'conferenceData' => $conference,
            'conferenceDataVersion' => 1
        ));
        $calendar_event = $calendar_service->events->insert($calendar_id, $calendar_event, array(
            'conferenceDataVersion' => 1
        ));

        $meeting_link = $calendar_event->getHangoutLink();
        header("Location: all_meetings.php");
        exit();
    }
    else {
        $authUrl = $client->createAuthUrl();
        header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
        exit;
    }
}
?>

<?php
if (isset($_GET['code'])) {
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
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Create Meeting</h5>
                        <form method="POST">
                        <div class="mb-3">
                                <label for="meeting-name" class="form-label">Meeting Name</label>
                                <input type="text" class="form-control" id="meeting-name" name="meeting_name">
                            </div>
                            <div class="mb-3">
                                <label for="meeting-date" class="form-label">Date</label>
                                <input type="date" class="form-control" id="meeting-date" name="meeting_date">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="start-time" class="form-label">Start Time</label>
                                        <input type="time" class="form-control" id="start-time" name="start_time">
                                    </div>
                                </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="end-time" class="form-label">End Time</label>
                                    <input type="time" class="form-control" id="end-time" name="end_time">
                                </div>
                            </div>
                        </div>
                            <div class="mb-3">
                                <label for="meeting-description" class="form-label">Meeting Description</label>
                                <textarea class="form-control" id="meeting-descriptiont" rows="3" name="meeting_description"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary" name="submit">Create</button>
                            <a href="dashboard.php" class="btn btn-secondary">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php }
else {
    $authUrl = $client->createAuthUrl();
        header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
        exit;
}
?>
