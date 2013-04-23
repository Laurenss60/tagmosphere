<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Credits extends CI_Controller{
	
  /* Pages */
  public function index(){
    $data['access'] = $this->session->userdata('user_access');
    $data['firstName'] = $this->session->userdata('user_firstname');
    $data['lastName'] = $this->session->userdata('user_lastname');
    $data['page'] = 'credits';
    $this->load->view('template/header', $data);
    $this->load->view('credits/credits', $data);
    $this->load->view('template/footer', $data);
  }
  
  public function search(){
    $searchString = $this->input->post('location-search', TRUE);
    
    # Get location
    $data['location'] = $this->doctrine->em->getRepository('Entities\Location')->findBy(array('name' => $searchString));
    
    if(!empty($data['location'])){
      # Get photo's
      $data['photos'] = $this->doctrine->em->getRepository('Entities\Photo')->findBy(array('location' => $data['location']), array('id' => 'DESC'), 40, 0); 
    }
    
    $data['page'] = 'wall';
    $data['access'] = $this->session->userdata('user_access');
    $data['firstName'] = $this->session->userdata('user_firstname');
    $data['lastName'] = $this->session->userdata('user_lastname');
    $this->load->view('template/header', $data);
    $this->load->view('wall/wall', $data);
    $this->load->view('template/footer', $data);
  }
  
}



/* End of file credits.php */
/* Location: ./application/controllers/credits.php */