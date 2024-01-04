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
        <title>All Campaign Register</title>
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
            <?php $this->load->view('header_sidebar');
            $campaign_id = $campaign_client_details['campaign_id'];
            $campaign_telephone_relation_id = $campaign_client_details['entity_id'];

                $client_data = $this->db->select('*')->from('campaign_telephone_relation')->where('entity_id',$campaign_client_details['entity_id'])->get()->row_array();

                if ($client_data['company_name'] == null) {
                    $company_name ="NA";
                }else{
                    $company_name= $client_data['company_name'];
                }

                // $last_call= $this->db->select('last_log_date')->from('call_log')->where('campaign_relation_id',$campaign_id)->order_by('entity_id','DESC')->limit(1)->get()->row_array();

                $this->db->select('*');
                $this->db->from('campaign_telephone_relation');
                $where = '(campaign_telephone_relation.entity_id > "'.$campaign_telephone_relation_id.'" AND campaign_telephone_relation.campaign_id ="'.$campaign_id.'")';
                $this->db->where($where);
                $this->db->limit(1);
                $next_campaign_register = $this->db->get();
                $next_campaign_register_data = $next_campaign_register->row_array();

                if(empty($next_campaign_register_data))
                {
                    $ent='style="display:none;"';
                    $next_id = "";
                }else{
                    $ent = '';
                    $next_id = $next_campaign_register_data['entity_id'];
                }

                $this->db->select('*');
                $this->db->from('campaign_telephone_relation');
                $where = '(campaign_telephone_relation.entity_id < "'.$campaign_telephone_relation_id.'" AND campaign_telephone_relation.campaign_id ="'.$campaign_id.'")';
                $this->db->where($where);
                $this->db->order_by('entity_id', 'desc');
                $this->db->limit(1);
                $prev_campaign_register = $this->db->get();
                $prev_campaign_register_data = $prev_campaign_register->row_array();

                if(empty($prev_campaign_register_data))
                {
                    $pv='style="display:none;"';
                    $prev_id = "";
                }else{
                    $pv = '';
                    $prev_id = $prev_campaign_register_data['entity_id'];
                }

                /*
                $wh='entity_id >'.$entity_id.' AND campaign_id = '.$campaign_id;
                $chk= $this->db->select('entity_id')->from('campaign_relation')->where($wh)->get()->row_array();
                if ($chk > 0 ) {
                        $ent = '';
                }else{
                    $ent='style="display:none;"';

                }

                $wh='entity_id <'.$entity_id.' AND campaign_id = '.$campaign_id;
                $chk_pv= $this->db->select('entity_id')->from('campaign_relation')->where($wh)->get()->row_array();
                if ($chk_pv > 0 ) {
                        $pv = '';
                }else{
                    $pv='style="display:none;"';

                }*/

            ?>
                <!-- /.navbar -->
                <!-- Main Sidebar Container -->  
            <div class="content-wrapper">
                <!-- Content Wrapper. Contains page content -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="card">
                            <div class="card-header" >
                                <h1 class="card-title"> Client Details</h1>
                                <div class="col-sm-6">
                                    <br><br>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                                        <li class="breadcrumb-item"><a href="<?php echo base_url().'view_campaign2/'.$campaign_id;?>">Campaign Register</a>
                                        </li>
                                        <li class="breadcrumb-item"> Client Call Log
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
                                        <h3 class="card-title">  Client Details </h3>

                                        <a href="<?php echo base_url();?>view_call_log2/<?php echo $next_id;?>" class="btn btn-md btn-warning " <?php echo $ent;?> style="float:right;">Skip <i class="fas fa-arrow-right"></i></a>&nbsp;&nbsp;
                                        <a href="<?php echo base_url();?>view_call_log2/<?php echo $prev_id;?>" class="btn btn-md btn-default text-black" <?php echo $pv;?> style="float:right;color:black;margin-right: 20px;"><i class="fas fa-arrow-left"></i> Previous </a>
                                    </div>
                                    <div class="row col-md-12 pt-4 ">
                                        <div class="col-md-3 border-2">
                                            <span class="text-success p-3 font-weight-bold">Client Name: - </span><label><?php echo $campaign_client_details['client_name'];?></label>
                                        </div>
                                        <div class="col-md-3">
                                            
                                            <span class="text-success p-3 font-weight-bold">Email Id : - </span><label> <?php echo $campaign_client_details['email'];?></label>
                                        </div>
                                        <div class="col-md-3">
                                            
                                            <span class="text-success p-3 font-weight-bold">Mobile No : - </span><label> <?php echo $campaign_client_details['mobile'];?></label>
                                        </div>
                                        <div class="col-md-3">
                                            
                                            <span class="text-success p-3 font-weight-bold">Company : - </span><label>  <?php echo $campaign_client_details['company_name'];?></label>
                                        </div>
                                    </div>
                                    <div class="row col-md-12 pb-4">
                                        <div class="col-md-3 border-2">
                                            <span class="text-success p-3 font-weight-bold">Category: - </span><label> <?php echo $campaign_client_details['category'];?></label>
                                        </div>
                                        <div class="col-md-3">
                                            
                                            <span class="text-success p-3 font-weight-bold">Designation  : - </span><label><?php echo $campaign_client_details['designation'];?></label>
                                        </div>
                                        <div class="col-md-3">
                                            
                                            <span class="text-success p-3 font-weight-bold">Source : - </span><label> <?php echo $campaign_client_details['source'];?></label>
                                        </div>
                                        <div class="col-md-3">
                                            
                                            <span class="text-success p-3 font-weight-bold">City : - </span><label> <?php echo $campaign_client_details['city'];?></label>
                                        </div>
                                    </div>
                                    <div class="row col-md-12 pb-4">
                                        <div class="col-md-3 border-2">
                                            <span class="text-success p-3 font-weight-bold">State: - </span><label> <?php echo $campaign_client_details['state'];?></label>
                                        </div>

                                        <div class="col-md-3 border-2">
                                            <span class="text-success p-3 font-weight-bold">Pincode: - </span><label> <?php echo $campaign_client_details['pincode'];?></label>
                                        </div>
                                        <div class="col-md-3">
                                            
                                            <span class="text-success p-3 font-weight-bold">Address : - </span><label> <?php echo $campaign_client_details['address'];?></label>
                                        </div>
                                        <div class="col-md-3">
                                            
                                            <span class="text-success p-3 font-weight-bold">Website : - </span><label> <?php echo $campaign_client_details['website'];?></label>
                                        </div>
                                    </div>
                                    <div class="row col-md-12 pb-4">
                                        
                                        <div class="col-md-3">
                                            
                                            <span class="text-primary p-3 font-weight-bold">Last Call  : - </span><label><?php //echo $last_call['last_log_date'];?></label>
                                        </div>
                                        <div class="col-md-3">
                                            
                                            <span class="text-danger p-3 font-weight-bold">DND : - </span><label>
                                             <?php 

                                             if($campaign_client_details['dnd'] == 0){
                                                echo "";
                                             }else{
                                                echo "DND";
                                             }
                                             ?>
                                                 
                                             </label>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="card-body">
                                        <div class="card-header">
                                            <h3 class="card-title"> Call Details </h3>
                                        </div>
                                        <form method="post" action="<?php echo base_url();?>sales/campaign_register/save_call_log2">

                                            <input type="hidden" name="mobile" id="mobile" value=" <?php echo $campaign_client_details['mobile'];?>">

                                            <input type="hidden" name="campaign_telephone_relation_id" id="campaign_telephone_relation_id" value=" <?php echo $campaign_client_details['entity_id'];?>">

                                            <input type="hidden" name="campaign_id" id="campaign_id" value="<?php echo $campaign_client_details['campaign_id']; ?>">

                                            <input type="hidden" name="campaign_name" id="campaign_name" value="<?php echo $campaign_client_details['campaign_id']; ?>">

                                            <div class="row col-md-12">
                                                <div class="col-md-6 pt-5"> 
                                                    <div class="form-group">
                                                        <input type="radio" name="call_sts" id="call_sts" style="padding: 20px;" value="1" required>&nbsp;&nbsp;<label>Call Answered</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="radio" name="call_sts" id="call_sts" required value="2">&nbsp;&nbsp;<label>Call Not Answered</label>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Call Description </label>
                                                        <textarea class="form-control" id="call_description" name="call_description" rows="3" placeholder="Enter Conservation From Client"></textarea>
                                                    </div>
                                                </div> 

                                                <div class="col-md-6 pt-5">
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <input type="radio" name="open_close" required id="open_close" style="padding: 20px;" value="1">&nbsp;&nbsp;<label>No Requirement</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <input type="radio" name="open_close" required id="open_close" value="2">&nbsp;&nbsp;<label>Follow-Up Required</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <input type="radio" name="open_close" required id="open_close" value="3">&nbsp;&nbsp;<label>Irrelevant Contact</label>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group" id="message" >
                                                                <label> Next Action</label>
                                                                <textarea class="form-control" id="next_action" name="next_action" rows="3" placeholder="Enter Conservation From Client"></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group" id="message" >
                                                                <label> Follow-Up Date</label>
                                                                <input type="date" name="fdate" id="fdate" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <a href="#" class="btn btn-md btn-info text-white">Create Lead</a>&nbsp;&nbsp;

                                            <div class="row col-md-12 mt-3">
                                                <div style="display: inline-flex;margin: 0 auto;">
                                                    <div>
                                                        <div class="form-group">
                                                            <input type="checkbox" name="wrong_number" id="wrong_number" value="1">
                                                            <label style="margin-left:10px;"> Wrong Number</label>
                                                        </div>
                                                    </div>&nbsp;&nbsp;&nbsp;&nbsp;

                                                    <div>
                                                        <div lass="form-group">
                                                            <input type="checkbox" name="dnd" id="dnd" value="1">
                                                            <label style="margin-left:10px;">DND</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <input type="hidden" name="next_telephone_id" id="next_telephone_id" value="<?php echo $next_id;?>">

                                            <center>
                                              <input type="submit" class="btn btn-success" value="Save & Next"> 
                                            </center>
                                        </form>

                                        <br>
                                        <div class="card-header mb-4">
                                            <h3 class="card-title"> Call Log </h3>
                                        </div>
                                        <div  class="table-responsive">
                                            <table id="example1" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Sr. No.</th>
                                                        <th>Record Date</th>
                                                        <th>Call Status</th>
                                                        <th>Case Close OR Follow</th>
                                                        <th>Discussion</th>
                                                        <th>Next Action</th>
                                                        <th>Follow-Up Date</th>
                                                        <th>Wrong Number</th>
                                                        <th>DND</th>
                                                        <th>Added By</th>
                                                        <!-- <th>Status</th> -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $no = 0;
                                                        foreach ($log_detail as $row):
                                                            $no++;
                                                            $entity_id = $row->entity_id;

                                                            $record_date = $row->last_log_date;
                                                            /*$record_date = date("d-m-Y", strtotime($record_date_format));*/

                                                            $follow_up_date_format = $row->follow_up_date;
                                                            if(!empty($follow_up_date_format))
                                                            {
                                                                $follow_up_date = date("d-m-Y", strtotime($follow_up_date_format));
                                                            }else{
                                                                $follow_up_date = "NA";
                                                            }

                                                            $call_sts = $row->call_answered;

                                                            if ($call_sts == 1) {
                                                                $answer = "Call Answered";
                                                            }else if ($call_sts == 2) {

                                                                $answer = "Call Not Answered";
                                                            }else{
                                                                $answer = "";
                                                            }

                                                            $case =$row->case_open_close;
                                                            if ($case == 1) {
                                                                $case_close = "Case Close";
                                                            }else if ($case == 2) {

                                                                $case_close = "Follow-Up Required";
                                                            }else{
                                                                $case_close = "";
                                                            }

                                                            $dnd =$row->dnd;
                                                            if ($dnd == 0) {
                                                                $dnd_chk = "";
                                                            }else if ($dnd == 1) {

                                                                $dnd_chk = "DND";
                                                            }else{
                                                                $dnd_chk = "";
                                                            }

                                                            $wrong =$row->wrong_number;
                                                            if ($wrong == 0) {
                                                                $wrong_nmbr = "";
                                                            }else if ($wrong == 1) {

                                                                $wrong_nmbr = "Wrong Number";
                                                            }else{
                                                                $wrong = "";
                                                            }

                                                            $user = $this->db->select('user_name')->from('user_login')->where('entity_id',$row->user_id)->get()->row_array();
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $no;?></td>
                                                        <td><?php echo $record_date;?></td>
                                                        <td><?php echo $answer;?></td>
                                                        <td><?php echo $case_close;?></td>
                                                        <td><?php echo $row->call_description;?></td>
                                                        <td><?php echo $row->next_action;?></td>
                                                        <td><?php echo $follow_up_date;?></td>
                                                        <td><?php echo $wrong_nmbr;?></td>
                                                        <td><?php echo $dnd_chk;?></td>
                                                        
                                                        <td><?php echo $user['user_name'];?></td>
                                                        <!-- <td><?php echo $row->status;?></td> -->
                                                    </tr>
                                                <?php endforeach;?>
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

            <div class="modal fade" id="modal-call_log">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Create New Log</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                           <div class="modal-body">
                                    <div class="form-group">
                                        <label class="text-danger"> Log Type * </label>
                                        <select class="form-control select2bs4" name="log_type" id="log_type">
                                            <option>SELECT LOG TYPE</option>
                                            <option value="Phone-Call">Phone-Call</option>
                                            <option value="E-Mail">E-Mail</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="text-danger" > Status *</label><!-- 
                                        <input type="radio" name="status" value="wrong " class="text-success">
                                        <input type="radio" name="status" value="wrong ">
                                        <input type="radio" name="status" value="wrong Name">
                                        <input type="radio" name="status" value="wrong Name">
                                        <input type="radio" name="status" value="wrong Name">
                                        <input type="radio" name="status" value="wrong Name">
                                        <input type="radio" name="status" value="wrong Name"> -->

                                        <select class="form-control select2bs4" name="log_status" id="log_status" onchange="show_msg(this);">
                                            <option>SELECT LOG STATUS</option>
                                            <option value="Wrong-Number">Wrong-Number</option>
                                            <option value="Not-Answering">Not-Answering</option>
                                            <option value="Call-Answered">Call-Answered</option>
                                            <option value="No-Reply">No-Reply</option>
                                            <option value="Mark-DND">Mark-DND</option>
                                            <option value="Follow-up after 1week">Follow-up after 1week​</option>

                                        </select>
                                    </div>
                                    <div class="form-group" id="message" hidden>
                                        <label> Response Message </label>
                                        <textarea class="form-control" id="log_response" name="log_response" rows="3" placeholder="Enter Conservation From Client"></textarea>
                                    </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="log_save">Save</button>
                            </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                 <!-- /.modal-dialog -->
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
        <script type="text/javascript">
            function show_msg(argument) {
                var data=argument.value;
                var msg=document.getElementById('message');
                if(data != "Call-Answered"){
                }else{
                    msg.removeAttribute('hidden');
                }
            }



            $('#log_save').click(function (arg) {
                var camp_name=$('#campaign_name').val();
                var type=$('#log_type').val();
                var status=$('#log_status').val();
                var msg=$('#log_response').val();
                var entity_id=$('#entity_id').val();

                $.ajax({
                    url:'<?php echo base_url();?>sales/campaign_register/create_call_log',
                    method:'POST',
                    type:'json',
                    data:{
                        'type':type,'status':status,'msg':msg,'entity_id':entity_id,'camp_name':camp_name
                    },
                    dataType:'json',
                    success:function (arg) {
                        console.log(arg);
                        window.location.reload(true);
                    }
                });
            });
        </script>
    </body>
</html>