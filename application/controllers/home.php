<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller{
	
  /* Pages */
  public function index(){
    $data['access'] = $this->session->userdata('user_access');
    $data['firstName'] = $this->session->userdata('user_firstname');
    $data['lastName'] = $this->session->userdata('user_lastname');
    $data['page'] = 'home';
    $this->load->view('template/header', $data);
    $this->load->view('home/home', $data);
    $this->load->view('template/footer', $data);
	}
  
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */