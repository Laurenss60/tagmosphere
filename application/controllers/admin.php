<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller{

  /* Authentication check */
  public function __construct() {
    parent::__construct();
    # Login check
    if($this->session->userdata('user_access') < 2){
      redirect(site_url('user/login'));
    }
  }
	
  /* Pages */
  public function index(){
    redirect(site_url('admin/dashboard'));
	}
  public function dashboard(){
    # Load the DirectAdmin class
    $this->load->library('directadmin');
    
    # Info server 1
    $data['bandwithPercentage'] = round((($this->directadmin->getUserBandwidth() / $this->directadmin->getUserBandwidthLimit()) * 100), 2);
    $data['bandwidthUsed'] = $this->directadmin->getUserBandwidth();
    $data['bandwidthTotal'] = $this->directadmin->getUserBandwidthLimit();
    $data['diskSpacePercentage'] = round((($this->directadmin->getUserQuota() / $this->directadmin->getUserQuotaLimit()) * 100), 2);
    $data['diskSpaceUsed'] = $this->directadmin->getUserQuota();
    $data['diskSpaceTotal'] = $this->directadmin->getUserQuotaLimit();
    
    # Get data for category chart
    $qb = $this->doctrine->em->createQueryBuilder();
    $qb->select(array('c.name', 'COUNT(l.id) as num'))
        ->from('Entities\Location', 'l')
        ->leftJoin('l.category', 'c')
        ->groupBy('c.id')
        ->orderBy('num', 'DESC')
        ->setMaxResults(5);
    $data['category_chart'] = $qb->getQuery()->getResult();
    
    # Get users count
    $qb = $this->doctrine->em->createQueryBuilder();
    $qb->select('COUNT(u.id) as num')
       ->from('Entities\User', 'u');
    $data['users_count'] = $qb->getQuery()->getSingleResult();
    
    # Get photos count
    $qb = $this->doctrine->em->createQueryBuilder();
    $qb->select('COUNT(p.id) as num')
       ->from('Entities\Photo', 'p');
    $data['photos_count'] = $qb->getQuery()->getSingleResult();
    
    # Get locations count
    $qb = $this->doctrine->em->createQueryBuilder();
    $qb->select('COUNT(l.id) as num')
       ->from('Entities\Location', 'l');
    $data['locations_count'] = $qb->getQuery()->getSingleResult();
    
    # Get categories count
    $qb = $this->doctrine->em->createQueryBuilder();
    $qb->select('COUNT(c.id) as num')
       ->from('Entities\Category', 'c');
    $data['categories_count'] = $qb->getQuery()->getSingleResult();
    
    # Get datasets count
    $qb = $this->doctrine->em->createQueryBuilder();
    $qb->select('COUNT(d.id) as num')
       ->from('Entities\Dataset', 'd');
    $data['datasets_count'] = $qb->getQuery()->getSingleResult();
    
    $this->load->view('admin/dashboard', $data);
  }
  public function users($action = NULL, $id = NULL){
    switch($action){
      case NULL:
        $this->users_list();
        break;
      case 'search':
        $this->users_search();
        break;
      case 'setAdmin':
        $this->users_setAccess($id, 2);
        echo 'ok';
        break;
      case 'setUser':
        $this->users_setAccess($id, 1);
        break;
      case 'delete':
        $this->users_delete($id);
        break;
    }
  }
  public function locations($action = NULL, $id= NULL){
    switch($action){
      case NULL:
        $this->locations_list();
        break;
      case 'search':
        $this->locations_search();
        break;
      case 'create':
        $this->locations_create();
        break;
      case 'delete':
        $this->locations_delete($id);
        break;
    }
  }
  public function categories($action = NULL, $id = NULL){
    switch($action){
      case NULL:
        $this->categories_list();
        break;
      case 'search':
        $this->categories_search();
        break;
      case 'create':
        $this->categories_create();
        break;
      case 'delete':
        $this->categories_delete($id);
        break;
    }
  }
  public function datasets($action = NULL, $id = NULL){
    switch($action){
      case NULL:
        $this->datasets_list();
        break;
      case 'create':
        $this->datasets_create();
        break;
      case 'delete':
        $this->datasets_delete($id);
        break;
      case 'search':
        $this->datasets_search();
        break;
      case 'update':
        $this->datasets_update($id);
        break;
      case 'cronjob':
        $this->datasets_cronjob($id);
        break;
    }
  }
  
  /* Users */
  private function users_list(){
    # Get all users
    $data['users'] = $this->doctrine->em->getRepository("Entities\User")->findAll();
    
    $data['serverAlert'] = $this->servermsg->toHTML();
    $this->load->view('admin/users/list', $data);
  }
  private function users_setAccess($id, $access){
    # You cannot change you own access level
    if($id == $this->session->userdata('user_id')){
      $this->servermsg->setFlashError('Je kan je eigen toegangsniveau niet wijzigen!');
    }else{
      # Get user
      $user = $this->doctrine->em->getRepository("Entities\User")->find($id);

      # Update access level
      $user->setAccess($access);
      $this->doctrine->em->persist($user);
      $this->doctrine->run();

      # Set success message
      if($access >= 2){
        $this->servermsg->setFlashSuccess($user->getUsername() . ' is nu een beheerder!');
      }else{
        $this->servermsg->setFlashSuccess($user->getUsername() . ' is nu een gebruiker!');
      }
    }
    
    # Redirect to users list
    redirect(site_url('admin/users'));
  }
  private function users_delete($id){
    # You cannot delete your own account from the admin panel
    if($id == $this->session->userdata('user_id')){
      $this->servermsg->setFlashError('Je kan je eigen profiel niet verwijderen vanuit het beheerderspaneel!');
    }else{
      # Get user
      $user = $this->doctrine->em->getRepository("Entities\User")->find($id);

      # Remove user
      $this->doctrine->em->remove($user);
      $this->doctrine->run();

      # Set success message
      $this->servermsg->setFlashSuccess($user->getUsername() . ' is verwijderd!');
    }
    
    # Redirect to users list
    redirect(site_url('admin/users'));
  }
  private function users_search(){
    # Get users that match the search query
    $qb = $this->doctrine->em->createQueryBuilder();
    $qb->select('u')
        ->from('Entities\User', 'u')
        ->where($qb->expr()->orX(
          $qb->expr()->like('u.username', '?1'),
          $qb->expr()->like('u.firstname', '?1'),
          $qb->expr()->like('u.lastname', '?1')
        ))
        ->orderBy('u.username')
        ->setParameter(1, '%' . $this->input->post('search', TRUE) . '%');
    $data['users'] = $qb->getQuery()->getResult();
    
    $data['serverAlert'] = $this->servermsg->toHTML();
    $this->load->view('admin/users/list', $data);
  }
  
  /* Locations */
  private function locations_list(){
    # Get all locations (limit 120)
    $qb = $this->doctrine->em->createQueryBuilder();
    $qb->select('l')
       ->from('Entities\Location', 'l')
       ->setMaxResults(120);
    $data['locations'] = $qb->getQuery()->getResult();
    //$data['locations'] = $this->doctrine->em->getRepository("Entities\Location")->findAll();
    
    $data['serverAlert'] = $this->servermsg->toHTML();
    $this->load->view('admin/locations/list', $data);
  }
  private function locations_create(){
    $this->_locations_create();
    
    # Get all categories
    $data['categories'] = $this->doctrine->em->getRepository("Entities\Category")->findAll();
    
    $data['serverAlert'] = $this->servermsg->toHTML();
    $this->load->view('admin/locations/create', $data);
  }
  private function locations_delete($id){
    # Get location
    $location = $this->doctrine->em->getRepository("Entities\Location")->find($id);

    # Remove user
    $this->doctrine->em->remove($location);
    $this->doctrine->run();

    # Set success message
    $this->servermsg->setFlashSuccess($location->getName() . ' is verwijderd!');
    
    # Redirect to locations list
    redirect(site_url('admin/locations'));
  }
  private function locations_search(){
    # Get locations that match the search query
    $qb = $this->doctrine->em->createQueryBuilder();
    $qb->select('l')
        ->from('Entities\Location', 'l')
        ->where($qb->expr()->orX(
          $qb->expr()->like('l.name', '?1')
        ))
        ->orderBy('l.name')
        ->setParameter(1, '%' . $this->input->post('search', TRUE) . '%');
    $data['locations'] = $qb->getQuery()->getResult();
    
    $data['serverAlert'] = $this->servermsg->toHTML();
    $this->load->view('admin/locations/list', $data);
  }
  
  /* Categories */
  private function categories_list(){
    # Get all categories
    $data['categories'] = $this->doctrine->em->getRepository("Entities\Category")->findAll();
    
    $data['serverAlert'] = $this->servermsg->toHTML();
    $this->load->view('admin/categories/list', $data);
  }
  private function categories_create(){
    $this->_categories_create();
    
    # Redirect to users list
    redirect(site_url('admin/categories'));
  }
  private function categories_delete($id){
    # Get category
    $category = $this->doctrine->em->getRepository("Entities\Category")->find($id);

    # Remove user
    $this->doctrine->em->remove($category);
    $this->doctrine->run();

    # Set success message
    $this->servermsg->setFlashSuccess($category->getName() . ' is verwijderd!');
    
    # Redirect to categories list
    redirect(site_url('admin/categories'));
  }
  private function categories_search(){
    # Get categories that match the search query
    $qb = $this->doctrine->em->createQueryBuilder();
    $qb->select('c')
        ->from('Entities\Category', 'c')
        ->where($qb->expr()->orX(
          $qb->expr()->like('c.name', '?1')
        ))
        ->orderBy('c.name')
        ->setParameter(1, '%' . $this->input->post('search', TRUE) . '%');
    $data['categories'] = $qb->getQuery()->getResult();
    
    $data['serverAlert'] = $this->servermsg->toHTML();
    $this->load->view('admin/categories/list', $data);
  }
  
  /* Datasets */
  private function datasets_list(){
    # Get all datasets
    $data['datasets'] = $this->doctrine->em->getRepository("Entities\Dataset")->findAll();
    # Get all categories
    $data['categories'] = $this->doctrine->em->getRepository("Entities\Category")->findAll();
    # Get cronjob setting
    $this->config->load('cronjobs');
    $data['cronjob'] = $this->config->item('cronjobs_enabled');
    
    $data['serverAlert'] = $this->servermsg->toHTML();
    $this->load->view('admin/datasets/list', $data);
  }
  private function datasets_create(){
    $this->_datasets_create();
    
    # Redirect to users list
    redirect(site_url('admin/datasets'));
  }
  private function datasets_delete($id){
    # Get datasets
    $dataset = $this->doctrine->em->getRepository("Entities\Dataset")->find($id);

    # Remove dataset
    $this->doctrine->em->remove($dataset);
    $this->doctrine->run();

    # Set success message
    $this->servermsg->setFlashSuccess($dataset->getName() . ' is verwijderd!');
    
    # Redirect to dataset list
    redirect(site_url('admin/datasets'));
  }
  private function datasets_search(){
    # Get categories that match the search query
    $qb = $this->doctrine->em->createQueryBuilder();
    $qb->select('d')
        ->from('Entities\Dataset', 'd')
        ->where($qb->expr()->orX(
          $qb->expr()->like('d.name', '?1')
        ))
        ->orderBy('d.name')
        ->setParameter(1, '%' . $this->input->post('search', TRUE) . '%');
    $data['datasets'] = $qb->getQuery()->getResult();
    
    $data['serverAlert'] = $this->servermsg->toHTML();
    $this->load->view('admin/datasets/list', $data);
  }
  private function datasets_update($id){
    # Get dataset info from database
    $dataset = $this->doctrine->em->getRepository("Entities\Dataset")->find($id);
    
    # Get dataset from url
    $json = file_get_contents($dataset->getUrl());
    $objects = json_decode($json);
    $nameTag = $dataset->getNameTag();
    foreach($objects as $array){
      foreach((array)$array as $entry){
        $locationExists = $this->doctrine->em->getRepository("Entities\Location")->findOneBy(array('name' => $entry->$nameTag));
        if(!is_object($locationExists)){
          $location = new Entities\Location;
          $location->setName($entry->$nameTag);
          $location->setCategory($dataset->getCategory());
          $location->setLat($entry->lat);
          $location->setLng($entry->long);
          $this->doctrine->em->persist($location);
          $this->doctrine->em->flush();
        }
      }
    }
    
    # Store new update DateTime
    $dataset->setUpdated(new DateTime('now'));
    $this->doctrine->em->persist($dataset);
    $this->doctrine->em->flush();
    
    # Set success message
    $this->servermsg->setFlashSuccess('Dataset ' . $dataset->getName() . ' is geupdate!');
    
    # Redirect to users list
    redirect(site_url('admin/datasets'));
  }
  private function datasets_cronjob($action){
    $this->load->helper('file');
    $header = '<?php  if ( ! defined("BASEPATH")) exit("No direct script access allowed");' . "\n\n";
    if($action == 'enable'){
      $settings = '$config["cronjobs_enabled"] = true;';
    }else{
      $settings = '$config["cronjobs_enabled"] = false;';
    }
    
    #Write file
    if(!write_file('./application/config/cronjobs.php', $header . $settings, 'w+')){
      $this->servermsg->setFlashError('Kan het configuratie bestand niet aanpassen!');
    }else{
      $this->servermsg->setFlashSuccess('Cronjob instelling is gewijzigd!');
    }
    
    redirect(site_url('admin/datasets'));
  }
  
  /* Validation & logic */
  private function _categories_create(){
    # Validation rules
		$this->form_validation->set_rules('categoryName', 'Categorie naam', 'trim|required|xss_clean|min_length[3]|max_length[32]|callback_categoryExists');
    
    # Run validation
    if($this->form_validation->run()){
			# Store the location category
			$category = new Entities\Category;
			$category->setName($this->form_validation->set_value('categoryName'));
			$this->doctrine->em->persist($category);
			$this->doctrine->run();

      # Set success message
			$this->servermsg->setFlashSuccess('Locatie categorie is aangemaakt!');
      return true;
		}else{
      $error = validation_errors('<span>', '</span>');
      $this->servermsg->setFlashError($error);
      return false;
    }
    
    return;
  }
  private function _locations_create(){
    # Validation rules
    $this->form_validation->set_rules('locationName', 'Locatie naam', 'trim|required|xss_clean|min_length[2]|max_length[32]|callback_locationExists');
		$this->form_validation->set_rules('category', 'Categorie', 'trim|required|xss_clean');
    $this->form_validation->set_rules('lat', 'Latitude', 'trim|required|xss_clean|max_length[10]');
    $this->form_validation->set_rules('lng', 'Longitude', 'trim|required|xss_clean|max_length[10]');
    
    # Run validation
    if($this->form_validation->run()){
      # Get category entity
      $category = $this->doctrine->em->getRepository("Entities\Category")->find($this->form_validation->set_value('category'));
      
			# Store the location
			$location = new Entities\Location;
			$location->setName($this->form_validation->set_value('locationName'));
      $location->setCategory($category);
      $location->setLat($this->form_validation->set_value('lat'));
      $location->setLng($this->form_validation->set_value('lng'));
      $this->doctrine->em->persist($location);
			$this->doctrine->run();
         
      # Set success message
			$this->servermsg->setSuccess('Locatie is aangemaakt!');
      return true;
		}
    
    return;
  }
  private function _datasets_create(){
    # Validation rules
    $this->form_validation->set_rules('datasetName', 'Dataset naam', 'trim|required|xss_clean|min_length[2]|max_length[32]|callback_datasetExists');
		$this->form_validation->set_rules('category', 'Categorie', 'trim|required|xss_clean');
    $this->form_validation->set_rules('datasetUrl', 'Dataset url', 'trim|required|xss_clean|max_length[128]');
    $this->form_validation->set_rules('datasetNameTag', 'Naam-tag', 'trim|required|xss_clean|max_length[32]');
    
    # Run validation
    if($this->form_validation->run()){
      # Get category entity
      $category = $this->doctrine->em->getRepository("Entities\Category")->find($this->form_validation->set_value('category'));
      
			# Store the dataset
			$dataset = new Entities\Dataset;
			$dataset->setName($this->form_validation->set_value('datasetName'));
      $dataset->setCategory($category);
      $dataset->setUrl($this->form_validation->set_value('datasetUrl'));
      $dataset->setNametag($this->form_validation->set_value('datasetNameTag'));
      $this->doctrine->em->persist($dataset);
			$this->doctrine->run();
         
      # Set success message
			$this->servermsg->setFlashSuccess('Dataset is aangemaakt!');
      return true;
		}else{
      $error = validation_errors('<span>', '</span>');
      $this->servermsg->setFlashError($error);
      return false;
    }
    
    return;
  }
  
  /* Validation helpers */
  public function categoryExists($categoryName){
    # Get user
		$category = $this->doctrine->em->getRepository("Entities\Category")->findby(array('name' => $categoryName));
		
    # Category exists?
    if($category){
      # Set form validation error
      $this->form_validation->set_message('categoryExists', 'Categorie bestaat al!');
			return false;
		}
		return true;
	}
  public function datasetExists($datasetName){
    # Get dataset
		$dataset = $this->doctrine->em->getRepository("Entities\Dataset")->findby(array('name' => $datasetName));
		
    # Category exists?
    if($dataset){
      # Set form validation error
      $this->form_validation->set_message('datasetExists', 'De dataset met de door u gekozen naam bestaat al!');
			return false;
		}
		return true;
	}
  public function locationExists($locationName){
    # Get location
		$location = $this->doctrine->em->getRepository("Entities\Location")->findby(array('name' => $locationName));
		
    # Location exists?
    if($location){
      # Set form validation error
      $this->form_validation->set_message('locationExists', 'De Locatie met de door u gekozen naam bestaat al!');
			return false;
		}
		return true;
	}
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */