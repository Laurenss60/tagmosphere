<?php
class DirectAdmin{
  
  private $socket = null;
  private $user;
  
  public function __construct(){
    # Load HttpSocket lib
    $this->CI = get_instance();
    $this->CI->load->library('httpsocket');
    
    # Connect to DirectAdmin
    $this->socket = $this->CI->httpsocket;
    $this->socket->connect('159.253.7.186', 2222);
    $this->socket->set_login('tagmospher','betatest');
    $this->socket->set_method('POST');
    
    # If not admin, set the user
    $this->user = 'tagmospher';
  }
  
  public function getServerBandwidth(){
    $serverStats = $this->getServerStats();
    return $serverStats['bandwidth'];
  }
  public function getServerDiskSpacePercentage(){
    $serverStats = $this->getServerStats();
    $diskSpace = $serverStats['disk1'];
    $diskSpace_Explode = explode(':', $diskSpace);
    $diskSpace_Explode2 = explode('%', $diskSpace_Explode[4]);
    $diskSpacePercentage = $diskSpace_Explode2[0];
    return $diskSpacePercentage;
  }
  public function getServerDiskSpaceTotal(){
    $serverStats = $this->getServerStats();
    $diskSpace = $serverStats['disk1'];
    $diskSpace_Explode = explode(':', $diskSpace);
    $diskSpacePercentage = $diskSpace_Explode[1];
    return $diskSpacePercentage;
  }
  public function getServerDiskSpaceUsed(){
    $serverStats = $this->getServerStats();
    $diskSpace = $serverStats['disk1'];
    $diskSpace_Explode = explode(':', $diskSpace);
    $diskSpacePercentage = $diskSpace_Explode[2];
    return $diskSpacePercentage;
  }
  public function getServerDiskSpaceAvailable(){
    $serverStats = $this->getServerStats();
    $diskSpace = $serverStats['disk1'];
    $diskSpace_Explode = explode(':', $diskSpace);
    $diskSpacePercentage = $diskSpace_Explode[3];
    return $diskSpacePercentage;
  }
  public function getServerUserCount(){
    $serverStats = $this->getServerStats();
    return $serverStats['nusers'];
  }
  public function getServerDomainCount(){
    $serverStats = $this->getServerStats();
    return $serverStats['vdomains'];
  }
  public function getServerSubdomainCount(){
    $serverStats = $this->getServerStats();
    return $serverStats['nsubdomains'];
  }
  public function getServerDomainPointerCount(){
    $serverStats = $this->getServerStats();
    return $serverStats['domainptr'];
  }
  public function getServerDatabaseCount(){
    $serverStats = $this->getServerStats();
    return $serverStats['mysql'];
  }
  public function getServerFtpCount(){
    $serverStats = $this->getServerStats();
    return $serverStats['ftp'];
  }
  public function getServerEmailCount(){
    $serverStats = $this->getServerStats();
    return $serverStats['nemails'];
  }
  
  public function getUserBandwidth(){
    $userStats = $this->getUserStats();
    return $userStats['bandwidth'];
  }
  public function getUserQuota(){
    $userStats = $this->getUserStats();
    return $userStats['quota'];
  }
  
  public function getUserBandwidthLimit(){
    $userStats = $this->getUserLimits();
    return $userStats['bandwidth'];
  }
  public function getUserQuotaLimit(){
    $userStats = $this->getUserLimits();
    return $userStats['quota'];
  }
  
  protected function getUserStats(){
    $this->socket->query('/CMD_API_SHOW_USER_USAGE?user="' . $user . '"');
    return $this->socket->fetch_parsed_body();
  }
  protected function getUserLimits(){
    $this->socket->query('/CMD_API_SHOW_USER_CONFIG?user="' . $user . '"');
    return $this->socket->fetch_parsed_body();
  }


  protected function getServerStats(){
    $this->socket->query('/CMD_API_ADMIN_STATS');
    return $this->socket->fetch_parsed_body();
  }
}
?>
