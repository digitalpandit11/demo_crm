<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
if (!$_SESSION['user_name']) {
  header("location:dashboard");
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Select Clients For Campaign</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Data Tables -->
  <link rel="stylesheet" href="<?php echo base_url() . 'assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css' ?>">
  <!-- Font Awesome -->
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
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Navbar -->
    <?php
    $this->load->view('header_sidebar');

    $state_list = $this->db->select('*')->from('state_master')->get()->result();
    ?>
    <!-- <?php
          $first_date_of_month = date("Y-m-01");
          $end_date_of_month = date("Y-m-t");
          ?> -->
    <!-- /.navbar -->
    <!-- Main Sidebar Container -->
    <div class="content-wrapper">
      <!-- Content Wrapper. Contains page content -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="card">
            <div class="card-header">
              <h1 class="card-title">Edit Campaign</h1>
              <div class="col-sm-6">
                <br><br>
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?php echo base_url() . 'dashboard' ?>">Home</a></li>
                  <li class="breadcrumb-item"><a href="<?php echo base_url() . 'vw_campaign' ?>">Campaign Register</a>
                  </li>
                  <li class="breadcrumb-item">Edit Campaign</li>
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
                  <h3 class="card-title">Campaign Details </h3>
                </div>
                <div class="card-body" style="border-radius: 1.25rem;">
                  <form role="form" name="sales_register_report" action="<?php echo site_url('sales/campaign_register/update_campaign2'); ?>" method="post">
                    <div class="card-body">
                      <input type="hidden" name="campaign_id" id="campaign_id" class="form-control" size="50" value="<?php echo $campaign_details->entity_id; ?>">
                      <div class="row">
                        <div class="col-sm-2">
                          <div class="form-group">
                            <label> Campaign Number</label>
                            <input type="text" name="campaign_number" id="campaign_number" class="form-control" size="50" value="<?php echo $campaign_details->campaign_number; ?>" placeholder="Enter Campaign Number" required readonly>
                          </div>
                        </div>
                        <div class="col-sm-3">
                          <div class="form-group">
                            <label> Campaign Name <span style="color: #FF0000;">* Mandatory Field</span></label>
                            <input type="text" name="campaign_name" id="campaign_name" class="form-control" size="50" value="<?php echo $campaign_details->campaign_name; ?>" placeholder="Enter Campaign Name" required>
                          </div>
                        </div>


                        <div class="col-sm-2">
                          <div class="form-group">
                            <label> Assigne To <span style="color: #FF0000;">* Mandatory Field</span></label>
                            <select class="form-control select2bs4" style="width: 100%;" id="compaign_assign" name="compaign_assign" required>
                              <option value="">Selected Employee</option>
                              <?php
                              foreach ($employee_list as $emp) : ?>
                                <option value="<?php echo $emp->entity_id; ?>" <?php if ($campaign_details->user_id == $emp->entity_id) {
                                                                                  echo "selected";
                                                                                } ?>><?php echo $emp->emp_first_name; ?></option>
                              <?php
                              endforeach;
                              ?>
                            </select>
                          </div>
                        </div>

                        <div class="col-sm-2">
                          <div class="form-group">
                            <label> Start Date <span style="color: #FF0000;">* Mandatory Field</span></label>
                            <input type="date" name="start_date" id="start_date" class="form-control" value="<?php echo $campaign_details->start_date; ?>">
                          </div>
                        </div>

                        <div class="col-sm-2">
                          <div class="form-group">
                            <label> End Date <span style="color: #FF0000;">* Mandatory Field</span></label>
                            <input type="date" name="end_date" id="end_date" class="form-control" value="<?php echo $campaign_details->end_date; ?>">
                          </div>
                        </div>
                      </div>
                      <hr>
                      <section class="content">
                        <div class="container-fluid">
                          <div class="row">
                            <div class="col-md-12">
                              <!-- general form elements disabled -->
                              <div class="card card-primary">
                                <div class="card-header">
                                  <h3 class="card-title">TelePhone Call Master</h3>
                                  <?php $product_attachment = "csv_example.csv"; ?>
                                  <button style="width: 200px;  margin: auto;" type="button" class="btn btn-block btn-danger float-right"><a target="_blank" href="<?php echo base_url(); ?>assets/<?php echo $product_attachment; ?>">
                                      Download Example Sheet</a>
                                  </button>
                                </div>
                                <div>
                                  <div class="btn-group" style="margin-top: 15px; margin-left: 15px;">
                                    <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#add-contact-modal">Add Contacts</button>

                                  </div>

                                  <div class="btn-group" style="margin-top: 15px; margin-left: 15px;">
                                    <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#importModal">Import Contacts</button>
                                  </div>
                                </div>
                                <div class="card-body">
                                  <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                      <thead>
                                        <tr>
                                          <th>Sr. No.</th>
                                          <th>Client Name</th>
                                          <th>Email id</th>
                                          <th>Mobile Number</th>
                                          <th>Company Name</th>
                                          <th>State</th>
                                          <th>City</th>
                                          <th>Pin Code</th>
                                          <th>Website</th>
                                          <th>Source</th>
                                          <th>Category</th>
                                          <th>Designation</th>
                                          <th>Address</th>
                                          <th>Action</th>
                                        </tr>
                                      </thead>
                                      <tbody id="telephon_data">

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
                    <div class="col-sm-2">
                      <div class="form-group">
                        <label>Status<span style="color: #FF0000;"></span></label>
                        <select class="form-control select2bs4" style="width: 100%;" id="compaign_status" name="compaign_status" required>
                          <option value="">Select Status</option>
                          <option value="1" <?php if ($campaign_details->status == 1) {
                                              echo "selected";
                                            } ?>>Active</option>
                          <option value="2" <?php if ($campaign_details->status == 2) {
                                              echo "selected";
                                            } ?>>Stopped</option>
                          <option value="3" <?php if ($campaign_details->status == 3) {
                                              echo "selected";
                                            } ?>>Complete</option>
                        </select>
                      </div>
                    </div>
                    <button style="margin-left: 500px;" type="submit" class="btn btn-primary">Save</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <?php $this->load->view('footer'); ?>
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>


  <!-- ./wrapper -->
  <!-- import conntact -->
  <div class="modal fade" id="importModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Upload Csv file</h4>
        </div>
        <div class="modal-body">
          <form role="form" name="client_info" action="<?php echo site_url('sales/campaign_register/uploadData'); ?>" method="post" enctype="multipart/form-data">

            <div class="col-lg-12">
              <div class="form-group">
                <input type="text" name="campaign_id" id="campaign_id" class="filestyle" value="<?php echo $campaign_details->entity_id; ?>" data-icon="false" readonly>
              </div>
            </div>

            <div class="col-lg-12">
              <div class="form-group">
                <input type="file" name="file" id="file" class="filestyle" data-icon="false">
              </div>
            </div>

            <div class="col-lg-12">
              <input type='submit' value='Upload' name='upload'>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


  <!-- ./wrapper -->
  <!-- import conntact -->
  <div class="modal modal-fade" id="add-contact-modal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Contact</h4>
        </div>
        <div class="modal-body">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Add Contact</h3>
            </div>
            <div class="card-body" style="border-radius: 1.25rem;">
              <form role="form" name="telephone_register_form" id="telephone_register_form" action="<?php echo site_url('sales/campaign_register/add_contact'); ?>" method="post">
                <input type="hidden" name="modal_campaign_id" id="modal_campaign_id" class="form-control" size="50" value="<?php echo $campaign_details->entity_id; ?>">
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label style="color: #FF0000;">Company Name * </label>
                      <input type="text" class="form-control" name="company_name" id="company_name" placeholder="Enter Company Name" required>
                    </div>
                  </div>

                  <div class="col-sm-6">
                    <div class="form-group">
                      <label style="color: #FF0000;">Client Name * </label>
                      <input type="text" class="form-control" name="client_name" id="client_name" placeholder="Enter Client Name" required>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label>Email</label>
                      <input type="email" class="form-control" name="email_address" id="email_address" placeholder="Enter Email Address">
                    </div>
                  </div>

                  <div class="col-sm-4">
                    <div class="form-group">
                      <label>Mobile Number</label>
                      <input type="text" class="form-control" name="mobile_number" id="mobile_number" placeholder="Enter Mobile Number">
                    </div>
                  </div>

                  <div class="col-sm-4">
                    <div class="form-group">
                      <label>Source</label>
                      <input type="text" class="form-control" name="source" id="source" placeholder="Enter Source">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label>Designation</label>
                      <input type="text" class="form-control" name="designation" id="designation" placeholder="Enter Designation">
                    </div>
                  </div>

                  <div class="col-sm-4">
                    <div class="form-group">
                      <label>Remark</label>
                      <textarea class="form-control" id="remark" name="remark" rows="3" placeholder="Enter Remark"></textarea>
                    </div>
                  </div>

                  <div class="col-sm-4">
                    <div class="form-group">
                      <label>Address</label>
                      <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter Address"></textarea>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label>State</label>
                      <input type="text" class="form-control" name="state" id="state" placeholder="Enter State">
                    </div>
                  </div>

                  <div class="col-sm-4">
                    <div class="form-group">
                      <label>City</label>
                      <input type="text" class="form-control" name="city" id="city" placeholder="Enter City">
                    </div>
                  </div>

                  <div class="col-sm-4">
                    <div class="form-group">
                      <label>Pin Code</label>
                      <input type="text" class="form-control" name="pin_code" id="pin_code" placeholder="Enter Pin Code">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Website</label>
                      <input type="text" class="form-control" name="website" id="website" placeholder="Enter Website">
                    </div>
                  </div>

                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Category</label>
                      <input type="text" class="form-control" name="category" id="category" placeholder="Enter Category">
                    </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button id="add_contact" type="submit" class="btn btn-default">Add</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- jQuery -->
  <script src="<?php echo base_url() . 'assets/plugins/jquery/jquery.min.js' ?>"></script>
  <!-- Bootstrap 4 -->
  <script src="<?php echo base_url() . 'assets/plugins/bootstrap/js/bootstrap.bundle.min.js' ?>"></script>
  <!-- Select2 -->
  <script src="<?php echo base_url() . 'assets/plugins/select2/js/select2.full.min.js' ?>"></script>
  <!-- Bootstrap4 Duallistbox -->
  <script src="<?php echo base_url() . 'assets/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js' ?>"></script>
  <!-- InputMask -->
  <script src="<?php echo base_url() . 'assets/plugins/moment/moment.min.js' ?>"></script>
  <script src="<?php echo base_url() . 'assets/plugins/inputmask/min/jquery.inputmask.bundle.min.js' ?>"></script>
  <!-- date-range-picker -->
  <script src="<?php echo base_url() . 'assets/plugins/daterangepicker/daterangepicker.js' ?>"></script>
  <!-- bootstrap color picker -->
  <script src="<?php echo base_url() . 'assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js' ?>"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="<?php echo base_url() . 'assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js' ?>"></script>
  <!-- Bootstrap Switch -->
  <script src="<?php echo base_url() . 'assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js' ?>"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo base_url() . 'assets/dist/js/adminlte.min.js' ?>"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="<?php echo base_url() . 'assets/dist/js/demo.js' ?>"></script>
  <!-- DataTables -->
  <script src="<?php echo base_url() . 'assets/plugins/datatables/jquery.dataTables.js' ?>"></script>
  <script src="<?php echo base_url() . 'assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js' ?>"></script>
  <!-- Page script -->


  <script>
    $(document).ready(function() {

      campaign_id = $('#campaign_id').val();

      $.ajax({
        url: "<?php echo base_url('sales/campaign_register/fetch_campaign_telephone_numbers'); ?>",
        data: {
          campaign_id: campaign_id
        },
        method: "post",
        async: true,
        dataType: 'json',
        success: function(data) {
          console.log(data);
          console.log(data[0].client_name);

          html = '';
          no = 0;
          for (var count = 0; count < data.length; count++) {
            no++;
            console.log(data[count]);

            html += '<tr>';
            html += '<td class = "table_data" data-row_id = "' + data[count].entity_id + '"data-column_name = "entity_id" style = "display: none">' + data[count].entity_id + '</td>';
            html += '<td class = "table_data bg-secondary" data-row_id = "' + data[count].entity_id + '"data-column_name = "sr_no" >' + no + '</td>';
            html += '<td class = "table_data" data-row_id = "' + data[count].entity_id + '"data-column_name = "client_name" >' + data[count].client_name + '</td>';
            html += '<td class = "table_data" data-row_id = "' + data[count].entity_id + '"data-column_name = "email" >' + data[count].email + '</td>';
            html += '<td class = "table_data" data-row_id = "' + data[count].entity_id + '"data-column_name = "mobile" >' + data[count].mobile + '</td>';
            html += '<td class = "table_data" data-row_id = "' + data[count].entity_id + '"data-column_name = "company_name" >' + data[count].company_name + '</td>';
            html += '<td class = "table_data" data-row_id = "' + data[count].entity_id + '"data-column_name = "state" >' + data[count].state + '</td>';
            html += '<td class = "table_data" data-row_id = "' + data[count].entity_id + '"data-column_name = "city" >' + data[count].city + '</td>';
            html += '<td class = "table_data" data-row_id = "' + data[count].entity_id + '"data-column_name = "pincode" >' + data[count].pincode + '</td>';
            html += '<td class = "table_data" data-row_id = "' + data[count].entity_id + '"data-column_name = "website" >' + data[count].website + '</td>';
            html += '<td class = "table_data" data-row_id = "' + data[count].entity_id + '"data-column_name = "source" >' + data[count].source + '</td>';
            html += '<td class = "table_data" data-row_id = "' + data[count].entity_id + '"data-column_name = "category" >' + data[count].category + '</td>';
            html += '<td class = "table_data" data-row_id = "' + data[count].entity_id + '"data-column_name = "designation" >' + data[count].designation + '</td>';
            html += '<td class = "table_data" data-row_id = "' + data[count].entity_id + '"data-column_name = "address" >' + data[count].address + '</td>';
            // html += '<td class = "table_data" data-row_id = "' + data[count].entity_id + '"data-column_name = "remark" >' + data[count].remark + '</td>';
            // html += '<td class = "table_data" data-row_id = "' + data[count].entity_id + '"data-column_name = "status" >' + data[count].status + '</td>';

            html += '<td class = "bg-secondary"><button type = "button" name = "delete_btn" id = "' + data[count].entity_id + '" class = "btn btn-xs btn-danger"><i class="fas fa-trash"></i></button></td></tr>';



          }

          $('#telephon_data').html(html);
        }



      });




    });
  </script>







  <script>
    $(function() {
      //Initialize Select2 Elements
      $('.select2').select2()

      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })

      //Datemask dd/mm/yyyy
      $('#datemask').inputmask('dd/mm/yyyy', {
        'placeholder': 'dd/mm/yyyy'
      })
      //Datemask2 mm/dd/yyyy
      $('#datemask2').inputmask('mm/dd/yyyy', {
        'placeholder': 'mm/dd/yyyy'
      })
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
      $('#daterange-btn').daterangepicker({
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate: moment()
        },
        function(start, end) {
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

      $("input[data-bootstrap-switch]").each(function() {
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
      });
    })
  </script>
</body>

</html>