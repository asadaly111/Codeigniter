<?php
defined('BASEPATH') OR exit('No direct script access allowed');


function pr($array) {
	echo "<pre>";
	print_r($array);
	echo "</pre>";
	die();
}
/// Get Day name
function getDayName($date){
	return date('D', strtotime($date));
}
/// Date Formate
function get_date($date){
	return date('d M Y', strtotime($date));
}
function get_time($time){
	$date = new DateTime($time);
	return $date->format('g:i A ');
}
/// Date Formate
function Y_M_D($date){
	return date('Y-m-d', strtotime($date));
}
/// Get Current Time in H:i, hour minute formate
function getCurrentTime(){
	return date('H:i');
}
/// Get Current Day Name
function getCurrentDay(){
	return date('D');
}

function current_full_url()
{
    $CI =& get_instance();

    $url = $CI->config->site_url($CI->uri->uri_string());
    return $_SERVER['QUERY_STRING'] ? $url.'?'.$_SERVER['QUERY_STRING'] : $url;
}


function publicview($template, $data='')
{
	$CI =& get_instance();
	$CI->load->view('inc/header.php', $data);
	$CI->load->view($template, $data);
	$CI->load->view('inc/footer.php', $data);
}


// *****************admin *********************
function order_view($template, $data='')
{
	$CI =& get_instance();
	$CI->load->view('admin/inc/header.php', $data);
	$CI->load->view('admin/order/page', $data);
	$CI->load->view($template, $data);
	$CI->load->view('admin/inc/footer.php', $data);
}

function admin_view($template, $data='')
{
	$CI =& get_instance();
	$CI->load->view('admin/inc/header.php', $data);
	$CI->load->view($template, $data);
	$CI->load->view('admin/inc/footer.php', $data);
}


// option from database
function get_option($value='')
{	
	$CI =& get_instance();
	$CI->db->select('option_value');
	$CI->db->where('option_name' , $value);
	$query = $CI->db->get('options');
	$var = $query->row_array();
	return $var['option_value'];
}



function Consignee_no()
{
	$CI =& get_instance();
	$CI->db->select_max('consinNo');
	$query = $CI->db->get('orders');
	$var = $query->row_array();
	$var = str_replace('khi-', '', $var['consinNo']);

	if (empty($var)) {
		return "khi-000001";
	} else {
		$no = $var+1;
		if ($no < 10) {
			return 'khi-00000'.$no;
		}elseif ($no < 100 ) {
			return 'khi-0000'.$no;
		}
		elseif ($no < 1000 ) {
			return 'khi-000'.$no;
		}
		elseif ($no < 10000 ) {
			return 'khi-00'.$no;
		}
		elseif ($no < 100000 ) {
			return 'khi-0'.$no;
		}
		else {
			return $no;
		}
	}
}