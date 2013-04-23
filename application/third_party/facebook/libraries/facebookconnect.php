<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class FacebookConnect {
  private $facebook = null;

  public function popup(){
    # Load facebook lib
    $CI =& get_instance();
    $CI->config->load('facebook');
    $CI->load->library('facebook/facebook');
    
    # Create new facebook object
    $this->facebook = new Facebook(array(
      'appId'     =>  $CI->config->item('app_id'),
      'secret'    =>  $CI->config->item('app_secret')
    ));
    
    # Try to get the user
    $user = $this->facebook->getUser();
    if(!$user){
      # Try to login with facebook
      $this->login();
      return false;
    }
    
    # Get user info
    try{
      $user_profile = $this->facebook->api('/me');
      
      # Set default facebook session data
      $CI->session->set_userdata('fb_connect', true);
      $CI->session->set_userdata('fb_user_id', $user_profile['id']);
    }catch(FacebookApiException $e){
      error_log($e);
      $user = NULL;
      return false;
    }
    
    # Return user profile
    return $user_profile;
  }
  public function closePopup(){
    echo '<script type="text/javascript">window.close();</script>';
    return;
  }
  public function connectSuccess(){
    # Redirect if facebook login is successfull
    $CI =& get_instance();
    $CI->config->load('facebook');
    if($CI->session->userdata['fb_connect'] === true){
      if(!$CI->session->userdata['fb_new_user']){
        redirect($CI->config->item('redirect_after_login'));
      }
    }
  }
  
  private function login(){
    # Show facebook login page
    $CI =& get_instance();
    $CI->config->load('facebook');
    $loginurl = $this->facebook->getLoginUrl(array(
      'scope'=> 'email',
      'redirect_uri'  => $CI->config->item('fb_popup_window'),
      'display'=>'popup'
    ));
    redirect($loginurl);
    return;
  }
  
}

/* End of file FacebookConnect.php */
/* Location: ./application/libraries/FacebookConnect.php */