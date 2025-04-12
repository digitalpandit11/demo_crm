<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ob_start();
class Tnc_master extends CI_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('tnc_master_model');
        $this->load->library('session');
    }

	public function index()
	{
        $this->load->view('master/tnc_master/vw_tnc_master_index');
	}

    public function ajax_tnc_master_index()
    { 
        $table = "tnc_master";
        $primaryKey = 'entity_id';

        $columns = array(
            array(
                'db' => 'entity_id',
                'dt' => 0,
                'field' => 'entity_id'
            ),
            array(
                'db' => 'tnc_name',
                'dt' => 1,
                'field' => 'tnc_name'
            ),
            array(
                'db' => 'status',
                'dt' => 2,
                'formatter' => function($d, $row) {
                    return ($d == 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
                },
                'field' => 'status'
            ),
            array(
                'db' => 'entity_id',
                'dt' => 3,
                'formatter' => function($d, $row) {
                    return '
                        <a href="edit_tnc_master/'.$row[0].'">
                            <span class="btn btn-sm btn-primary">
                                <i class="fa fa-edit"></i>
                            </span>
                        </a><br>
                    ';
                },
                'field' => 'entity_id'
            )
        );

        $sql_details = array(
            'user' => ($_SERVER['HTTP_HOST'] != 'localhost') ? 'u117003035_vbtek' : 'root',
            'pass' => ($_SERVER['HTTP_HOST'] != 'localhost') ? 'S@14vbtek' : '',
            'db'   => ($_SERVER['HTTP_HOST'] != 'localhost') ? 'u117003035_demo_crm' : 'demo_crm',
            'host' => 'localhost'
        );

        include APPPATH . 'third_party/datatable_ssp_class/ssp.php';

        $joinQuery = "";
        $extraCondition = "";
        $groupBy = "";

        echo json_encode(
            SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraCondition, $groupBy)
        );
    }

    public function create() 
    {
        $this->load->view('master/tnc_master/vw_tnc_master_create');
    }

    public function save_tnc_master() 
    {
        $data = array(
            'tnc_name' => $this->input->post('tnc_name'),
            'terms_conditions' => $this->input->post('terms_conditions'),
            'status' => $this->input->post('status') // default active
        );

        $insert = $this->tnc_master_model->save_tnc_master($data);

        if ($insert) {
            $this->session->set_flashdata('success', 'Terms & Conditions added successfully.');
        } else {
            $this->session->set_flashdata('error', 'Something went wrong.');
        }

        redirect('vw_tnc_master_index'); // redirect to listing page
    }

    public function edit_tnc_master()
    {
        $entity_id = $this->uri->segment(2);
        $data['entity_id'] = $entity_id;
        $data['tnc'] = $this->tnc_master_model->edit_tnc_master($entity_id);
        $this->load->view('master/tnc_master/vw_tnc_master_edit',$data);
    }

    public function update_tnc_master() 
    {
        $entity_id = $this->input->post('entity_id');
        $tnc_name = $this->input->post('tnc_name');
        $terms_conditions = $this->input->post('terms_conditions');
        $status = $this->input->post('status');

        $data = array('entity_id' => $entity_id , 'tnc_name' => $tnc_name,'terms_conditions' => $terms_conditions,'status' => $status);

        $this->tnc_master_model->edit_tnc_master_info($data);
        redirect('vw_tnc_master_index');
    }
}