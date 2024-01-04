<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Employee Master Form</title>
      <!-- Tell the browser to be responsive to screen width -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- Data Tables -->
      <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css'?>">
      <!-- Font Awesome -->
      <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/fontawesome-free/css/all.min.css'?>">
      <!-- Ionicons -->
      <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
      <!-- daterange picker -->
      <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/daterangepicker/daterangepicker.css'?>">
      <!-- iCheck for checkboxes and radio inputs -->
      <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css'?>">
      <!-- Bootstrap Color Picker -->
      <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css'?>">
      <!-- Tempusdominus Bbootstrap 4 -->
      <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css'?>">
      <!-- Select2 -->
      <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/select2/css/select2.min.css'?>">
      <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css'?>">
      <!-- Bootstrap4 Duallistbox -->
      <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css'?>">
      <!-- Theme style -->
      <link rel="stylesheet" href="<?php echo base_url().'assets/dist/css/adminlte.min.css'?>">
      <!-- Google Font: Source Sans Pro -->
      <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
   </head>
   <body class="hold-transition sidebar-mini">
      <div class="wrapper">
         <!-- Navbar -->
         <?php $this->load->view('header_sidebar');?>
         <!-- /.navbar -->
         <!-- Main Sidebar Container -->  
         <div class="content-wrapper">
            <!-- Content Wrapper. Contains page content -->
            <section class="content-header">
               <div class="container-fluid">
                  <br>
                  <!-- <div class="card" style="background-color: #20c997;"> -->
                  <div class="card">
                     <div class="card-header" >
                        <h1 class="card-title">Employee Master</h1>
                        <div class="col-sm-6">
                           <br><br>
                           <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                              <li class="breadcrumb-item"><a href="<?php echo base_url().'employee_master'?>">Employee Master</a></li>
                              <li class="breadcrumb-item">Update Employee Details :- <?php  echo $entity_id; ?></li>
                           </ol>
                        </div>
                     </div>
                  </div>
                  <!-- <div class="row mb-2">
                     <div class="col-sm-6">
                         <h1>Advanced Form</h1>
                        
                     </div> -->
                  <!-- <div class="col-sm-6">
                     <ol class="breadcrumb float-sm-right">
                         <li class="breadcrumb-item"><a href="#">Home</a></li>
                         <li class="breadcrumb-item active">Advanced Form</li>
                     </ol>
                     </div> -->
                  <!-- </div> -->
               </div>
            </section>
            <section class="content">
               <div class="container-fluid">
                  <div class="row">
                     <div class="col-md-12">
                        <!-- general form elements disabled -->
                        <div class="card card-primary">
                           <div class="card-header">
                              <h3 class="card-title">Employee Master Form</h3>
                           </div>
                           <div class="card-body">
                              <form role="form" name="client_info" enctype="multipart/form-data" action="<?php echo site_url('master/employee_master/update_employee_master');?>" method="post">

                                <input type="hidden" id="entity_id" name="entity_id" value="<?php echo $entity_id?>" required>

                                 <div class="row">
                                    <div class="col-sm-3">
                                       <div class="form-group">
                                          <label>Employee Id</label>
                                          <input type="text" name="employee_id" id="employee_id" class="form-control" placeholder="Employee Id" readonly>
                                       </div>
                                    </div>
                                    <div class="col-sm-3">
                                       <div class="form-group">
                                          <label>First Name</label>
                                          <input type="text" name="emp_first_name" id="emp_first_name" class="form-control" placeholder="First Name" required>
                                       </div>
                                    </div>
                                    <div class="col-sm-3">
                                       <div class="form-group">
                                          <label>Middle Name</label>
                                          <input type="text" name="emp_middle_name" id="emp_middle_name" class="form-control" placeholder="Middle Name" required>
                                       </div>
                                    </div>
                                    <div class="col-sm-3">
                                       <div class="form-group">
                                          <label>Last Name</label>
                                          <input type="text" name="emp_last_name" id="emp_last_name" class="form-control" placeholder="Last Name" required>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-sm-3">
                                       <div class="form-group">
                                          <label>Email</label>
                                          <input type="email" name="email_id" id="email_id" class="form-control" placeholder="Email" required>
                                       </div>
                                    </div>
                                    <div class="col-sm-3">
                                       <div class="form-group">
                                          <label>Contact No</label>
                                          <input type="text" name="mobile_no" id="mobile_no" class="form-control" placeholder="Contact No" required>
                                       </div>
                                    </div>
                                    <div class="col-sm-3">
                                       <div class="form-group">
                                          <label>Date Of Birth</label>
                                          <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" placeholder="Date Of Birth" required>
                                       </div>
                                    </div>
                                    <div class="col-sm-3">
                                       <div class="form-group">
                                          <label>Date Of Joining</label>
                                          <input type="date" name="joining_date" id="joining_date" class="form-control" placeholder="Date Of Joining" required>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-sm-4">
                                       <div class="form-group">
                                           <label>State Name </label>
                                           <select class="form-control select2bs4" style="width: 100%;" id="emp_region_to_handle" name="emp_region_to_handle">
                                               <option value="">No Selected</option>
                                               <?php foreach($state_list as $row):?>
                                               <option value="<?php echo $row->entity_id;?>"><?php echo $row->state_name;?></option>
                                               <?php endforeach;?>
                                           </select>
                                       </div>
                                   </div>

                                    <div class="col-sm-3">
                                       <div class="form-group">
                                          <label>Date Of Leaving</label>
                                          <input type="date" name="leaving_date" id="leaving_date" class="form-control" placeholder="Date Of Leaving">
                                       </div>
                                    </div>

                                    <div class="col-sm-3">
                                       <div class="form-group">
                                          <label> Employee Status</label>
                                          <select class="form-control" style="width: 100%;" id="emp_status" name="emp_status" required>
                                              <option value="">No Selected</option>
                                              <option value="1">Active</option>
                                              <option value="2">In-Active</option>
                                          </select>
                                       </div>
                                    </div>

                                 </div>
                                 <!-- <div class="col-sm-3" >
                                    <div class="form-group">
                                       <label>Employee Id</label>
                                       <input type="text" name="entity_id" id="entity_id" class="form-control" placeholder="Employee Id" value="<?php echo $entity_id; ?>" readonly>
                                    </div>
                                 </div> -->
                                 <div class="card-body">
                                    <button type="submit" class="btn btn-success toastrDefaultSuccess">
                                    Submit
                                    </button>
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
         </div>
         <?php $this->load->view('footer');?>
         <!-- Control Sidebar -->
         <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
         </aside>
         <!-- /.control-sidebar -->
      </div>
      <!-- ./wrapper -->
      <script src="<?php echo base_url().'assets/plugins/jquery/jquery.min.js'?>"></script>
      <!-- Bootstrap 4 -->
      <script src="<?php echo base_url().'assets/plugins/bootstrap/js/bootstrap.bundle.min.js'?>"></script>
      <!-- Select2 -->
      <script src="<?php echo base_url().'assets/plugins/select2/js/select2.full.min.js'?>"></script>
      <!-- Bootstrap4 Duallistbox -->
      <script src="<?php echo base_url().'assets/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js'?>"></script>
      <!-- InputMask -->
      <script src="<?php echo base_url().'assets/plugins/moment/moment.min.js'?>"></script>
      <script src="<?php echo base_url().'assets/plugins/inputmask/min/jquery.inputmask.bundle.min.js'?>"></script>
      <!-- date-range-picker -->
      <script src="<?php echo base_url().'assets/plugins/daterangepicker/daterangepicker.js'?>"></script>
      <!-- bootstrap color picker -->
      <script src="<?php echo base_url().'assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js'?>"></script>
      <!-- Tempusdominus Bootstrap 4 -->
      <script src="<?php echo base_url().'assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js'?>"></script>
      <!-- Bootstrap Switch -->
      <script src="<?php echo base_url().'assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js'?>"></script>
      <!-- AdminLTE App -->
      <script src="<?php echo base_url().'assets/dist/js/adminlte.min.js'?>"></script>
      <!-- AdminLTE for demo purposes -->
      <script src="<?php echo base_url().'assets/dist/js/demo.js'?>"></script>
      <!-- DataTables -->
      <script src="<?php echo base_url().'assets/plugins/datatables/jquery.dataTables.js'?>"></script>
      <script src="<?php echo base_url().'assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js'?>"></script>
      <!-- bs-custom-file-input -->
      <script src="<?php echo base_url().'assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js'?>"></script>
      <!-- AdminLTE App -->
      <script src="<?php echo base_url().'assets/dist/js/adminlte.min.js'?>"></script>
      <!-- AdminLTE for demo purposes -->
      <script src="<?php echo base_url().'assets/dist/js/demo.js'?>"></script>
      <script type="text/javascript">
         $(document).ready(function () {
           bsCustomFileInput.init();
         });
      </script>
      <!-- Page script -->
      <script>
         $(function () {
             $("#example1").DataTable();
             $('#example2').DataTable({
               "paging": true,
               "lengthChange": false,
               "searching": false,
               "ordering": true,
               "info": true,
               "autoWidth": false,
             });
         });
      </script>

      <script type="text/javascript">
            $(document).ready(function(){
                //call function get data edit
                get_data_edit();
                //get_city_data_edit();

                //load data for edit
                function get_data_edit(){
                    var entity_id = $('[name="entity_id"]').val();
                    
                    $.ajax({
                        url : "<?php echo site_url('master/employee_master/get_all_data_by_id');?>",
                        method : "POST",
                        data :{entity_id :entity_id},
                        async : true,
                        dataType : 'json',
                        success : function(data){
                            $.each(data, function(i, item){
                                console.log(data);
                                $val = 
                                $('[name="employee_id"]').val(data[i].employee_id);
                                $('[name="emp_first_name"]').val(data[i].emp_first_name);
                                $('[name="emp_middle_name"]').val(data[i].emp_middle_name);
                                $('[name="emp_last_name"]').val(data[i].emp_last_name);
                                $('[name="email_id"]').val(data[i].email_id);
                                $('[name="mobile_no"]').val(data[i].mobile_no);
                                $('[name="date_of_birth"]').val(data[i].date_of_birth);
                                $('[name="joining_date"]').val(data[i].joining_date);
                                $('[name="leaving_date"]').val(data[i].leaving_date);
                                $('[name="emp_region_to_handle"]').val(data[i].emp_region_to_handle).trigger('change');
                                $('[name="emp_status"]').val(data[i].status).trigger('change');
                            });
                        }
                    });
                }  
            });
         </script>
         <script>
            $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
              theme: 'bootstrap4'
            })

            //Datemask dd/mm/yyyy
            $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
            //Datemask2 mm/dd/yyyy
            $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
            //Money Euro
            $('[data-mask]').inputmask()

            //Date range picker
            $('#reservation').daterangepicker()
            //Date range picker with time picker
            $('#reservationtime').daterangepicker({
              timePicker: true,
              timePickerIncrement: 30,
              locale: {
                format: 'MM/DD/YYYY hh:mm A'
              }
            })
            //Date range as a button
            $('#daterange-btn').daterangepicker(
              {
                ranges   : {
                  'Today'       : [moment(), moment()],
                  'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                  'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
                  'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                  'This Month'  : [moment().startOf('month'), moment().endOf('month')],
                  'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate  : moment()
              },
              function (start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
              }
            )

            //Timepicker
            $('#timepicker').datetimepicker({
              format: 'LT'
            })
            
            //Bootstrap Duallistbox
            $('.duallistbox').bootstrapDualListbox()

            //Colorpicker
            $('.my-colorpicker1').colorpicker()
            //color picker with addon
            $('.my-colorpicker2').colorpicker()

            $('.my-colorpicker2').on('colorpickerChange', function(event) {
              $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
            });

            $("input[data-bootstrap-switch]").each(function(){
              $(this).bootstrapSwitch('state', $(this).prop('checked'));
            });

          })
         </script>
   </body>
</html>
