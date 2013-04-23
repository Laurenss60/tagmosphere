<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Photo extends CI_Controller{

  /* Authentication check */
  public function __construct() {
    parent::__construct();
    # Login check
    if($this->session->userdata('user_access') < 1){
      redirect(site_url('user/login'));
    }
  }
	
  /* Pages */
  public function index(){
    if($this->_createPhoto()){
      $response['success'] = true;
      echo json_encode($response);
      print_r(validation_errors());
      return;
    }
    
    $data['serverAlert'] = $this->servermsg->toHTML();
    $data['access'] = $this->session->userdata('user_access');
    $data['firstName'] = $this->session->userdata('user_firstname');
    $data['lastName'] = $this->session->userdata('user_lastname');
    $data['page'] = "photo";
    $this->load->view('template/header', $data);
    $this->load->view('photo/photo', $data);
    $this->load->view('template/footer', $data);
	}
  public function getLocationsNearby($lat, $lng){
    $this->load->database();
    # Get all locations (limit 120)
    $query = $this->db->query("
      SELECT *, ((ACOS(SIN(" . mysql_real_escape_string($lat) . " * PI() / 180) * SIN(lat * PI() / 180) + COS(" . mysql_real_escape_string($lat) ." * PI() / 180) * COS(lat * PI() / 180) * COS((" . mysql_real_escape_string($lng) . " - lng) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344) as distance
      FROM location
      HAVING distance <= 20
      ORDER BY distance ASC
      LIMIT 0, 15
    ");
    echo json_encode($query->result());
  }
  public function autocompleteTags(){
    $searchString = $this->input->get('query', TRUE);
    
    #Search
    $qb = $this->doctrine->em->createQueryBuilder();
    $results = $qb->select('t')
                 ->from('Entities\Tag', 't')
                 ->where($qb->expr()->like('t.name', $qb->expr()->literal('%' . $searchString . '%')))
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
  
  private function _createPhoto(){
    # Validation rules
		$this->form_validation->set_rules('photo', 'Foto', 'required|xss_clean');
    $this->form_validation->set_rules('atmosphere', 'required|xss_clean');
    $this->form_validation->set_rules('location_id', 'required|xss_clean');
    $this->form_validation->set_rules('tags', 'Tags', 'required|xss_clean');
    
    # Run validation
    if($this->form_validation->run()){
			# Get the user
      $user = $this->doctrine->em->getRepository("Entities\User")->find($this->session->userdata('user_id'));
      
      # Get the location
      $location = $this->doctrine->em->getRepository("Entities\Location")->find($this->form_validation->set_value('location_id'));
      
      # Loop thru tags and get the id's. If tag doesn't exist yet, create it
      $db_tags;
      foreach($this->input->post('tags', TRUE) as $tag){
        # Try to find the tag
        $db_tag = $this->doctrine->em->getRepository("Entities\Tag")->findBy(array('name' => $tag));
        if(!$db_tag){
          $db_tag = new Entities\Tag;
          $db_tag->setName($tag);
          $this->doctrine->em->persist($db_tag);
          $this->doctrine->run();
          $db_tags[] = $db_tag;
        }else{
          $db_tags[] = $db_tag[0];
        }
      }
      
      # Add the photo
      $photo = new Entities\Photo;
      $photo->setUser($user);
      $photo->setLocation($location);
      $photo->setPhoto($this->input->post('photo', TRUE));
      $photo->setAtmosphere($this->input->post('atmosphere', TRUE));
      $photo->setCreated(new \DateTime());
      $this->doctrine->em->persist($photo);
      $this->doctrine->run();
      
      # Add the photo_tags
      foreach($db_tags as $tag){
        $photo_tag = new Entities\PhotoTag;
        $photo_tag->setPhoto($photo);
        $photo_tag->setTag($tag);
        $this->doctrine->em->persist($photo_tag);
        $this->doctrine->run();
      }
      
      # Set success message
			$this->servermsg->setFlashSuccess('Locatie categorie is aangemaakt!');
      return true;
		}else{
      return false;
    }
    return;
  }
  
}

/* End of file photo.php */
/* Location: ./application/controllers/photo.php */