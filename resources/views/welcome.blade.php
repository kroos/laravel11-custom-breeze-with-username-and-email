@extends('layouts.app')

@section('content')
<div class="col-sm-12 row align-items-center justify-content-center">
	<div class="col-sm-6 m-3">
		<canvas id="myChart" width="200" height="75"></canvas>
	</div>
	<div class="col-sm-6 m-3">
		<div id='calendar'></div>
	</div>

</div>
@endsection

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
// chartjs
const ctx = document.getElementById('myChart').getContext('2d');
const myChart = new Chart(ctx, {
	type: 'line',
	data: {
		labels: ['Point 1', 'Point 2', 'Point 3'], // X-axis labels
		datasets: [{
			label: 'Sample Line',
			data: [5, 4, 8], // Y-axis values corresponding to each point
			borderColor: 'rgba(75, 192, 192, 1)',
			backgroundColor: 'rgba(75, 192, 192, 0.2)',
			borderWidth: 2,
			tension: 0.4, // Makes the line slightly curved
		}]
	},
	options: {
		responsive: true,
		plugins: {
			legend: {
				display: true,
				position: 'top',
			}
		},
		scales: {
			x: {
				title: {
					display: true,
					text: 'X Axis Label',
				}
			},
			y: {
				title: {
					display: true,
					text: 'Y Axis Label',
				},
				beginAtZero: true,
			}
		}
	}
});

// 	new Chart(document.getElementById('myChart'), {
// 		data: {
// 			labels: 'Examples ChartJS',
// 			datasets: [
// 				{
// 					type: 'line',
// 					label: 'Total Attendance Percentage By Day(%)',
// 					data: 2,
// 					tension: 0.3,
// 				},
// 				{
// 					type: 'bar',
// 					label: 'Available Staff',
// 					data: 2,
// 				},
// 			],
// 		},
// 		options: {
// 			responsive: true,
// 			scales: {
// 				y: {
// 					beginAtZero: true
// 				}
// 			},
// 			interaction: {
// 				intersect: false,
// 				mode: 'index',
// 			},
// 		},
// 		plugins: {
// 			legend: {
// 				position: 'top',
// 			},
// 			title: {
// 				display: true,
// 				text: 'Attendance Statistic Daily'
// 			},
// 		},
// 	});

/////////////////////////////////////////////////////////////////////////////////////////
// fullcalendar
const calendarEl = document.getElementById('calendar');
const calendar = new FullCalendar.Calendar(calendarEl, {
	initialView: 'dayGridMonth', // Show monthly view
	initialDate: '{{ now() }}', // Start calendar with a specific date
	headerToolbar: {
		left: 'prev,next today',
		center: 'title',
		right: 'multiMonthYear,dayGridMonth,timeGridWeek'
	},
	events: [
		{
			title: 'Event 1',
			start: '2025-01-05', // Date of the event
			description: 'Description of Event 1'
		},
		{
			title: 'Event 2',
			start: '2025-01-10T10:00:00', // Date and time
			end: '2025-01-10T12:00:00', // Optional end time
			description: 'Description of Event 2'
		},
		{
			title: 'Event 3',
			start: '2025-01-20',
			description: 'Description of Event 3'
		}
	],
	eventClick: function(info) {
		// alert(info.event.title + "\n" + info.event.extendedProps.description);
		swal.fire({
			title: info.event.title,
			text: info.event.extendedProps.description,
			icon: 'info',
		});
	},
	eventDidMount: function(info) {
		$(info.el).tooltip({
			title: info.event.extendedProps.description,
			placement: 'top',
			trigger: 'hover',
			container: 'body'
		});
	},
	eventTimeFormat: { // like '14:30:00'
		hour: '2-digit',
		minute: '2-digit',
		second: '2-digit',
		hour12: true
	},
});
calendar.render();


//  const calendarEl = document.getElementById('calendar')
//  const calendar = new FullCalendar.Calendar(calendarEl, {
//  	// plugins: [
//  	// 	timeGridPlugin,
//  	// 	dayGridPlugin,
//  	// 	multiMonthPlugin,
//  	// 	momentPlugin,
//  	// 	bootstrap5Plugin
//  	// ],
//  	aspectRatio: 1.3,
//  	height: 2000,
//  	weekNumbers: true,
//  	themeSystem: 'bootstrap',
//  	initialView: 'multiMonthYear',
//  	// initialView: 'dayGridMonth',
//  	headerToolbar: {
//  		left: 'prev,next today',
//  		center: 'title',
//  		// right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
//  		right: 'multiMonthYear,dayGridMonth,timeGridWeek'
//  	},
//  	// events: {
//  	// 	url: '{{-- route('loancalendar') --}}',
//  	// 	method: 'GET',
//  	// 	extraParams: {
//  	// 		_token: '{{-- csrf_token() --}}',
//  	// 	},
//  	// },
//  	events: [
//  		{
//  			title: 'Test Calendar',
//  			start: '{{ now() }}',
//  			end: '{{ now() }}',
//  			// url: route('hrleave.show', $v->id),
//  			allDay: true,
//  			// extendedProps: {
//  			// 						department: 'BioChemistry'
//  			// 					},
//  			description: 'Test Tooltips',
//  			color: 'teal',
//  			textColor: 'yellow',
//  			borderColor: 'green',
//  		}
//  	],
//  	eventDidMount: function(info) {
//  		$(info.el).tooltip({
//  			title: info.event.extendedProps.description,
//  			placement: 'top',
//  			trigger: 'hover',
//  			container: 'body'
//  		});
//  	},
//  	eventTimeFormat: { // like '14:30:00'
//  		hour: '2-digit',
//  		minute: '2-digit',
//  		second: '2-digit',
//  		hour12: true
//  	}
//  })
//  calendar.render()

@endsection
