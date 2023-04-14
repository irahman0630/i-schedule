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
        $calendar_events_html = '<ul>';
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
                $calendar_events_html .= '<li>';
                $calendar_events_html .= '<h3>' . $event->getSummary() . '</h3>';
                $calendar_events_html .= '<p>Start: ' . date('F j, Y, g:i a', strtotime($start)) . '</p>';
                $calendar_events_html .= '<p>End: ' . date('F j, Y, g:i a', strtotime($end)) . '</p>';
                $calendar_events_html .= '<p>Description: ' . $event->getDescription() . '</p>';
                if ($event->getHangoutLink()) {
                    $calendar_events_html .= '<p>Meeting Link: ' . $event->getHangoutLink() . '</p>';
                }
                $calendar_events_html .= '</li>';
            }
        }
        $calendar_events_html .= '</ul>';
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
    <div class="container mt-3">
        <div class="row">
            <?php foreach ($calendar_events->getItems() as $event) {
                if ($event->getCreator()->getEmail() == $email) {
                    $start = $event->start->dateTime;
                    if (empty($start)) {
                        $start = $event->start->date;
                    }
                    $end = $event->end->dateTime;
                    if (empty($end)) {
                        $end = $event->end->date;
                    }
                    ?>
                    <div class="col-md-12">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h3 class="card-title"><?php echo $event->getSummary(); ?></h3>
                                <p class="card-text"><strong>Start:</strong> <?php echo date('F j, Y, g:i a', strtotime($start)); ?></p>
                                <p class="card-text"><strong>End:</strong> <?php echo date('F j, Y, g:i a', strtotime($end)); ?></p>
                                <?php if($event->getHangoutLink()) { ?>
                                    <p class="card-text"><strong>Meeting Link:</strong> <a href="<?php echo $event->getHangoutLink(); ?>" target="_blank"><?php echo $event->getHangoutLink(); ?></a></p>
                                <?php } ?>
                                <p class="card-text"><strong>Description:</strong> <?php echo $event->getDescription(); ?></p>
                            </div>
                        </div>
                    </div>
            <?php }
            } ?>
        </div>
    </div>

</body>
