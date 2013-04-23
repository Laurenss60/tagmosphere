<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Cronjob extends CI_Controller{
  
  /* Cronjobs */
  public function update_datasets(){
    if($_SERVER['REMOTE_ADDR'] == 'localhost' || $_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '159.253.7.186' || $_SERVER['REMOTE_ADDR'] == '185.13.224.150'){
      $this->load->config('cronjobs');
      if($this->config->item('cronjobs_enabled')){
        # Get datasets info from database
        $datasets = $this->doctrine->em->getRepository("Entities\Dataset")->findAll();

        foreach($datasets as $dataset){
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
        }
      }
    }else{
      echo 'No access!';
    }
  }
}

/* End of file cronjob.php */
/* Location: ./application/controllers/cronjob.php */