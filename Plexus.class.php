<?php
Class Plexus{

	private $api_target;
	private $user;
	private $pass;

	/**
	  * Constructor
	  *
	  * @author Leo Brown
	  */
	function __construct($api_target, $user, $pass){
		$this->api_target = $api_target;
		$this->user = $user;
		$this->pass = $pass;
	}

	/**
	  * Make API Call
	  *
	  * @author Leo Brown
	  */
	function __call($endpoint, $data=array()){

		$ch = curl_init();
		curl_setopt_array($ch, array(
			CURLOPT_URL => $this->api_target . $endpoint,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_USERPWD => "{$this->user}:{$this->pass}"
		));

		if($data){
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		}
		$res = curl_exec($ch);
		$res = json_decode($res, true);
		return $res;
	}

	/**
	  *
	  *
	  */
	function getCustomerCount(){
		$customer_resp = $this->__call('/customers');
		return @$customer_resp['response']['total_results'];
	}

}

