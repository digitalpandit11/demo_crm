<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ob_start();
class Dosage_master extends CI_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('dosage_master_model');
        $this->load->library('session');
    }

	public function index()
	{
        $this->load->view('master/dosage_master/vw_dosage_master_index');
	}

    public function ajax_dosage_index()
    { 
        $table = "dosage_master";
        $primaryKey = 'entity_id';

        $columns = array(
            array(
                'db' => 'entity_id',
                'dt' => 0,
                'field' => 'entity_id'
            ),
            array(
                'db' => 'dosage',
                'dt' => 1,
                'field' => 'dosage'
            ),
            array(
                'db' => 'entity_id',
                'dt' => 2,
                'formatter' => function($d, $row) {
                    return '
                        <a href="edit_dosage_master/'.$row[0].'">
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
        $this->load->view('master/dosage_master/vw_dosage_master_create');
    }

    public function save_dosage() 
    {
        $dosage = $this->input->post('dosage');

        $data = array(      
          'dosage' => $dosage);

        $this->dosage_master_model->save_dosage_info($data);
        redirect('vw_dosage_index');
    }

    public function edit_dosage_master()
    {
        $entity_id = $this->uri->segment(2);

        $data['entity_id'] = $entity_id;

        $this->db->select('*');
        $this->db->from('dosage_master');
        $where = '(entity_id = "'.$entity_id.'")';
        $this->db->where($where);
        $dosage_master = $this->db->get();
        $dosage_master_data = $dosage_master->row_array();

        $dosage = $dosage_master_data['dosage'];

        $data['dosage'] = $dosage;

        $this->load->view('master/dosage_master/vw_dosage_master_edit',$data);
    }

    public function edit_dosage() 
    {
        $entity_id = $this->input->post('entity_id');
        $dosage = $this->input->post('dosage');

        $data = array('entity_id' => $entity_id , 'dosage' => $dosage);

        $this->dosage_master_model->edit_dosage_master_info($data);
        redirect('vw_dosage_index');
    }
}