<?php
session_start();
include "header.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
}

$user_id = $_SESSION["user_id"];
$email = $_SESSION["email"];
$client->setRedirectUri('http://localhost/i-schedule/all_meetings.php');

if (isset($_GET['code'])) {
    $client->authenticate($_GET['code']);
    $access_token = $client->getAccessToken();
    $calendar_service = new Google_Service_Calendar($client);
    $calendar_id = 'primary';
    $calendar_events = $calendar_service->events->listEvents($calendar_id);

    $now = date('c');
    $optParams = array(
        'timeMin' => $now,
        'orderBy' => 'startTime',
        'singleEvents' => true,
        'maxResults' => 10,
    );

    $calendar_events = $calendar_service->events->listEvents($calendar_id, $optParams);

    if (count($calendar_events->getItems()) == 0) {
        $calendar_events_html = 'No upcoming events found.';
    }
    else {
        $events = array();
        foreach ($calendar_events->getItems() as $event) {
            if ($event->getCreator()->getEmail() == $email) {
                $start = $event->start->dateTime;
                if (empty($start)) {
                    $start = $event->start->date;
                }
                $end = $event->end->dateTime;
                if (empty($end)) {
                    $end = $event->end->date;
                }
                // Get the meeting link from the SQL database
                $meeting_id = $event->getId();
                $stmt = $conn->prepare("SELECT meeting_link FROM meeting WHERE meeting_id = ?");
                $stmt->bind_param("s", $meeting_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $meeting_link = $row["meeting_link"];
                $stmt->close();
                
                $event_data = array(
                    'title' => $event->getSummary(),
                    'start' => $start,
                    'end' => $end,
                    'description' => $event->getDescription(),
                    'url' => $event->getHangoutLink(),
                    'meeting_link' => $meeting_link
                );
                array_push($events, $event_data);
            }
        }
        $events_json = json_encode($events);
    }
} else {
    $authUrl = $client->createAuthUrl();
    header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
    exit;
}
?>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">i-Schedule</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="btn btn-secondary" href="dashboard.php">Back</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <br>
    <div class="container mt-3">
        <h1 class="text-center">All Meetings</h1>
    </div>
    <div class="container mt-3">
        <div class="container mt-3">
            <div id='calendar'></div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    events: <?php echo $events_json; ?>
                });
                calendar.render();
            });
        </script>
    </div>
</body>
