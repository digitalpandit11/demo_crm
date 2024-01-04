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
  <title>VBTEK CRM</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Data Tables -->
  <link rel="stylesheet" href="<?php echo base_url() . 'assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css' ?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url() . 'assets/plugins/fontawesome-free/css/all.min.css' ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="<?php echo base_url() . 'assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css' ?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url() . 'assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css' ?>">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?php echo base_url() . 'assets/plugins/jqvmap/jqvmap.min.css' ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() . 'assets/dist/css/adminlte.min.css' ?>">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url() . 'assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css' ?>">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url() . 'assets/plugins/daterangepicker/daterangepicker.css' ?>">
  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo base_url() . 'assets/plugins/summernote/summernote-bs4.css' ?>">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php $this->load->view('header_sidebar'); ?>
    <?php
$session_data = $this->session->userdata();
   

    $current_month = date('m');
    $current_month_first_day = date('Y-' . $current_month . '-01');
    $current_month_last_day = date('Y-' . $current_month . '-t');

   
    // die();
    //calculating New Leads

    $this->db->select('*');
    $this->db->from('customer_master');
    $where1 = '(customer_master.date_entered >= "' . $current_month_first_day . '" And customer_master.date_entered <= "' . $current_month_last_day . '")';
    $this->db->where($where1);
    $leads_data = $this->db->get();
    $leads_count = $leads_data->num_rows();

    if (!empty($leads_data)) {
      $leads_count = $leads_count;
    } else {
      $leads_count = 0;
    }


    $this->db->select('enquiry_register.*');
    $this->db->from('enquiry_register');
    $where1 = '(enquiry_register.enquiry_date >= "' . $current_month_first_day . '" And enquiry_register.enquiry_date <= "' . $current_month_last_day . '")';
    $this->db->where($where1);
    $enquiry_register_data = $this->db->get();
    $enquiry_count = $enquiry_register_data->num_rows();

    if (!empty($enquiry_count)) {
      $enquiry_register_data_count =  $enquiry_count;
    } else {
      $enquiry_register_data_count = 0;
    }

    //calculating New Quotations
    $this->db->select('offer_register.*');
    $this->db->from('offer_register');
    $where = '(offer_register.status != "' . '10' . '" And offer_register.status != "' . '1' . '")';
    $this->db->where($where);
    $where1 = '(offer_register.offer_date >= "' . $current_month_first_day . '" And offer_register.offer_date <= "' . $current_month_last_day . '")';
    $this->db->where($where1);
    $offer_register_month_data = $this->db->get();
    $offer_register_month_data_count = $offer_register_month_data->num_rows();


    if (!empty($offer_register_month_data_count)) {
      $offer_register_month_count = $offer_register_month_data_count;
    } else {
      $offer_register_month_count = 1;
    }

    $finacial_year = "2021-04-01 00:00:00";
    $this->db->select_sum('total_amount_without_gst');
    $this->db->from('offer_product_relation');
    $where = '(offer_register.status != "' . '10' . '" )';
    $this->db->where($where);
    $where1 = '(offer_register.offer_date >= "' . $current_month_first_day . '" And offer_register.offer_date <= "' . $current_month_last_day . '")';
    $this->db->where($where1);
    $this->db->join('offer_register', 'offer_product_relation.offer_id = offer_register.entity_id', 'INNER');
    $query = $this->db->get();
    $total_offer_amount = $query->row();
    $total_offer_amount_final = $total_offer_amount->total_amount_without_gst;
    $final_offer_amount = number_format($total_offer_amount_final / 100000, 0, '.', '');


    //calculation WON orders

    $this->db->select('offer_register.*');
    $this->db->from('offer_register');
    $where2 = '(offer_register.status = "' . '6' . '" )';
    $this->db->where($where2);
    $where3 = '(offer_register.offer_close_date >= "' . $current_month_first_day . '" And offer_register.offer_close_date <= "' . $current_month_last_day . '")';
    $this->db->where($where3);
    $won_offer_register_month_data = $this->db->get();
    $won_offer_register_month_data_count = $won_offer_register_month_data->num_rows();


    if (!empty($won_offer_register_month_data_count)) {
      $won_offer_register_month_count = $won_offer_register_month_data_count;
    } else {
      $won_offer_register_month_count = 0;
    }

    $finacial_year = "2021-04-01 00:00:00";
    $this->db->select_sum('total_amount_without_gst');
    $this->db->from('offer_product_relation');
    $where = '(offer_register.status = "' . '6' . '" )';
    $this->db->where($where);
    $where1 = '(offer_register.offer_close_date >= "' . $current_month_first_day . '" And offer_register.offer_close_date <= "' . $current_month_last_day . '")';
    $this->db->where($where1);
    $this->db->join('offer_register', 'offer_product_relation.offer_id = offer_register.entity_id', 'INNER');
    $query = $this->db->get();
    $won_offer_amount = $query->row();
    $won_offer_amount_final = $won_offer_amount->total_amount_without_gst;
    $won_offer_amount_final_formatted = number_format($won_offer_amount_final / 100000, 0, '.', '');

    //end of WON calculations

    $this->db->select('offer_register.*');
    $this->db->from('offer_register');
    $where = '(offer_register.status = "' . '6' . '")';
    $this->db->where($where);
    $won_order_register_data_for_funnel = $this->db->get();
    $won_order_reg_count = $won_order_register_data_for_funnel->num_rows();

    if (!empty($won_order_reg_count)) {
      $won_order_register_count = $won_order_reg_count;
    } else {
      $won_order_register_count = 1;
    }

    $this->db->select_sum('total_amount_without_gst');
    $this->db->from('offer_product_relation');
    $where = '(offer_register.status = "' . '6' . '")';
    $this->db->where($where);
    $where1 = '(offer_register.offer_date >= "' . $finacial_year . '")';
    $this->db->where($where1);
    $this->db->join('offer_register', 'offer_product_relation.offer_id = offer_register.entity_id', 'INNER');
    $query = $this->db->get();
    $total_won_order_amount_funnel = $query->row();
    $total_won_order_amount_funnel_final = $total_won_order_amount_funnel->total_amount_without_gst;
    $funnel_won_order_amount = number_format($total_won_order_amount_funnel_final, 2, '.', '');


    // $this->db->select('work_order_master.*');
    // $this->db->from('work_order_master');
    // $where = '(work_order_master.work_order_type = "'.'1'.'")';
    // $this->db->where($where);
    // $swork_order_data = $this->db->get();
    // $workorder_order_register_count = $swork_order_data->num_rows();

    // $this->db->select('work_order_master.*');
    // $this->db->from('work_order_master');
    // $where = '(work_order_master.work_order_type = "'.'2'.'")';
    // $this->db->where($where);
    // $trade_order_data = $this->db->get();
    // $trade_order_register_count = $trade_order_data->num_rows();

    // $Conversion_ratio = $sales_order_register_count/$offer_register_month_count;
    // $Conversion_ratio_new = $Conversion_ratio*100;

    $new_width = ($won_offer_register_month_count / 100) * $offer_register_month_count;
    ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Dashboard</h1>
            </div>
          </div>
        </div>
      </div>

    

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- <div class="col-12"> -->
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Sales Funnel</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                <div class="col-8">
                  <div class="chart">
                    <div id="chartContainer" style="height: 400px; width: 90%;"></div>

                    <?php
                    //funnel

                    // $this->db->select('offer_register.*');
                    //   $this->db->from('offer_register');
                    //   $where = '(offer_register.status != "'.'4'.'" or offer_register.status != "'.'5'.'" or offer_register.status != "'.'6'.'")';
                    //   $this->db->where($where);
                    //   $offer_register_data = $this->db->get();
                    //   $offer_register_data_count = $offer_register_data->num_rows();

                    //   if(!empty($offer_register_data_count))
                    //   {
                    //       $offer_register_count = $offer_register_data_count;
                    //   }else{
                    //       $offer_register_count = 1;
                    //   }

                    //funnel value
                    // Active
                    $this->db->select_sum('offer_product_relation.total_amount_without_gst');
                    $this->db->from('offer_register');
                    $this->db->join('offer_product_relation', 'offer_register.entity_id = offer_product_relation.offer_id', 'INNER');
                    $where = '(offer_register.status  = "' . '2' . '" or offer_register.status = "' . '3' . '" )';
                    $this->db->where($where);
                    $active_offers_value_data = $this->db->get();
                    $active_offers_value = $active_offers_value_data->row_array();
                    $val1 = $active_offers_value['total_amount_without_gst'];
                    if (!empty($val1)) {
                      $active_value = number_format($val1 / 100000, 0, '.', '');
                    } else {
                      $active_value = 0;
                    }

                    // Stage A
                    $this->db->select_sum('offer_product_relation.total_amount_without_gst');
                    $this->db->from('offer_register');
                    $this->db->join('offer_product_relation', 'offer_register.entity_id = offer_product_relation.offer_id', 'INNER');
                    $where = '(offer_register.status  = "' . '8' . '")';
                    $this->db->where($where);
                    $offer_register_dataa = $this->db->get();
                    $offer_register_data_count = $offer_register_dataa->row_array();
                    $val1 = $offer_register_data_count['total_amount_without_gst'];
                    if (!empty($val1)) {
                      $valuee11 = number_format($val1 / 100000, 0, '.', '');
                    } else {
                      $valuee11 = 0;
                    }

                    //Stage - B Value
                    $this->db->select_sum('offer_product_relation.total_amount_without_gst');
                    $this->db->from('offer_register');
                    $this->db->join('offer_product_relation', 'offer_register.entity_id = offer_product_relation.offer_id', 'INNER');
                    $where = '(offer_register.status  = "' . '9' . '")';
                    $this->db->where($where);
                    $ooffer_register_dataa = $this->db->get();
                    $ooffer_register_data_count = $ooffer_register_dataa->row_array();
                    $val2 = $ooffer_register_data_count['total_amount_without_gst'];
                    if (!empty($val2)) {
                      $valuee22 = number_format($val2 / 100000, 0, '.', '');
                    } else {
                      $valuee22 = 0;
                    }

                    //3
                    $this->db->select_sum('offer_product_relation.total_amount_with_gst');
                    $this->db->from('offer_register');
                    $this->db->join('offer_product_relation', 'offer_register.entity_id = offer_product_relation.offer_id', 'INNER');
                    $where = '(offer_register.winning_chance  = "' . '3' . '")';
                    $this->db->where($where);
                    $ooffer_register_dataaa = $this->db->get();
                    $ooffer_register_data_countt = $ooffer_register_dataaa->row_array();
                    $val3 = $ooffer_register_data_countt['total_amount_with_gst'];

                    if (!empty($val3)) {
                      $valuee33 = $val3;
                    } else {
                      $valuee33 = 0;
                    }
                    ?>
                  </div>
                </div>



                <div class="col-4">
                  <table>
                    <tr>
                      <td>
                        <div class="col">
                          <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

                            <div class="info-box-content">
                              <span class="info-box-text">New Leads</span>
                              <span class="info-box-number">
                                <?php echo $leads_count; ?> Nos
                                <!-- <small>%</small> -->
                              </span>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>

                    <tr>
                      <td>
                        <div class="col">
                          <div class="info-box">
                            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-inbox"></i></span>

                            <div class="info-box-content">
                              <span class="info-box-text">Quotation</span>
                              <span class="info-box-number">
                                <?php echo $offer_register_month_count; ?> Nos<span style="font-size: 15px;"> (Rs <?php echo $final_offer_amount . " Lacs"; ?>)</span>
                                <!-- <small>%</small> -->
                              </span>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>

                    <tr>
                      <td>
                        <div class="col">
                          <div class="info-box">
                            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                            <div class="info-box-content">
                              <span class="info-box-text">Won Orders</span>
                              <span class="info-box-number"><?php echo $won_offer_register_month_count; ?> Nos<span style="font-size: 15px;"> (Rs <?php echo $won_offer_amount_final_formatted . " Lacs"; ?>)</span></span>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>

                    <tr>
                      <td>
                        <div class="col">
                          <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-thumbs-up"></i></span>
                            <div class="info-box-content">
                              <span class="info-box-text">Conversion Ratio</span>
                              <span class="info-box-number">
                                <?php echo $new_width; ?>
                                <small>%</small>
                              </span>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
        


        <div class="row">
          <div class="col-md-12">
            <div class="card">


              <?php
              $this->db->select('sales_order_register.*');
              $this->db->from('sales_order_register');
              $sales_order_register_data = $this->db->get();
              $sales_order_count = $sales_order_register_data->num_rows();

              if (!empty($sales_order_count)) {
                $sales_order_register_count = $sales_order_count;
              } else {
                $sales_order_register_count = 1;
              }


              $this->db->select('sales_order_register.*');
              $this->db->from('sales_order_register');
              $this->db->like('sales_order_no', "MH");
              $sales_order_no = $this->db->get();
              $sales_order_no_MH_count = $sales_order_no->num_rows();

              $MH_percentage = (($sales_order_no_MH_count * 100) / $sales_order_register_count);


              $this->db->select('sales_order_register.*');
              $this->db->from('sales_order_register');
              $this->db->like('sales_order_no', "PS");
              $sales_order_no = $this->db->get();
              $sales_order_no_PS_count = $sales_order_no->num_rows();

              $PS_percentage = (($sales_order_no_PS_count * 100) / $sales_order_register_count);


              $this->db->select('sales_order_register.*');
              $this->db->from('sales_order_register');
              $this->db->like('sales_order_no', "VC");
              $sales_order_no = $this->db->get();
              $sales_order_no_VC_count = $sales_order_no->num_rows();

              $VC_percentage = (($sales_order_no_VC_count * 100) / $sales_order_register_count);


              $this->db->select('sales_order_register.*');
              $this->db->from('sales_order_register');
              $this->db->like('sales_order_no', "TD");
              $sales_order_no = $this->db->get();
              $sales_order_no_TD_count = $sales_order_no->num_rows();

              $TD_percentage = (($sales_order_no_TD_count * 100) / $sales_order_register_count);


              $this->db->select('sales_order_register.*');
              $this->db->from('sales_order_register');
              $this->db->like('sales_order_no', "OT");
              $sales_order_no = $this->db->get();
              $sales_order_no_OT_count = $sales_order_no->num_rows();

              $OT_percentage = (($sales_order_no_OT_count * 100) / $sales_order_register_count);
              ?>

              <!-- <div class="card-body">
                <div class="row">
                  <div class="col-md-12"> -->

                    <?php
                    //Current Month Start

                    $activemonth = date('m');
                    $subactive = date("F", mktime(0, 0, 0, $activemonth));

                    $firstday_subactive = date('Y-' . $activemonth . '-01');
                    $lastday_subactive = date('Y-' . $activemonth . '-t');

                    $this->db->select('customer_master.*');
                    $this->db->from('customer_master');
                    $where = '(customer_master.date_entered >= "' . $firstday_subactive . '" And customer_master.date_entered <= "' . $lastday_subactive . '")';
                    $this->db->where($where);
                    $enquiry_subactive = $this->db->get();
                    $enquiry_subactive_count = $enquiry_subactive->num_rows();


                    $this->db->select('offer_register.*');
                    $this->db->from('offer_register');
                    $where = '(offer_register.offer_date >= "' . $firstday_subactive . '" And offer_register.offer_date <= "' . $lastday_subactive . '")';
                    $this->db->where($where);
                    $where1 = '(offer_register.status != "' . '10' . '" And offer_register.status != "' . '1' . '")';
                    $this->db->where($where1);
                    $offer_subactive = $this->db->get();
                    $offer_subactive_count = $offer_subactive->num_rows();

                    $this->db->select('offer_register.*');
                    $this->db->from('offer_register');
                    $where = '(offer_register.offer_close_date >= "' . $firstday_subactive . '" And offer_register.offer_close_date <= "' . $lastday_subactive . '")';
                    $this->db->where($where);
                    $this->db->where('status', 6);
                    $offer_subactive = $this->db->get();
                    $sales_order_subactive_count = $offer_subactive->num_rows();


                    // $this->db->select('sales_order_register.*');
                    // $this->db->from('sales_order_register');
                    // $where = '(sales_order_register.sales_order_date >= "'.$firstday_subactive.'" And sales_order_register.sales_order_date <= "'.$lastday_subactive.'")';
                    // $this->db->where($where);    
                    // $sales_order_subactive = $this->db->get();
                    // $sales_order_subactive_count = $sales_order_subactive->num_rows();


                    //Last Month Start

                    $currmonthsubone = date('m', strtotime('-1 month'));
                    $subone = date("F", mktime(0, 0, 0, $currmonthsubone));

                    $firstday_subone = date("Y-m-01", strtotime('-1 month'));
                    $lastday_subone = date("Y-m-t", strtotime('-1 month'));

                    $this->db->select('customer_master.*');
                    $this->db->from('customer_master');
                    $where = '(customer_master.date_entered >= "' . $firstday_subone . '" And customer_master.date_entered <= "' . $lastday_subone . '")';
                    $this->db->where($where);
                    $enquiry_subone = $this->db->get();
                    $enquiry_subone_count = $enquiry_subone->num_rows();


                    $this->db->select('offer_register.*');
                    $this->db->from('offer_register');
                    $where = '(offer_register.offer_date >= "' . $firstday_subone . '" And offer_register.offer_date <= "' . $lastday_subone . '")';
                    $this->db->where($where);
                    $offer_subone = $this->db->get();
                    $where1 = '(offer_register.status != "' . '10' . '" And offer_register.status != "' . '1' . '")';
                    $this->db->where($where1);
                    $offer_subone_count = $offer_subone->num_rows();


                    $this->db->select('offer_register.*');
                    $this->db->from('offer_register');
                    $where = '(offer_register.offer_close_date >= "' . $firstday_subone . '" And offer_register.offer_close_date <= "' . $lastday_subone . '")';
                    $this->db->where($where);
                    $this->db->where('status', 6);
                    $offer_subone = $this->db->get();
                    $sales_order_subone_count = $offer_subone->num_rows();


                    // $this->db->select('sales_order_register.*');
                    // $this->db->from('sales_order_register');
                    // $where = '(sales_order_register.sales_order_date >= "'.$firstday_subone.'" And sales_order_register.sales_order_date <= "'.$lastday_subone.'")';
                    // $this->db->where($where);    
                    // $sales_order_subone = $this->db->get();
                    // $sales_order_subone_count = $sales_order_subone->num_rows();


                    //SecondLast Month Start

                    $currmonthsubtwo = date('m', strtotime('-2 month'));
                    $subtwo = date("F", mktime(0, 0, 0, $currmonthsubtwo));

                    $firstday_subtwo = date("Y-m-01", strtotime('-2 month'));
                    $lastday_subtwo = date("Y-m-t", strtotime('-2 month'));

                    $this->db->select('customer_master.*');
                    $this->db->from('customer_master');
                    $where = '(customer_master.date_entered >= "' . $firstday_subtwo . '" And customer_master.date_entered <= "' . $lastday_subtwo . '")';
                    $this->db->where($where);
                    $enquiry_subtwo = $this->db->get();
                    $enquiry_subtwo_count = $enquiry_subtwo->num_rows();


                    $this->db->select('offer_register.*');
                    $this->db->from('offer_register');
                    $where = '(offer_register.offer_date >= "' . $firstday_subtwo . '" And offer_register.offer_date <= "' . $lastday_subtwo . '")';
                    $this->db->where($where);
                    $where1 = '(offer_register.status != "' . '10' . '" And offer_register.status != "' . '1' . '")';
                    $this->db->where($where1);
                    $offer_subtwo = $this->db->get();
                    $offer_subtwo_count = $offer_subtwo->num_rows();


                    $this->db->select('offer_register.*');
                    $this->db->from('offer_register');
                    $where = '(offer_register.offer_close_date >= "' . $firstday_subtwo . '" And offer_register.offer_close_date <= "' . $lastday_subtwo . '")';
                    $this->db->where($where);
                    $this->db->where('status', 6);
                    $offer_subtwo = $this->db->get();
                    $sales_order_subtwo_count = $offer_subtwo->num_rows();


                    // $this->db->select('sales_order_register.*');
                    // $this->db->from('sales_order_register');
                    // $where = '(sales_order_register.sales_order_date >= "'.$firstday_subtwo.'" And sales_order_register.sales_order_date <= "'.$lastday_subtwo.'")';
                    // $this->db->where($where);     
                    // $sales_order_subtwo = $this->db->get();
                    // $sales_order_subtwo_count = $sales_order_subtwo->num_rows();


                    //ThirdLast Month Start

                    $currmonthsubthree = date('m', strtotime('-3 month'));
                    $subthree = date("F", mktime(0, 0, 0, $currmonthsubthree));

                    $firstday_subthree = date("Y-m-01", strtotime('-3 month'));
                    $lastday_subthree = date("Y-m-t", strtotime('-3 month'));

                    $this->db->select('customer_master.*');
                    $this->db->from('customer_master');
                    $where = '(customer_master.date_entered >= "' . $firstday_subthree . '" And customer_master.date_entered <= "' . $lastday_subthree . '")';
                    $this->db->where($where);
                    $enquiry_subthree = $this->db->get();
                    $enquiry_subthree_count = $enquiry_subthree->num_rows();


                    $this->db->select('offer_register.*');
                    $this->db->from('offer_register');
                    $where = '(offer_register.offer_date >= "' . $firstday_subthree . '" And offer_register.offer_date <= "' . $lastday_subthree . '")';
                    $this->db->where($where);
                    $where1 = '(offer_register.status != "' . '10' . '" And offer_register.status != "' . '1' . '")';
                    $this->db->where($where1);
                    $offer_subthree = $this->db->get();
                    $offer_subthree_count = $offer_subthree->num_rows();


                    $this->db->select('offer_register.*');
                    $this->db->from('offer_register');
                    $where = '(offer_register.offer_close_date >= "' . $firstday_subthree . '" And offer_register.offer_close_date <= "' . $lastday_subthree . '")';
                    $this->db->where($where);
                    $this->db->where('status', 6);
                    $offer_subthree = $this->db->get();
                    $sales_order_subthree_count = $offer_subthree->num_rows();


                    // $this->db->select('sales_order_register.*');
                    // $this->db->from('sales_order_register');
                    // $where = '(sales_order_register.sales_order_date >= "'.$firstday_subthree.'" And sales_order_register.sales_order_date <= "'.$lastday_subthree.'")';
                    // $this->db->where($where);     
                    // $sales_order_subthree = $this->db->get();
                    // $sales_order_subthree_count = $sales_order_subthree->num_rows();


                    //FourthLast Month Start

                    $currmonthsubfour = date('m', strtotime('-4 month'));
                    $subfour = date("F", mktime(0, 0, 0, $currmonthsubfour));

                    $firstday_subfour = date("Y-m-01", strtotime('-4 month'));
                    $lastday_subfour = date("Y-m-t", strtotime('-4 month'));

                    $this->db->select('customer_master.*');
                    $this->db->from('customer_master');
                    $where = '(customer_master.date_entered >= "' . $firstday_subfour . '" And customer_master.date_entered <= "' . $lastday_subfour . '")';
                    $this->db->where($where);
                    $enquiry_subfour = $this->db->get();
                    $enquiry_subfour_count = $enquiry_subfour->num_rows();


                    $this->db->select('offer_register.*');
                    $this->db->from('offer_register');
                    $where = '(offer_register.offer_date >= "' . $firstday_subfour . '" And offer_register.offer_date <= "' . $lastday_subfour . '")';
                    $this->db->where($where);
                    $where1 = '(offer_register.status != "' . '10' . '" And offer_register.status != "' . '1' . '")';
                    $this->db->where($where1);
                    $offer_subfour = $this->db->get();
                    $offer_subfour_count = $offer_subfour->num_rows();


                    $this->db->select('offer_register.*');
                    $this->db->from('offer_register');
                    $where = '(offer_register.offer_close_date >= "' . $firstday_subfour . '" And offer_register.offer_close_date <= "' . $lastday_subfour . '")';
                    $this->db->where($where);
                    $this->db->where('status', 6);
                    $offer_subfour = $this->db->get();
                    $sales_order_subfour_count = $offer_subfour->num_rows();


                    // $this->db->select('sales_order_register.*');
                    // $this->db->from('sales_order_register');
                    // $where = '(sales_order_register.sales_order_date >= "'.$firstday_subfour.'" And sales_order_register.sales_order_date <= "'.$lastday_subfour.'")';
                    // $this->db->where($where);     
                    // $sales_order_subfour = $this->db->get();
                    // $sales_order_subfour_count = $sales_order_subfour->num_rows();


                    //FifthLast Month Start

                    $currmonthsubfive = date('m', strtotime('-5 month'));
                    $subfive = date("F", mktime(0, 0, 0, $currmonthsubfive));

                    $firstday_subfive = date("Y-m-01", strtotime('-5 month'));
                    $lastday_subfive = date("Y-m-t", strtotime('-5 month'));

                    $this->db->select('customer_master.*');
                    $this->db->from('customer_master');
                    $where = '(customer_master.date_entered >= "' . $firstday_subfive . '" And customer_master.date_entered <= "' . $lastday_subfive . '")';
                    $this->db->where($where);
                    $enquiry_subfive = $this->db->get();
                    $enquiry_subfive_count = $enquiry_subfive->num_rows();


                    $this->db->select('offer_register.*');
                    $this->db->from('offer_register');
                    $where = '(offer_register.offer_date >= "' . $firstday_subfive . '" And offer_register.offer_date <= "' . $lastday_subfive . '")';
                    $this->db->where($where);
                    $where1 = '(offer_register.status != "' . '10' . '" And offer_register.status != "' . '1' . '")';
                    $this->db->where($where1);
                    $offer_subfive = $this->db->get();
                    $offer_subfive_count = $offer_subfive->num_rows();



                    $this->db->select('offer_register.*');
                    $this->db->from('offer_register');
                    $where = '(offer_register.offer_close_date >= "' . $firstday_subfive . '" And offer_register.offer_close_date <= "' . $lastday_subfive . '")';
                    $this->db->where($where);
                    $this->db->where('status', 6);
                    $offer_subfive = $this->db->get();
                    $sales_order_subfive_count = $offer_subfive->num_rows();


                    // $this->db->select('sales_order_register.*');
                    // $this->db->from('sales_order_register');
                    // $where = '(sales_order_register.sales_order_date >= "'.$firstday_subfive.'" And sales_order_register.sales_order_date <= "'.$lastday_subfive.'")';
                    // $this->db->where($where);     
                    // $sales_order_subfive = $this->db->get();
                    // $sales_order_subfive_count = $sales_order_subfive->num_rows();


                    //SixthLast Month Start

                    $currmonthsubsix = date('m', strtotime('-6 month'));
                    $curryearsubsix = date('Y', strtotime('-6 month'));
                    $subsix = date("F", mktime(0, 0, 0, $currmonthsubsix));

                    // $firstday_subsix = date('Y-' . $currmonthsubsix . '-01');
                    // $lastday_subsix = date('Y-' . $currmonthsubsix . '-t');

                    $firstday_subsix = date("Y-m-01", strtotime('-6 month'));
                    $lastday_subsix = date("Y-m-t", strtotime('-6 month'));


                    $this->db->select('customer_master.*');
                    $this->db->from('customer_master');
                    $where = '(customer_master.date_entered >= "' . $firstday_subsix . '" And customer_master.date_entered <= "' . $lastday_subsix . '")';
                    $this->db->where($where);
                    $enquiry_subsix = $this->db->get();
                    $enquiry_subsix_count = $enquiry_subsix->num_rows();


                    // echo '<pre>';
                    // print_r($firstday_subsix);
                    // die();
                    $this->db->select('offer_register.*');
                    $this->db->from('offer_register');
                    $where = '(offer_register.offer_date >= "' . $firstday_subsix . '" And offer_register.offer_date <= "' . $lastday_subsix . '")';
                    $this->db->where($where);
                    $where1 = '(offer_register.status != "' . '10' . '" And offer_register.status != "' . '1' . '")';
                    $this->db->where($where1);
                    $offer_subsix = $this->db->get();
                    $offer_subsix_count = $offer_subsix->num_rows();


                    $this->db->select('offer_register.*');
                    $this->db->from('offer_register');
                    $where = '(offer_register.offer_close_date >= "' . $firstday_subsix . '" And offer_register.offer_close_date <= "' . $lastday_subsix . '")';
                    $this->db->where($where);
                    $this->db->where('status', 6);
                    $offer_subsix = $this->db->get();
                    $sales_order_subsix_count = $offer_subsix->num_rows();


                    // $this->db->select('sales_order_register.*');
                    // $this->db->from('sales_order_register');
                    // $where = '(sales_order_register.sales_order_date >= "'.$firstday_subsix.'" And sales_order_register.sales_order_date <= "'.$lastday_subsix.'")';
                    // $this->db->where($where);
                    // $sales_order_subsix = $this->db->get();
                    // $sales_order_subsix_count = $sales_order_subsix->num_rows();

                    //SixthLast Month End
                    ?>

                    <!-- Bar Chart Month -->
                    <input type="hidden" id="subactive" name="subactive" value="<?php echo $subactive; ?>" required>
                    <input type="hidden" id="subone" name="subone" value="<?php echo $subone; ?>" required>
                    <input type="hidden" id="subtwo" name="subtwo" value="<?php echo $subtwo; ?>" required>
                    <input type="hidden" id="subthree" name="subthree" value="<?php echo $subthree; ?>" required>
                    <input type="hidden" id="subfour" name="subfour" value="<?php echo $subfour; ?>" required>
                    <input type="hidden" id="subfive" name="subfive" value="<?php echo $subfive; ?>" required>
                    <input type="hidden" id="subsix" name="subsix" value="<?php echo $subsix; ?>" required>

                    <!-- Bar Chart Month Value -->

                    <input type="hidden" id="enquiry_subactive_count" name="enquiry_subactive_count" value="<?php echo $enquiry_subactive_count ?>" required>
                    <input type="hidden" id="offer_subactive_count" name="offer_subactive_count" value="<?php echo $offer_subactive_count ?>" required>
                    <input type="hidden" id="sales_order_subactive_count" name="sales_order_subactive_count" value="<?php echo $sales_order_subactive_count ?>" required>


                    <input type="hidden" id="enquiry_subone_count" name="enquiry_subone_count" value="<?php echo $enquiry_subone_count ?>" required>
                    <input type="hidden" id="offer_subone_count" name="offer_subone_count" value="<?php echo $offer_subone_count ?>" required>
                    <input type="hidden" id="sales_order_subone_count" name="sales_order_subone_count" value="<?php echo $sales_order_subone_count ?>" required>


                    <input type="hidden" id="enquiry_subtwo_count" name="enquiry_subtwo_count" value="<?php echo $enquiry_subtwo_count ?>" required>
                    <input type="hidden" id="offer_subtwo_count" name="offer_subtwo_count" value="<?php echo $offer_subtwo_count ?>" required>
                    <input type="hidden" id="sales_order_subtwo_count" name="sales_order_subtwo_count" value="<?php echo $sales_order_subtwo_count ?>" required>


                    <input type="hidden" id="enquiry_subthree_count" name="enquiry_subthree_count" value="<?php echo $enquiry_subthree_count ?>" required>
                    <input type="hidden" id="offer_subthree_count" name="offer_subthree_count" value="<?php echo $offer_subthree_count ?>" required>
                    <input type="hidden" id="sales_order_subthree_count" name="sales_order_subthree_count" value="<?php echo $sales_order_subthree_count ?>" required>


                    <input type="hidden" id="enquiry_subfour_count" name="enquiry_subfour_count" value="<?php echo $enquiry_subfour_count ?>" required>
                    <input type="hidden" id="offer_subfour_count" name="offer_subfour_count" value="<?php echo $offer_subfour_count ?>" required>
                    <input type="hidden" id="sales_order_subfour_count" name="sales_order_subfour_count" value="<?php echo $sales_order_subfour_count ?>" required>


                    <input type="hidden" id="enquiry_subfive_count" name="enquiry_subfive_count" value="<?php echo $enquiry_subfive_count ?>" required>
                    <input type="hidden" id="offer_subfive_count" name="offer_subfive_count" value="<?php echo $offer_subfive_count ?>" required>
                    <input type="hidden" id="sales_order_subfive_count" name="sales_order_subfive_count" value="<?php echo $sales_order_subfive_count ?>" required>


                    <input type="hidden" id="enquiry_subsix_count" name="enquiry_subsix_count" value="<?php echo $enquiry_subsix_count ?>" required>
                    <input type="hidden" id="offer_subsix_count" name="offer_subsix_count" value="<?php echo $offer_subsix_count ?>" required>
                    <input type="hidden" id="sales_order_subsix_count" name="sales_order_subsix_count" value="<?php echo $sales_order_subsix_count ?>" required>

                    <!-- BAR CHART -->
                    <div class="card card-success">
                      <div class="card-header">
                        <h3 class="card-title">Monthly Recap Report</h3>
                        <div class="card-tools">
                          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                          </button>
                          <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                        </div>
                      </div>

                      <div class="card-body">
                        <div class="chart">
                          <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                      </div>
                    </div>
                  <!-- </div> -->
                  <?php
                  $query = "SELECT offer_engg_name, COUNT(DISTINCT entity_id) AS Record FROM offer_register WHERE offer_date >= '" . $current_month_first_day . "' And offer_date <= '" . $current_month_last_day . "' And status != '10'  GROUP BY offer_engg_name ORDER BY offer_engg_name DESC LIMIT 5";
                  $save_execute = $this->db->query($query);
                  $emp_record_data = $save_execute->result();

                  ?>

                <!-- </div>
              </div> -->

              <?php
              $this->db->select_sum('total_amount_with_gst');
              $this->db->from('sales_order_product_relation');
              $this->db->join('sales_order_register', 'sales_order_product_relation.sales_order_id = sales_order_register.entity_id', 'INNER');
              $where = '(sales_order_register.status = "1" )';
              $this->db->where($where);
              $query = $this->db->get();
              $total_sales_order_amount = $query->row();
              $total_sales_order_amount_final = $total_sales_order_amount->total_amount_with_gst;
              $total_amount_with_gst_new_format = number_format($total_sales_order_amount_final, 3);


              $this->db->select_sum('total_amount_without_gst');
              $this->db->from('offer_product_relation');
              $this->db->join('offer_register', 'offer_product_relation.offer_id = offer_register.entity_id', 'INNER');
              $where = '(offer_register.status = "2" )';
              $this->db->where($where);
              $query = $this->db->get();
              $total_sales_order_amount_complete = $query->row();
              $total_sales_order_amount_final_complete = $total_sales_order_amount_complete->total_amount_without_gst;
              $total_amount_with_gst_new_format_complete = number_format($total_sales_order_amount_final_complete, 2);


              $this->db->select_sum('total_amount_without_gst');
              $this->db->from('offer_product_relation');
              $this->db->join('offer_register', 'offer_product_relation.offer_id = offer_register.entity_id', 'INNER');
              $where = '(offer_register.status = "4" )';
              $this->db->where($where);
              $query = $this->db->get();
              $total_sales_order_amount_lost = $query->row();
              $total_sales_order_amount_final_lost = $total_sales_order_amount_lost->total_amount_without_gst;
              $total_amount_with_gst_new_format_lost = number_format($total_sales_order_amount_final_lost, 2);


              $this->db->select_sum('total_amount_without_gst');
              $this->db->from('offer_product_relation');
              $this->db->join('offer_register', 'offer_product_relation.offer_id = offer_register.entity_id', 'INNER');
              $where = '(offer_register.status = "8" )';
              $this->db->where($where);
              $offer_register_a = $this->db->get();
              $offer_register_a_data = $offer_register_a->row();
              $offer_type_a_format = $offer_register_a_data->total_amount_without_gst;
              $offer_type_a = number_format($offer_type_a_format, 2);


              $this->db->select_sum('total_amount_without_gst');
              $this->db->from('offer_product_relation');
              $this->db->join('offer_register', 'offer_product_relation.offer_id = offer_register.entity_id', 'INNER');
              $where = '(offer_register.status = "8" )';
              $this->db->where($where);
              $offer_register_b = $this->db->get();
              $offer_register_b_data = $offer_register_b->row();
              $offer_type_b_format = $offer_register_b_data->total_amount_without_gst;
              $offer_type_b = number_format($offer_type_b_format, 2);
              ?>


              <!-- </div>
	          				</div>
	        			</div> -->

              <?php

              $this->db->select("*");
              $this->db->from('offer_register');
              $where = '(status != 1)';
              $this->db->where($where);
              $where1 = '(offer_register.offer_date >= "' . $current_month_first_day . '" And offer_register.offer_date <= "' . $current_month_last_day . '")';
              $this->db->where($where1);
              $query = $this->db->get();
              $total_offers = $query->num_rows();

              $this->db->select('offer_source,enquiry_source_master.source_name, COUNT("entity_id") as offer_count');
              $this->db->from('offer_register');
              $this->db->join('enquiry_source_master', 'enquiry_source_master.entity_id = offer_register.offer_source', 'INNER');
              $where = '( status != 1)';
              $this->db->where($where);
              $where1 = '(offer_register.offer_date >= "' . $current_month_first_day . '" And offer_register.offer_date <= "' . $current_month_last_day . '")';
              $this->db->where($where1);
              $this->db->group_by('offer_source');
              $query = $this->db->get();
              $source_results = $query->result();
              // echo '<pre>';
              // print_r($total_offers);
              // die();

              $india_mart_count = "0";
              $tradeindia_count = "0";
              $exporterindia_count = "0";
              $campaign_count = "0";
              $coldcall_count = "0";
              $conference_count = "0";
              $directcall_count = "0";
              $existing_count = "0";
              $email_count = "0";
              $expo_count = "0";
              $gem_count = "0";
              $other_count = "0";
              $principle_count = "0";
              $public_count = "0";
              $self_count = "0";
              $website_count = "0";
              $olddb_count = "0";
              $mouth_count = "0";
              $mid_count = "0";
              $gid_count = "0";
              $directmail_count = "0";
              $partner_count = "0";

              $india_mart_percentage_value = "0";
              $tradeindia_percentage_value = "0";
              $exporterindia_percentage_value = "0";
              $campaign_percentage_value = "0";
              $coldcall_percentage_value = "0";
              $conference_percentage_value = "0";
              $directcall_percentage_value = "0";
              $existing_percentage_value = "0";
              $email_percentage_value = "0";
              $expo_percentage_value = "0";
              $gem_percentage_value = "0";
              $other_percentage_value = "0";
              $principle_percentage_value = "0";
              $public_percentage_value = "0";
              $self_percentage_value = "0";
              $website_percentage_value = "0";
              $olddb_percentage_value = "0";
              $mouth_percentage_value = "0";
              $mid_percentage_value = "0";
              $gid_percentage_value = "0";
              $direct_mail_percentage_value = "0";
              $partner_percentage_value = "0";

              $source_percentage_array = array();
              foreach ($source_results as $source_result) {

                $offer_source = $source_result->offer_source;

                switch ($offer_source) {
                  case 1:
                    $india_mart_count = $source_result->offer_count;
                    $india_mart_percentage = 100 * $source_result->offer_count / $total_offers;
                    $india_mart_percentage_value = number_format($india_mart_percentage, 0);
                    // array_push($source_percentage_array,$india_mart_percentage_value);
                    break;

                  case '2':
                    $tradeindia_count = $source_result->offer_count;
                    $tradeindia_percentage = 100 * $source_result->offer_count / $total_offers;
                    $tradeindia_percentage_value = number_format($tradeindia_percentage, 0);
                    // array_push($source_percentage_array,$tradeindia_percentage_value);
                    break;


                  case '3':
                    $exporterindia_count = $source_result->offer_count;
                    $exporterindia_percentage = 100 * $source_result->offer_count / $total_offers;
                    $exporterindia_percentage_value = number_format($exporterindia_percentage, 2);
                    // array_push($source_percentage_array,$exporterindia_percentage_value);
                    break;



                  case '4':
                    $campaign_count = $source_result->offer_count;
                    $campaign_percentage = 100 * $source_result->offer_count / $total_offers;
                    $campaign_percentage_value = number_format($campaign_percentage, 0);
                    // array_push($source_percentage_array,$campaign_percentage_value);
                    break;


                  case '5':
                    $coldcall_count = $source_result->offer_count;
                    $coldcall_percentage = 100 * $source_result->offer_count / $total_offers;
                    $coldcall_percentage_value = number_format($coldcall_percentage, 0);
                    // array_push($source_percentage_array,$coldcall_percentage_value);
                    break;


                  case '6':
                    $conference_count = $source_result->offer_count;
                    $conference_percentage = 100 * $source_result->offer_count / $total_offers;
                    $conference_percentage_value = number_format($conference_percentage, 0);
                    // array_push($source_percentage_array,$conference_percentage_value);
                    break;


                  case '7':
                    $directcall_count = $source_result->offer_count;
                    $directcall_percentage = 100 * $source_result->offer_count / $total_offers;
                    $directcall_percentage_value = number_format($directcall_percentage, 0);
                    // array_push($source_percentage_array,$directcall_percentage_value);
                    break;


                  case '8':
                    $existing_count = $source_result->offer_count;
                    $existing_percentage = 100 * $source_result->offer_count / $total_offers;
                    $existing_percentage_value = number_format($existing_percentage, 0);
                    // array_push($source_percentage_array,$existing_percentage_value);
                    break;


                  case '9':
                    $email_count = $source_result->offer_count;
                    $email_percentage = 100 * $source_result->offer_count / $total_offers;
                    $email_percentage_value = number_format($email_percentage, 0);
                    // array_push($source_percentage_array,$email_percentage_value);
                    break;


                  case '10':
                    $expo_count = $source_result->offer_count;
                    $expo_percentage = 100 * $source_result->offer_count / $total_offers;
                    $expo_percentage_value = number_format($expo_percentage, 0);
                    // array_push($source_percentage_array,$expo_percentage_value);
                    break;


                  case '11':
                    $gem_count = $source_result->offer_count;
                    $gem_percentage = 100 * $source_result->offer_count / $total_offers;
                    $gem_percentage_value = number_format($gem_percentage, 0);
                    // array_push($source_percentage_array,$gem_percentage_value);
                    break;


                  case '12':
                    $other_count = $source_result->offer_count;
                    $other_percentage = 100 * $source_result->offer_count / $total_offers;
                    $other_percentage_value = number_format($other_percentage, 0);
                    // array_push($source_percentage_array,$other_percentage_value);
                    break;


                  case '13':
                    $principle_count = $source_result->offer_count;
                    $principle_percentage = 100 * $source_result->offer_count / $total_offers;
                    $principle_percentage_value = number_format($principle_percentage, 0);
                    // array_push($source_percentage_array,$principle_percentage_value);
                    break;


                  case '14':
                    $public_count = $source_result->offer_count;
                    $public_percentage = 100 * $source_result->offer_count / $total_offers;
                    $public_percentage_value = number_format($public_percentage, 0);
                    // array_push($source_percentage_array,$public_percentage_value);
                    break;


                  case '15':
                    $self_count = $source_result->offer_count;
                    $self_percentage = 100 * $source_result->offer_count / $total_offers;
                    $self_percentage_value = number_format($self_percentage, 0);
                    // array_push($source_percentage_array,$self_percentage_value);
                    break;


                  case '16':
                    $website_count = $source_result->offer_count;
                    $website_percentage = 100 * $source_result->offer_count / $total_offers;
                    $website_percentage_value = number_format($website_percentage, 0);
                    // array_push($source_percentage_array,$website_percentage_value);
                    break;


                  case '17':
                    $mouth_count = $source_result->offer_count;
                    $mouth_percentage = 100 * $source_result->offer_count / $total_offers;
                    $mouth_percentage_value = number_format($mouth_percentage, 0);
                    // array_push($source_percentage_array,$mouth_percentage_value);
                    break;


                  case '18':
                    $olddb_count = $source_result->offer_count;
                    $olddb_percentage = 100 * $source_result->offer_count / $total_offers;
                    $olddb_percentage_value = number_format($olddb_percentage, 0);
                    // array_push($source_percentage_array,$olddb_percentage_value);
                    break;


                  case '19':
                    $mid_count = $source_result->offer_count;
                    $mid_percentage = 100 * $source_result->offer_count / $total_offers;
                    $mid_percentage_value = number_format($mid_percentage, 0);
                    // array_push($source_percentage_array,$mid_percentage_value);
                    break;


                  case '20':
                    $gid_count = $source_result->offer_count;
                    $gid_percentage = 100 * $source_result->offer_count / $total_offers;
                    $gid_percentage_value = number_format($gid_percentage, 0);
                    // array_push($source_percentage_array,$gid_percentage_value);
                    break;


                  case '21':
                    $directmail_count = $source_result->offer_count;
                    $directmail_percentage = 100 * $source_result->offer_count / $total_offers;
                    $directmail_percentage_value = number_format($directmail_percentage, 0);
                    // array_push($source_percentage_array,$directmail_percentage_value);
                    break;


                  case '22':
                    $partner_count = $source_result->offer_count;
                    $partner_percentage = 100 * $source_result->offer_count / $total_offers;
                    $partner_percentage_value = number_format($partner_percentage, 0);
                    // array_push($source_percentage_array,$partner_percentage_value);
                    break;

                  default:
                    $other_count = $source_result->offer_count;
                    $other_percentage = 100 * $source_result->offer_count / $total_offers;
                    $other_percentage_value = number_format($other_percentage, 0);

                    // array_push($source_percentage_array,$other_percentage_value);
                    break;
                }

                $source_percentage_array[$source_result->source_name] = number_format((100 * $source_result->offer_count / $total_offers), 0);
                arsort($source_percentage_array);
              }

              //  echo '<pre>';
              //  print_r($source_percentage_array);
              //  echo '<br>';
              //  print_r($source_results);

              //  tag1



              // $this->db->select('*');
              // $this->db->from('enquiry_register');
              // $where = '(enquiry_register.enquiry_source = "'.'1'.'")';
              // $this->db->where($where);
              // $where1 = '(enquiry_register.enquiry_date >= "'.$current_month_first_day.'" And enquiry_register.enquiry_date <= "'.$current_month_last_day.'")';				
              // $this->db->where($where1);
              // $query = $this->db->get();
              // $enquiry_source_india_mart =  $query->num_rows();

              // $india_mart_percentage = $enquiry_source_india_mart/$enquiry_register_data_count*100;
              // $india_mart_percentage_value = number_format($india_mart_percentage, 2);


              // $this->db->select('*');
              // $this->db->from('enquiry_register');
              // $where = '(enquiry_register.enquiry_source = "'.'2'.'")';
              // $this->db->where($where);
              // $where1 = '(enquiry_register.enquiry_date >= "'.$current_month_first_day.'" And enquiry_register.enquiry_date <= "'.$current_month_last_day.'")';				
              // $this->db->where($where1);
              // $query = $this->db->get();
              // $enquiry_source_excibition =  $query->num_rows();

              // $excibition_percentage = $enquiry_source_excibition/$enquiry_register_data_count*100;
              // $excibition_percentage_value = number_format($excibition_percentage, 2);

              // $this->db->select('*');
              // $this->db->from('enquiry_register');
              // $where = '(enquiry_register.enquiry_source = "'.'3'.'")';
              // $this->db->where($where);
              // $where1 = '(enquiry_register.enquiry_date >= "'.$current_month_first_day.'" And enquiry_register.enquiry_date <= "'.$current_month_last_day.'")';				
              // $this->db->where($where1);
              // $query = $this->db->get();
              // $enquiry_source_mid =  $query->num_rows();

              // $mid_percentage = $enquiry_source_mid/$enquiry_register_data_count*100;
              // $mid_percentage_value = number_format($mid_percentage, 2);

              // $this->db->select('*');
              // $this->db->from('enquiry_register');
              // $where = '(enquiry_register.enquiry_source = "'.'4'.'")';
              // $this->db->where($where);
              // $where1 = '(enquiry_register.enquiry_date >= "'.$current_month_first_day.'" And enquiry_register.enquiry_date <= "'.$current_month_last_day.'")';				
              // $this->db->where($where1);
              // $query = $this->db->get();
              // $enquiry_source_phone_call =  $query->num_rows();

              // $phone_call_percentage = $enquiry_source_phone_call/$enquiry_register_data_count*100;
              // $phone_call_percentage_value = number_format($phone_call_percentage, 2);

              // $this->db->select('*');
              // $this->db->from('enquiry_register');
              // $where = '(enquiry_register.enquiry_source = "'.'5'.'")';
              // $this->db->where($where);
              // $where1 = '(enquiry_register.enquiry_date >= "'.$current_month_first_day.'" And enquiry_register.enquiry_date <= "'.$current_month_last_day.'")';				
              // $this->db->where($where1);
              // $query = $this->db->get();
              // $enquiry_source_direct_mail =  $query->num_rows();

              // $direct_mail_percentage = $enquiry_source_direct_mail/$enquiry_register_data_count*100;
              // $direct_mail_percentage_value = number_format($direct_mail_percentage, 2);

              // $this->db->select('*');
              // $this->db->from('enquiry_register');
              // $where = '(enquiry_register.enquiry_source = "'.'6'.'")';
              // $this->db->where($where);
              // $where1 = '(enquiry_register.enquiry_date >= "'.$current_month_first_day.'" And enquiry_register.enquiry_date <= "'.$current_month_last_day.'")';				
              // $this->db->where($where1);
              // $query = $this->db->get();
              // $enquiry_source_others =  $query->num_rows();

              // $others_percentage = $enquiry_source_others/$enquiry_register_data_count*100;
              // $others_percentage_value = number_format($others_percentage, 2);


              //funnel - active quotations Count (SCALE 1:1)

              $this->db->select('offer_register.*');
              $this->db->from('offer_register');
              $where = '(offer_register.status = "' . '2' . '" or offer_register.status = "' . '3' . '" )';
              $this->db->where($where);
              $active_offer_register_data = $this->db->get();
              $active_offer_count_data = $active_offer_register_data->num_rows();

              if (!empty($active_offer_count_data)) {
                $active_offer_count =  $active_offer_count_data;
              } else {
                $active_offer_count = 0;
              }


              //Funnel - Stage A Count (SCALE 1:1)
              $this->db->select('*');
              $this->db->from('offer_register');
              /*$where = '(offer_register.winning_chance  = "'.'1'.'")';*/
              $where = '(offer_register.status  = "' . '8' . '")';

              // $where = '(offer_register.status != "'.'4'.'" or offer_register.status != "'.'5'.'" or offer_register.status != "'.'6'.'")';
              $this->db->where($where);
              $offer_register_data = $this->db->get();
              $offer_register_data_count = $offer_register_data->num_rows();

              if (!empty($offer_register_data_count)) {
                $offer_register_count = $offer_register_data_count;
              } else {
                $offer_register_count = 0;
              }

              //Funnel - Stage B Count (SCALE 1:1)
              $this->db->select('*');
              $this->db->from('offer_register');
              $where = '(offer_register.status  = "' . '9' . '")';

              // $where = '(offer_register.status != "'.'4'.'" or offer_register.status != "'.'5'.'" or offer_register.status != "'.'6'.'")';
              $this->db->where($where);
              $offer_register_data = $this->db->get();
              $offer_register_data_count_2 = $offer_register_data->num_rows();

              if (!empty($offer_register_data_count_2)) {
                $offer_register_count_2 = $offer_register_data_count_2;
              } else {
                $offer_register_count_2 = 0;
              }

              //Stage A
              $this->db->select('*');
              $this->db->from('offer_register');
              $where = '(offer_register.status  = "' . '8' . '" )';

              // $where = '(offer_register.status != "'.'4'.'" or offer_register.status != "'.'5'.'" or offer_register.status != "'.'6'.'")';
              $this->db->where($where);
              $offer_register_data = $this->db->get();
              $offer_register_data_count_3 = $offer_register_data->num_rows();

              if (!empty($offer_register_data_count_3)) {
                $offer_register_count_1 = $offer_register_data_count_3;
              } else {
                $offer_register_count_1 = 1;
              }
              //tag1
              ?>

              <input type="hidden" id="enquiry_source_india_mart" name="enquiry_source_india_mart" value="<?php echo $india_mart_count ?>" required>

              <input type="hidden" id="enquiry_source_tradeindia" name="enquiry_source_tradeindia" value="<?php echo $tradeindia_count ?>" required>

              <input type="hidden" id="enquiry_source_exporterindia" name="enquiry_source_exporterindia" value="<?php echo $exporterindia_count ?>" required>

              <input type="hidden" id="enquiry_source_campaign" name="enquiry_source_campaign" value="<?php echo $campaign_count ?>" required>

              <input type="hidden" id="enquiry_source_coldcall" name="enquiry_source_coldcall" value="<?php echo $coldcall_count ?>" required>

              <input type="hidden" id="enquiry_source_conference" name="enquiry_source_conference" value="<?php echo $conference_count ?>" required>

              <input type="hidden" id="enquiry_source_directcall" name="enquiry_source_directcall" value="<?php echo $directcall_count ?>" required>

              <input type="hidden" id="enquiry_source_existing" name="enquiry_source_existing" value="<?php echo $existing_count ?>" required>

              <input type="hidden" id="enquiry_source_email" name="enquiry_source_email" value="<?php echo $email_count ?>" required>

              <input type="hidden" id="enquiry_source_excibition" name="enquiry_source_excibition" value="<?php echo $expo_count ?>" required>

              <input type="hidden" id="enquiry_source_gem" name="enquiry_source_gem" value="<?php echo $gem_count ?>" required>

              <input type="hidden" id="enquiry_source_others" name="enquiry_source_others" value="<?php echo $other_count ?>" required>

              <input type="hidden" id="enquiry_source_principle" name="enquiry_source_principle" value="<?php echo $principle_count ?>" required>

              <input type="hidden" id="enquiry_source_public" name="enquiry_source_public" value="<?php echo $public_count ?>" required>


              <input type="hidden" id="enquiry_source_self" name="enquiry_source_self" value="<?php echo $self_count ?>" required>

              <input type="hidden" id="enquiry_source_website" name="enquiry_source_website" value="<?php echo $website_count ?>" required>


              <input type="hidden" id="enquiry_source_mouth" name="enquiry_source_mouth" value="<?php echo $mouth_count ?>" required>


              <input type="hidden" id="enquiry_source_olddb" name="enquiry_source_olddb" value="<?php echo $olddb_count ?>" required>

              <input type="hidden" id="enquiry_source_mid" name="enquiry_source_mid" value="<?php echo $mid_count ?>" required>

              <input type="hidden" id="enquiry_source_gid" name="enquiry_source_gid" value="<?php echo $gid_count ?>" required>

              <input type="hidden" id="enquiry_source_direct_mail" name="enquiry_source_direct_mail" value="<?php echo $directmail_count ?>" required>

              <input type="hidden" id="enquiry_source_partner" name="enquiry_source_partner" value="<?php echo $partner_count ?>" required>

              <!-- <input type="hidden" id="india_mart_percentage" name="india_mart_percentage" value="<?php echo $india_mart_percentage ?>" required> -->

              <div class="row">
                <div class="col-md-6">
                  <div class="card card-success mb-5">
                    <div class="card-header">
                      <h3 class="card-title">Lead Source</h3>
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                        </button>
                      </div>
                    </div>

                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-8">
                          <canvas id="donutChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                        </div>
                        <div class="col-md-4">
                          <ul class="chart-legend clearfix">
                            <?php foreach ($source_percentage_array as $key => $source_percentage_value) { ?>
                              <li><i class="far fa-circle text-danger"></i> <?php echo $source_percentage_value . "% " . $key; ?></li>
                            <?php } ?>


                            <!-- <li ><i class="far fa-circle text-danger"></i> <?php echo $india_mart_percentage_value; ?>% - IndiaMart</li>
                                    <li><i class="far fa-circle" style="color: #6610f2;"></i> <?php echo $tradeindia_percentage_value ?>% - Trade India</li>
                                    <li><i class="far fa-circle" style="color: #C0C0C0;"></i> <?php echo $exporterindia_percentage_value ?>% - ExporterIndia</li>
                                    <li><i class="far fa-circle" style="color: #808080;"></i> <?php echo $campaign_percentage_value ?>% - Campaign</li>
                                    <li><i class="far fa-circle" style="color: #800000;"></i> <?php echo $coldcall_percentage_value ?>% - Cold Call</li>
                                    <li><i class="far fa-circle" style="color: #FF0000;"></i> <?php echo $conference_percentage_value ?>% -Conference</li>
                                    <li><i class="far fa-circle" style="color: #008000;"></i> <?php echo $directcall_percentage_value ?>% - Direct Call</li>
                                    <li><i class="far fa-circle" style="color: #FFFF00;"></i> <?php echo $directmail_percentage_value ?>% - Direct Mail</li>
                                    <li><i class="far fa-circle" style="color: #000080;"></i> <?php echo $existing_percentage_value ?>% - Existing Customer</li>
                                    <li><i class="far fa-circle" style="color: #0000FF;"></i> <?php echo $email_percentage_value ?>% - Email</li>
                                    <li><i class="far fa-circle text-success" style="color: #008080;></i> <?php echo $expo_percentage_value ?>% - Expo</li>
                                    <li><i class="far fa-circle" style="color: #00FFFF;"></i> <?php echo $gem_percentage_value ?>% - GEM</li>
                                    <li><i class="far fa-circle text-secondary" style="color: #f5f5dc;"></i> <?php echo $other_percentage_value ?>% - Other</li>
                                    <li><i class="far fa-circle" style="color: #faebd7;"></i> <?php echo $principle_percentage_value ?>% - Principle</li>
                                    <li><i class="far fa-circle" style="color: #00ffff;"></i> <?php echo $public_percentage_value ?>% - PR </li>
                                    <li><i class="far fa-circle" style="color: #ffe4c4;"></i> <?php echo $self_percentage_value ?>% - Self</li>
                                    <li><i class="far fa-circle" style="color: #ff7f50;"></i> <?php echo $website_percentage_value ?>% - Website</li>
                                    <li><i class="far fa-circle" style="color: #6495ed;"></i> <?php echo $mouth_percentage_value ?>% - Word Of Mouth</li>
                                    <li><i class="far fa-circle" style="color: #fff8dc;"></i> <?php echo $olddb_percentage_value ?>% - Old DB</li>
                                    <li><i class="far fa-circle text-warning" style="color: #bdb76b;"></i> <?php echo $mid_percentage_value ?>% - MID</li>
                                    <li><i class="far fa-circle text-info" style="color: #8fbc8f;"></i> <?php echo $gid_percentage_value ?>% - GID</li>
                                    <li><i class="far fa-circle" style="color: #008b8b;"></i> <?php echo $partner_percentage_value ?>% - Partner</li> -->
                          </ul>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;">
                  <div class="card card-success">
                    <div class="card-header">
                      <h3 class="card-title">Engineer Wise Offer</h3>
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">

                      <?php
                      $this->db->select('employee_master.emp_first_name, count("*") as offer_count');
                      $this->db->from('offer_register');
                      $this->db->join('employee_master', 'employee_master.entity_id = offer_register.offer_engg_name', 'LEFT');
                      $where = '(offer_register.status != "' . '10' . '" And offer_register.status != "' . '1' . '" )';
                      $this->db->where($where);
                      $where1 = '(offer_register.offer_date >= "' . $current_month_first_day . '" And offer_register.offer_date <= "' . $current_month_last_day . '")';
                      $this->db->where($where1);
                      $this->db->group_by('employee_master.emp_first_name');
                      $total_offer_count_query = $this->db->get();
                      $total_offer_count = $total_offer_count_query->num_rows();
                      $total_offer_result = $total_offer_count_query->result();

                      foreach ($total_offer_result as $key => $value) {
                        $employee_name = $value->emp_first_name;

                        $offer_count = $value->offer_count;

                        //   		$this->db->select('employee_master.*');
                        // $this->db->from('employee_master');
                        // $where = '(employee_master.entity_id = "'.$emp_id.'")';
                        // $this->db->where($where);
                        // $employee_master = $this->db->get();
                        // $employee_master_data = $employee_master->row_array();

                        // $Emp_name = $employee_master_data['emp_first_name'].' '.$employee_master_data['emp_last_name'];

                        $ratio_format = $offer_count / $offer_register_month_count * 100;

                        $ratio = number_format((float)$ratio_format, 2, '.', '');
                      ?>
                        <div class="progress-group mt-4">
                          <span><?php echo $employee_name; ?></span>
                          <span class="float-right"><b><?php echo $offer_count; ?></b>/<?php echo $offer_register_month_count; ?></span>
                          <div class="progress progress-sm">
                            <div class="progress-bar bg-primary" style="width: <?php echo $ratio; ?>%"></div>
                          </div>
                        </div>
                      <?php } ?>

                    </div>
                  <!-- </div>
                </div>
              </div> -->

              <?php

              $this->db->select('enquiry_register.*');
              $this->db->from('enquiry_register');
              $where = '(enquiry_register.enquiry_status = "' . '1' . '")';
              $this->db->where($where);
              $where1 = '(enquiry_register.enquiry_date >= "' . $current_month_first_day . '" And enquiry_register.enquiry_date <= "' . $current_month_last_day . '")';
              $this->db->where($where1);
              $qualified_enquiry_register_data = $this->db->get();
              $qualified_enquiry_count = $qualified_enquiry_register_data->num_rows();


              if (!empty($qualified_enquiry_count)) {
                $qualified_enquiry_count = $qualified_enquiry_count;
              } else {
                $qualified_enquiry_count = 1;
              }

              $this->db->select('enquiry_register.*');
              $this->db->from('enquiry_register');
              $where = '(enquiry_register.enquiry_status = "' . '2' . '")';
              $this->db->where($where);
              $where1 = '(enquiry_register.enquiry_date >= "' . $current_month_first_day . '" And enquiry_register.enquiry_date <= "' . $current_month_last_day . '")';
              $this->db->where($where1);
              $qout_enquiry_register_data = $this->db->get();
              $qout_enquiry_count = $qout_enquiry_register_data->num_rows();

              if (!empty($qout_enquiry_count)) {
                $qout_enquiry_count = $qout_enquiry_count;
              } else {
                $qout_enquiry_count = 1;
              }

              $this->db->select('enquiry_register.*');
              $this->db->from('enquiry_register');
              $where = '(enquiry_register.enquiry_status = "' . '5' . '" or enquiry_register.enquiry_status = "' . '6' . '")';
              $this->db->where($where);
              $where1 = '(enquiry_register.enquiry_date >= "' . $current_month_first_day . '" And enquiry_register.enquiry_date <= "' . $current_month_last_day . '")';
              $this->db->where($where1);
              $reg_disqualify_enquiry_register_data = $this->db->get();
              $reg_disqualify_enquiry_count = $reg_disqualify_enquiry_register_data->num_rows();

              if (!empty($reg_disqualify_enquiry_count)) {
                $reg_disqualify_enquiry_count = $reg_disqualify_enquiry_count;
              } else {
                $reg_disqualify_enquiry_count = 1;
              }

              $this->db->select('enquiry_register.*');
              $this->db->from('enquiry_register');
              $where = '(enquiry_register.enquiry_status = "' . '3' . '")';
              $this->db->where($where);
              $where1 = '(enquiry_register.enquiry_date >= "' . $current_month_first_day . '" And enquiry_register.enquiry_date <= "' . $current_month_last_day . '")';
              $this->db->where($where1);
              $order_enquiry_register_data = $this->db->get();
              $order_enquiry_count = $order_enquiry_register_data->num_rows();

              if (!empty($order_enquiry_count)) {
                $order_enquiry_count = $order_enquiry_count;
              } else {
                $order_enquiry_count = 1;
              }

              $this->db->select('enquiry_register.*');
              $this->db->from('enquiry_register');
              $where = '(enquiry_register.enquiry_status = "' . '4' . '" or enquiry_register.enquiry_status = "' . '7' . '")';
              $this->db->where($where);
              $where1 = '(enquiry_register.enquiry_date >= "' . $current_month_first_day . '" And enquiry_register.enquiry_date <= "' . $current_month_last_day . '")';
              $this->db->where($where1);
              $lost_enquiry_register_data = $this->db->get();
              $lost_enquiry_count = $lost_enquiry_register_data->num_rows();

              if (!empty($lost_enquiry_count)) {
                $lost_enquiry_count = $lost_enquiry_count;
              } else {
                $lost_enquiry_count = 1;
              }

              ?>

              <input type="hidden" id="qualified_enquiry_count" name="qualified_enquiry_count" value="<?php echo $qualified_enquiry_count ?>" required>

              <input type="hidden" id="qout_enquiry_count" name="qout_enquiry_count" value="<?php echo $qout_enquiry_count ?>" required>

              <input type="hidden" id="reg_disqualify_enquiry_count" name="reg_disqualify_enquiry_count" value="<?php echo $reg_disqualify_enquiry_count ?>" required>

              <input type="hidden" id="order_enquiry_count" name="order_enquiry_count" value="<?php echo $order_enquiry_count ?>" required>

              <input type="hidden" id="lost_enquiry_count" name="lost_enquiry_count" value="<?php echo $lost_enquiry_count ?>" required>

              <div class="col-md-12">
                <!-- <div class="card">
			              			<div class="card-header">
			                			<h3 class="card-title">Lead Stag</h3>
						                <div class="card-tools">
						                  	<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
						                  	</button>
						                  	<button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
						                  	</button>
					                	</div>
					              	</div>

					              	<div class="card-body">
					                	<div class="row">
					                  		<div class="col-md-12">
					                      		
					                      		<canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
					                  		</div>
					                	</div>
					              	</div>
					            </div> -->

                <!-- <div class="card">
					              	<div class="card-header border-transparent">
					                	<h3 class="card-title">Offer Tracking Followup Notification</h3>
					                	<div class="card-tools">
					                  		<button type="button" class="btn btn-tool" data-card-widget="collapse">
					                    	<i class="fas fa-minus"></i>
					                  		</button>
						                  	<button type="button" class="btn btn-tool" data-card-widget="remove">
						                    	<i class="fas fa-times"></i>
						                  	</button>
					                	</div>
					              	</div>

					              	<div class="card-body p-0">
					                	<div class="table-responsive">
					                  		<table class="table m-0">
					                    		<thead>
								                    <tr>
								                      	<th>Tracking No</th>
								                      	<th>Tracking Date</th>
								                      	<th>Offer No</th>
								                      	<th>Tracking Record</th>
								                    </tr>
					                    		</thead>
						                    	<tbody>
							                      	<?php

                                      $current_date = date('Y-m-d');

                                      $this->db->select('offer_tracking_master.*,
							                                         offer_register.offer_no');
                                      $this->db->from('offer_tracking_master');
                                      $where = '(offer_tracking_master.tracking_date = "' . $current_date . '")';
                                      $this->db->where($where);
                                      $this->db->join('offer_register', 'offer_tracking_master.offer_id = offer_register.entity_id', 'INNER');
                                      $this->db->order_by('offer_tracking_master.entity_id', 'DESC');

                                      $query = $this->db->get();
                                      $query_result = $query->result();

                                      $no = 0;
                                      foreach ($query_result as $row) :
                                      ?>
								                    <tr>
						                      			<td><a href="vw_offer_tracking_entry"><?php echo $row->tracking_number; ?></a></td>
						                      			<td>
						                        			<div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo date("d-m-Y", strtotime($row->tracking_date)); ?></div>
						                      			</td>
								                      	<td><?php echo $row->offer_no; ?></td>
								                      	<td><?php echo $row->tracking_record; ?></td>
						                    		</tr>
						                    		<?php endforeach; ?>
						                    	</tbody>
					                  		</table>
					                	</div>
	              					</div>
	            				</div> -->
              </div>


              <!-- <div class="col-md-6">
				            	<div class="card">
				              		<div class="card-header border-transparent">
				                		<h3 class="card-title">Latest Orders</h3>
				                		<div class="card-tools">
				                  			<button type="button" class="btn btn-tool" data-card-widget="collapse">
				                    			<i class="fas fa-minus"></i>
				                  			</button>
						                  	<button type="button" class="btn btn-tool" data-card-widget="remove">
						                    	<i class="fas fa-times"></i>
						                  	</button>
				                		</div>
				              		</div>

					              	<div class="card-body p-0">
					                	<div class="table-responsive">
					                  		<table class="table m-0">
					                    		<thead>
					                    			<tr>
					                      				<th>Order No. </th>
					                  					<th>Order Description</th>
					                      				<th>Order Date</th>
					                    			</tr>
					                    		</thead>
					                    		<tbody>
						                      		<?php

                                      $this->db->select('sales_order_register.*,
								                      	employee_master.emp_first_name');
                                      $this->db->from('sales_order_register');
                                      $where = '(sales_order_register.status = "' . '2' . '" And sales_order_register.order_execution_status IS NULL)';
                                      $this->db->where($where);
                                      $this->db->join('employee_master', 'sales_order_register.order_engg_name = employee_master.entity_id', 'INNER');
                                      $this->db->order_by('sales_order_register.entity_id', 'DESC');
                                      $this->db->limit(10);
                                      $this->db->group_by('sales_order_register.entity_id');
                                      $query = $this->db->get();
                                      $query_result = $query->result();

                                      $no = 0;

                                      foreach ($query_result as $row) :
                                        $no++;
                                        $entity_id = $row->entity_id;
                                        $offer_id = $row->offer_id;

                                        if ($offer_id == Null) {
                                          $offer_no = 'NA';
                                          $enquiry_no = 'NA';
                                        } else {
                                          $this->db->select('offer_register.*');
                                          $this->db->from('offer_register');
                                          $where = '(offer_register.entity_id = "' . $offer_id . '" )';
                                          $this->db->where($where);
                                          $query = $this->db->get();
                                          $offer_id_result =  $query->row_array();
                                          $offer_no = $offer_id_result['offer_no'];
                                          $enquiry_id = $offer_id_result['enquiry_id'];

                                          $this->db->select('enquiry_register.*');
                                          $this->db->from('enquiry_register');
                                          $where = '(enquiry_register.entity_id = "' . $enquiry_id . '" )';
                                          $this->db->where($where);
                                          $query = $this->db->get();
                                          $enquiry_id_result =  $query->row_array();
                                          $enquiry_no = $enquiry_id_result['enquiry_no'];
                                        }
                                      ?>
						                    			<tr>
									                      	<td><a href=""><?php echo $row->sales_order_no; ?></a></td>
									                      	<td><?php echo $row->sales_order_description; ?></td>
						                      				<td>
						                        				<div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo date("d-m-Y", strtotime($row->sales_order_date)); ?></div>
						                      				</td>
						                    			</tr>
					                    			<?php endforeach; ?>
					                    		</tbody>
					                  		</table>
					                	</div>
					              	</div>
					            </div>
			          		</div> -->
            </div>
            
            </div>
            <!-- <div class="row"> -->
                                <div class="col-md-12">
                                    <div class="card card-success">
                                        <div class="card-header">
                                            <h3 class="card-title">Task Details</h3>
                                        </div>

                                        <div class="card-body">

                                        <div class="btn-group" style="margin-bottom: 15px; margin-left: 15px;">
                                             
                                              <div class="dropdown-menu">
                                                <a class="dropdown-item btn btn-block btn-primary" href="overdue_task_index">Overdue Tasks</a>
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
                                                                    date_default_timezone_set("Asia/Calcutta");
                                                                    $current_date = date('Y-m-d');
                                                              
                                                                    $emp_id = $this->session->userdata('emp_id');
                                                              
                                                              
                                                                    $this->db->select("offer_register.*,eq1.* ,customer_master.customer_name, customer_contact_master.contact_person, customer_contact_master.first_contact_no, employee_master.email_id, employee_master.emp_first_name, offer_register.status as offer_status");
                                                                    $this->db->from('enquiry_tracking_master as eq1');
                                                                    $this->db->join('offer_register', 'offer_register.entity_id = eq1.offer_id','INNER');
                                                                    $this->db->join('customer_master', 'customer_master.entity_id = offer_register.customer_id','INNER');
                                                                    $this->db->join('customer_contact_master', 'offer_register.contact_person_id = customer_contact_master.entity_id', 'INNER');
                                                                    $this->db->join('employee_master', 'offer_register.offer_engg_name = employee_master.entity_id', 'INNER');
                                                                    // $this->db->where('eq1.entity_id = (SELECT MAX(eq2.entity_id) FROM enquiry_tracking_master as eq2 WHERE eq1.offer_id = eq2.offer_id && eq2.status = 2)',NULL,FALSE);
                                                                    $where = '(eq1.action_due_date != "" And eq1.next_action != "" And eq1.status = "2" And offer_register.offer_engg_name = "'.$emp_id.'")';
                                                                    $this->db->where($where);
                                                                    $where1 = '(offer_register.status <= 3 or offer_register.status = 8 or offer_register.status = 9)';
                                                                    $this->db->where($where1);
                                                                    $this->db->order_by('eq1.tracking_date','DESC');
                                                                    // $this->db->group_by('eq1.offer_id');
                                                                    $enquiry_tracking_details = $this->db->get()->result();
                                                                    
                                                                 
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
                            <!-- </div> -->
            </div>
      </section>
      
    </div>

    <div class="modal fade" id="modal-sm">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Notification Alert!</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>You have one or more overdue tasks&hellip;</p>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="notification_alert">Check Notifications</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->




    <?php $this->load->view('footer'); ?>

    <aside class="control-sidebar control-sidebar-dark">
    </aside>
  </div>

  <!-- jQuery -->
  <script src="<?php echo base_url() . 'assets/plugins/jquery/jquery.min.js' ?>"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="<?php echo base_url() . 'assets/plugins/jquery-ui/jquery-ui.min.js' ?>"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

  <script>
    $(function() {
      /* ChartJS
       * -------
       * Here we will create a few charts using ChartJS
       */

      //--------------
      //- AREA CHART -
      //--------------

      // Get context with jQuery - using jQuery's .get() method.
      /*var areaChartCanvas = $('#areaChart').get(0).getContext('2d')*/

      var subactive = document.getElementById('subactive').value;

      var subone = document.getElementById('subone').value;
      var subtwo = document.getElementById('subtwo').value;
      var subthree = document.getElementById('subthree').value;
      var subfour = document.getElementById('subfour').value;
      var subfive = document.getElementById('subfive').value;
      var subsix = document.getElementById('subsix').value;

      var enquiry_subactive_count = document.getElementById('enquiry_subactive_count').value;
      var offer_subactive_count = document.getElementById('offer_subactive_count').value;
      var sales_order_subactive_count = document.getElementById('sales_order_subactive_count').value;

      var enquiry_subone_count = document.getElementById('enquiry_subone_count').value;
      var offer_subone_count = document.getElementById('offer_subone_count').value;
      var sales_order_subone_count = document.getElementById('sales_order_subone_count').value;


      var enquiry_subtwo_count = document.getElementById('enquiry_subtwo_count').value;
      var offer_subtwo_count = document.getElementById('offer_subtwo_count').value;
      var sales_order_subtwo_count = document.getElementById('sales_order_subtwo_count').value;


      var enquiry_subthree_count = document.getElementById('enquiry_subthree_count').value;
      var offer_subthree_count = document.getElementById('offer_subthree_count').value;
      var sales_order_subthree_count = document.getElementById('sales_order_subthree_count').value;


      var enquiry_subfour_count = document.getElementById('enquiry_subfour_count').value;
      var offer_subfour_count = document.getElementById('offer_subfour_count').value;
      var sales_order_subfour_count = document.getElementById('sales_order_subfour_count').value;


      var enquiry_subfive_count = document.getElementById('enquiry_subfive_count').value;
      var offer_subfive_count = document.getElementById('offer_subfive_count').value;
      var sales_order_subfive_count = document.getElementById('sales_order_subfive_count').value;


      var enquiry_subsix_count = document.getElementById('enquiry_subsix_count').value;
      var offer_subsix_count = document.getElementById('offer_subsix_count').value;
      var sales_order_subsix_count = document.getElementById('sales_order_subsix_count').value;

      var areaChartData = {
        labels: [subsix, subfive, subfour, subthree, subtwo, subone, subactive],
        datasets: [{
            label: 'Quotation',
            backgroundColor: 'rgba(60,141,188,0.9)',
            borderColor: 'rgba(60,141,188,0.8)',
            pointRadius: false,
            pointColor: '#3b8bba',
            pointStrokeColor: 'rgba(60,141,188,1)',
            pointHighlightFill: '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data: [offer_subsix_count, offer_subfive_count, offer_subfour_count, offer_subthree_count, offer_subtwo_count, offer_subone_count, offer_subactive_count]
          },
          {
            label: 'Lead',
            backgroundColor: 'rgba(210, 214, 222, 1)',
            borderColor: 'rgba(210, 214, 222, 1)',
            pointRadius: false,
            pointColor: 'rgba(210, 214, 222, 1)',
            pointStrokeColor: '#c1c7d1',
            pointHighlightFill: '#fff',
            pointHighlightStroke: 'rgba(220,220,220,1)',
            data: [enquiry_subsix_count, enquiry_subfive_count, enquiry_subfour_count, enquiry_subthree_count, enquiry_subtwo_count, enquiry_subone_count, enquiry_subactive_count]
          },
          {
            label: 'Orders',
            backgroundColor: 'rgba(128,0,0)',
            borderColor: 'rgba(210, 214, 222, 1)',
            pointRadius: false,
            pointColor: 'rgba(210, 214, 222, 1)',
            pointStrokeColor: '#c1c7d1',
            pointHighlightFill: '#fff',
            pointHighlightStroke: 'rgba(220,220,220,1)',
            data: [sales_order_subsix_count, sales_order_subfive_count, sales_order_subfour_count, sales_order_subthree_count, sales_order_subtwo_count, sales_order_subone_count, sales_order_subactive_count]
          },
        ]
      }

      var areaChartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
          display: false
        },
        scales: {
          xAxes: [{
            gridLines: {
              display: false,
            }
          }],
          yAxes: [{
            gridLines: {
              display: false,
            }
          }]
        }
      }

      //-------------
      //- BAR CHART -
      //-------------

      var barChartCanvas = $('#barChart').get(0).getContext('2d');
      var barChartData = jQuery.extend(true, {}, areaChartData)
      var temp0 = areaChartData.datasets[0]
      var temp1 = areaChartData.datasets[1]
      barChartData.datasets[0] = temp1
      barChartData.datasets[1] = temp0

      var barChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        datasetFill: false
      }

      var barChart = new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions
      })

      // This will get the first returned node in the jQuery collection.
      /*var areaChart       = new Chart(areaChartCanvas, { 
        	type: 'line',
        	data: areaChartData, 
        	options: areaChartOptions
      })*/



      //-------------
      //- DONUT CHART -
      //-------------
      // Get context with jQuery - using jQuery's .get() method.
      var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
      //var enquiry_source_one = $data_result.val();
      var enquiry_source_india_mart = document.getElementById('enquiry_source_india_mart').value;
      var enquiry_source_tradeindia = document.getElementById('enquiry_source_tradeindia').value;
      var enquiry_source_exporterindia = document.getElementById('enquiry_source_exporterindia').value;
      var enquiry_source_campaign = document.getElementById('enquiry_source_campaign').value;
      var enquiry_source_coldcall = document.getElementById('enquiry_source_coldcall').value;
      var enquiry_source_conference = document.getElementById('enquiry_source_conference').value;
      var enquiry_source_directcall = document.getElementById('enquiry_source_directcall').value;
      var enquiry_source_existing = document.getElementById('enquiry_source_existing').value;
      var enquiry_source_email = document.getElementById('enquiry_source_email').value;
      var enquiry_source_excibition = document.getElementById('enquiry_source_excibition').value;
      var enquiry_source_gem = document.getElementById('enquiry_source_gem').value;
      var enquiry_source_other = document.getElementById('enquiry_source_others').value;
      var enquiry_source_principle = document.getElementById('enquiry_source_principle').value;
      var enquiry_source_public = document.getElementById('enquiry_source_public').value;
      var enquiry_source_self = document.getElementById('enquiry_source_self').value;
      var enquiry_source_website = document.getElementById('enquiry_source_website').value;
      var enquiry_source_mouth = document.getElementById('enquiry_source_mouth').value;
      var enquiry_source_olddb = document.getElementById('enquiry_source_olddb').value;
      var enquiry_source_mid = document.getElementById('enquiry_source_mid').value;
      var enquiry_source_gid = document.getElementById('enquiry_source_gid').value;
      var enquiry_source_direct_mail = document.getElementById('enquiry_source_direct_mail').value;
      var enquiry_source_partner = document.getElementById('enquiry_source_partner').value;

      // var india_mart_percentage = document.getElementById('india_mart_percentage').value;
      var donutData = {
        labels: [
          'Indiamart',
          'Trade India',
          'Exporter',
          'Campaign',
          'Coldcall',
          'Conference',
          'Directcall',
          'Existing',
          'Email',
          'Exhibition',
          'GEM',
          'Other',
          'Principle',
          'PR',
          'Self',
          'Word of Mouth',
          'Old DB',
          'MID',
          'Website',
          'GID',
          'Directmail',
          'Partner'
        ],
        datasets: [{
          data: [
            enquiry_source_india_mart,
            enquiry_source_tradeindia,
            enquiry_source_exporterindia,
            enquiry_source_campaign,
            enquiry_source_coldcall,
            enquiry_source_conference,
            enquiry_source_directcall,
            enquiry_source_existing,
            enquiry_source_email,
            enquiry_source_excibition,
            enquiry_source_gem,
            enquiry_source_other,
            enquiry_source_principle,
            enquiry_source_public,
            enquiry_source_self,
            enquiry_source_mouth,
            enquiry_source_olddb,
            enquiry_source_mid,
            enquiry_source_website,
            enquiry_source_gid,
            enquiry_source_direct_mail,
            enquiry_source_partner
          ],
          backgroundColor: ['#C0C0C0', '#808080', '#800000', '#FF0000', '#008000', '#00FF00', '#808000', '#FFFF00', '#000080', '#0000FF', '#008080', '#f0f8ff', '#f5f5dc', '#a52a2a', '#ff7f50', '#6495ed', '#dc143c', '#00008b', '#008b8b', '#bdb76b', '#8fbc8f', '#ff1493'],
        }]
      }

      var donutOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
          display: false
        }
      }


      //Create pie or douhnut chart
      // You can switch between pie and douhnut using the method below.
      var donutChart = new Chart(donutChartCanvas, {
        type: 'doughnut',
        data: donutData,
        options: donutOptions
      })





      // var donutChartCanvas1 = $('#pieChart').get(0).getContext('2d')
      // var qualified_enquiry_count = document.getElementById('qualified_enquiry_count').value;
      // var qout_enquiry_count = 1;

      // var reg_disqualify_enquiry_count = document.getElementById('reg_disqualify_enquiry_count').value;
      // var order_enquiry_count = document.getElementById('order_enquiry_count').value;
      // var lost_enquiry_count = document.getElementById('lost_enquiry_count').value;

      // var pieData        = {
      //   	labels: [
      //       'Qualified Lead', 
      //       'Quotations',
      //       'Regretted/Disqualified Leads',
      //       'Orders', 
      //       'Lost/regretted Leads', 
      //   	],
      //   		datasets: [
      //       {
      //         	data: [qualified_enquiry_count,qout_enquiry_count,reg_disqualify_enquiry_count,order_enquiry_count,lost_enquiry_count],
      //         	backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#6610f2'],
      //       }
      //   	]
      // }

      // //-------------
      // //- PIE CHART -
      // //-------------
      // // Get context with jQuery - using jQuery's .get() method.
      // var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
      // var pieData        = pieData;

      // var pieOptions     = {
      //   maintainAspectRatio : false,
      //   responsive : true,
      // }
      // //Create pie or douhnut chart
      // // You can switch between pie and douhnut using the method below.
      // var pieChart = new Chart(pieChartCanvas, {
      //   	type: 'pie',
      //   	data: pieData,
      //   	options: pieOptions      
      // })   
    })
  </script>

  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>

  <script type="text/javascript">
    window.onload = function() {

      var chart = new CanvasJS.Chart("chartContainer", {
        title: {
          text: "Sales Funnel"
        },
        data: [{
          type: "funnel",
          indexLabel: "{label} [{y}] {label1} [{z}]",
          toolTipContent: "{label} - {y} {label1} [{z}]",
          dataPoints: [{
              y: <?php echo $active_offer_count; ?>,
              label: "Active Offers",
              z: <?php echo $active_value; ?>,
              label1: "Rs.(Lacs)"
            },
            {
              y: <?php echo $offer_register_count_2; ?>,
              label: "Stage B",
              z: <?php echo $valuee22; ?>,
              label1: "Rs.(Lacs)"
            },
            {
              y: <?php echo $offer_register_count_1; ?>,
              label: "Stage A",
              z: <?php echo $valuee11; ?>,
              label1: "Rs.(Lacs)"
            }
          ]
        }]
      });
      chart.render();
    }
  </script>

  <script>
    // var chart = new CanvasJS.Chart("chartContainer", {
    //   	title: {
    //     	text: "Sales Funnel"
    //   	},
    //   	data: [{
    //     	type: "funnel",
    //     	indexLabel: "{label} [{y}] {label1} [{z}]",
    //         toolTipContent: "{label} - {y} {label1} [{z}]",
    //     	dataPoints: [
    //       		{ y: <?php echo $active_offer_count; ?>, label: "Active"},

    //       		{ y: <?php echo $offer_register_count_2; ?>, label: "Stage B", z: <?php echo $valuee22; ?> , label1: "value"},
    //       		{ y:<?php echo $offer_register_count_1; ?> , label: "Stage A", z: <?php echo $valuee11; ?> , label1: "value"},
    //       		{ y:<?php echo $won_order_register_count; ?>, label: "Working/Sales Order" , z: <?php echo $funnel_won_order_amount; ?> , label1: "value"}
    //     	]
    //   	}]
    // });
    // 	chart.render();
    // }
  </script>

  <script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?php echo base_url() . 'assets/plugins/bootstrap/js/bootstrap.bundle.min.js' ?>"></script>
  <!-- ChartJS -->
  <script src="<?php echo base_url() . 'assets/plugins/chart.js/Chart.min.js' ?>"></script>
  <!-- Sparkline -->
  <script src="<?php echo base_url() . 'assets/plugins/sparklines/sparkline.js' ?>"></script>
  <!-- JQVMap -->
  <script src="<?php echo base_url() . 'assets/plugins/jqvmap/jquery.vmap.min.js' ?>"></script>
  <script src="<?php echo base_url() . 'assets/plugins/jqvmap/maps/jquery.vmap.usa.js' ?>"></script>
  <!-- jQuery Knob Chart -->
  <script src="<?php echo base_url() . 'assets/plugins/jquery-knob/jquery.knob.min.js' ?>"></script>
  <!-- daterangepicker -->
  <script src="<?php echo base_url() . 'assets/plugins/moment/moment.min.js' ?>"></script>
  <script src="<?php echo base_url() . 'assets/plugins/daterangepicker/daterangepicker.js' ?>"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="<?php echo base_url() . 'assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js' ?>"></script>
  <!-- Summernote -->
  <script src="<?php echo base_url() . 'assets/plugins/summernote/summernote-bs4.min.js' ?>"></script>
  <!-- overlayScrollbars -->
  <script src="<?php echo base_url() . 'assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js' ?>"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo base_url() . 'assets/dist/js/adminlte.js' ?>"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <!-- <script src="assets/dist/js/pages/dashboard.js'?>"></script> -->

  <!-- <script src="<?php echo base_url() . 'assets/dist/js/pages/dashboard2.js' ?>"></script> -->
  <!-- AdminLTE for demo purposes -->
  <script src="<?php echo base_url() . 'assets/dist/js/demo.js' ?>"></script>


  <script src="<?php echo base_url() . 'assets/plugins/jquery/jquery.min.js' ?>"></script>
  <!-- Bootstrap 4 -->
  <script src="<?php echo base_url() . 'assets/plugins/bootstrap/js/bootstrap.bundle.min.js' ?>"></script>
  <!-- ChartJS -->
  <script src="<?php echo base_url() . 'assets/plugins/chart.js/Chart.min.js' ?>"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo base_url() . 'assets/dist/js/adminlte.min.js' ?>"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="<?php echo base_url() . 'assets/dist/js/demo.js' ?>"></script>
  <!-- DataTables -->
  <script src="<?php echo base_url() . 'assets/plugins/datatables/jquery.dataTables.js' ?>"></script>
  <script src="<?php echo base_url() . 'assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js' ?>"></script>

  <script>
    $(document).ready(function() {
      $('#example1').DataTable();
    });
  </script>

  <script type="text/javascript">
    $(document).on('click', '#add_labour', function() {

      var Track_id = document.getElementById('Track_id').value;
      var due_date = document.getElementById('pop_up_due_date').value;
      var remark = document.getElementById('pop_up_remark').value;
      var status = document.getElementById('pop_up_status').value;
      var offer_id = document.getElementById('pop_up_offer_id').value;


      if (Track_id != "" && due_date != "" && remark != "" && status != "" && offer_id != "")

      {
        $.ajax({
          url: "<?php echo site_url('welcome/update_tracking_details'); ?>",
          type: 'POST',
          data: {
            'Track_id': Track_id,
            'due_date': due_date,
            'remark': remark,
            'status': status,
            'offer_id': offer_id
          },
          success: function(data) {
            data = data.trim();
            if (data == 3 || data == '3') {
              var redirect = "<?php echo site_url('create_customer_sales_order'); ?>";
              window.location = redirect;
            } {
              location.reload();
            }
          },
          error: function() {
            alert("Fail")
          }
        });
      } else {
        alert("Enter All Details.....");
      }
    });
  </script>

  <script type="text/javascript">
    $(document).ready(function() {

      $.ajax({

        url: "<?php echo site_url('sales/enquiry_tracking_register/get_next_action_date'); ?>",
        type: 'POST',
        dataType: "json",
        success: function(data) {

          var desiredDate = new Date(data.action_due_date);
          var currentDate = new Date();

          if (currentDate.getTime() > desiredDate.getTime()) {
            // Display a notification if the current date and time are equal to the desired date and time
            $('#modal-sm').modal('show');
          }
        }

      });

      $('#notification_alert').click(function() {
        window.location.href = "task_index";
      });
    });
  </script>

</body>

</html>