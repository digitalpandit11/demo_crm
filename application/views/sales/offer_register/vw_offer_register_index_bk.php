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
        <title>Quotation Register</title>
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
                            <div class="card">
                                <div class="card-header" >
                                    <h1 class="card-title">Quotation Register</h1>
                                    <div class="col-sm-6">
                                        <br><br>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'vw_offer_data'?>">Quotation Register</a>
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
                                            <h3 class="card-title">Quotation Register</h3>
                                        </div>
                                        <div>
                                            <div class="btn-group" style="margin-top: 15px; margin-left: 15px;">
                                                <a href="create_customer_offer" class="btn btn-block btn-primary">
                                                Create Quotation
                                                </a>
                                            </div>
                                            <div class="btn-group" style="margin-top: 15px; margin-left: 15px;">
                                                <a href="vw_all_offer_data" class="btn btn-block btn-primary">
                                                All Quotation's
                                                </a>
                                            </div>
                                            <div class="btn-group" style="margin-top: 15px; margin-left: 15px;">
                                                <a href="create_offer_without_lead" class="btn btn-block btn-primary">
                                                Create Quotation Without Lead
                                                </a>
                                            </div>
                                            <div class="btn-group" style="margin-top: 15px; margin-left: 15px;">
                                                <a href="old_offers" class="btn btn-block btn-primary">
                                                Old Quotation's
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div  class="table-responsive">
                                                <table id="example1" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Sr. No.</th>
                                                            <th>Quotation No. </th>
                                                            <th>Lead No. </th>
                                                            <th>Company Name</th>
                                                            <th>Contact Person</th>
                                                            <th>Contact No.</th>
                                                            <th>Email Id.</th>
                                                            <th>Employee Name</th>
                                                            <th>Quotation Date</th>
                                                            <th>Quote Stage</th>
                                                            <th>Quote Value</th>
                                                            <th>Action</th>
                                                            <th>Operation</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $no = 0;
                                                            foreach ($offer_details as $row):
                                                                $no++;
                                                                $entity_id = $row->entity_id;

                                                                $status = $row->status;
                                                                $enquiry_id = $row->enquiry_id;

                                                                $customer_id = $row->customer_id;
                                                                $contact_id = $row->contact_person_id;

                                                                $cname=$this->db->select('customer_name')->from('customer_master')->where('entity_id',$customer_id)->get()->row_array();

                                                                $this->db->select('*');
                                                                $this->db->from('customer_contact_master');
                                                                $where = '(customer_contact_master.entity_id = "'.$contact_id.'")';
                                                                $this->db->where($where);
                                                                $query = $this->db->get();
                                                                $query_result = $query->row_array();

                                                                $email = $query_result['email_id'];
                                                                $Contact_person = $query_result['contact_person'];
                                                                $First_contact_no = $query_result['first_contact_no'];

                                                                $this->db->select('*');
                                                                $this->db->from('enquiry_register');
                                                                $where = '(enquiry_register.entity_id = "'.$enquiry_id.'")';
                                                                $this->db->where($where);
                                                                $enquiry_register_query = $this->db->get();
                                                                $enquiry_register_query_result = $enquiry_register_query->row_array();

                                                                $Enquiry_no = $enquiry_register_query_result['enquiry_no'];

                                                                if($status == 2)
                                                                {
                                                                    $Status_data = "Active";
                                                                }elseif($status == 6){
                                                                    $Status_data = "Win";
                                                                }elseif($status == 7){
                                                                    $Status_data = "On Hold";
                                                                }elseif($status == 8){
                                                                    $Status_data = "A";
                                                                }elseif($status == 9){
                                                                    $Status_data = "B";
                                                                }else{
                                                                    $Status_data = "NA";
                                                                }

                                                                $this->db->select_sum('total_amount_with_gst');
                                                                $this->db->from('offer_product_relation');
                                                                $where1 = '(offer_product_relation.offer_id = "'.$entity_id.'")';
                                                                $this->db->where($where1);
                                                                $query=$this->db->get();
                                                                $total_offer_amount = $query->row();

                                                                if(!empty($total_offer_amount))
                                                                {
                                                                    $total_offer_amount_final = $total_offer_amount->total_amount_with_gst;
                                                                    $final_offer_amount = number_format($total_offer_amount_final, 2, '.', '');
                                                                }else{
                                                                    $final_offer_amount = 0;
                                                                }


                                                                $emp_name = $this->db->select('emp_first_name')->from('employee_master')->where('entity_id',$row->offer_engg_name)->get()->row_array();
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $no;?></td>
                                                            <td><?php echo $row->offer_no;?></td>
                                                            <td><?php echo $Enquiry_no;?></td>
                                                            <td><b><?php echo $cname['customer_name'];?></b></td>
                                                            <td><?php echo $Contact_person;?></td>
                                                            <td><?php echo $First_contact_no;?></td>
                                                            <td><?php echo $email;?></td>
                                                            <td><?php echo $emp_name['emp_first_name'];?></td>
                                                            <td><?php echo date("d-m-Y", strtotime($row->offer_date));?></td>
                                                            <td><?php echo $Status_data;?></td>
                                                            <td><?php echo $final_offer_amount;?></td>
                                                            <td>
                                                                <div class="btn-group">
                                                                    <a href="<?php echo site_url('update_offer_data/'.$entity_id);?>" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>

                                                                    <!-- <a href="<?php echo site_url('delete_enquiry_data/'.$row->entity_id);?>" class="btn btn-sm btn-danger" onclick="return confirm('Are You Sure ?')"><i class="fas fa-trash"></i></a> -->

                                                                    <a href="<?php echo site_url('view_offer_data/'.$entity_id);?>" class="btn btn-sm btn-success"><i class="fas fa-eye"></i></a> 

                                                                    <a href="<?php echo site_url('download_offer/'.$entity_id);?>" target="_blank" class="btn btn-secondary"><i class="fa fa-print"></i></a>  
                                                                </div> 
                                                            </td>

                                                            <td>
                                                                <a onclick="return confirm('Are You Sure To Make Offer?')" href="<?php echo site_url('setorder/'.$entity_id);?>" class="btn btn-block btn-warning">Make Order</a>
                                                                <a onclick="return confirm('Are You Sure To Make Offer?')" href="<?php echo site_url('set_revision_offer/'.$entity_id);?>" class="btn btn-block btn-warning">Make Revision</a>
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
    </body>
</html>