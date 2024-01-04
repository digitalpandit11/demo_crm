<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
if(!$_SESSION['user_name'])
{
   header("location:welcome");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Overdue_Task Index</title>
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
            <?php $this->load->view('header_sidebar');
                date_default_timezone_set("Asia/Calcutta");
            ?> 
                <div class="content-wrapper">
                    <section class="content-header">
                        <div class="container-fluid">
                            <br>
                            <div class="card">
                                <div class="card-header" >
                                    <h1 class="card-title">Overdue Task Index</h1>
                                    <div class="col-sm-6">
                                        <br><br>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'task_index'?>">Overdue Task Index</a></li>
                                        </ol>
                                    </div>      
                                </div>   
                            </div>
                        </div>
                    </section>

                    <section class="content">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Task Index</h3>
                                        </div>

                                        <div class="card-body">

                                        <div class="btn-group" style="margin-bottom: 15px; margin-left: 15px;">
                                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                                Overdue Tasks
                                              </button>
                                              <div class="dropdown-menu">
                                                <a class="dropdown-item btn btn-block btn-primary" href="task_index">All Tasks</a>
                                                <a class="dropdown-item btn btn-block btn-primary" href="todays_task_index">Todays' Tasks</a>
                                              </div>
                                            </div>
                                            
                                            
                                                        <div  class="table-responsive">
                                                            <table id="example1" class="table table-bordered table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <!-- <th>Action</th> -->
                                                                        <!-- <th>Operation</th> -->
                                                                        <th>Sr. No.</th>
                                                                        <th>Tracking No.</th>
                                                                        <th>Last Call Date</th>
                                                                        <th style = "column-width: 150px;">Company Name</th>
                                                                        <th>Contact Person</th>
                                                                        <th>Contact No.</th>
                                                                        <th>Last Discussion</th>
                                                                        <!-- <th>Next Action</th> -->
                                                                        <th>Action Due Date</th>
                                                                        <th>Offer No</th>
                                                                        <th>Offer Description</th>
                                                                        <th>Offer Date</th>
                                                                        <th>Offer Engg</th>
                                                                        <th>Offer Stage</th>
                                                                        <th>Remark</th>
                                                                        <th>Action</th>
                                                                        <!-- <th>Operation</th> -->
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                 
                                                                        $no = 0;
                                                                      
                                                                        foreach ($enquiry_tracking_details as $row):
                                                                            $no++;
                                                                            $entity_id = $row->offer_id;
                                                                            
                                                                            $Status_data = $row->offer_status;

                                                                            if($Status_data == '1')
                                                                            {
                                                                                $Status = "Pending Offer Creation";
                                                                            }else if($Status_data == '2')
                                                                            {
                                                                                $Status = "Offer Created";
                                                                            }else if($Status_data == '3')
                                                                            {
                                                                                $Status = "Order Created";
                                                                            }else if($Status_data == '4')
                                                                            {
                                                                                $Status = "Offer Lost";
                                                                            }else if($Status_data == '5')
                                                                            {
                                                                                $Status = "Offer Regrated";
                                                                            }else if($Status_data == '6')
                                                                            {
                                                                                $Status = "Win";
                                                                            }else if($Status_data == '7')
                                                                            {
                                                                                $Status = "InActive";
                                                                            }else if($Status_data == '8')
                                                                            {
                                                                                $Status = "A";
                                                                            }else if($Status_data == '9')
                                                                            {
                                                                                $Status = "B";
                                                                            }else if($Status_data == '10')
                                                                            {
                                                                                $Status = "Offer Revised";
                                                                            }else{
                                                                                $Status = "NA";
                                                                            }

                                                                           
                                                                            $Enquiry_id = $row->enquiry_id;
                                                                            if(empty($Enquiry_id))
                                                                            {
                                                                                $Enquiry_number = "NA";
                                                                            }else{
                                                                                $this->db->select('*');
                                                                                    $this->db->from('enquiry_register');
                                                                                    $where = '(enquiry_register.entity_id = "'.$Enquiry_id.'")';
                                                                                    $this->db->where($where);
                                                                                    $query = $this->db->get();
                                                                                    $query_result = $query->row_array();

                                                                                    $Enquiry_number = $query_result['enquiry_no'];
                                                                            }
                                                                            // new addition to get track details
                                                                            
                                                                    ?>
                                                                    
                                                                    <tr>
                                                                      <td><?php echo $no;?></td>
                                                                       
                                                                      <td><?php echo $row->tracking_number;?></td>
                                                                      <td><?php echo $row->tracking_date;?></td>
                                                                      <td><b><?php echo $row->customer_name;?></b></td>
                                                                      <td><?php echo $row->contact_person;?></td>
                                                                      <td><?php echo $row->first_contact_no;?></td>
                                                                      <td><?php echo $row->tracking_record."<br>".$row->next_action;?></td>
                                                                      <!-- <td><?php echo $row->next_action;?></td> -->
                                                                      <td><?php echo $row->action_due_date;?></td>
                                                                      <td><?php echo $row->offer_no;?></td>
                                                                      <td><?php echo $row->offer_description;?></td>
                                                                      <td><?php echo date("Y-m-d", strtotime($row->offer_date));?></td>
                                                                      <td><?php echo $row->emp_first_name;?></td>
                                                                      <td><?php echo $Status;?></td>
                                                                      <td><?php echo $row->remark;?></td>
                                                                      <td>
                                                                          <div class="btn-group">
                                                                              <a href="<?php echo site_url('update_next_action/'.$row->entity_id);?>" class="btn btn-block btn-danger"><i class="fas fa-paper-plane"></i></a>
                                                                          </div> 
                                                                      </td>
                                                                    </tr>
                                                                <?php endforeach;?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    
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
        <!-- jQuery -->
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
        <!-- bs-custom-file-input -->
        <script src="<?php echo base_url().'assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js'?>"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo base_url().'assets/dist/js/adminlte.min.js'?>"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="<?php echo base_url().'assets/dist/js/demo.js'?>"></script>
        <!-- Page script -->
        <!-- DataTables -->
        <script src="<?php echo base_url().'assets/plugins/datatables/jquery.dataTables.js'?>"></script>
        <script src="<?php echo base_url().'assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js'?>"></script>
        <script>
            $(document).ready( function () {
                $('#example1').DataTable();
            } );

            $(document).ready( function () {
                $('#example2').DataTable();
            } );
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
