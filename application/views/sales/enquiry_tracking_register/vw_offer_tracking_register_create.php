<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
if (!$_SESSION['user_name']) {
  header("location:welcome");
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Create Offer Tracking Record</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
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
    <?php

    $this->load->view('header_sidebar');

    $this->db->select('*');
    $this->db->from('enquiry_tracking_master');
    $where = '(enquiry_tracking_master.offer_id = "' . $entity_id . '" And enquiry_tracking_master.status = "' . '1' . '")';
    $this->db->where($where);
    $this->db->order_by('entity_id', 'DESC');
    $this->db->limit(1);
    $query = $this->db->get();
    $query_result = $query->row();

    $Tracking_number = $query_result->tracking_number;
    $Enquiry_id = $query_result->enquiry_id;
    $Customer_id = $query_result->customer_id;

    $trackin_sts = $query_result->status;

    if ($trackin_sts == 1) {
      $Tracking_status = "Pending";
    } else {
      $Tracking_status = "Completed";
    }

    $this->db->select('*');
    $this->db->from('customer_master');
    $where = '(customer_master.entity_id = "' . $Customer_id . '")';
    $this->db->where($where);
    $customer_data = $this->db->get();
    $customer_data_result = $customer_data->row();

    $Customer_name = $customer_data_result->customer_name;

    if (!empty($Enquiry_id)) {
      $this->db->select('*');
      $this->db->from('enquiry_register');
      $where = '(enquiry_register.entity_id = "' . $Enquiry_id . '")';
      $this->db->where($where);
      $enquiry_data = $this->db->get();
      $enquiry_data_result = $enquiry_data->row();

      $Enquiry_number = $enquiry_data_result->enquiry_no;
    } else {
      $Enquiry_number = "NA";
    }

    $this->db->select('*');
    $this->db->from('offer_register');
    $where = '(offer_register.entity_id = "' . $entity_id . '")';
    $this->db->where($where);
    $offer_data = $this->db->get();
    $offer_data_result = $offer_data->row();

    $Offer_number = $offer_data_result->offer_no;
    $Offer_description = $offer_data_result->offer_description;

    $val = $offer_data_result->status;

    $this->db->select_sum('total_amount_with_gst');
    $this->db->from('offer_product_relation');
    $where = '(offer_product_relation.offer_id = "' . $entity_id . '")';
    $this->db->where($where);
    $product_amount = $this->db->get();
    $product_amount_result =  $product_amount->row_array();

    if (!empty($product_amount_result)) {
      $product_amount_without_gst_format = $product_amount_result['total_amount_with_gst'];
      $Product_amt = number_format((float)$product_amount_without_gst_format, 2, '.', '');
    } else {
      $Product_amt = 0;
    }


    $Service_amt = 0;

    $Offer_order_val = $Product_amt + $Service_amt;
    $Offer_order_amount = number_format((float)$Offer_order_val, 2, '.', '');

    date_default_timezone_set("Asia/Calcutta");
    $todays_date = date('Y-m-d');

    ?>
    <div class="content-wrapper">
      <!-- Content Wrapper. Contains page content -->
      <section class="content-header">
        <div class="container-fluid">
          <br>
          <!-- <div class="card" style="background-color: #20c997;"> -->
          <div class="card">
            <div class="card-header">
              <h1 class="card-title">Create Offer Tracking</h1>
              <div class="col-sm-6">
                <br><br>
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?php echo base_url() . 'dashboard' ?>">Home</a></li>
                  <li class="breadcrumb-item"><a href="<?php echo base_url() . 'vw_tracking_data_entry' ?>">Quote Follow up</a></li>
                </ol>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="content">
        <div class="container-fluid">
          <div class="col-md-12">
            <!-- general form elements disabled -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Offer Section</h3>
              </div>
              <div class="card-body">
                <form role="form" name="enquiry_tracking_form" enctype="multipart/form-data" action="<?php echo site_url('sales/enquiry_tracking_register/save_offer_tracking'); ?>" method="post">

                <input type="hidden" id="offer_entity_id" name="offer_entity_id" value="<?php echo $entity_id ?>" required>

                <input type="hidden" id="enquiry_entity_id" name="enquiry_entity_id" value="<?php echo $entity_id ?>" required>
                <div class="row">


                  <div class="col-sm-3">
                    <div class="form-group">
                      <label style="color: #FF0000;"> Offer Number *</label>
                      <input type="text" name="offer_number" id="offer_number" class="form-control" value="<?php echo $Offer_number ?>" size="50" placeholder="Enter Offer Number" readonly>
                    </div>
                  </div>

                  <div class="col-sm-3">
                    <div class="form-group">
                      <label style="color: #FF0000;"> Enquiry Number *</label>
                      <input type="hidden" name="enquiry_id" id="enquiry_id" class="form-control" value="<?php echo $Enquiry_id ?>">

                      <input type="text" name="enquiry_number" id="enquiry_number" class="form-control" value="<?php echo $Enquiry_number ?>" size="50" placeholder="Enter Enquiry Number" readonly>
                    </div>
                  </div>

                  <div class="col-sm-3">
                    <div class="form-group">
                      <label style="color: #FF0000;"> Customer Name *</label>
                      <input type="hidden" name="customer_id" id="customer_id" class="form-control" value="<?php echo $Customer_id ?>">

                      <input type="text" name="customer_name" id="customer_name" class="form-control" value="<?php echo $Customer_name ?>" size="50" placeholder="Enter Customer Name" readonly>
                    </div>
                  </div>

                  <div class="col-sm-3">
                    <div class="form-group">
                      <label> Offer Value </label>
                      <input type="text" name="offer_value" id="offer_value" class="form-control" value="<?php echo $Offer_order_amount ?>" size="50" readonly>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-3">
                    <div class="form-group">
                      <label> Offer Description </label>
                      <textarea class="form-control" id="offer_descrption" name="offer_descrption" rows="3" placeholder="Offer Description" readonly><?php echo $Offer_description; ?></textarea>
                    </div>
                  </div>
												<div class="col-sm-3">
													<div class="form-group">
														<label style="color: #FF0000;"> Quotation Status *</label>
														<select class="form-control" style="width: 100%;" id="offer_status" name="offer_status" required>
															<option value="">Not Selected</option>
															<?php foreach ($stage_list as $row): ?>
															<option value="<?= $row->status_value; ?>" <?= ($row->status_value == $val) ? "selected" : "" ;?>><?= $row->status_name; ?></option>
														<?php endforeach; ?>
														</select>
													</div>
												</div>
	
												<div class="col-sm-3" id="Offer_reason_text">
													<div class="form-group">
														<label><span style="color: #FF0000;">Won / Loss Reason *</span></label>
														<select class="form-control" style="width: 100%;" id="offer_reason" name="offer_reason" required>
														<option value="99" active >NA</option>
														<?php foreach ($offer_reason_list as $row): ?>
															<option value="<?= $row->status_value; ?>" ><?= $row->status_name; ?></option>
														<?php endforeach; ?>
														</select>
													</div>
												</div>
											
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <!-- general form elements disabled -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Offer Tracking Details Form</h3>
                </div>
                <div class="card-body">
                  
                    <div class="row">
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label> Tracking Number </label>
                          <input type="text" name="tracking_number" id="tracking_number" class="form-control" value="<?php echo $Tracking_number ?>" size="50" placeholder="Enter Tracking Number" readonly>
                        </div>
                      </div>

                      <div class="col-sm-3">
                        <div class="form-group">
                          <label style="color: #FF0000;"> Tracking Date *</label>
                          <input type="date" name="tracking_date" id="tracking_date" required class="form-control" value="<?php echo $todays_date; ?>" size="50">
                        </div>
                      </div>

                    </div>

                    <div class="row">

                    </div>

                    <div class="row">

                      <div class="col-sm-3">
                        <div class="form-group">
                          <label style="color: #FF0000;"> Tracking Description * </label>
                          <textarea class="form-control" id="tracking_descrption" name="tracking_descrption" rows="3" placeholder="Enter Tracking Description" required></textarea>
                        </div>
                      </div>

                      <!-- <div class="col-sm-3">
                        <div class="form-group">
                          <label style="color: #FF0000;"> Next Action * </label>
                          <textarea class="form-control" id="tracking_next_action" name="tracking_next_action" rows="3" placeholder="Enter Tracking Next Action" required></textarea>
                        </div>
                      </div> -->

                      <div class="col-sm-3">
                        <div class="form-group">
                          <label style="color: #FF0000;"> Action Due Date *</label>
                          <input type="date" name="action_due_date" id="action_due_date" required class="form-control" size="50">
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
                </form>

                <div class="col-md-12">
                  <!-- general form elements disabled -->
                  <div class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">Tracking History</h3>
                    </div>
                    <div class="card-body">

                      <div class="table-responsive">
                        <table id="example12" class="table table-bordered table-striped">
                          <tr>
                            <th> Tracking Number</th>
                            <th> Tracking Date</th>
                            <th> Tracking Record</th>
                            <th> Action Status</th>
                            <th> Action </th>
                          </tr>
                        </table>
                      </div>
                    </div>


                    <!-- <div class="card-body">
                                                <div  class="table-responsive">
                                                <table id="example14" class="table table-bordered table-striped">
                                                    <tr>
                                                        <th>Enquiry Tracking Number</th>
                                                        <th>Enquiry Tracking Date</th>
                                                        <th>Enquiry Tracking Record</th>
                                                       
                                                    </tr>
                                                </table>
                                            </div>
                                            </div> -->
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
  <!-- bs-custom-file-input -->
  <script src="<?php echo base_url() . 'assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js' ?>"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo base_url() . 'assets/dist/js/adminlte.min.js' ?>"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="<?php echo base_url() . 'assets/dist/js/demo.js' ?>"></script>
  <!-- Page script -->
  <script type="text/javascript">
    $(document).ready(function() {
      //call function get data edit
      get_data_edit();

      //load data for edit
      function get_data_edit() {
        var entity_id = $('[name="offer_entity_id"]').val();

        $.ajax({
          url: "<?php echo site_url('sales/enquiry_tracking_register/get_offer_tracking_data_by_offer_id'); ?>",
          method: "POST",
          data: {
            entity_id: entity_id
          },
          async: true,
          dataType: 'json',
          success: function(data) {
            console.log(data);
            var trHTML = '';
            $.each(data, function(i, item) {
              //bill_link = 'http://shreeautocare.com/erp/view_invoice/'+ item.Bill_id;
              trHTML += '<tr><td>' + item.tracking_number + '</td><td>' + item.tracking_date + '</td><td>' + item.tracking_record + '<br>' + item.next_action + '</td><td>' + item.status + '</td><td>action</td></tr>';
            });
            $('#example12').append(trHTML);
          }
        });
      }
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
