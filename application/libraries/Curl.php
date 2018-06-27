<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Curl {

	protected $main_url="";

    public function curl_get($url,$par=array()){
    	$url=($this->main_url!='')?$this->main_url.$url:$url;
    	$querystring='';
    	if(!empty($par)){
    		foreach ($par as $key => $value) {
    			$querystring .=($querystring=='')?"$key=$value":"&$key=$value";
    		}
    		$url=$url.'?'.$querystring;
    	}   	
    	//return $url;
    	$ch = curl_init();    
		curl_setopt($ch, CURLOPT_URL, $url);    
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		if(ENVIRONMENT == 'development'){
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		}	   
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);    
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);   
		$response = curl_exec($ch);
		curl_close($ch);

		return json_decode($response,true);
    }

    public function curl_post($url,$par=array()){
    	$url=($this->main_url!='')?$this->main_url.$url:$url;
    	$data_string=json_encode($par);

    	$ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


        if(ENVIRONMENT == 'development'){
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        }	

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string))
         );		
        $response = curl_exec($ch);
        curl_close($ch); 
        

        return json_decode($response,true);
    }

    public function curl_put($url,$par=array()){
    	$url=($this->main_url!='')?$this->main_url.$url:$url;
    	$data_string=json_encode($par);

    	$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
		curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		if(ENVIRONMENT == 'development'){
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		}

		$response  = curl_exec($ch);
		curl_close($ch); 

		return json_decode($response,true); 
    }

    public function curl_del($url,$par=array()){
    	$url=($this->main_url!='')?$this->main_url.$url:$url;
    	$data_string=json_encode($par);
    	
    	$ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL,$url);
	    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
	    if(!empty($par)){
	    	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	    }
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	    if(ENVIRONMENT == 'development'){
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		}
		
	    $response = curl_exec($ch);
	    curl_close($ch);

	    return json_decode($response,true);
    }

}