<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
if(!$_SESSION['user_name'])
{
    $data = site_url('dashboard');
    header("location:$data");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Enquiry Register</title>
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
        <link rel="stylesheet" href="<?php echo base_url().'assets/css/local.css'?>">
        <link rel="icon" href="<?php echo base_url().'assets/company_logo/construction.jpg'?>" type="image/ico" />
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
                            <div class="card">
                                <div class="card-header" >
                                    <h1 class="card-title">Enquiry Register</h1>
                                    <div class="col-sm-6">
                                        <br><br>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'vw_enquiry_data'?>">Enquiry Register</a>
                                            </li>
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
                                    <!-- general form elements disabled -->
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Enquiry Register</h3>
                                        </div>
                                        <div>
                                            <div class="btn-group" style="margin-top: 15px; margin-left: 15px;">
                                                <a href="create_customer_enquiry" class="btn btn-block btn-primary">
                                                Create Enquiry
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div  class="table-responsive">
                                                <table id="example1" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Sr. No.</th>
                                                            <th>Action</th>
                                                            <th>Enq.No.</th>
                                                            <th>Customer Name</th>
                                                            <th>Contact Person</th>
                                                            <th>Contact No.</th>
                                                            <th>Enquiry Description</th>
                                                            <!-- <th>Enquiry Type</th> -->
                                                            <th>Enq.Date.</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $no = 0;
                                                            foreach ($enquiry_details as $row):
                                                               $no++;
                                                                $entity_id = $row->entity_id;
                                                                $Enquiry_status = $row->enquiry_status;
                                                                $Enquiry_type = $row->enquiry_type;

                                                                if($Enquiry_status == 1)
                                                                {
                                                                    $en_status = "Offer Pending";
                                                                }elseif($Enquiry_status == 2)
                                                                {
                                                                    $en_status = "Offer Received";
                                                                }elseif($Enquiry_status == 3)
                                                                {
                                                                    $en_status = "Closed";
                                                                }elseif($Enquiry_status == 4)
                                                                {
                                                                    $en_status = "Cancelled";
                                                                }
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $no;?></td>
                                                            <td>
                                                                <div class="btn-group">
                                                                    <a href="<?php echo site_url('view_enquiry_data/'.$entity_id);?>" class="btn btn-sm btn-success"><i class="fas fa-eye"></i></a> 

                                                                    <!-- <?php if($Enquiry_status == 1 || $Enquiry_status == 2) {?>
                                                                        <a href="<?php echo site_url('update_enquiry_data/'.$entity_id);?>" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>

                                                                        <a onclick="return confirm('Are You Sure To Track Enquiry?')" href="<?php echo site_url('track/'.$entity_id);?>" class="btn btn-sm btn-danger" ><i class="fas fa-paper-plane" style="color: #FFFFFF;"></i></a>
                                                                    <?php }?>  -->

                                                                    <a href="<?php echo site_url('update_enquiry_data/'.$entity_id);?>" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>

                                                                    <!-- <a onclick="return confirm('Are You Sure To Track Enquiry?')" href="<?php echo site_url('track/'.$entity_id);?>" class="btn btn-sm btn-danger" ><i class="fas fa-paper-plane" style="color: #FFFFFF;"></i></a> -->

                                                                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#test<?php echo $entity_id; ?>">
                                                                        <i class="fas fa-paper-plane" style="color: #FFFFFF;"></i>
                                                                    </button>
                                                                </div>
                                                            </td>

                                                            <div class="modal fade" id="test<?php echo $entity_id; ?>">
                                                                <div class="modal-dialog modal-lg">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title">Create RFQ</h4>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>

                                                                        <div class="modal-body">
                                                                            <form role="form" name="pop_up_2" id="pop_up_2" method="post">
                                                                                <div class="row">
                                                                                    <input type="hidden" id="enquiry_entity_id" name="enquiry_entity_id" value="<?php echo $entity_id?>" required>

                                                                                    <div class="col-sm-6">
                                                                                        <div class="form-group">
                                                                                            <label> Enquiry Number </label>
                                                                                            <input type="text" name="enquiry_number" id="enquiry_number" class="form-control" disabled value="<?php echo $row->enquiry_no; ?>">
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-sm-6">
                                                                                        <div class="form-group">
                                                                                            <label> Vender Name </label>
                                                                                             <select class="form-control select2bs4" style="width: 100%;" id="vender_id" name="vender_id" required>
                                                                                                <option value="">Select Vender</option>
                                                                                                <?php foreach($vender_details as $row_data):?>
                                                                                                <option value="<?php echo $row_data->entity_id;?>"><?php echo $row_data->vendor_name;?></option>
                                                                                                <?php endforeach;?>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                        <div class="modal-footer justify-content-between">
                                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                            <button type="button" class="btn btn-primary" id="craete_rfq">Add</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            
                                                            <td><input type="text" value="<?php echo $row->enquiry_no;?>" style="width: 150px; color: #000; border-style: none;background: none;" disabled></td>
                                                            <td><b><input type="text" value="<?php echo $row->customer_name;?>" style="color: #000; border-style: none;background: none;" disabled></b></td>

                                                            <td><input type="text" value="<?php echo $row->contact_person;?>" style="color: #000; border-style: none;background: none;" disabled></td>

                                                            <td><input type="text" value="<?php echo $row->first_contact_no;?>" style="width: 150px; color: #000; border-style: none;background: none;" disabled></td>

                                                            <td><input type="text" value="<?php echo $row->enquiry_long_desc;?>" style="color: #000; border-style: none;background: none;" disabled></td>

                                                            <!-- <td><?php echo $Enq_type;?></td> -->
                                                            <td><input type="text" value="<?php echo date("d-m-Y", strtotime($row->enquiry_date));?>" style="width: 100px; color: #000; border-style: none;background: none;" disabled></td>

                                                            <td><input type="text" value="<?php echo $en_status;?>" style="width: 100px; color: #000; border-style: none;background: none;" disabled></td>
                                                            <td>
                                                                <div class="btn-group">
                                                                    <a href="<?php echo site_url('view_enquiry_data/'.$entity_id);?>" class="btn btn-sm btn-success"><i class="fas fa-eye"></i></a> 

                                                                    <!-- <?php if($Enquiry_status == 1 || $Enquiry_status == 2) {?>
                                                                        <a href="<?php echo site_url('update_enquiry_data/'.$entity_id);?>" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>

                                                                        <a onclick="return confirm('Are You Sure To Track Enquiry?')" href="<?php echo site_url('track/'.$entity_id);?>" class="btn btn-sm btn-danger" ><i class="fas fa-paper-plane" style="color: #FFFFFF;"></i></a>
                                                                    <?php }?>  -->

                                                                    <a href="<?php echo site_url('update_enquiry_data/'.$entity_id);?>" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                                                    
                                                                    <a onclick="return confirm('Are You Sure To Track Enquiry?')" href="<?php echo site_url('track/'.$entity_id);?>" class="btn btn-sm btn-danger" ><i class="fas fa-paper-plane" style="color: #FFFFFF;"></i></a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach;?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
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
        <!-- AdminLTE App -->
        <script src="<?php echo base_url().'assets/dist/js/adminlte.min.js'?>"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="<?php echo base_url().'assets/dist/js/demo.js'?>"></script>
        <!-- DataTables -->
        <script src="<?php echo base_url().'assets/plugins/datatables/jquery.dataTables.js'?>"></script>
        <script src="<?php echo base_url().'assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js'?>"></script>
        <!-- Page script -->
        <script type="text/javascript">
            $(document).on('click', '#craete_rfq', function () {
                
                var enquiry_id = document.getElementById('enquiry_entity_id').value;
                var vender_id = document.getElementById('vender_id').value;

                if(enquiry_id != "" && vender_id != "")
                {   
                    $.ajax({
                        url:"<?php echo site_url('sales/rfq_register/create_rfq_from_enquiry');?>",
                        type: 'POST',
                        data: {'enquiry_id': enquiry_id , 'vender_id' : vender_id},
                        success : function(data) {
                            data = data.trim();
                            window.location.href = data;
                        },
                        error: function(){
                         alert("Fail")
                        }
                    });
                }else{
                    alert("Enter All Details.....");
                }
            });
        </script>

        <script>
            $(document).ready( function () {
                $('#example1').DataTable();
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
