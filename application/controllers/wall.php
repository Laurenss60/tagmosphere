<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Wall extends CI_Controller{

  /* Authentication check */
  public function __construct() {
    parent::__construct();
    # Login check
    if($this->session->userdata('user_access') < 1){
      redirect(site_url('user/login'));
    }
  }
	
  /* Pages */
  public function index($view = NULL){
    if($view == 'personal'){
      $user = $this->doctrine->em->getRepository('Entities\User')->find($this->session->userdata('user_id'));
      $data['photos'] = $this->doctrine->em->getRepository('Entities\Photo')->findBy(array('user' => $user), array('id' => 'DESC'), 40, 0);
    }else{
      $data['photos'] = $this->doctrine->em->getRepository('Entities\Photo')->findBy(array(), array('id' => 'DESC'), 40, 0);
    }
    
    $data['page'] = 'wall';
    $data['access'] = $this->session->userdata('user_access');
    $data['firstName'] = $this->session->userdata('user_firstname');
    $data['lastName'] = $this->session->userdata('user_lastname');
    $this->load->view('template/header', $data);
    $this->load->view('wall/wall', $data);
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
  public function autocompleteLocation(){
    $searchString = $this->input->get('query', TRUE);
    
    #Search
    $qb = $this->doctrine->em->createQueryBuilder();
    $results = $qb->select('l')
                 ->from('Entities\Location', 'l')
                 ->where($qb->expr()->like('l.name', $qb->expr()->literal('%' . $searchString . '%')))
                 ->setMaxResults(10)
                 ->getQuery()
                 ->getResult();
    
    $response = Array();
    if(empty($results)){
      $response['suggestions'][] = '';
    }else{
      foreach($results as $result){
        $response['suggestions'][] = $result->getName();
      }
    }
    
    $response_json = json_encode($response);
    echo $response_json;
    return;
  }
  
}

/* End of file wall.php */
/* Location: ./application/controllers/wall.php */