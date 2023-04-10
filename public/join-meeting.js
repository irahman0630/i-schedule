document.getElementById('join-meeting-form').addEventListener('submit', function (event) {
    event.preventDefault();

    const meetingURLInput = document.getElementById('meeting-url');
    const meetingURL = meetingURLInput.value;

    if (!isValidURL(meetingURL)) {
        alert('Please enter a valid meeting URL.');
        return;
    }

    window.location.href = meetingURL;
});

function isValidURL(url) {
    try {
        new URL(url);
        return true;
    } catch (error) {
        return false;
    }
}
