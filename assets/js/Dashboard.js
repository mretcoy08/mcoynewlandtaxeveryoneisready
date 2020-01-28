var ctxL = document.getElementById("lineChart").getContext('2d');
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


$(document).ready(function () {

	$.ajax({
		url: global.settings.url + '/Datamanager/loadEmpStatus',
		dataType: 'json',
		success: function(res) {

        console.log(res);


			// $('#total_register').html(res.count_register);

      $('#online_emp').html(createCommas(res.online_emp) + ' / ' + createCommas(res.all_emp));

      $('#all_users').html(createCommas(res.online_user) + ' / ' + createCommas(res.all_user));
      $('#total_availnumber').html(createCommas(res.count_takennumber) +'/'+ createCommas(res.count_availnumber));

      $('#pending_request').html(createCommas(res.pending_request));
      $('#task').html(createCommas(res.task));
      $('#services').html(createCommas(res.services));
		},
		error: function(xhr) {
			notify('Error in Dashboard Statistics', 'danger');
		}
	});








});
