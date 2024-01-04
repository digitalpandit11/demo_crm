<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Product_master_model extends CI_Model{

    public function save_product_master_model($data,$product_price)
    {
        $result = $this->db->insert('product_master',$data);
        $product_lastid = $this->db->insert_id();

        date_default_timezone_set("Asia/Calcutta");
        $product_year = date('Y');

        $data_result = array('product_id'=> $product_lastid , 'price' => $product_price , 'year' => $product_year);
        $this->db->insert('product_pricelist_master',$data_result);
        return $result;
    }

    public function get_make_list()
    {
        $make_list = $this->db->select('*')->from('product_make_master')->get()->result();
        return $make_list;
    }

    public function get_unit_list()
    {
        return $this->db->select('*')->from('unit_master')->get()->result();
    }

    public function get_product_category()
    {
        $this->db->select('*');
        $this->db->from('product_category_master');
        $this->db->order_by('entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_product_hsn_code()
    {
        $this->db->select('*');
        $this->db->from('product_hsn_master');
        $this->db->order_by('entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_sub_category($category_id){
        $query = $this->db->get_where('product_subcategory_master', array('category_id' => $category_id));
        return $query;
    }

    public function get_product_id($category_id,$sub_category_id)
    {
        $this->db->select('category_initial');
        $this->db->from('product_category_master');
        $where = '(product_category_master.entity_id = "'.$category_id.'")';
        $this->db->where($where);
        $product_category_master = $this->db->get();
        $results_product_category_master = $product_category_master->row_array();

        if(!empty($results_product_category_master))
        {
            $category_initial = $results_product_category_master['category_initial'];
        }else{
            $category_initial = "CREATE_INITIAL";
        }

        $this->db->select('subcategory_initial');
        $this->db->from('product_subcategory_master');
        $where = '(product_subcategory_master.entity_id = "'.$sub_category_id.'")';
        $this->db->where($where);
        $product_subcategory_master = $this->db->get();
        $results_product_subcategory_master = $product_subcategory_master->row_array();

        if(!empty($results_product_subcategory_master))
        {
            $subcategory_initial = $results_product_subcategory_master['subcategory_initial'];
        }else{
            $subcategory_initial = "CREATE_INITIAL";
        }

        $this->db->select('product_id');
        $this->db->from('product_master');
        $where = '(product_master.category_id = "'.$category_id.'" And product_master.subcategory_id = "'.$sub_category_id.'")';
        $this->db->where($where);
        $this->db->order_by('entity_id', 'DESC');
        $this->db->limit(1);
        $product_master = $this->db->get();
        $results_product_master = $product_master->row_array();

        if(!empty($results_product_master))
        {
            $product_id = $results_product_master['product_id'];
            $product_id_data_seprate = explode('/', $product_id);
            $ex_no = $product_id_data_seprate['2'];
            $next_en = $ex_no + 1;
            $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
            $new_product_id = $category_initial.'/'.$subcategory_initial.'/'.$next_doc_no;
            $doc_no = array('product_id' => $new_product_id);
            return $doc_no;
        }else{
            $first_no = '0001';
            $new_product_id = $category_initial.'/'.$subcategory_initial.'/'.$first_no;
            $doc_no = array('product_id' => $new_product_id);
            return $doc_no;
        }  
    }

    public function get_product_details()
    {
        $this->db->select('product_master.*,product_hsn_master.hsn_code,product_category_master.category_name,product_make_master.make_name');
        $this->db->from('product_master');
        $this->db->join('product_hsn_master', 'product_master.hsn_id = product_hsn_master.entity_id', 'INNER');
        $this->db->join('product_category_master', 'product_master.category_id = product_category_master.entity_id', 'INNER');
        $this->db->join('product_make_master', 'product_master.product_make = product_make_master.entity_id', 'INNER');
        /*$this->db->join('product_subcategory_master', 'product_master.subcategory_id = product_subcategory_master.entity_id', 'INNER');*/
        $this->db->order_by('entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_id_wise_product_master($entity_id)
    {

        $this->db->select('*');
        $this->db->from('product_pricelist_master');
        $where = '(product_pricelist_master.product_id = "'.$entity_id.'" )';
        $this->db->where($where);
        $this->db->order_by('product_pricelist_master.entity_id', 'DESC');
        $this->db->limit(1);
        $product_pricelist_master_query = $this->db->get();
        $product_pricelist_master_query_result = $product_pricelist_master_query->row();

        $Latest_product_price = $product_pricelist_master_query_result->price;

        $Latest_product_price_array = array('product_price' => $Latest_product_price);

        $this->db->select('*');
        $this->db->from('product_master');
        $where = '(product_master.entity_id = "'.$entity_id.'" )';
        $this->db->where($where);
        $query = $this->db->get();
        $query_result = $query->row_array();

        $result_query = array_merge($Latest_product_price_array, $query_result);
        $data_result['data'] = json_encode($result_query);

        return $result_query;
    }





    public function get_product_sub_category_details()
    {
        $this->db->select('product_category_master.category_name,product_category_master.category_initial,product_subcategory_master.*');
        $this->db->from('product_subcategory_master');
        $this->db->join('product_category_master', 'product_subcategory_master.category_id = product_category_master.entity_id', 'INNER');
        $this->db->order_by('product_subcategory_master.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_id_wise_product_sub_category($entity_id)
    {
        $query = $this->db->get_where('product_subcategory_master', array('entity_id' =>  $entity_id));
        return $query;
    }

    public function update_product_master_model($data,$product_price,$entity_id)
    {
        $this->db->where('entity_id', $data['entity_id']);
        $result = $this->db->update('product_master', $data);

        date_default_timezone_set("Asia/Calcutta");
        $product_year = date('Y');

        $this->db->select('*');
        $this->db->from('product_pricelist_master');
        $where = '(product_pricelist_master.product_id = "'.$entity_id.'" And product_pricelist_master.year = "'.$product_year.'")';
        $this->db->where($where);
        $product_pricelist_master_query = $this->db->get();
        $product_pricelist_master_query_result = $product_pricelist_master_query->row();

        if(!empty($product_pricelist_master_query_result))
        {
            $product_price_entity_id = $product_pricelist_master_query_result->entity_id;

            $price_data_array = array('price' => $product_price);
            $this->db->where('entity_id', $product_price_entity_id);
            $this->db->update('product_pricelist_master', $price_data_array);
        }else{
            $data_result = array('product_id'=> $entity_id , 'price' => $product_price , 'year' => $product_year);
            $this->db->insert('product_pricelist_master',$data_result);
        }
        return $result;
    }

    public function delete_product_master($entity_id)
    {
        $this->db->where('entity_id', $entity_id);
        $data = $this->db->delete('product_master');
        return $data;
    }  
    
    public function product_id_check_model($product_id)
    {
        $this->db->select('*');
        $this->db->from('product_master');
        $where = '(product_master.product_id = "'.$product_id.'" )';
        $this->db->where($where);
        $query = $this->db->get();
        $query_result = $query->num_rows();
        if($query_result == 0)
        {
            return true;
        }else
        {
            return false;
        }   
    }
}
?>