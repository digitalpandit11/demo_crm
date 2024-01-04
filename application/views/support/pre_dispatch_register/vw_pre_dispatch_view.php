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
        <title>View Pre Dispatch</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css'?>">
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
        <link rel="icon" href="<?php echo base_url().'assets/company_logo/construction.jpg'?>" type="image/ico" />
    </head>
    <body class="hold-transition sidebar-mini">
        <div class="wrapper">
            <?php $this->load->view('header_sidebar');?> 
            <?php 

                $this->db->select('predispatch_master.*');
                $this->db->from('predispatch_master');
                $this->db->where('entity_id', $entity_id);
                $query = $this->db->get();
                $query_result = $query->row_array();

                $customer_id = $query_result['customer_id'];

                $this->db->select('customer_master.*');
                $this->db->from('customer_master');
                $this->db->where('entity_id', $customer_id);
                $customer_master_query = $this->db->get();
                $customer_master_query_result = $customer_master_query->row_array();

                $Customer_name = $customer_master_query_result['customer_name'];

                $contact_id = $query_result['contact_person_id'];

                $this->db->select('customer_contact_master.contact_person,
                    customer_contact_master.email_id,
                    customer_contact_master.first_contact_no,
                    state_master.state_name,
                    state_master.state_code,
                    city_master.city_name');
                $this->db->from('customer_contact_master');
                $this->db->join('customer_master', 'customer_master.entity_id = customer_contact_master.customer_id', 'INNER');   
                $this->db->join('state_master', 'customer_master.state_id = state_master.entity_id', 'INNER');
                $this->db->join('city_master', 'customer_master.city_id = city_master.entity_id', 'INNER');
                $where = '(customer_contact_master.entity_id = "'.$contact_id.'" )';
                $this->db->where($where);
                $customer_contact_master = $this->db->get();
                $customer_contact_master_query_result = $customer_contact_master->row_array();

                $contact_person = $customer_contact_master_query_result['contact_person'];
                $email_id = $customer_contact_master_query_result['email_id'];
                $first_contact_no = $customer_contact_master_query_result['first_contact_no'];
                $state_name = $customer_contact_master_query_result['state_name'];
                $state_code = $customer_contact_master_query_result['state_code'];
                $city_name = $customer_contact_master_query_result['city_name'];

                $this->db->select('predispatch_attachment.*');
                $this->db->from('predispatch_attachment');
                $where = '(predispatch_attachment.predispatch_id = "'.$entity_id.'")';
                $this->db->where($where);
                $predispatch_attachment = $this->db->get();
                $predispatch_attachment_record = $predispatch_attachment->result();
            ?>
                <div class="content-wrapper">
                    <!-- Content Wrapper. Contains page content -->
                    <section class="content-header">
                        <div class="container-fluid">
                            <br>
                            <!-- <div class="card" style="background-color: #20c997;"> -->
                            <div class="card">
                                <div class="card-header" >
                                    <h1 class="card-title">View Pre Dispatch</h1>
                                    <div class="col-sm-6">
                                        <br><br>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'vw_predispatch_data'?>">Pre Dispatch</a></li>
                                            <li class="breadcrumb-item">View Pre Dispatch Of Id :- <?php  echo $entity_id; ?> </li>
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
                                            <h3 class="card-title">Pre Dispatch Details Form</h3>
                                        </div>
                                        <div class="card-body">
                                            <form role="form" id="predispatch_form" name="predispatch_form" enctype="multipart/form-data" action="<?php echo site_url('support/pre_dispatch_register/update_pre_dispatch');?>" method="post">
                                                
                                                <input type="hidden" id="entity_id" name="entity_id" value="<?php echo $entity_id?>" required>

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label> <span style="color: #FF0000;"> Customer Name * </span></label>
                                                            <input type="text" name="customer_name" id="customer_name" class="form-control" size="50" placeholder="Enter Customer Name" value="<?php echo $Customer_name;?>" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label> <span style="color: #FF0000;"> Contact Person * </span></label>
                                                            <input type="text" name="contact_person" id="contact_person" class="form-control" size="50" placeholder="Enter Contact Person" value="<?php echo $contact_person;?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card card-primary">
                                                            <div class="card-header">
                                                                <h3 class="card-title"> Customer Details</h3>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> Customer Contact Person </label>
                                                                            <input type="text" name="enquiry_contact_person" id="enquiry_contact_person" class="form-control" size="50" placeholder="Customer Contact Person" value="<?php echo $contact_person;?>" readonly>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> Customer Email Id </label>
                                                                            <input type="text" name="enquiry_email_id" id="enquiry_email_id" class="form-control" size="50" placeholder="Customer Email Id" value="<?php echo $email_id;?>" readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-3">
                                                                        <div class="form-group">
                                                                            <label> Customer Contact Number </label>
                                                                            <input type="text" name="enquiry_contact_number" id="enquiry_contact_number" class="form-control" size="50" placeholder="Customer Contact Number" value="<?php echo $first_contact_no;?>" readonly>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-3">
                                                                        <div class="form-group">
                                                                            <label> Customer State </label>
                                                                            <input type="text" name="enquiry_customer_state" id="enquiry_customer_state" class="form-control" size="50" placeholder="Customer State" value="<?php echo $state_name;?>" readonly>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-3">
                                                                        <div class="form-group">
                                                                            <label> Customer City </label>
                                                                            <input type="text" name="enquiry_customer_city" id="enquiry_customer_city" class="form-control" size="50" placeholder="Customer City" value="<?php echo $city_name;?>" readonly>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-3">
                                                                        <div class="form-group">
                                                                            <label> State Code </label>
                                                                            <input type="text" name="enquiry_state_code" id="enquiry_state_code" class="form-control" size="50" value="<?php echo $state_code;?>" placeholder="State Code" readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Product Make </label>
                                                            <input type="text" name="product_make" id="product_make" class="form-control" size="50" placeholder="Enter Product Make" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> <span style="color: #FF0000;"> Product Name * </span> </label>
                                                            <textarea class="form-control" id="product_name" name="product_name" rows="3" placeholder="Enter Product Name" readonly></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Serial Number </label>
                                                            <input type="text" name="serial_number" id="serial_number" class="form-control" size="50" placeholder="Enter Serial Number" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Invoice Number </label>
                                                            <input type="text" name="invoice_number" id="invoice_number" class="form-control" size="50" placeholder="Enter Invoice Number" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label> Comment </label>
                                                            <textarea class="form-control" id="comment" name="comment" rows="3" placeholder="Enter Comment" readonly></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card card-primary">
                                                            <div class="card-header">
                                                                <h3 class="card-title">Pre Dispatch Attachment</h3>
                                                            </div>
                                                            <div class="card-body">
                                                                <div  class="table-responsive">
                                                                    <table id="example1" class="table table-bordered table-striped">
                                                                        <thead>
                                                                            <th style="display: none;">Entity Id</th>
                                                                            <th>Sr No</th>
                                                                            <th>Attachment</th>
                                                                            <th>Uploaded On</th>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                                $no = 0;
                                                                                foreach ($predispatch_attachment_record as $row):
                                                                                    $no++; 
                                                                                    $relation_entity_id = $row->entity_id;
                                                                            ?>
                                                                                <tr>
                                                                                    <td style="display: none;" class="relation_entity_id" id="relation_entity_id"><?php echo $relation_entity_id;?></td>

                                                                                    <td><input type="text" value="<?php echo $no;?>" style="width: 70px; color: #000; border-style: none;background: none;" disabled></td>

                                                                                    <td><a target="_blank" href="<?php echo base_url();?>assets/predispatch_attachment/<?php echo $row->attachment_name;?>"><?php echo $row->attachment_name;?></a></td>

                                                                                    <td><input type="text" value="<?php echo date("d-m-Y", strtotime($row->uploaded_on));?>" style="width: 100px; color: #000; border-style: none;background: none;" disabled></td>
                                                                                </tr>
                                                                            <?php endforeach;?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
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
        <!-- DataTables -->
        <script src="<?php echo base_url().'assets/plugins/datatables/jquery.dataTables.js'?>"></script>
        <script src="<?php echo base_url().'assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js'?>"></script>
        <!-- Page script -->
        <script type="text/javascript">
            $(document).ready(function () {
                bsCustomFileInput.init();
            });
        </script>

        <script type="text/javascript">
            $(document).ready(function(){
                //call function get data edit
                get_data_edit();

                /*get_enquiry_product_data();*/
                //load data for edit
                function get_data_edit(){
                    var entity_id = $('[name="entity_id"]').val();
                    
                    $.ajax({
                        url : "<?php echo site_url('support/pre_dispatch_register/get_details_by_id');?>",
                        method : "POST",
                        data :{entity_id :entity_id},
                        async : true,
                        dataType : 'json',
                        success : function(data){
                            $.each(data, function(i, item){
                                console.log(data);
                                $val =
                                $('[name="product_make"]').val(data[i].product_make);
                                $('[name="product_name"]').val(data[i].product_name);
                                $('[name="serial_number"]').val(data[i].serial_number);
                                $('[name="invoice_number"]').val(data[i].invoice_number);
                                $('[name="comment"]').val(data[i].comment);

                                /*$('[name="ticket_type"]').val(data[i].ticket_type).trigger('change');*/
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

        <script>
           $(document).ready( function () {
                  $('#example1').DataTable();
                  $('#example2').DataTable();
            } );
        </script>
    </body>
</html>