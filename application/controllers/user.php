<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller{

  /* Authentication check */
  public function __construct(){
    parent::__construct();
    # Login check
    if($this->session->userdata('user_access') < 1){
      $action = $this->uri->segment(2);
      if($action != 'authentication' && $action != 'facebook' && $action != 'logout'){
        redirect(site_url('user/authentication'));
      }
    }
  }
	
  /* Pages */
  public function index(){
    # User is logged in?
    if($this->session->userdata('user_access') > 0){
      redirect(site_url('wall'));
    }else{
      redirect(site_url('user/login'));
    }
	}
  public function authentication(){
    # Redirect if already logged in
    if($this->session->userdata('user_access') > 0){
      redirect(site_url('wall'));
    }
    
    # Validation (forms)
    switch($this->input->post('action', TRUE)){
      case 'login':
        $this->_login();
        echo 'nok';
        $data['action'] = 'login';
        break;
      case 'register':
        $this->_register();
        $data['action'] = 'register';
        break;
    }
    
    # Remove facebook new user marker
    if($this->session->userdata('fb_new_user')){
      $this->session->sess_destroy();
    }
    
    # Facebook redirect (new user)
    if($this->session->userdata('fb_new_user')){
      $data['fb_new_user']    = $this->session->userdata('fb_new_user');
      $data['fb_id']          = $this->session->userdata('fb_user_id');
      $data['username']       = $this->session->userdata('fb_user_username');
      $data['email']          = $this->session->userdata('fb_user_email');
      $data['firstName']      = $this->session->userdata('fb_user_firstName');
      $data['lastName']       = $this->session->userdata('fb_user_lastName');
    }
    
    # Load facebook package
    $this->load->add_package_path(APPPATH.'third_party/facebook/');
    $this->load->library('facebookconnect');
    $this->load->helper('facebook');
    
    # Redirect if facebook login is successfull
    $this->facebookconnect->connectSuccess();
    
    # Pass the facebook connect var
    $data['facebookConnected'] = $this->session->userdata('fb_connect');
    
    $data['page'] = 'authentication';
    $data['serverAlert'] = $this->servermsg->toHTML(false);
    $this->load->view('template/header', $data);
    $this->load->view('user/authentication', $data);
    $this->load->view('template/footer', $data);
  }
  public function logout(){
    $this->session->sess_destroy();
    redirect(site_url('user/authentication'));
    return;
  }  
  public function facebook($action){
    switch($action){
      case 'popup':
        # Load facebook package
        $this->load->add_package_path(APPPATH.'third_party/facebook/');
        $this->load->library('facebookconnect');

        if(($userProfile = $this->facebookconnect->popup()) !== false){
          # Get tagmosphere account with facebook id
          $user = $this->doctrine->em->getRepository("Entities\User")->findOneBy(array('facebookid' => $userProfile['id']));
          if($user){
            # Is existing user
            $this->session->set_userdata('fb_new_user', false);
            $this->session->set_userdata('user_id', $user->getId());
            $this->session->set_userdata('user_username', $user->getUsername());
            $this->session->set_userdata('user_access', $user->getAccess());
            $this->session->set_userdata('user_firstname', $user->getFirstName());
            $this->session->set_userdata('user_lastname', $user->getLastName());
          }else{
            # Temporarly store user info in session. The main window will load the register form.
            $this->session->set_userdata('fb_new_user', true);
            $this->session->set_userdata('fb_user_username', $userProfile['username']);
            $this->session->set_userdata('fb_user_firstName', $userProfile['first_name']);
            $this->session->set_userdata('fb_user_lastName', $userProfile['last_name']);
            $this->session->set_userdata('fb_user_email', $userProfile['email']);
          }
          # Close the pop-up
          $this->facebookconnect->closePopup();
        }
        break;
    }
  }

  /* Validation & logic */
  private function _login(){
    # Validation rules
    $this->form_validation->set_rules('username', 'Gebruiker', 'trim|required|xss_clean|min_length[5]|max_length[16]');
    $this->form_validation->set_rules('password', 'Wachtwoord', 'trim|required|md5');
		
    # Run validation
    if($this->form_validation->run()){
      # Get user by username and password
			$user = $this->doctrine->em->getRepository("Entities\User")->findOneBy(array('username' => $this->form_validation->set_value('username'), 'password' => md5($this->form_validation->set_value('password'))));
        
      # User is found?
      if(!$user){
        $this->servermsg->setError('Gebruikersnaam en/of wachtwoord incorrect!');
        return false;
      }
        
      # Store user info in session
      $this->session->set_userdata('user_id', $user->getId());
      $this->session->set_userdata('user_username', $user->getUsername());
      $this->session->set_userdata('user_firstname', $user->getFirstName());
      $this->session->set_userdata('user_lastname', $user->getLastName());
      $this->session->set_userdata('user_access', $user->getAccess());
      
      # Redirect the user
      redirect('wall');
      return true;
		}
  }
  private function _register(){
    # Validation rules
		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean|min_length[3]|max_length[127]|callback_usernameExists');
    $this->form_validation->set_rules('password', 'Password', 'trim|required||matches[repeat_password]|md5');
    $this->form_validation->set_rules('repeat_password', 'Repeat Password', 'required');
    $this->form_validation->set_rules('email', 'Email address', 'trim|required|xss_clean|valid_email|max_length[255]');
    $this->form_validation->set_rules('first_name', 'First name', 'trim|required|xss_clean|max_length[128]');
    $this->form_validation->set_rules('last_name', 'Last name', 'trim|required|xss_clean|max_length[128]');
    $this->form_validation->set_rules('fb_id', 'Facebook id', 'trim|xss_clean');
		
    
    # Run validation
    if($this->form_validation->run()){
			# Store the new user
			$user = new Entities\User;
			$user->setUsername($this->form_validation->set_value('username'));
      $user->setPassword(md5($this->form_validation->set_value('password')));
      $user->setEmailaddress($this->form_validation->set_value('email'));
      $user->setFirstname($this->form_validation->set_value('first_name'));
      $user->setLastname($this->form_validation->set_value('last_name'));
      $user->setFacebookid($this->form_validation->set_value('fb_id'));
      $user->setAccess(1);
			$this->doctrine->em->persist($user);
			$this->doctrine->run();

      # Set success message
			$this->servermsg->setSuccess('Registreren gelukt!');
      return true;
		}
    
    return false;
  }
  
  /* Validation helpers */
  public function usernameExists($username){
    # Get user
		$user = $this->doctrine->em->getRepository("Entities\User")->findby(array('username' => $username));
		
    # User exists?
    if($user){
      # Set form validation error
      $this->form_validation->set_message('usernameExists', 'De gebruikersnaam %s bestaat al!');
			return false;
		}
		return true;
	}
  
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */