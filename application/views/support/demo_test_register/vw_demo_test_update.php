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
        <title>Update Demo Test</title>
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

                $this->db->select('demotest_attachment.*');
                $this->db->from('demotest_attachment');
                $where = '(demotest_attachment.demo_test_id = "'.$entity_id.'")';
                $this->db->where($where);
                $demotest_attachment = $this->db->get();
                $demotest_attachment_record = $demotest_attachment->result();
            ?>
                <div class="content-wrapper">
                    <!-- Content Wrapper. Contains page content -->
                    <section class="content-header">
                        <div class="container-fluid">
                            <br>
                            <!-- <div class="card" style="background-color: #20c997;"> -->
                            <div class="card">
                                <div class="card-header" >
                                    <h1 class="card-title">Update Demo Test</h1>
                                    <div class="col-sm-6">
                                        <br><br>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'vw_demotest_data'?>">Demo Test</a></li>
                                            <li class="breadcrumb-item">Update Demo Test Of Id :- <?php  echo $entity_id; ?> </li>
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
                                            <h3 class="card-title">Demo Test Details Form</h3>
                                        </div>
                                        <div class="card-body">
                                            <form role="form" id="demotest_form" name="demotest_form" enctype="multipart/form-data" action="<?php echo site_url('support/demo_test_register/edit_demo_test');?>" method="post">
                                                
                                                <input type="hidden" id="entity_id" name="entity_id" value="<?php echo $entity_id?>" required>

                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;">Category * </label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="category_id" name="category_id" required>
                                                                <option value="">Select Category</option>
                                                                <?php foreach($product_category as $row):?>
                                                                <option value="<?php echo $row->entity_id;?>"><?php echo $row->category_name;?></option>
                                                                <?php endforeach;?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label> Product Make </label>
                                                            <input type="text" name="product_make" id="product_make" class="form-control" size="50" placeholder="Enter Product Make">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Product Name *</label>
                                                            <textarea class="form-control" id="product_name" name="product_name" rows="3" placeholder="Enter Product Name" required></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Test Name *</label>
                                                            <input type="text" name="test_name" id="test_name" class="form-control" placeholder="Enter Test Name" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">   
                                                            <label for="attachment">Attachment</label>
                                                            <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" name="attachment[]"  id="attachment" multiple>
                                                                    <label class="custom-file-label" for="attachment">Choose Attachment</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card-body">
                                                    <center>
                                                        <button type="submit" class="btn btn-success toastrDefaultSuccess">
                                                            Submit
                                                        </button>
                                                    </center>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card card-primary">
                                                            <div class="card-header">
                                                                <h3 class="card-title">Demo Test Attachment</h3>
                                                            </div>
                                                            <div class="card-body">
                                                                <div  class="table-responsive">
                                                                    <table id="example1" class="table table-bordered table-striped">
                                                                        <thead>
                                                                            <th style="display: none;">Entity Id</th>
                                                                            <th>Sr No</th>
                                                                            <th>Attachment</th>
                                                                            <th>Uploaded On</th>
                                                                            <th>Action</th>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                                $no = 0;
                                                                                foreach ($demotest_attachment_record as $row):
                                                                                    $no++; 
                                                                                    $relation_entity_id = $row->entity_id;
                                                                            ?>
                                                                                <tr>
                                                                                    <td style="display: none;" class="relation_entity_id" id="relation_entity_id"><?php echo $relation_entity_id;?></td>

                                                                                    <td><input type="text" value="<?php echo $no;?>" style="width: 70px; color: #000; border-style: none;background: none;" disabled></td>

                                                                                    <td><a target="_blank" href="<?php echo base_url();?>assets/demotest_attachment/<?php echo $row->attachment_name;?>"><?php echo $row->attachment_name;?></a></td>

                                                                                    <td><input type="text" value="<?php echo date("d-m-Y", strtotime($row->uploaded_on));?>" style="width: 100px; color: #000; border-style: none;background: none;" disabled></td>

                                                                                    <td>
                                                                                        <a class="btn btn-sm btn-danger" onclick="delete_attachment(<?php echo $relation_entity_id; ?>)"><i class="fas fa-trash"></i> </a>
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
                        url : "<?php echo site_url('support/demo_test_register/get_details_by_id');?>",
                        method : "POST",
                        data :{entity_id :entity_id},
                        async : true,
                        dataType : 'json',
                        success : function(data){
                            $.each(data, function(i, item){
                                console.log(data);
                                $val =
                                $('[name="category_id"]').val(data[i].category_id).trigger('change');
                                $('[name="product_make"]').val(data[i].product_make);
                                $('[name="product_name"]').val(data[i].product_name);
                                $('[name="test_name"]').val(data[i].test_name);
                            });
                        }
                    });
                }
            });
        </script>

        <script type="text/javascript">
            function delete_attachment(d){
                var id=d;
                $.ajax({
                    url : "<?php echo site_url('support/demo_test_register/delete_attachment');?>",
                    type : "POST",
                    data: {'id': id},
                    success : function(data) {
                        location.reload(true);
                    },
                    error : function(data) {
                        alert("Failed!!");
                    }
                });
            }
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