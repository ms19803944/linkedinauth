<?php


session_start();

require_once('config.php');
require_once('csrf.class.php');
require_once('handle_linkedin_oauth.php');


// create the  csrf value
$csrf = new csrf();
$token_id = $csrf->get_token_id();
$token_value = $csrf->get_token($token_id);


if($token_value){

     $authrizationLink=getAuthorizationlink($config['Client_ID'], $config['callback_url'],$token_value);

     if(is_null($authrizationLink)){

        echo 'You need a API Key and Secret Key and redirect URL. Get one from <a href="https://www.linkedin.com/developer/apps/">https://www.linkedin.com/developer/apps/</a>';
        exit;

     }else{ ?>


      <html>
  <head>
    <style>
     html {
  margin: 40px auto;
  text-align: center;
}
  .btn-linkedin {
    background: #0E76A8;
    border-radius: 0;
    color: #fff;
    border-width: 1px;
    border-style: solid;
    border-color: #084461;
  }
  .btn-linkedin:link, .btn-linkedin:visited {
    color: #fff;
  }
  .btn-linkedin:active, .btn-linkedin:hover {
    background: #084461;
    color: #fff;
  }
   </style>

  </head>
   <body>
    
     <a href="<?php echo $authrizationLink ?>">
        <img class="resource-paragraph-image lazy-load lazy-load-src" alt="Sign in with LinkedIn" src="https://content.linkedin.com/content/dam/developer/global/en_US/site/img/signin-button.png" pagespeed_url_hash="1811720327" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
        </a>

   </body>
</html>
  

        
    <?php  

 

  }

} ?>


 

  
 


