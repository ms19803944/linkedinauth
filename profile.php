<?php


require_once('csrf.class.php');
require_once('config.php');
require_once('handle_linkedin_oauth.php');
session_start();


$csrf = new csrf();
$token_id = $csrf->get_token_id();
$token_value = $csrf->get_token($token_id);



// OAuth 2 Control Flow
if (isset($_GET['error'])) {

  // LinkedIn returned an error
    print $_GET['error'] . ': ' . $_GET['error_description'];
    exit;
} else if(isset($_GET['code'])) {

	if($csrf->check_valid('get')){

    $accesstokenTokenurl=getAccesstokenlink();
    $parameters=getAcesstoeknwithparams($_GET['code'],$config['callback_url'] ,$config['Client_ID'],$config['Client_Secret']);

      

    $accessTokenResult=post_curl($accesstokenTokenurl,$parameters);



    $encodeAccesstoken=json_decode($accessTokenResult);

    if(isset($encodeAccesstoken->error)){

    
        header("Location: index.php"); 

    }else{
 

    
     // Store access token and expiration time
    $_SESSION['access_token'] = $encodeAccesstoken->access_token; // guard this! 
    $_SESSION['expires_in']   = $encodeAccesstoken->expires_in; // relative time (in seconds)
    $_SESSION['expires_at']   = time() + $_SESSION['expires_in']; // absolute time

     

    }
 
 }else{

     echo "csrf token does not match";
     exit();

 }

}else{

    if ((empty($_SESSION['expires_at'])) || (time() > $_SESSION['expires_at'])) {
        // Token has expired, clear the state
          $_SESSION = array();
     }
    if (empty($_SESSION['access_token'])) {
        // Start authorization process
         header("Location: index.php"); 
      }


}


//Logout
if (isset($_REQUEST['logout'])) {
    unset($_SESSION['access_token']);
    header("Location: index.php"); 
}


 //var_dump($_SESSION['access_token']);
 //die();
 $url = 'https://api.linkedin.com/v2/me?projection=(id,firstName,lastName,profilePicture(displayImage~:playableStreams))&oauth2_access_token='.$_SESSION['access_token'];
 $user_details = json_decode(get_curl($url)); // Request user information on received token

  ?>

  <html>
   <head>
   </head>

   <body>


<div align="right">
  <a class="btn btn-danger" href="?logout=true">Logout</a>
    
</div>
     <center><h2><b>Basic Profile Detials</b></h2></center>
    
     </br>
           <center><img src="<?php echo $user_details->profilePicture->{'displayImage~'}->elements[0]->identifiers[0]->identifier; ?>" alt="Profile Image" ></center>
       </br>
       <center><h5> First Name : <?php echo $user_details->firstName->localized->en_US; ?> </h5></center>
      <center><h5> Last Name : <?php echo $user_details->lastName->localized->en_US; ?> </h5></center>

         
      
  </body>


  </html>


