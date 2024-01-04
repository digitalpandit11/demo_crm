<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- <?php
if(!$_SESSION['user_name'])
{
   header("location:dashboard");
}
?> -->
<!DOCTYPE html>
<html>
    <head>
        
        <!-- <style>    
            th { white-space: nowrap; }
        </style> -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title> Enquiry Summary Report From <?php echo date("d-m-Y", strtotime($timesheet_from_date));?> To <?php echo date("d-m-Y", strtotime($timesheet_to_date));?></title>
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
                                <h1 class="card-title">Enquiry Summary Report</h1>
                                <div class="col-sm-6">
                                    <br><br>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                                        <li class="breadcrumb-item"><a href="<?php echo base_url().'vw_enquiry_summary_report'?>">Enquiry Summary Report</a>
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
                                <div class="card card-primary">
                                    <section class="content-header">
                                        <div class="container-fluid">
                                            <div class="card">
                                                <div class="card card-success">
                                                    <div class="card-header" >
                                                        <center>
                                                            <h1>Enquiry Summary Report From <?php echo date("d-m-Y", strtotime($timesheet_from_date));?> To <?php echo date("d-m-Y", strtotime($timesheet_to_date));?></h1>
                                                        </center>         
                                                    </div> 
                                                </div>  
                                            </div>
                                        </div>
                                    </section>
                                    <?php
                                        $this->db->select('enquiry_register.*,customer_master.customer_name');
                                        $this->db->from('enquiry_register');
                                        $this->db->join('customer_master','enquiry_register.customer_id = customer_master.entity_id', 'INNER');

                                        $where = '(enquiry_register.user_id = "'.$user_id.'" And enquiry_register.enquiry_date >= "'.$timesheet_from_date.'" And enquiry_register.enquiry_date <= "'.$timesheet_to_date.'"  And enquiry_register.enquiry_source = 1)';
                                        $this->db->where($where);
                                        //$this->db->order_by('sales_order_register.entity_id', 'DESC');
                                        $query = $this->db->get();
                                        $india_mart = $query->num_rows();



                                        $this->db->select('enquiry_register.*,customer_master.customer_name');
                                        $this->db->from('enquiry_register');
                                        $this->db->join('customer_master','enquiry_register.customer_id = customer_master.entity_id', 'INNER');

                                        $where = '(enquiry_register.user_id = "'.$user_id.'" And enquiry_register.enquiry_date >= "'.$timesheet_from_date.'" And enquiry_register.enquiry_date <= "'.$timesheet_to_date.'"  And enquiry_register.enquiry_source = 1 AND enquiry_register.enquiry_status = 1)';

                                        $this->db->where($where);
                                        //$this->db->order_by('sales_order_register.entity_id', 'DESC');
                                        $query = $this->db->get();
                                        $india_mart_pending_count = $query->num_rows();


                                        $this->db->select('enquiry_register.*,customer_master.customer_name');
                                        $this->db->from('enquiry_register');
                                        $this->db->join('customer_master','enquiry_register.customer_id = customer_master.entity_id', 'INNER');

                                        $where = '(enquiry_register.user_id = "'.$user_id.'" And enquiry_register.enquiry_date >= "'.$timesheet_from_date.'" And enquiry_register.enquiry_date <= "'.$timesheet_to_date.'"  And enquiry_register.enquiry_source = 1 AND enquiry_register.enquiry_status = 2)';

                                        $this->db->where($where);
                                        //$this->db->order_by('sales_order_register.entity_id', 'DESC');
                                        $query = $this->db->get();
                                        $india_mart_offer_count = $query->num_rows();


                                        $this->db->select('enquiry_register.*,customer_master.customer_name');
                                        $this->db->from('enquiry_register');
                                        $this->db->join('customer_master','enquiry_register.customer_id = customer_master.entity_id', 'INNER');

                                        $where = '(enquiry_register.user_id = "'.$user_id.'" And enquiry_register.enquiry_date >= "'.$timesheet_from_date.'" And enquiry_register.enquiry_date <= "'.$timesheet_to_date.'"  And enquiry_register.enquiry_source = 1 AND enquiry_register.enquiry_status = 3)';

                                        $this->db->where($where);
                                        //$this->db->order_by('sales_order_register.entity_id', 'DESC');
                                        $query = $this->db->get();
                                        $india_mart_not_qualified_count = $query->num_rows();
                                        //////////////////////////////////////////////////////////////////////////////

                                        $this->db->select('enquiry_register.*,customer_master.customer_name');
                                        $this->db->from('enquiry_register');
                                        $this->db->join('customer_master','enquiry_register.customer_id = customer_master.entity_id', 'INNER');

                                        $where = '(enquiry_register.user_id = "'.$user_id.'" And enquiry_register.enquiry_date >= "'.$timesheet_from_date.'" And enquiry_register.enquiry_date <= "'.$timesheet_to_date.'"  And enquiry_register.enquiry_source = 2)';
                                        $this->db->where($where);
                                        //$this->db->order_by('sales_order_register.entity_id', 'DESC');
                                        $query = $this->db->get();
                                        $excibition = $query->num_rows();




                                        $this->db->select('enquiry_register.*,customer_master.customer_name');
                                        $this->db->from('enquiry_register');
                                        $this->db->join('customer_master','enquiry_register.customer_id = customer_master.entity_id', 'INNER');

                                        $where = '(enquiry_register.user_id = "'.$user_id.'" And enquiry_register.enquiry_date >= "'.$timesheet_from_date.'" And enquiry_register.enquiry_date <= "'.$timesheet_to_date.'"  And enquiry_register.enquiry_source = 2 AND enquiry_register.enquiry_status = 1)';
                                        $this->db->where($where);
                                        //$this->db->order_by('sales_order_register.entity_id', 'DESC');
                                        $query = $this->db->get();
                                        $excibition_pending_count = $query->num_rows();




                                        $this->db->select('enquiry_register.*,customer_master.customer_name');
                                        $this->db->from('enquiry_register');
                                        $this->db->join('customer_master','enquiry_register.customer_id = customer_master.entity_id', 'INNER');

                                        $where = '(enquiry_register.user_id = "'.$user_id.'" And enquiry_register.enquiry_date >= "'.$timesheet_from_date.'" And enquiry_register.enquiry_date <= "'.$timesheet_to_date.'"  And enquiry_register.enquiry_source = 2 AND enquiry_register.enquiry_status = 2)';
                                        $this->db->where($where);
                                        //$this->db->order_by('sales_order_register.entity_id', 'DESC');
                                        $query = $this->db->get();
                                        $excibition_offer_count = $query->num_rows();



                                        $this->db->select('enquiry_register.*,customer_master.customer_name');
                                        $this->db->from('enquiry_register');
                                        $this->db->join('customer_master','enquiry_register.customer_id = customer_master.entity_id', 'INNER');

                                        $where = '(enquiry_register.user_id = "'.$user_id.'" And enquiry_register.enquiry_date >= "'.$timesheet_from_date.'" And enquiry_register.enquiry_date <= "'.$timesheet_to_date.'"  And enquiry_register.enquiry_source = 2 AND enquiry_register.enquiry_status = 3)';
                                        $this->db->where($where);
                                        //$this->db->order_by('sales_order_register.entity_id', 'DESC');
                                        $query = $this->db->get();
                                        $excibition_not_qualified_count = $query->num_rows();
                                        //////////////////////////////////////////////////////////////////////////////

                                        $this->db->select('enquiry_register.*,customer_master.customer_name');
                                        $this->db->from('enquiry_register');
                                        $this->db->join('customer_master','enquiry_register.customer_id = customer_master.entity_id', 'INNER');

                                        $where = '(enquiry_register.user_id = "'.$user_id.'" And enquiry_register.enquiry_date >= "'.$timesheet_from_date.'" And enquiry_register.enquiry_date <= "'.$timesheet_to_date.'"  And enquiry_register.enquiry_source = 3)';
                                        $this->db->where($where);
                                        //$this->db->order_by('sales_order_register.entity_id', 'DESC');
                                        $query = $this->db->get();
                                        $mid = $query->num_rows();



                                        $this->db->select('enquiry_register.*,customer_master.customer_name');
                                        $this->db->from('enquiry_register');
                                        $this->db->join('customer_master','enquiry_register.customer_id = customer_master.entity_id', 'INNER');

                                        $where = '(enquiry_register.user_id = "'.$user_id.'" And enquiry_register.enquiry_date >= "'.$timesheet_from_date.'" And enquiry_register.enquiry_date <= "'.$timesheet_to_date.'"  And enquiry_register.enquiry_source = 3 AND enquiry_register.enquiry_status = 1)';
                                        $this->db->where($where);
                                        //$this->db->order_by('sales_order_register.entity_id', 'DESC');
                                        $query = $this->db->get();
                                        $mid_pending_count = $query->num_rows();

                                        $this->db->select('enquiry_register.*,customer_master.customer_name');
                                        $this->db->from('enquiry_register');
                                        $this->db->join('customer_master','enquiry_register.customer_id = customer_master.entity_id', 'INNER');

                                        $where = '(enquiry_register.user_id = "'.$user_id.'" And enquiry_register.enquiry_date >= "'.$timesheet_from_date.'" And enquiry_register.enquiry_date <= "'.$timesheet_to_date.'"  And enquiry_register.enquiry_source = 3 AND enquiry_register.enquiry_status = 2)';
                                        $this->db->where($where);
                                        //$this->db->order_by('sales_order_register.entity_id', 'DESC');
                                        $query = $this->db->get();
                                        $mid_offer_count = $query->num_rows();

                                        $this->db->select('enquiry_register.*,customer_master.customer_name');
                                        $this->db->from('enquiry_register');
                                        $this->db->join('customer_master','enquiry_register.customer_id = customer_master.entity_id', 'INNER');

                                        $where = '(enquiry_register.user_id = "'.$user_id.'" And enquiry_register.enquiry_date >= "'.$timesheet_from_date.'" And enquiry_register.enquiry_date <= "'.$timesheet_to_date.'"  And enquiry_register.enquiry_source = 3 AND enquiry_register.enquiry_status = 3)';
                                        $this->db->where($where);
                                        //$this->db->order_by('sales_order_register.entity_id', 'DESC');
                                        $query = $this->db->get();
                                        $mid_not_qualified_count = $query->num_rows();
                                        ///////////////////////////////////////////////////////////////////////////

                                        $this->db->select('enquiry_register.*,customer_master.customer_name');
                                        $this->db->from('enquiry_register');
                                        $this->db->join('customer_master','enquiry_register.customer_id = customer_master.entity_id', 'INNER');

                                        $where = '(enquiry_register.user_id = "'.$user_id.'" And enquiry_register.enquiry_date >= "'.$timesheet_from_date.'" And enquiry_register.enquiry_date <= "'.$timesheet_to_date.'"  And enquiry_register.enquiry_source = 4)';
                                        $this->db->where($where);
                                        //$this->db->order_by('sales_order_register.entity_id', 'DESC');
                                        $query = $this->db->get();
                                        $phone_call = $query->num_rows();

                                        $this->db->select('enquiry_register.*,customer_master.customer_name');
                                        $this->db->from('enquiry_register');
                                        $this->db->join('customer_master','enquiry_register.customer_id = customer_master.entity_id', 'INNER');

                                        $where = '(enquiry_register.user_id = "'.$user_id.'" And enquiry_register.enquiry_date >= "'.$timesheet_from_date.'" And enquiry_register.enquiry_date <= "'.$timesheet_to_date.'"  And enquiry_register.enquiry_source = 4 AND enquiry_register.enquiry_status = 1)';
                                        $this->db->where($where);
                                        //$this->db->order_by('sales_order_register.entity_id', 'DESC');
                                        $query = $this->db->get();
                                        $phone_call_pending_count = $query->num_rows();

                                        $this->db->select('enquiry_register.*,customer_master.customer_name');
                                        $this->db->from('enquiry_register');
                                        $this->db->join('customer_master','enquiry_register.customer_id = customer_master.entity_id', 'INNER');

                                        $where = '(enquiry_register.user_id = "'.$user_id.'" And enquiry_register.enquiry_date >= "'.$timesheet_from_date.'" And enquiry_register.enquiry_date <= "'.$timesheet_to_date.'"  And enquiry_register.enquiry_source = 4 AND enquiry_register.enquiry_status = 2)';
                                        $this->db->where($where);
                                        //$this->db->order_by('sales_order_register.entity_id', 'DESC');
                                        $query = $this->db->get();
                                        $phone_call_offer_count = $query->num_rows();

                                        $this->db->select('enquiry_register.*,customer_master.customer_name');
                                        $this->db->from('enquiry_register');
                                        $this->db->join('customer_master','enquiry_register.customer_id = customer_master.entity_id', 'INNER');

                                        $where = '(enquiry_register.user_id = "'.$user_id.'" And enquiry_register.enquiry_date >= "'.$timesheet_from_date.'" And enquiry_register.enquiry_date <= "'.$timesheet_to_date.'"  And enquiry_register.enquiry_source = 4 AND enquiry_register.enquiry_status = 3)';
                                        $this->db->where($where);
                                        //$this->db->order_by('sales_order_register.entity_id', 'DESC');
                                        $query = $this->db->get();
                                        $phone_call_not_qualified_count = $query->num_rows();


                                        $this->db->select('enquiry_register.*,customer_master.customer_name');
                                        $this->db->from('enquiry_register');
                                        $this->db->join('customer_master','enquiry_register.customer_id = customer_master.entity_id', 'INNER');

                                        $where = '(enquiry_register.user_id = "'.$user_id.'" And enquiry_register.enquiry_date >= "'.$timesheet_from_date.'" And enquiry_register.enquiry_date <= "'.$timesheet_to_date.'"  And enquiry_register.enquiry_source = 5)';
                                        $this->db->where($where);
                                        //$this->db->order_by('sales_order_register.entity_id', 'DESC');
                                        $query = $this->db->get();
                                        $direct_mail = $query->num_rows();

                                        $this->db->select('enquiry_register.*,customer_master.customer_name');
                                        $this->db->from('enquiry_register');
                                        $this->db->join('customer_master','enquiry_register.customer_id = customer_master.entity_id', 'INNER');

                                        $where = '(enquiry_register.user_id = "'.$user_id.'" And enquiry_register.enquiry_date >= "'.$timesheet_from_date.'" And enquiry_register.enquiry_date <= "'.$timesheet_to_date.'"  And enquiry_register.enquiry_source = 5 AND enquiry_register.enquiry_status = 1)';
                                        $this->db->where($where);
                                        //$this->db->order_by('sales_order_register.entity_id', 'DESC');
                                        $query = $this->db->get();
                                        $direct_mail_pending_count = $query->num_rows();


                                        $this->db->select('enquiry_register.*,customer_master.customer_name');
                                        $this->db->from('enquiry_register');
                                        $this->db->join('customer_master','enquiry_register.customer_id = customer_master.entity_id', 'INNER');

                                        $where = '(enquiry_register.user_id = "'.$user_id.'" And enquiry_register.enquiry_date >= "'.$timesheet_from_date.'" And enquiry_register.enquiry_date <= "'.$timesheet_to_date.'"  And enquiry_register.enquiry_source = 5 AND enquiry_register.enquiry_status = 1)';
                                        $this->db->where($where);
                                        //$this->db->order_by('sales_order_register.entity_id', 'DESC');
                                        $query = $this->db->get();
                                        $direct_mail_offer_count = $query->num_rows();

                                        $this->db->select('enquiry_register.*,customer_master.customer_name');
                                        $this->db->from('enquiry_register');
                                        $this->db->join('customer_master','enquiry_register.customer_id = customer_master.entity_id', 'INNER');

                                        $where = '(enquiry_register.user_id = "'.$user_id.'" And enquiry_register.enquiry_date >= "'.$timesheet_from_date.'" And enquiry_register.enquiry_date <= "'.$timesheet_to_date.'"  And enquiry_register.enquiry_source = 5 AND enquiry_register.enquiry_status = 3)';
                                        $this->db->where($where);
                                        //$this->db->order_by('sales_order_register.entity_id', 'DESC');
                                        $query = $this->db->get();
                                        $direct_mail_not_qualified_count = $query->num_rows();
                                        //////////////////////////////////////////////////////////////////////////////

                                        $this->db->select('enquiry_register.*,customer_master.customer_name');
                                        $this->db->from('enquiry_register');
                                        $this->db->join('customer_master','enquiry_register.customer_id = customer_master.entity_id', 'INNER');

                                        $where = '(enquiry_register.user_id = "'.$user_id.'" And enquiry_register.enquiry_date >= "'.$timesheet_from_date.'" And enquiry_register.enquiry_date <= "'.$timesheet_to_date.'"  And enquiry_register.enquiry_source = 6)';
                                        $this->db->where($where);
                                        //$this->db->order_by('sales_order_register.entity_id', 'DESC');
                                        $query = $this->db->get();
                                        $others = $query->num_rows();


                                        $this->db->select('enquiry_register.*,customer_master.customer_name');
                                        $this->db->from('enquiry_register');
                                        $this->db->join('customer_master','enquiry_register.customer_id = customer_master.entity_id', 'INNER');

                                        $where = '(enquiry_register.user_id = "'.$user_id.'" And enquiry_register.enquiry_date >= "'.$timesheet_from_date.'" And enquiry_register.enquiry_date <= "'.$timesheet_to_date.'"  And enquiry_register.enquiry_source = 6  AND enquiry_register.enquiry_status = 1)';
                                        $this->db->where($where);
                                        //$this->db->order_by('sales_order_register.entity_id', 'DESC');
                                        $query = $this->db->get();
                                        $others_pending_count = $query->num_rows();


                                        $this->db->select('enquiry_register.*,customer_master.customer_name');
                                        $this->db->from('enquiry_register');
                                        $this->db->join('customer_master','enquiry_register.customer_id = customer_master.entity_id', 'INNER');

                                        $where = '(enquiry_register.user_id = "'.$user_id.'" And enquiry_register.enquiry_date >= "'.$timesheet_from_date.'" And enquiry_register.enquiry_date <= "'.$timesheet_to_date.'"  And enquiry_register.enquiry_source = 6  AND enquiry_register.enquiry_status = 2)';
                                        $this->db->where($where);
                                        //$this->db->order_by('sales_order_register.entity_id', 'DESC');
                                        $query = $this->db->get();
                                        $others_offer_count = $query->num_rows();


                                        $this->db->select('enquiry_register.*,customer_master.customer_name');
                                        $this->db->from('enquiry_register');
                                        $this->db->join('customer_master','enquiry_register.customer_id = customer_master.entity_id', 'INNER');

                                        $where = '(enquiry_register.user_id = "'.$user_id.'" And enquiry_register.enquiry_date >= "'.$timesheet_from_date.'" And enquiry_register.enquiry_date <= "'.$timesheet_to_date.'"  And enquiry_register.enquiry_source = 6  AND enquiry_register.enquiry_status = 3)';
                                        $this->db->where($where);
                                        //$this->db->order_by('sales_order_register.entity_id', 'DESC');
                                        $query = $this->db->get();
                                        $others_not_qualified_count = $query->num_rows();
                                    ?>
                                    <div class="card-body">
                                        <div  class="table-responsive">
                                            <table id="example1" class="table table-bordered table-striped">
                                                
                                                <thead>
                                                    <tr>
                                                        
                                                        <th>Sr. No.</th>
                                                        <th>Source</th>
                                                        <th>Total Lead</th>
                                                        <th>Pending</th>
                                                        <th>Qualified & Offer Made</th>
                                                        <th>Not Qualified</th>
                                                        
                                                        <!-- <th>Name</th>
                                                        <th>Description</th>
                                                        <th style="width: 10%;">Delivery Period</th>
                                                        <th>Warranty</th>
                                                        <th>Price</th>
                                                        <th>Qty</th> -->
                                                        <!-- <th>Basic Amount</th>
                                                        <th>Discount(%)</th>
                                                        <th>Discount(Amt)</th>
                                                        <th>Unit Discounted(Amt)</th>
                                                        <th>Total Amount Without GST</th>
                                                        <th>CGST%</th>
                                                        <th>SGST%</th>
                                                        <th>IGST%</th>
                                                        <th>Tax Amount</th> -->
                                                        <!-- <th>Total Amount</th> -->
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- <?php
                                                        $no = 0;
                                                        $final_amount = 0;
                                                        foreach ($enquiry_summary_report_date_wise as $row):
                                                          
                                                          $no++;
                                                        
                                                    ?>
                                                    <tr>
                                                        <td>1</td>
                                                        <td><?php echo $india_mart;?></td>
                                                        <td>1</td>
                                                        <td>1</td>
                                                        <td>1</td>
                                                        <td>1</td>
                                                        
                                                        
                                                    </tr>
                                                   <?php endforeach;?> -->

                                                   <tr>
                                                        <td>1</td>
                                                        <td>India Mart</td>
                                                        <td><?php echo $india_mart;?></td>
                                                        <td><?php echo $india_mart_pending_count;?></td>
                                                        <td><?php echo $india_mart_offer_count;?></td>
                                                        <td><?php echo $india_mart_not_qualified_count;?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>Excibition</td>
                                                        <td><?php echo $excibition;?></td>
                                                        <td><?php echo $excibition_pending_count;?></td>
                                                        <td><?php echo $excibition_offer_count;?></td>
                                                        <td><?php echo $excibition_not_qualified_count;?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td>MID</td>
                                                        <td><?php echo $mid;?></td>
                                                        <td><?php echo $mid_pending_count;?></td>
                                                        <td><?php echo $mid_offer_count;?></td>
                                                        <td><?php echo $mid_not_qualified_count;?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>4</td>
                                                        <td>Phone Call</td>
                                                        <td><?php echo $phone_call;?></td>
                                                        <td><?php echo $phone_call_pending_count;?></td>
                                                        <td><?php echo $phone_call_offer_count;?></td>
                                                        <td><?php echo $phone_call_not_qualified_count;?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>5</td>
                                                        <td>Direct Mail</td>
                                                        <td><?php echo $direct_mail;?></td>
                                                        <td><?php echo $direct_mail_pending_count;?></td>
                                                        <td><?php echo $direct_mail_offer_count;?></td>
                                                        <td><?php echo $direct_mail_not_qualified_count;?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>6</td>
                                                        <td>Others</td>
                                                        <td><?php echo $others;?></td>
                                                        <td><?php echo $others_pending_count;?></td>
                                                        <td><?php echo $others_offer_count;?></td>
                                                        <td><?php echo $others_not_qualified_count;?></td>
                                                    </tr>
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
        <!-- AdminLTE App -->
        <script src="<?php echo base_url().'assets/dist/js/adminlte.min.js'?>"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="<?php echo base_url().'assets/dist/js/demo.js'?>"></script>
        </script>
        <!-- Page script -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">

        <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#example1').DataTable( {
                    dom: 'Bfrtip',
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdfHtml5'
                    ]
                } )
            } );
        </script> 

        <script>
            $(document).ready(function() {
                $('#example2').DataTable( {
                    dom: 'Bfrtip',
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdfHtml5'
                    ]
                } )
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
