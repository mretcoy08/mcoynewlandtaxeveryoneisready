$(document).ready(function() {

	$.ajax({
		url: global.settings.url + '/Cpylonadmin/dashboardStats',
		dataType: 'json',
		success: function(res) {

			$('#total_register').html(res.count_register);
			$('#total_availnumber').html(res.count_availnumber);

			$('#total_number').html(res.count_totalnum);
					$('#count_takennumber').html(res.count_takennumber);
		},
		error: function(xhr) {
			notify('Error in Dashboard Statistics', 'danger');
		}
	});




	function notify(msg, type) {
		setTimeout(function() {
			$.bootstrapGrowl(msg, {
				type: type,
				align: 'right',
				width: 'auto',
				allow_dismiss: false
			});
		}, 500);






	}


	var ctxL = document.getElementById("lineChart2").getContext('2d');
	var myLineChart = new Chart(ctxL, {
	  type: 'line',
	  data: {
	    labels: ["January", "February", "March", "April", "May", "June", "July" , "August"  , "September" , "October" , "November" , "December"],
	    datasets: [{
	        label: "New",
			data: [10, 7, 5, 0, 1, 3, 0 , 0 , 0 , 0 , 0 , 0],
			backgroundColor: [
	          'rgba(105, 0, 132, .2)',
	        ],
	        borderColor: [
	          'rgba(200, 99, 132, .7)',
	        ],
	        borderWidth: 2
	      },
	      {
	        label: "Renewal",
			data: [10, 7, 5, 0, 1, 3, 0 , 0 , 0 , 0 , 0 , 0],
			backgroundColor: [
	          'rgba(0, 137, 132, .2)',
	        ],
	        borderColor: [
	          'rgba(0, 10, 130, .7)',
	        ],
	        borderWidth: 2
	      },
	      {
	        label: "Retired",
			data: [10, 0, 4, 0, 0, 0, 1 , 0 , 0 ,0 , 0 , 0 , 0],
			backgroundColor: [
	          'rgba(141, 161, 47, .2)',
	        ],
	        borderColor: [
	          'rgba(242, 159, 64, .7)',
	        ],
	        borderWidth: 2
	      }
	    ]
	  },
	  options: {
	    responsive: true
	  }
	});





});
