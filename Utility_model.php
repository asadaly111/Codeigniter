<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Utility_model extends CI_Model {

//update
public function update_ci($table,$dataToUpdate,$whereClause){
	$this->db->where($whereClause);
	return $this->db->update($table, $dataToUpdate);
}
// insert
public function insert_ci($table, $data){
	$this->db->insert($table, $data);
	return $insert_id = $this->db->insert_id();
}
//Delete
public function delete_ci($table,$whereClause){
	return $this->db->delete($table,$whereClause);
}
// Fetching Process
public function getRows($table,$conditions = array()){

	if(array_key_exists("col",$conditions)){
		$this->db->select($conditions['col']);
	}

	if(array_key_exists("group_by",$conditions)){
		$this->db->group_by($conditions['group_by']);
	}		

	if(array_key_exists("where",$conditions)){
		$this->db->where($conditions['where']);
	}

	if(array_key_exists("order_by",$conditions)){
		$this->db->order_by($conditions['order_by']); 
	}
	if(array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){
		$this->db->limit($conditions['limit'], $conditions['start']);
	}elseif(!array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){
		$this->db->limit($conditions['limit']); 
	}

	if(array_key_exists("return_type",$conditions) && $conditions['return_type'] != 'all'){
		switch($conditions['return_type']){
			case 'count':
			return $this->db->count_all_results($table);
			break;
			case 'single':
			$query = $this->db->get($table);
			return $query->row_array();
			break;
			default:
			$data = '';
		}
	}else{
		$query = $this->db->get($table);
		if ($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
}


// Custom Query
public function custom_query($query){
	$query_res = $this->db->query($query);
	if ($query_res->num_rows() > 0){
		return $query_res->result_array();
	}
	else{
		return false;
	}
}

public function users()
{
	$this->db->select('a.id, a.email, gs.name');
	$this->db->from('users a');
	$this->db->join('users_groups g', 'g.user_id = a.id', 'left');
	$this->db->join('groups gs', 'gs.id = g.group_id', 'left');
	$this->db->where('a.comp_id', $this->session->userdata('comp_id') );
	$query = $this->db->get();
	if($query->num_rows() != 0)
	{
		return $query->result_array();
	}
	else
	{
		return false;
	}
}

// fetch item 

// fetch item 
public function order($id ,$conditions = array())
{
	$this->db->select('a.id, a.user_id	, a.origin, a.destination, a.consinNo, a.consigName, a.consigAdd, a.consigCont, a.consigEmail, a.piece, a.weight, a.costumer_ref, a.cash_collection, a.cash_status, a.product_detail,a.type,a.isfragile,a.remarks,a.status,a.date,
		p.id as paymentid,
		p.amount as paymentamount,
		p.charges as paymentcharges,
		p.date as paymentdate,
		p.status as paymentstatus,
		u.bus_name as UserbusName,
		u.phone as Userphone,
		u.email as Useremail,
		');
	$this->db->from('orders a');
	$this->db->join('order_payment p', 'p.order_id = a.id', 'left');
	$this->db->join('users u', 'u.id = a.user_id', 'left');
	// $this->db->join('units u', 'u.id = a.Unit', 'left');
	$this->db->where('a.id', $id );

	if(array_key_exists("where",$conditions)){
		$this->db->where($conditions['where']);
	}
	if(array_key_exists("order_by",$conditions)){
		$this->db->order_by($conditions['order_by']); 
	}
	if(array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){
		$this->db->limit($conditions['limit'], $conditions['start']);
	}elseif(!array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){
		$this->db->limit($conditions['limit']); 
	}
	if(array_key_exists("return_type",$conditions) && $conditions['return_type'] != 'all'){
		switch($conditions['return_type']){
			case 'count':
			return $this->db->count_all_results($table);
			break;
			case 'single':
			$query = $this->db->get();
			return $query->row_array();
			break;
			default:
			$data = '';
		}
	}else{
		$query = $this->db->get();
		if ($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}


}

public function getstatus($value='')
{
	$this->db->select('s.status , s.date , s.type');
	$this->db->from('orders a');
	$this->db->join('order_status s', 's.order_id = a.id', 'right');
	$this->db->where('a.consinNo',  $value);
	$query = $this->db->get();
	if($query->num_rows() != 0){
		return $query->result_array();
	}else{
		return false;
	}
}



}

/* End of file Utility_model.php */
/* Location: ./application/models/Utility_model.php */