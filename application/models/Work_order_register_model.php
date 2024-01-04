<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Work_order_register_model extends CI_Model{

    public function get_all_pending_work_order()
    {
        $this->db->select('*');
        $this->db->from('work_order_master');
        $where = '(work_order_master.work_order_status = "'.'1'.'")';
        $this->db->where($where);
        $this->db->order_by('entity_id','DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_all_work_order_data()
    {
        $this->db->select('*');
        $this->db->from('work_order_master');
        // $where = '(work_order_master.work_order_status = "'.'1'.'")';
        // $this->db->where($where);
        $this->db->order_by('entity_id','DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_all_work_order()
    {
        $this->db->select('*');
        $this->db->from('work_order_master');
        $where = '(work_order_master.work_order_status = "'.'2'.'")';
        $this->db->where($where);
        $this->db->order_by('entity_id','DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_work_order_data($order_type)
    {
        if($order_type == 1)
        {
            $this->db->select('work_order_no');
            $this->db->from('work_order_master');
            $where = '(work_order_master.work_order_type = "'.'1'.'")';
            $this->db->where($where);
            $this->db->order_by('entity_id', 'DESC');
            $this->db->limit(1);
            $workorder_master = $this->db->get();
            $results_workorder_master = $workorder_master->result_array();

            if(!empty($results_workorder_master))
            {
                $workorder_serial_no = $results_workorder_master[0]['work_order_no'];
                $workorder_data_seprate = explode('/', $workorder_serial_no);
                $workorder_doc_year = $workorder_data_seprate['1'];
            }

            $this->db->select('document_series_no');
            $this->db->from('documentseries_master');
            $this->db->where('entity_id=5');
            $doc_record=$this->db->get();
            $results_doc_record = $doc_record->result_array();

            $doc_serial_no = $results_doc_record[0]['document_series_no'];
            $doc_data_seprate = explode('/', $doc_serial_no);
            $doc_year = $doc_data_seprate['1'];

            if(empty($results_workorder_master[0]['work_order_no']) || ($workorder_doc_year != $doc_year))
            {
                $first_no = '0001';
                $doc_no = $doc_serial_no.$first_no;
            }elseif(!empty($results_workorder_master) && ($workorder_doc_year == $doc_year))
            {
                $doc_type = $workorder_data_seprate['0'];
                $ex_no = $workorder_data_seprate['2'];
                $next_en = $ex_no + 1;
                $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
                $doc_no = $doc_type.'/'.$workorder_doc_year.'/'.$next_doc_no;
            }

            date_default_timezone_set('Asia/Kolkata');
            $work_order_date = date("Y-m-d");

            $data_array = array('order_number' => $doc_no , 'order_date' => $work_order_date);
            $data_result['data'] = json_encode($data_array);
            return $data_array;
        }elseif($order_type == 2)
        {
            $this->db->select('work_order_no');
            $this->db->from('work_order_master');
            $where = '(work_order_master.work_order_type = "'.'2'.'")';
            $this->db->where($where);
            $this->db->order_by('entity_id', 'DESC');
            $this->db->limit(1);
            $workorder_master = $this->db->get();
            $results_workorder_master = $workorder_master->result_array();
            
            if(!empty($results_workorder_master))
            {
                $workorder_serial_no = $results_workorder_master[0]['work_order_no'];
                $workorder_data_seprate = explode('/', $workorder_serial_no);
                $workorder_doc_year = $workorder_data_seprate['1'];
            }

            $this->db->select('document_series_no');
            $this->db->from('documentseries_master');
            $this->db->where('entity_id=6');
            $doc_record=$this->db->get();
            $results_doc_record = $doc_record->result_array();

            $doc_serial_no = $results_doc_record[0]['document_series_no'];
            $doc_data_seprate = explode('/', $doc_serial_no);
            $doc_year = $doc_data_seprate['1'];

            if(empty($results_workorder_master[0]['work_order_no']) || ($workorder_doc_year != $doc_year))
            {
                $first_no = '0001';
                $doc_no = $doc_serial_no.$first_no;

            }elseif(!empty($results_workorder_master) && ($workorder_doc_year == $doc_year))
            {
                $doc_type = $workorder_data_seprate['0'];
                $ex_no = $workorder_data_seprate['2'];
                $next_en = $ex_no + 1;
                $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
                $doc_no = $doc_type.'/'.$workorder_doc_year.'/'.$next_doc_no;
            }

            date_default_timezone_set('Asia/Kolkata');
            $work_order_date = date("Y-m-d");

            $data_array = array('order_number' => $doc_no , 'order_date' => $work_order_date);
            $data_result['data'] = json_encode($data_array);
            return $data_array;
        }
    }

    public function get_product_list()
    {
        date_default_timezone_set("Asia/Calcutta");
        $product_year = date('Y');

        $this->db->select('product_master.*,
            product_pricelist_master.price');
        $this->db->from('product_master');
        $where = '(product_pricelist_master.year = "'.$product_year.'" )';
        $this->db->where($where);
        $this->db->join('product_pricelist_master', 'product_master.entity_id = product_pricelist_master.product_id', 'INNER');
        $this->db->order_by('product_master.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();

        if(empty($query_result))
        {
            $this->db->select('product_master.*,
            product_pricelist_master.price');
            $this->db->from('product_master');
            $this->db->join('product_pricelist_master', 'product_master.entity_id = product_pricelist_master.product_id', 'INNER');
            $this->db->order_by('product_master.entity_id', 'DESC');
             $this->db->group_by('product_master.entity_id');
            $query_data = $this->db->get();
            $data_query_result = $query_data->result();
            return $data_query_result;  
        }else{
            return $query_result; 
        }  
    }  

    public function get_order_product_list($entity_id)
    {
        $this->db->select('work_order_product_relation.*,
            product_master.product_name,
            product_master.product_id,
            product_master.product_long_description');
        $this->db->from('work_order_product_relation');
        $this->db->join('product_master', 'work_order_product_relation.product_id = product_master.entity_id', 'INNER');
        
        $where = '(work_order_product_relation.work_order_id = "'.$entity_id.'" )';
        $this->db->where($where);
        $query = $this->db->get();
        $query_data_result = $query->result();
        return $query_data_result;  
    }

    public function get_order_details_by_id_model($entity_id)
    {
        $this->db->select('work_order_master.*,
                           customer_master.customer_name');
        $this->db->from('work_order_master');
        $this->db->join('customer_master', 'work_order_master.customer_id = customer_master.entity_id', 'INNER');
        $where = '(work_order_master.entity_id = "'.$entity_id.'" )';
        $this->db->where($where);
        $query = $this->db->get();
        return $query;
    }

    public function update_order_product_relation($update_array)
    {
        $this->db->where('entity_id', $update_array['entity_id']);
        return $this->db->update('work_order_product_relation', $update_array);
    }

    public function delete_order_product($entity_id)
    {
        $this->db->where('entity_id', $entity_id);
        return $this->db->delete('work_order_product_relation'); 
    }

    public function get_first_category_order_details_by_id_model($entity_id)
    {
        $this->db->select('work_order_master.*,
            sales_order_register.sales_order_no,
            sales_order_register.sales_order_description,
            sales_order_register.po_no,
            sales_order_register.po_date,
            customer_master.customer_name');
        $this->db->from('work_order_master');
        $this->db->join('sales_order_register', 'work_order_master.sales_order_id = sales_order_register.entity_id', 'INNER');

        $this->db->join('customer_master', 'sales_order_register.customer_id = customer_master.entity_id', 'INNER');
        $where = '(work_order_master.entity_id = "'.$entity_id.'" )';
        $this->db->where($where);
        $query = $this->db->get();
        return $query;
    }

    public function get_customer_list()
    {
        $this->db->select('*');
        $this->db->from('customer_master');
        $where = '(customer_master.status != "'.'3'.'")';
        $this->db->where($where);
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_state_list()
    {
        $this->db->select('*');
        $this->db->from('state_master');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }
}
?>