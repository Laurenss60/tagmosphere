<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class ServerMsg {
  
    private $serverSuccess;
    private $serverMsg;
    
    public function __construct(){
      $CI =& get_instance();
      $serverSuccess = $CI->session->flashdata('serverSuccess');
      $serverMsg = $CI->session->flashdata('serverMsg');
      if(!empty($serverMsg) && empty($serverSuccess)){
        $this->serverSuccess = FALSE;
        $this->serverMsg = $CI->session->flashdata('serverMsg');
      }elseif($serverSuccess != null && $serverMsg != null){
        $this->serverSuccess = $CI->session->flashdata('serverSuccess');
        $this->serverMsg = $CI->session->flashdata('serverMsg');
      }
    }

    public function setError($msg){
      $this->serverSuccess = FALSE;
      $this->serverMsg = $msg;
    }
    public function setSuccess($msg){
      if($this->serverSuccess !== FALSE){
        $this->serverSuccess = TRUE;
        $this->serverMsg = $msg;
      }
    }
    public function setFlashError($msg){
      $CI =& get_instance();
      $CI->session->set_flashdata('serverSuccess', FALSE);
      $CI->session->set_flashdata('serverMsg', $msg);
    }
    public function setFlashSuccess($msg){
      $CI =& get_instance();
      $serverSuccess = $CI->session->flashdata('serverSuccess');
      if(empty($this->serverSuccess) && empty($serverSuccess)){
        $CI->session->set_flashdata('serverSuccess', TRUE);
        $CI->session->set_flashdata('serverMsg', $msg);
      }
    }
    
    public function toHTML($bootstrap = true){
      $html = '';
      if($this->serverSuccess === true){
        $html .= '<div class="alert alert-success">';
        if($bootstrap){ $html .= '<button type="button" class="close" data-dismiss="alert">&times;</button>'; }
        $html .= $this->serverMsg . '</div>';
      }elseif($this->serverSuccess === false){
        $html .= '<div class="alert alert-error">';
        if($bootstrap){ $html .= '<button type="button" class="close" data-dismiss="alert">&times;</button>'; }
        $html .= $this->serverMsg . '</div>';
      }
      return $html;
    }
}

/* End of file ServerMsg.php */
/* Location: ./application/libraries/ServerMsg.php */