document.getElementById('create-meeting-form').addEventListener('submit', async function (event) {
  event.preventDefault();

  const meetingTitleInput = document.getElementById('meeting-title');
  const meetingDescriptionInput = document.getElementById('meeting-description');
  const meetingDateInput = document.getElementById('meeting-date');
  const meetingTimeInput = document.getElementById('meeting-time');

  const meetingDate = new Date(meetingDateInput.value);
  const meetingTime = meetingTimeInput.valueAsDate;
  const now = new Date();

  // Check if the inputted date is before the current date
  if (meetingDate.setHours(0, 0, 0, 0) < now.setHours(0, 0, 0, 0)) {
    alert('You cannot create a meeting with a date in the past.');
    return;
  }

  if (meetingDate.getFullYear() < now.getFullYear()) {
    alert('You cannot create a meeting in a previous year.');
    return;
  }

  if (meetingDate.toDateString() === now.toDateString() && meetingTime <= now) {
    alert('You cannot create a meeting at a time that has already passed.');
    return;
  }

  const requestData = {
    title: meetingTitleInput.value,
    description: meetingDescriptionInput.value,
    startTime: meetingDateInput.value + 'T' + meetingTimeInput.value,
    endTime: meetingDateInput.value + 'T' + meetingTimeInput.value // Assuming the meeting ends at the same time it starts: Will update this
  };

  console.log(requestData);

  const requestOptions = {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(requestData)
  };

  try {
    const response = await fetch('/api/create-meeting', requestOptions);
    const data = await response.json();

    if (response.ok) {
      const meetingID = data.meeting.title; // This will get replaced when we connect to our database
      const meetingTitle = encodeURIComponent(requestData.title);
      const meetingDescription = encodeURIComponent(requestData.description);
      window.location.href = `/meeting.html?id=${meetingID}&title=${meetingTitle}&description=${meetingDescription}`;
    } else {
      alert(`There was an error creating the meeting. ${data.message}`);
      console.error(`Error: ${data.message}`);
    }
  } catch (error) {
    alert('There was an error creating the meeting. Please try again.');
    console.error('Error:', error);
  }
});
