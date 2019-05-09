<?php
 
 function getAuthorizationlink($client_id,$redirect_url,$state){

 
   $base_authrization_url="https://www.linkedin.com/uas/oauth2/authorization";
   

  if ($client_id === '' || $redirect_url === ''){

      
      return null;

  }else{

  	 $authrization_url_with_params=$base_authrization_url.'?response_type=code&client_id='.$client_id.'&redirect_uri='.$redirect_url.'&state='.$state.'&scope=r_liteprofile w_member_social r_emailaddress';
  
      return $authrization_url_with_params;

  }

}

function  getAccesstokenlink(){

   $base_accesstoken_url="https://www.linkedin.com/uas/oauth2/accessToken";

   return $base_accesstoken_url;

}

function  getAcesstoeknwithparams($code,$call_back_url,$client_id,$client_secret){

 $param = 'grant_type=authorization_code&code='.$code.'&redirect_uri='.$call_back_url.'&client_id='.$client_id.'&client_secret='.$client_secret;

 return $param;

}


function post_curl($url,$param="")
{
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
if($param!="")
curl_setopt($ch,CURLOPT_POSTFIELDS,$param);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$result = curl_exec($ch);
curl_close($ch);

return $result;
}


function get_curl($url){
  
$curl = curl_init();
// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $url,
    CURLOPT_USERAGENT => 'Get User Information cURL Request'
]);
// Send the request & save response to $resp
$resp = curl_exec($curl);
// Close request to clear up some resources
curl_close($curl);

 return $resp;

}












?>