<!DOCTYPE html>

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Calendar</title>

	<!-- Simple CSS file for HTML page -->
	<link rel="stylesheet" href="css/main.css" type="text/css" media="screen" title="no title" charset="utf-8">

	<!-- jCalendar CSS - Contains Tipsy CSS - Delete as needed -->
	<link rel="stylesheet" href="css/calendar.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" href="css/mps_style.css" type="text/css" media="screen" title="no title" charset="utf-8">

	<!-- Source jQuery -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>

	<!-- Source CalendarJS - Contains Tipsy jQuery Plugin - Delete as needed -->
	<script src="js/jquery.calendar.js" type="text/javascript" charset="utf-8"></script>

	<!-- Call the Calendar -->
	<script>

		$(document).ready(function() {
			$.ajax({
				type: "POST",
				url: "/get-calender",
				dataType: "json",
				success: function (resp) {
					$("#main-container").calendar({
						response : resp,
						tipsy_gravity: 's', // How do you want to anchor the tipsy notification? (n / s / e / w)
						click_callback: calendar_callback, // Callback to return the clicked date
						scroll_to_date: false // Scroll to the current date?
					});
				}
			});
		});

		//
		// Example of callback - do something with the returned date
		var calendar_callback = function(date) {

			//
			// Returned date is a date object containing the day, month, and year.
			// date.day = day; date.month = month; date.year = year;
			alert("Open your Javascript console to see the returned result object.");
			console.log(date);
		}
	</script>
</head>
<body>
	
	<div id="main-container"></div>
</body>
</html>
