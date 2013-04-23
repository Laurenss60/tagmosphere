<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function facebookLoginButton(){
  return '<img src="' . base_url() . 'assets/images/facebookconnect.png" class="facebook" />';
}

function facebookLoginScript(){
  return '<script src="' . base_url() . 'assets/javascript/jquery/libs/jquery.oauthpopup.js"></script>
          <script type="text/javascript">
            $(document).ready(function(){
              $(".facebook").click(function(e){
                $.oauthpopup({
                  path: "' . site_url('user/facebook/popup') . '",
                  width:600,
                  height:300,
                  callback: function(){
                    window.location.reload();
                  }
                });
                e.preventDefault();
              });
            });
          </script>';
}