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
  <title>Create Lead</title>
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
    ?>
    <div class="content-wrapper">
      <!-- Content Wrapper. Contains page content -->
      <section class="content-header">
        <div class="container-fluid">
          <br>
          <!-- <div class="card" style="background-color: #20c997;"> -->
          <div class="card">
            <div class="card-header">
              <h1 class="card-title">Create Lead</h1>
              <div class="col-sm-6">
                <br><br>
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?php echo base_url() . 'dashboard' ?>">Home</a></li>
                  <li class="breadcrumb-item"><a href="<?php echo base_url() . 'vw_enquiry_data' ?>">Lead Register</a></li>
                  <li class="breadcrumb-item">Enter Lead Details</li>
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
                  <h3 class="card-title">Lead Details Form</h3>
                </div>
                <div class="card-body">
                  <form role="form" name="enquiry_form" enctype="multipart/form-data" action="<?php echo site_url('sales/enquiry_register/save_lead_data'); ?>" method="post">

                    <input type="hidden" id="customer_id" name="customer_id">

                    <div class="row">
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label style="color: #FF0000;"> Customer Email Id *</label>
                          <input type="text" name="enquiry_email_id" id="enquiry_email_id" class="form-control" size="30" placeholder="Customer Email Id" required>
                        </div>
                      </div>
                    </div>

                    <div id="showcontact"></div>
                    <!-- <div class="row">
                                                    <div class="col-md-12"> -->
                    <!-- general form elements disabled -->
                    <!-- <div class="card card-primary">
                      <div class="card-header">
                          <h3 class="card-title"> Contact Details</h3>
                      </div> -->

                    <!-- <div class="card-body">
                      <div  class="table-responsive">
                          <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                
                                  <th>Cust_address_Entity_id</th>
                                  <th>Contact Person</th>
                                  <th>Email Id</th>
                                  <th>Fisrt Contact No</th>
                                  <th>Second Contact No</th>
                                  <th>Customer Name</th></th>
                                  <th>Customer Type</th>
                                  <th>Address</th>
                                  <th>State</th>
                                  <th>City</th>
                                  <th>Pincode</th>
                                  <th>Action</th>
                                </tr>
                              
                            </thead>
                            <tbody id ="showdata"> -->

                        <!-- </tbody>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
      </div> -->



                    <div class="row">
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label style="color: #FF0000;"> Customer Contact Number * </label> <a href="#" title="Acceptable Mobile Number formats- 
                                                            9822558876
                                                            +919822558876
                                                            +91-9822558876
                                                            +91 9822558876
                                                            +, -, & space can only be used with country code" data-toggle="popover" data-trigger="click" data-content="Click anywhere in the document to close this popover">Acceptable Formats</a>
                          <input type="text" name="enquiry_contact_number" id="enquiry_contact_number" class="form-control" size="30" placeholder="Customer Contact Number" required>
                          <span id="lblError" class="error">Invalid Number - Please check 'Acceptable Formats' </span>
                        </div>
                      </div>
                    </div>

                    <div id="showcompany"></div>



                    <div class="row">
                      <div class="col-md-12">
                        <div class="card card-primary">
                          <div class="card-header">
                            <h3 id="other_data" class="card-title"> Other Details</h3>
                          </div>
                          <div class="card-body">

                            <div class="row">
                              <div class="col-sm-4">
                                <div class="form-group">
                                  <label style="color: #FF0000;"> Contact Person *</label>
                                  <input type="text" name="enquiry_contact_person" id="enquiry_contact_person" class="form-control" size="50" placeholder="Customer Contact Person" required>
                                </div>
                              </div>


                              <div class="col-sm-4">
                                <div class="form-group">
                                  <label style="color: #FF0000;"> Customer Name (Company) *</label>
                                  <input type="text" name="customer_name" id="customer_name" class="form-control" size="50" placeholder="Enter Customer Name" required>
                                </div>
                              </div>

                              <div class="col-sm-4">
                                <div class="form-group">
                                  <label style="color: #FF0000;"> Customer Type *</label>
                                  <select class="form-control select2bs4" style="width: 100%;" id="customer_type" name="customer_type" required>
                                    <option value="">No Selected</option>
                                    <option value="1">Dealer</option>
                                    <option value="2">End User</option>
                                    <option value="3">OEM</option>
                                    <option value="4">Trader</option>
                                    <option value="5">System Integrator</option>
                                  </select>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-sm-4">
                                <div class="form-group">
                                  <label style="color: #FF0000;"> Address *</span> </label>
                                  <textarea class="form-control" id="address" name="address" rows="4" placeholder="Enter Address" required></textarea>
                                </div>
                              </div>

                              <div class="col-sm-8">



                                <div class="row">
                                  <div class="col-sm-4">
                                    <div class="form-group">
                                      <label style="color: #FF0000;">State Name *</label>
                                      <select class="form-control select2bs4" style="width: 100%;" id="state_id" name="state_id" required>
                                        <option value="">Select State</option>
                                        <?php foreach ($state_list as $row) : ?>
                                          <option value="<?php echo $row->entity_id; ?>"><?php echo $row->state_name; ?></option>
                                        <?php endforeach; ?>
                                      </select>
                                    </div>
                                  </div>


                                  <div class="col-sm-4">
                                    <div class="form-group">
                                      <label style="color: #FF0000;">City Name *</label>
                                      <select class="form-control select2bs4" style="width: 100%;" id="city_id" name="city_id" required>
                                        <option value="">Select City</option>
                                      </select>
                                    </div>
                                  </div>

                                  <div class="col-sm-4">
                                    <div class="form-group">
                                      <label style="color: #FF0000;">State Code *</label>
                                      <input type="text" name="state_code" id="state_code" class="form-control" size="50" placeholder="State Code" readonly>
                                    </div>
                                  </div>
                                </div>

                                <div class="row">

                                 

                                  <div class="col-sm-4">
                                    <div class="form-group">
                                      <label> Pin Code </label>
                                      <input type="number" name="customer_pin_code" id="customer_pin_code" class="form-control" size="50" placeholder="Enter Customer Pin Code">
                                    </div>
                                  </div>

                                  <div class="col-sm-4">
                                    <div class="form-group">
                                        <label> GST Number </label>
                                        <input type="text" name="customer_gst_number" id="customer_gst_number" class="form-control" size="50" placeholder="Enter GST Number">
                                    </div>
                                </div>


                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label> Pan Number </label>
                                        <input type="text" name="customer_pan_number" id="customer_pan_number" class="form-control" size="50" placeholder="Enter Pan Number">
                                    </div>
                                </div>
                                
                                </div>
                              </div>
                            </div>



                              <div class="row">
                                <div class="col-sm-6">
                                  <div class="form-group">
                                    <label style="color: #FF0000;"> Lead Description *</label>
                                    <textarea class="form-control" id="enquiry_descrption" name="enquiry_descrption" rows="3" placeholder="Enter Lead Description" required></textarea>
                                  </div>
                                </div>

                                <div class="col-sm-6">
                                  <div class="form-group">
                                    <label style="color: #FF0000;"> Select Sales Engineer *</label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="employee_id" name="employee_id" required>
                                      <option value="">No Selected</option>
                                      <?php foreach ($employee_list as $row) : ?>
                                        <option value="<?php echo $row->entity_id; ?>"><?php echo $row->Emp_name; ?></option>
                                      <?php endforeach; ?>
                                    </select>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                               

                                
                              </div>

                              <div class="row">
                                <div class="col-sm-3">
                                  <div class="form-group">
                                    <label style="color: #FF0000;"> Lead Type *</label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="enquiry_type" name="enquiry_type" required>
                                      <option value="5">Other (OT)</option>
                                    </select>
                                  </div>
                                </div>

                                <div class="col-sm-3">
                                  <div class="form-group">
                                    <label style="color: #FF0000;"> Lead Source *</label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="enquiry_source" name="enquiry_source" required>
                                      <option value="">No Selected</option>
                                      <?php foreach ($source_list as $row) : ?>
                                        <option value="<?php echo $row->entity_id; ?>"><?php echo $row->source_name; ?></option>
                                      <?php endforeach; ?>
                                    </select>
                                  </div>
                                </div>

                                <div class="col-sm-3">
                                  <div class="form-group">
                                    <label style="color: #FF0000;"> Lead Urgency *</label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="enquiry_urgency" name="enquiry_urgency" required>
                                      <option value="">Select</option>
                                      <option value="1">Cold Call </option>
                                      <option value="2">Live Enquiry / Budgatory</option>
                                      <option value="3">Hot Lead</option>
                                    </select>
                                  </div>
                                </div>

                                <div class="col-sm-3">
                                  <div class="form-group">
                                    <label for="employee_attachment">Attachment</label>
                                    <div class="input-group">
                                      <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="employee_attachment[]" multiple id="employee_attachment">
                                        <label class="custom-file-label" for="employee_attachment">Choose Attachment</label>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>

                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="card-body">
                        <center>
                          <button type="submit" id="lead_submit" name="lead_submit" class="btn btn-success toastrDefaultSuccess" disabled>
                            Submit
                          </button>
                        </center>
                      </div>
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
      bsCustomFileInput.init();
    });
  </script>

  <script type="text/javascript">
    $(document).ready(function() {
      //call function get data edit
      get_customer_details();

      //load data for edit
      function get_customer_details() {
        var id = $('[name="customer_id_for_enquiry"]').val();

        $.ajax({
          url: "<?php echo site_url('sales/enquiry_register/get_all_customer_data'); ?>",
          method: "POST",
          data: {
            id: id
          },
          async: true,
          dataType: 'json',
          success: function(data) {
            $.each(data, function(i, item) {
              console.log(data);
              $val =
                $('[name="customer_name"]').val(data[i].Contact_id).trigger('change');
            });
          }
        });
      }
    });
  </script>

  <script type="text/javascript">
    $(document).on('keyup change', '#enquiry_email_id', function() {
      var id = $(this).val();
      var baseurl = "<?php echo site_url('create_offer_from_contact/'); ?>";
      $.ajax({
        url: "<?php echo site_url('sales/enquiry_register/get_customer_details_by_email_id'); ?>",
        method: "POST",
        data: {
          id: id
        },
        async: true,
        dataType: 'json',
        success: function(data) {
          console.log(data);
          var html = '';
          var i = 0;
          if (data) {
            html += '<div class="row"><div class="col-md-12"><div class="card-body"><div  class="table-responsive"><table id="example1" class="table table-bordered table-striped"><thead><tr><th>Customer_id</th><th>Customer Name(Company)</th><th>Contact Person</th><th>Email Id</th><th>Fisrt Contact No</th><th>Second Contact No</th></th><th>State</th><th>City</th><th>Address</th><th>Pincode</th><th>Action</th></tr></thead><tbody>';

            for (i in data) {


              html += "<tr><td>" + data[i].Customer_id + "</td><td>" + data[i].customer_name + "</td><td>" + data[i].contact_person + "</td><td>" + data[i].email_id + "</td><td>" + data[i].first_contact_no + "</td><td>" + data[i].second_contact_no + "</td><td>" + data[i].state_name + "</td><td>" + data[i].city_name + "</td><td>" + data[i].address + "</td><td>" + data[i].pin_code + "</td><td><a href='" + baseurl + data[i].Contact_id + "'class='btn btn-sm btn-danger'><i class='fas fa-arrow-right'></i></a></td></tr>";

              // <a href="" class="btn btn-sm btn-danger"><i class="fas fa-arrow-right"></i></a>

            }
            html += "</tbody></table></div></div></div></div>";
            $('#showcontact').html(html);

          } else {
            $('#showcontact').html('');
          }
          // $.each(data, function(i, item){
          //     console.log(data);
          //     $val = 
          //     $('[name="customer_id"]').val(data[i].Customer_id);
          //     $('[name="enquiry_contact_person"]').val(data[i].contact_person);
          //     $('[name="enquiry_email_id"]').val(data[i].email_id);
          //     $('[name="enquiry_contact_number"]').val(data[i].first_contact_no);
          //     $('[name="customer_name"]').val(data[i].customer_name);

          //     $('[name="customer_type"]').val(data[i].customer_type).trigger('change');
          //     $('[name="address"]').val(data[i].address);
          //     $('[name="state_id"]').val(data[i].state_id).trigger('change');
          //     $('[name="city_id"]').val(data[i].city_id).trigger('change');
          //     $('[name="state_code"]').val(data[i].state_code);
          //     $('[name="customer_pin_code"]').val(data[i].pin_code);
          //     $('[name="customer_gst_number"]').val(data[i].gst_no);
          //     $('[name="customer_pan_number"]').val(data[i].pan_no);
          //     $('#enquiry_contact_number').attr('readonly',true);

          // });

        }
      });

    });



    $(document).on('keyup change', '#enquiry_contact_number', function() {
      var id = $(this).val();
      var regex = /^(?:(?:\+|0{1})91(\s|\-)?)?(\d{10})$/;
      var baseurl = "<?php echo site_url('create_offer_from_contact/'); ?>";

      if (regex.test($("#enquiry_contact_number").val())) {
        $("#lblError").css("visibility", "hidden");
        $('#lead_submit').attr('disabled', false);
        id = regex.exec(id)[2];
        $.ajax({
          url: "<?php echo site_url('sales/enquiry_register/get_customer_details_by_contact_no'); ?>",
          method: "POST",
          data: {
            id: id
          },
          async: true,
          dataType: 'json',
          success: function(data) {
            var html = '';
            var i = 0;
            if (data) {
              html += '<div class="row"><div class="col-md-12"><div class="card-body"><div  class="table-responsive"><table id="example1" class="table table-bordered table-striped"><thead><tr><th>Customer_id</th><th>Customer Name(Company)</th><th>Contact Person</th><th>Email Id</th><th>Fisrt Contact No</th><th>Second Contact No</th></th><th>State</th><th>City</th><th>Address</th><th>Pincode</th><th>Action</th></tr></thead><tbody>';

              for (i in data) {


                html += "<tr><td>" + data[i].Customer_id + "</td><td>" + data[i].customer_name + "</td><td>" + data[i].contact_person + "</td><td>" + data[i].email_id + "</td><td>" + data[i].first_contact_no + "</td><td>" + data[i].second_contact_no + "</td><td>" + data[i].state_name + "</td><td>" + data[i].city_name + "</td><td>" + data[i].address + "</td><td>" + data[i].pin_code + "</td><td><a href='" + baseurl + data[i].Contact_id + "'class='btn btn-sm btn-danger'><i class='fas fa-arrow-right'></i></a></td></tr>";

                // <a href="" class="btn btn-sm btn-danger"><i class="fas fa-arrow-right"></i></a>

              }
              html += "</tbody></table></div></div></div></div></div>";
              $('#showcompany').html(html);
              $('#other_data').html("If above result don't match, please fill and submit the remaining form");


            } else {
              $('#showcompany').html('');
              $('#other_data').html("Other Details");
            }
            // $.each(data, function(i, item){
            //     console.log(data);
            //     $val = 
            //     $('[name="customer_id"]').val(data[i].Customer_id);
            //     $('[name="enquiry_contact_person"]').val(data[i].contact_person);
            //     $('[name="enquiry_email_id"]').val(data[i].email_id);
            //     $('[name="enquiry_contact_number"]').val(data[i].first_contact_no);
            //     $('[name="customer_name"]').val(data[i].customer_name);

            //     $('[name="customer_type"]').val(data[i].customer_type).trigger('change');
            //     $('[name="address"]').val(data[i].address);
            //     $('[name="state_id"]').val(data[i].state_id).trigger('change');
            //     $('[name="city_id"]').val(data[i].city_id).trigger('change');
            //     $('[name="state_code"]').val(data[i].state_code);
            //     $('[name="customer_pin_code"]').val(data[i].pin_code);
            //     $('[name="customer_gst_number"]').val(data[i].gst_no);
            //     $('[name="customer_pan_number"]').val(data[i].pan_no);
            //     $('#enquiry_contact_number').attr('readonly',true);

            // });

          },
          error: function(data) {
            alert(xhr.responseText);
          }
        });
      } else {
        $("#lblError").css("visibility", "visible");
        $('#lead_submit').attr('disabled', true);
        $('#showcompany').html('');
      }
      return false;
    });
  </script>

  <script type="text/javascript">
    $(document).ready(function() {
      $('#state_id').change(function() {
        var id = $(this).val();

        $.ajax({
          url: "<?php echo site_url('master/customer_master/get_city_name'); ?>",
          method: "POST",
          data: {
            id: id
          },
          async: true,
          dataType: 'json',
          /*success: function(data){ 
              var html = '';
              var i;
              for(i=0; i<data.length; i++){
                   html += '<option value='+data[i].entity_id+'>'+data[i].city_name+'</option>';
              }
                  $('#city_id').html(html);
          }*/
          success: function(response) {

            // Remove options 
            $('#city_id').find('option').not(':first').remove();

            // Add options
            $.each(response, function(index, data) {
              $('#city_id').append('<option value="' + data['entity_id'] + '">' + data['city_name'] + '</option>');
            });
          }
        });
        return false;
      });
    });
  </script>

  <script type="text/javascript">
    //load data for edit
    $('#state_id').change(function() {
      var id = $(this).val();
      $.ajax({
        url: "<?php echo site_url('master/customer_master/get_state_code'); ?>",
        method: "POST",
        data: {
          id: id
        },
        async: true,
        dataType: 'json',
        success: function(data) {
          $.each(data, function(i, item) {
            console.log(data);
            $val =
              $('[name="state_code"]').val(data[i].state_code);
          })
        }
      });
      return false;
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