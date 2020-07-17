<?php 

// ensure this file is being included by a parent file
if( !defined( 'SITE_URL' ) && !defined( 'SITE_DATE_FORMAT' ) ) die( 'Restricted access' );


class Country {
	
	// set the number of users that can be created by an account
	public $countries;
	public $code;
	public $name;
	
	public function single_country($item_value) {
		
		global $booking;
		
		$this->found = false;
		
		$field = (preg_match("/^[0-9]+$/", strtoupper($item_value))) ? "id" : "country_code";
			
		try {
			
			$sql = $booking->query("SELECT * FROM country WHERE `$field`='$item_value'");
			
			if($sql->rowCount() == 1) {
				
				$this->found = true;
				
				foreach($sql as $results) {
					$this->id = $results["id"];
					$this->name = $results["country_name"];
					$this->code = $results["country_code"];
				}

			}
		} catch(PDOException $e) { }

		return $this;
	}
	
	public function all_countries() {
		
		global $booking;
		
			
		try {
			
			$sql = $booking->query("SELECT * FROM country ORDER BY country_name");
			
			return $sql ?? [];

		} catch(PDOException $e) { }

		return $this;
	}

}

?>