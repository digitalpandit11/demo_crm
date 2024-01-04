<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
if (!$_SESSION['user_name']) {
  $data = site_url('dashboard');
  header("location:$data");
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Timesheet Main Index</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url() . 'assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css' ?>">
  <link rel="stylesheet" href="<?php echo base_url() . 'assets/plugins/fontawesome-free/css/all.min.css' ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url() . 'assets/plugins/daterangepicker/daterangepicker.css' ?>">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="<?php echo base_url() . 'assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css' ?>">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="<?php echo base_url() . 'assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css' ?>">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="<?php echo base_url() . 'assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css' ?>">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url() . 'assets/plugins/select2/css/select2.min.css' ?>">
  <link rel="stylesheet" href="<?php echo base_url() . 'assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css' ?>">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="<?php echo base_url() . 'assets/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css' ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() . 'assets/dist/css/adminlte.min.css' ?>">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="icon" href="<?php echo base_url() . 'assets/company_logo/construction.jpg' ?>" type="image/ico" />
  <!-- fullCalendar -->
  <!-- CSS for full calender -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" rel="stylesheet" />
<!-- JS for jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- JS for full calender -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
<!-- bootstrap css and js -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"/>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  

</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <?php $this->load->view('header_sidebar'); ?>

  



    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1><?php echo "Calendar for ".$employee_details->emp_first_name; ?></h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo base_url().'timesheet_main_index'?>">Timesheet Index</a></li>
                <li class="breadcrumb-item active">Calendar</li>
              </ol>
            </div>
          </div>
        </div>        
        <!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
      
        <div class="container-fluid">
          <div class="row">
            
            
              <div class="card card-primary">
                <div class="card-body p-0">
                  <!-- THE CALENDAR -->
                  <div id="calendar"></div>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
  </div>

  <!-- Start popup dialog box -->
<div class="modal fade" id="event_entry_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalLabel">Add New Event</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="img-container">
					<div class="row">
						<div class="col-sm-12">  
							<div class="form-group">
							  <label for="event_name">Event name</label>
							  <input type="text" name="event_name" id="event_name" class="form-control" placeholder="Enter your event name">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">  
							<div class="form-group">
							  <label for="event_start_date">Event start</label>
							  <input type="date" name="event_start_date" id="event_start_date" class="form-control onlydatepicker" placeholder="Event start date">
							 </div>
						</div>
						<div class="col-sm-6">  
							<div class="form-group">
							  <label for="event_end_date">Event end</label>
							  <input type="date" name="event_end_date" id="event_end_date" class="form-control" placeholder="Event end date">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" onclick="save_event()">Save Event</button>
			</div>
		</div>
	</div>
</div>
<!-- End popup dialog box -->



  <!-- ./wrapper -->

  <!-- jQuery -->
  <!-- <script src="<?php echo base_url() . 'assets/plugins/jquery/jquery.min.js' ?>"></script> -->
  <!-- Bootstrap -->
  <!-- <script src="<?php echo base_url() . 'assets/plugins/bootstrap/js/bootstrap.bundle.min.js' ?>"></script> -->
  <!-- jQuery UI -->
  <!-- <script src="<?php echo base_url() . 'assets/plugins/jquery-ui/jquery-ui.min.js' ?>"></script> -->
  <!-- AdminLTE App -->
  <!-- <script src="<?php echo base_url() . 'assets/dist/js/adminlte.min.js' ?>"></script> -->
  <!-- AdminLTE for demo purposes -->
  <!-- <script src="<?php echo base_url() . 'assets/dist/js/demo.js' ?>"></script> -->
  <!-- fullCalendar 2.2.5 -->
  <!-- <script src="<?php echo base_url() . 'assets/plugins/moment/moment.min.js' ?>"></script> -->
  <!-- <script src="<?php echo base_url() . 'assets/plugins/fullcalendar/main.min.js' ?>"></script>
    <script src="<?php echo base_url() . 'assets/plugins/fullcalendar/jquery/jquery.min.js' ?>"></script>
    <script src="<?php echo base_url() . 'assets/plugins/fullcalendar-daygrid/main.min.js' ?>"></script>
    <script src="<?php echo base_url() . 'assets/plugins/fullcalendar-timegrid/main.min.js' ?>"></script>
    <script src="<?php echo base_url() . 'assets/plugins/fullcalendar-interaction/main.min.js' ?>"></script>
    <script src="<?php echo base_url() . 'assets/plugins/fullcalendar-bootstrap/main.min.js' ?>"></script> -->
  <!-- Page specific script -->
  <script>
$(document).ready(function() {
	display_events();
}); //end document.ready block

function display_events() {
  var employee_id= "<?php echo $employee_id;?>";
	var events = new Array();
  // alert(employee_id);
$.ajax({
    url: '<?php echo site_url("support/timesheet/get_employee_calender");?>',  
    type:"POST",
    dataType: 'json',
    data: {employee_id:employee_id},
    success: function (response) {
      
      // var result=response.data;
      // console.log(result);
    $.each(response, function (i, item) {
    	events.push({
            event_id: response[i].entity_id,
            title: response[i].activity_detail,
            start: response[i].start_datetime,
            end: response[i].end_datetime,
            color: response[i].activity_type,
            url: response[i].status
        }); 	
    });
    // console.log(events);
    
	var calendar = $('#calendar').fullCalendar({
	    defaultView: 'month',
		 timeZone: 'local',
	    editable: true,
        selectable: true,
		selectHelper: true,
        select: function(start, end) {
				// alert(start);
				// alert(end);
				$('#event_start_date').val(moment(start).format('YYYY-MM-DD'));
				$('#event_end_date').val(moment(end).format('YYYY-MM-DD'));
				$('#event_entry_modal').modal('show');
			},
        events: events,
	    eventRender: function(event, element, view) { 
            element.bind('click', function() {
					alert(event.event_id);
				});
    	}
		}); //end fullCalendar block	
	  },//end success block
	  error: function (xhr, status) {
	  // alert(response.msg);
	  }
	});//end ajax block	
}

function save_event()
{
var employee_id= "<?php echo $employee_id;?>";
var event_name=$("#event_name").val();
var event_start_date=$("#event_start_date").val();
var event_end_date=$("#event_end_date").val();
if(event_name=="" || event_start_date=="" || event_end_date=="")
{
alert("Please enter all required details.");
return false;
}
$.ajax({
 url:"<?php echo site_url('support/timesheet/add_employee_activity');?>",
 type:"POST",
 dataType: 'json',
 data: {
  employee_id:employee_id,
  event_name:event_name,
  event_start_date:event_start_date,
  event_end_date:event_end_date},
 success:function(response){
   $('#event_entry_modal').modal('hide');  
   if(response.status == true)
   {
	alert(response.msg);
	location.reload();
   }
   else
   {
	 alert(response.msg);
   }
  },
  error: function (xhr, status) {
  console.log('ajax error = ' + xhr.statusText);
  alert(response.msg);
  }
});    
return false;
}
</script>
  <!-- <script>
      $(function() {

        /* initialize the external events
         -----------------------------------------------------------------*/
        function ini_events(ele) {
          ele.each(function() {

            // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
            // it doesn't need to have a start or end
            var eventObject = {
              title: $.trim($(this).text()) // use the element's text as the event title
            }

            // store the Event Object in the DOM element so we can get to it later
            $(this).data('eventObject', eventObject)

            // make the event draggable using jQuery UI
            $(this).draggable({
              zIndex: 1070,
              revert: true, // will cause the event to go back to its
              revertDuration: 0 //  original position after the drag
            })

          })
        }

        ini_events($('#external-events div.external-event'))

        /* initialize the calendar
         -----------------------------------------------------------------*/
        //Date for the calendar events (dummy data)
        var date = new Date()
        var d = date.getDate(),
          m = date.getMonth(),
          y = date.getFullYear()

        var Calendar = FullCalendar.Calendar;
        var Draggable = FullCalendarInteraction.Draggable;

        var containerEl = document.getElementById('external-events');
        var checkbox = document.getElementById('drop-remove');
        var calendarEl = document.getElementById('calendar');

        // initialize the external events
        // -----------------------------------------------------------------

        new Draggable(containerEl, {
          itemSelector: '.external-event',
          eventData: function(eventEl) {
            console.log(eventEl);
            return {
              title: eventEl.innerText,
              backgroundColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
              borderColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
              textColor: window.getComputedStyle(eventEl, null).getPropertyValue('color'),
            };
          }
        });

        var calendar = new Calendar(calendarEl, {
          plugins: ['bootstrap', 'interaction', 'dayGrid', 'timeGrid'],
          header: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay',
          },
          //Random default events
          events: [{
              title: 'All Day Event',
              start: new Date(y, m, 1),
              backgroundColor: '#f56954', //red
              borderColor: '#f56954' //red
            },
            {
              title: 'Long Event',
              start: new Date(y, m, d - 5),
              end: new Date(y, m, d - 2),
              backgroundColor: '#f39c12', //yellow
              borderColor: '#f39c12' //yellow
            },
            {
              title: 'Meeting',
              start: new Date(y, m, d, 10, 30),
              allDay: false,
              backgroundColor: '#0073b7', //Blue
              borderColor: '#0073b7' //Blue
            },
            {
              title: 'Lunch',
              start: new Date(y, m, d, 12, 0),
              end: new Date(y, m, d, 14, 0),
              allDay: false,
              backgroundColor: '#00c0ef', //Info (aqua)
              borderColor: '#00c0ef' //Info (aqua)
            },
            {
              title: 'Birthday Party',
              start: new Date(y, m, d + 1, 19, 0),
              end: new Date(y, m, d + 1, 22, 30),
              allDay: false,
              backgroundColor: '#00a65a', //Success (green)
              borderColor: '#00a65a' //Success (green)
            },
            {
              title: 'Click for Google',
              start: new Date(y, m, 28),
              end: new Date(y, m, 29),
              url: 'http://google.com/',
              backgroundColor: '#3c8dbc', //Primary (light-blue)
              borderColor: '#3c8dbc' //Primary (light-blue)
            }
          ],
          editable: true,
          selecttable:true,
          selectHelper:true,
          droppable: true, // this allows things to be dropped onto the calendar !!!
          drop: function(info) {
            // is the "remove after drop" checkbox checked?
            if (checkbox.checked) {
              // if so, remove the element from the "Draggable Events" list
              info.draggedEl.parentNode.removeChild(info.draggedEl);
            }
          }
        });

        calendar.render();
        // $('#calendar').fullCalendar()

        /* ADDING EVENTS */
        var currColor = '#3c8dbc' //Red by default
        //Color chooser button
        var colorChooser = $('#color-chooser-btn')
        $('#color-chooser > li > a').click(function(e) {
          e.preventDefault()
          //Save color
          currColor = $(this).css('color')
          //Add color effect to button
          $('#add-new-event').css({
            'background-color': currColor,
            'border-color': currColor
          })
        })
        $('#add-new-event').click(function(e) {
          e.preventDefault()
          //Get value and make sure it is not null
          var val = $('#new-event').val()
          if (val.length == 0) {
            return
          }

          //Create events
          var event = $('<div />')
          event.css({
            'background-color': currColor,
            'border-color': currColor,
            'color': '#fff'
          }).addClass('external-event')
          event.html(val)
          $('#external-events').prepend(event)

          //Add draggable funtionality
          ini_events(event)

          //Remove event from text input
          $('#new-event').val('')
        })
      })
    </script> -->
</body>

</html>