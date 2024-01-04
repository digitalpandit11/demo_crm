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
  <title>Quotation Weekly Summary Report</title>
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
    <?php $this->load->view('header_sidebar'); ?>
    <!-- /.navbar -->
    <!-- Main Sidebar Container -->
    <div class="content-wrapper">
      <!-- Content Wrapper. Contains page content -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="card">
            <div class="card-header">
              <h1 class="card-title">Quotation Weekly Summary Report</h1>
              <div class="col-sm-6">
                <br><br>
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?php echo base_url() . 'dashboard' ?>">Home</a></li>
                  <li class="breadcrumb-item">Quotation Weekly Summary Report
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
              <?php

             
              //for 7th week 
              // $day6 = date('Y-m-d');
              // $week6 = strtoupper(date('Y-M', strtotime($day6 . "-6 Week")));
              // $first_date_of_6week = date('Y-m-d', strtotime($week6 . 'first day of this week'));
              // $last_date_of_6week = date('Y-m-d', strtotime($week6 . 'last day of this week'));

              // //for 6th week 
              // $day5 = date('Y-m-d');
              // $week5 = strtoupper(date('Y-M', strtotime($day5 . "-5 Week")));
              // $first_date_of_5week = date('Y-m-d', strtotime($week5 . 'first day of this week'));
              // $last_date_of_5week = date('Y-m-d', strtotime($week5 . 'last day of this week'));

              // //for 5th week 
              // $day4 = date('');
              // $week4 = strtoupper(date('Y-M', strtotime($day4 . "-4 Week")));
              // $first_date_of_4week = date('Y-m-d', strtotime($week4 . 'first day of this week'));
              // $last_date_of_4week = date('Y-m-d', strtotime($week4 . 'last day of this week'));

              // //for 4th week 
              // $day3 = date('Y-m-d');
              // $week3 = strtoupper(date('Y-M', strtotime($day3 . "-3 Week")));
              // $first_date_of_3week = date('Y-m-d', strtotime($week3 . 'first day of this week'));
              // $last_date_of_3week = date('Y-m-d', strtotime($week3 . 'last day of this week'));

              // //for 3th week 
              // $day2 = date('Y-m-d');
              // $week2 = strtoupper(date('Y-M', strtotime($day2 . "-2 Week")));
              // $first_date_of_2week = date('Y-m-d', strtotime($week2 . 'first day of this week'));
              // $last_date_of_2week = date('Y-m-d', strtotime($week2 . 'last day of this week'));

              // //for 2th week 
              // $day1 = date('Y-m-d');
              // $week1 = strtoupper(date('Y-M', strtotime($day1 . "-1 Week")));
              // $first_date_of_1week = date('Y-m-d', strtotime($week1 . 'first day of this week'));
              // $last_date_of_1week = date('Y-m-d', strtotime($week1 . 'last day of this week'));

              // //for 1th week 
              // $day0 = date('Y-m-d');
              // $week0 = strtoupper(date('Y-M', strtotime($day0 . "-0 Week")));

              // $first_date_of_0week = date('Y-m-d', strtotime($week0 . 'first day of this week'));
              // $last_date_of_0week = date('Y-m-d', strtotime($week0 . 'last day of this week'));


              //deifne variables

              date_default_timezone_set('UTC');
              $offer_engg_name = $offer_engg_name;
             // print_r( $offer_engg_name);die;
              $today = new DateTime();
              $data = [];
              
              for ($weekNumber = 0; $weekNumber < 48; $weekNumber++) {
                  $startDate = clone $today;
                  $endDate = clone $today;
                  $startDate->modify("-$weekNumber weeks")->modify('Monday this week');
                  $endDate->modify("-$weekNumber weeks")->modify('Sunday this week');
              
                  $weekStartDate = $startDate->format('d-m-y');
                  $weekEndDate = $endDate->format('d-m-y');
               
                  $this->db->select('state_master.state_name, sum(offer_all_index.total_amount_with_gst) as amt, count(*) as count');
                  $this->db->from('offer_all_index');
                  $this->db->join('customer_master', 'customer_master.entity_id = offer_all_index.customer_id', 'inner');
                  $this->db->join('state_master', 'state_master.entity_id = customer_master.state_id', 'inner');
                  $where = '(offer_all_index.offer_date >= "' . $startDate->format('Y-m-d') . '" AND offer_all_index.offer_date <= "' . $endDate->format('Y-m-d') . '" AND offer_all_index.offer_engg_name = "' . $offer_engg_name . '" AND offer_all_index.status != "10")';
                  $this->db->where($where);
                  $this->db->group_by('customer_master.state_id');
                  $query = $this->db->get();
                 // echo $this->db->last_query();die;
                  $query_result = $query->result();
                 //echo '<pre>'; print_r($query_result);die;
              
                  foreach ($query_result as $query_amt) {
                      $data[$query_amt->state_name][$weekNumber]["amt"] = $query_amt->amt / 1000;
                      $data[$query_amt->state_name][$weekNumber]["count"] = $query_amt->count;
                  }
              }
              
              
              
              

              ////Testing

              // $this->db->select('*');
              // $this->db->from('state_master');
              // $state_data = $this->db->get();
              // $state_list = $state_data->result();


              //  ////month0

              // $this->db->select('state_master.state_name, customer_master.state_id, sum(offer_all_index.total_amount_with_gst) as amt,count(*) as count');
              // $this->db->from('offer_all_index');
              // $this->db->join('customer_master', 'customer_master.entity_id = offer_all_index.customer_id', 'inner');
              // $this->db->join('state_master', 'state_master.entity_id = customer_master.state_id', 'inner');
              // $where = '(offer_all_index.offer_date >= "' . $first_date_of_0week. '" And offer_all_index.offer_date <= "' . $last_date_of_0week . '" And offer_all_index.offer_engg_name ="' . $offer_engg_name . '"  And offer_all_index.status !="10" )';
              // $this->db->where($where);
              // $this->db->group_by('customer_master.state_id');
              // $query = $this->db->get();
              // $query_result = $query->result();
              // $query_num_rows = $query->num_rows();


              // if ($query_num_rows > 0) {

              //   foreach ($query_result as $query_amt) {

              //     $data[$query_amt->state_name][0]["amt"] = $query_amt->amt/1000;
              //     $data[$query_amt->state_name][0]["count"] = $query_amt->count;
              //   }
              // }


              //  ////month1

              // $this->db->select('state_master.state_name, sum(offer_all_index.total_amount_with_gst) as amt,count(*) as count');
              // $this->db->from('offer_all_index');
              // $this->db->join('customer_master', 'customer_master.entity_id = offer_all_index.customer_id', 'inner');
              // $this->db->join('state_master', 'state_master.entity_id = customer_master.state_id', 'inner');
              // $where = '(offer_all_index.offer_date >= "' . $first_date_of_1week . '" And offer_all_index.offer_date <= "' . $last_date_of_1week . '" And offer_all_index.offer_engg_name ="' . $offer_engg_name . '" And offer_all_index.status !="10")';
              // $this->db->where($where);
              // $this->db->group_by('customer_master.state_id');
              // $query = $this->db->get();
              // $query_result = $query->result();
              // $query_num_rows = $query->num_rows();

              // if ($query_num_rows > 0) {

              //   foreach ($query_result as $query_amt) {

              //     $data[$query_amt->state_name][1]["amt"] = $query_amt->amt/1000;
              //     $data[$query_amt->state_name][1]["count"] = $query_amt->count;
              //   }
              // }

              // ////month2

              // $this->db->select('state_master.state_name, sum(offer_all_index.total_amount_with_gst) as amt,count(*) as count');
              // $this->db->from('offer_all_index');
              // $this->db->join('customer_master', 'customer_master.entity_id = offer_all_index.customer_id', 'inner');
              // $this->db->join('state_master', 'state_master.entity_id = customer_master.state_id', 'inner');
              // $where = '(offer_all_index.offer_date >= "' . $first_date_of_2week . '" And offer_all_index.offer_date <= "' . $last_date_of_2week . '" And offer_all_index.offer_engg_name ="' . $offer_engg_name . '" And offer_all_index.status !="10" )';
              // $this->db->where($where);
              // $this->db->group_by('customer_master.state_id');
              // $query = $this->db->get();
              // $query_result = $query->result();
              // $query_num_rows = $query->num_rows();

              // if ($query_num_rows > 0) {

              //   foreach ($query_result as $query_amt) {

              //     $data[$query_amt->state_name][2]["amt"] = $query_amt->amt/1000;
              //     $data[$query_amt->state_name][2]["count"] = $query_amt->count;
              //   }
              // }


              // ////week3
              // $this->db->select('state_master.state_name, sum(offer_all_index.total_amount_with_gst) as amt,count(*) as count');
              // $this->db->from('offer_all_index');
              // $this->db->join('customer_master', 'customer_master.entity_id = offer_all_index.customer_id', 'inner');
              // $this->db->join('state_master', 'state_master.entity_id = customer_master.state_id', 'inner');
              // $where = '(offer_all_index.offer_date >= "' . $first_date_of_3week . '" And offer_all_index.offer_date <= "' . $last_date_of_3week . '" And offer_all_index.offer_engg_name ="' . $offer_engg_name . '" And offer_all_index.status !="10" )';
              // $this->db->where($where);
              // $this->db->group_by('customer_master.state_id');
              // $query = $this->db->get();
              // $query_result = $query->result();
              // $query_num_rows = $query->num_rows();

              // if ($query_num_rows > 0) {

              //   foreach ($query_result as $query_amt) {

              //     $data[$query_amt->state_name][3]["amt"] = $query_amt->amt/1000;
              //     $data[$query_amt->state_name][3]["count"] = $query_amt->count;
              //   }
              // }


              

              // ////week4
              // $this->db->select('state_master.state_name, sum(offer_all_index.total_amount_with_gst) as amt,count(*) as count');
              // $this->db->from('offer_all_index');
              // $this->db->join('customer_master', 'customer_master.entity_id = offer_all_index.customer_id', 'inner');
              // $this->db->join('state_master', 'state_master.entity_id = customer_master.state_id', 'inner');
              // $where = '(offer_all_index.offer_date >= "' . $first_date_of_4week . '" And offer_all_index.offer_date <= "' . $last_date_of_4week . '" And offer_all_index.offer_engg_name ="' . $offer_engg_name . '" And offer_all_index.status !="10" )';
              // $this->db->where($where);
              // $this->db->group_by('customer_master.state_id');
              // $query = $this->db->get();
              // $query_result = $query->result();
              // $query_num_rows = $query->num_rows();

              // if ($query_num_rows > 0) {

              //   foreach ($query_result as $query_amt) {

              //     $data[$query_amt->state_name][4]["amt"] = $query_amt->amt/1000;
              //     $data[$query_amt->state_name][4]["count"] = $query_amt->count;
              //   }
              // }


              // ////week5
              // $this->db->select('state_master.state_name, sum(offer_all_index.total_amount_with_gst) as amt,count(*) as count');
              // $this->db->from('offer_all_index');
              // $this->db->join('customer_master', 'customer_master.entity_id = offer_all_index.customer_id', 'inner');
              // $this->db->join('state_master', 'state_master.entity_id = customer_master.state_id', 'inner');
              // $where = '(offer_all_index.offer_date >= "' . $first_date_of_5week . '" And offer_all_index.offer_date <= "' . $last_date_of_5week . '" And offer_all_index.offer_engg_name ="' . $offer_engg_name . '" And offer_all_index.status !="10" )';
              // $this->db->where($where);
              // $this->db->group_by('customer_master.state_id');
              // $query = $this->db->get();
              // $query_result = $query->result();
              // $query_num_rows = $query->num_rows();

              // if ($query_num_rows > 0) {

              //   foreach ($query_result as $query_amt) {

              //     $data[$query_amt->state_name][5]["amt"] = $query_amt->amt/1000;
              //     $data[$query_amt->state_name][5]["count"] = $query_amt->count;
              //   }
              // }


              // ////week6
              // $this->db->select('state_master.state_name, sum(offer_all_index.total_amount_with_gst) as amt,count(*) as count');
              // $this->db->from('offer_all_index');
              // $this->db->join('customer_master', 'customer_master.entity_id = offer_all_index.customer_id', 'inner');
              // $this->db->join('state_master', 'state_master.entity_id = customer_master.state_id', 'inner');
              // $where = '(offer_all_index.offer_date >= "' . $first_date_of_6week . '" And offer_all_index.offer_date <= "' . $last_date_of_6week . '" And offer_all_index.offer_engg_name ="' . $offer_engg_name . '" And offer_all_index.status !="10" )';
              // $this->db->where($where);
              // $this->db->group_by('customer_master.state_id');
              // $query = $this->db->get();
              // $query_result = $query->result();
              // $query_num_rows = $query->num_rows();

              // if ($query_num_rows > 0) {

              //   foreach ($query_result as $query_amt) {

              //     $data[$query_amt->state_name][6]["amt"] = $query_amt->amt/1000;
              //     $data[$query_amt->state_name][6]["count"] = $query_amt->count;
              //   }
              // }

              // ////week7
              // $this->db->select('state_master.state_name, sum(offer_all_index.total_amount_with_gst) as amt,count(*) as count');
              // $this->db->from('offer_all_index');
              // $this->db->join('customer_master', 'customer_master.entity_id = offer_all_index.customer_id', 'inner');
              // $this->db->join('state_master', 'state_master.entity_id = customer_master.state_id', 'inner');
              // $where = '(offer_all_index.offer_date >= "' . $first_date_of_7week . '" And offer_all_index.offer_date <= "' . $last_date_of_7week . '" And offer_all_index.offer_engg_name ="' . $offer_engg_name . '" And offer_all_index.status !="10" )';
              // $this->db->where($where);
              // $this->db->group_by('customer_master.state_id');
              // $query = $this->db->get();
              // $query_result = $query->result();
              // $query_num_rows = $query->num_rows();

              // if ($query_num_rows > 0) {

              //   foreach ($query_result as $query_amt) {

              //     $data[$query_amt->state_name][7]["amt"] = $query_amt->amt/1000;
              //     $data[$query_amt->state_name][7]["count"] = $query_amt->count;
              //   }
              // }




              // ////week8
              // $this->db->select('state_master.state_name, sum(offer_all_index.total_amount_with_gst) as amt,count(*) as count');
              // $this->db->from('offer_all_index');
              // $this->db->join('customer_master', 'customer_master.entity_id = offer_all_index.customer_id', 'inner');
              // $this->db->join('state_master', 'state_master.entity_id = customer_master.state_id', 'inner');
              // $where = '(offer_all_index.offer_date >= "' . $first_date_of_8week . '" And offer_all_index.offer_date <= "' . $last_date_of_8week . '" And offer_all_index.offer_engg_name ="' . $offer_engg_name . '" And offer_all_index.status !="10" )';
              // $this->db->where($where);
              // $this->db->group_by('customer_master.state_id');
              // $query = $this->db->get();
              // $query_result = $query->result();
              // $query_num_rows = $query->num_rows();

              // if ($query_num_rows > 0) {

              //   foreach ($query_result as $query_amt) {

              //     $data[$query_amt->state_name][8]["amt"] = $query_amt->amt/1000;
              //     $data[$query_amt->state_name][8]["count"] = $query_amt->count;
              //   }
              // }



              // ////week9
              // $this->db->select('state_master.state_name, sum(offer_all_index.total_amount_with_gst) as amt,count(*) as count');
              // $this->db->from('offer_all_index');
              // $this->db->join('customer_master', 'customer_master.entity_id = offer_all_index.customer_id', 'inner');
              // $this->db->join('state_master', 'state_master.entity_id = customer_master.state_id', 'inner');
              // $where = '(offer_all_index.offer_date >= "' . $first_date_of_9week . '" And offer_all_index.offer_date <= "' . $last_date_of_9week . '" And offer_all_index.offer_engg_name ="' . $offer_engg_name . '" And offer_all_index.status !="10" )';
              // $this->db->where($where);
              // $this->db->group_by('customer_master.state_id');
              // $query = $this->db->get();
              // $query_result = $query->result();
              // $query_num_rows = $query->num_rows();

              // if ($query_num_rows > 0) {

              //   foreach ($query_result as $query_amt) {

              //     $data[$query_amt->state_name][9]["amt"] = $query_amt->amt/1000;
              //     $data[$query_amt->state_name][9]["count"] = $query_amt->count;
              //   }
              // }




              // ////week10

              // $this->db->select('state_master.state_name, sum(offer_all_index.total_amount_with_gst) as amt,count(*) as count');
              // $this->db->from('offer_all_index');
              // $this->db->join('customer_master', 'customer_master.entity_id = offer_all_index.customer_id', 'inner');
              // $this->db->join('state_master', 'state_master.entity_id = customer_master.state_id', 'inner');
              // $where = '(offer_all_index.offer_date >= "' . $first_date_of_10week . '" And offer_all_index.offer_date <= "' . $last_date_of_10week . '" And offer_all_index.offer_engg_name ="' . $offer_engg_name . '" And offer_all_index.status !="10" )';
              // $this->db->where($where);
              // $this->db->group_by('customer_master.state_id');
              // $query = $this->db->get();
              // $query_result = $query->result();
              // $query_num_rows = $query->num_rows();

              // if ($query_num_rows > 0) {

              //   foreach ($query_result as $query_amt) {

              //     $data[$query_amt->state_name][10]["amt"] = $query_amt->amt/1000;
              //     $data[$query_amt->state_name][10]["count"] = $query_amt->count;
              //   }
              // }


              // ////week11

              // $this->db->select('state_master.state_name, sum(offer_all_index.total_amount_with_gst) as amt,count(*) as count');
              // $this->db->from('offer_all_index');
              // $this->db->join('customer_master', 'customer_master.entity_id = offer_all_index.customer_id', 'inner');
              // $this->db->join('state_master', 'state_master.entity_id = customer_master.state_id', 'inner');
              // $where = '(offer_all_index.offer_date >= "' . $first_date_of_11week . '" And offer_all_index.offer_date <= "' . $last_date_of_11week . '" And offer_all_index.offer_engg_name ="' . $offer_engg_name . '" And offer_all_index.status !="10" )';
              // $this->db->where($where);
              // $this->db->group_by('customer_master.state_id');
              // $query = $this->db->get();
              // $query_result = $query->result();
              // $query_num_rows = $query->num_rows();

              // if ($query_num_rows > 0) {

              //   foreach ($query_result as $query_amt) {

              //     $data[$query_amt->state_name][11]["amt"] = $query_amt->amt/1000;
              //     $data[$query_amt->state_name][11]["count"] = $query_amt->count;
              //   }
              // }




              ?>
              <!-- general form elements disabled -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Quotation Source Summary Report</h3>
                </div>
                <div class="card-body">
                  <h3>Count (Value in Thousands) </h3>
                  <h5>Figures in bracket () are Quotation Amount with GST in Rupees Thousands </h5>
                  <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped"  style="width: 100%;">
                      <thead>
                      <tr>
                     
                      <th  style="width:20%;">Source</th>
                        <?php
                        for ($weekNumber = 0; $weekNumber < 36; $weekNumber++) {
                            $startDate = clone $today;
                            $startDate->modify("-$weekNumber weeks")->modify('Monday this week');
                            $endDate = clone $today;
                            $endDate->modify("-$weekNumber weeks")->modify('Sunday this week');
                            echo '<th  style="width:20%;">'.$startDate->format('d').' to '.$endDate->format('d').'</th>';
                        }
                        ?>
                    </tr>
                      </thead>
                      <tbody>
                      <?php
                        foreach ($data as $key => $amount_count) {
                            echo '<tr>';
                            echo '<td style="width:20%;">' . $key . '</td>';
                            for ($weekNumber = 0; $weekNumber < 36; $weekNumber++) {
                                echo '<td  style="width:20%;">';
                                if (isset($amount_count[$weekNumber])) {
                                    echo $amount_count[$weekNumber]["count"] . '<br>(' . round($amount_count[$weekNumber]["amt"]) . ')';
                                }
                                echo '</td>';
                            }
                            echo '</tr>';
                        }
                        ?>


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
  <!-- AdminLTE App -->
  <script src="<?php echo base_url() . 'assets/dist/js/adminlte.min.js' ?>"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="<?php echo base_url() . 'assets/dist/js/demo.js' ?>"></script>
  <!-- DataTables -->
  <script src="<?php echo base_url() . 'assets/plugins/datatables/jquery.dataTables.js' ?>"></script>
  <script src="<?php echo base_url() . 'assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js' ?>"></script>
  <!-- DataTables -->
  <!-- <script src="assets/plugins/datatables/jquery.dataTables.js"></script>
        <script src="assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script> -->
  <!-- Page script -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">

  <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
  <!-- Page script -->
  <script>
    $(document).ready(function() {
      $('#example1').DataTable({
        dom: 'Bfrtip',
        buttons: [
          'copyHtml5',
          'excelHtml5',
          'csvHtml5',
          'pdfHtml5'
        ]
      });
    });
  </script>
</body>

</html>