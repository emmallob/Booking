<?php
// ensure this file is being included by a parent file
if( !defined( 'SITE_URL' ) ) die( 'Restricted access' );

class Sessions {
	
	public function __construct() {
		global $session;

		$this->session = $session;
	}

	private function countSessionData($sessionName) {
		return (isset($_SESSION[$sessionName]) and count($_SESSION[$sessionName]) > 0) ? true : false;
	}

	public function addSessionData($sessionName, $firstVariable, $secondVariable, $thirdVariable = null, $forthVariable = null, $fifthVariable = null, $sixthVariable = null) {
		
		if($this->countSessionData($sessionName)) {
			foreach($_SESSION[$sessionName] as $key => $value) {			
				if($value['first_item'] == $firstVariable) {
				 	$_SESSION[$sessionName][$key]['second_item'] = trim($secondVariable);
				 	(!empty($thirdVariable)) ? ($_SESSION[$sessionName][$key]['third_item'] = trim($thirdVariable)) : null;
				 	(!empty($forthVariable)) ? ($_SESSION[$sessionName][$key]['forth_item'] = trim($forthVariable)) : null;
				 	(!empty($fifthVariable)) ? ($_SESSION[$sessionName][$key]['fifth_item'] = trim($fifthVariable)) : null;
				 	(!empty($sixthVariable)) ? ($_SESSION[$sessionName][$key]['sixth_item'] = trim($sixthVariable)) : null;
				 	break;
				}
			}

			$itemId = array_column($_SESSION[$sessionName], "first_item");

            if (!in_array($firstVariable, $itemId)) {
            	if(empty($thirdVariable) && empty($forthVariable)) {
            		$_SESSION[$sessionName][] = array(
						'first_item'=>$firstVariable, 
						'second_item' => trim($secondVariable)
					);
            	} else {
            		if(!empty($forthVariable)) {
            			if(!empty($sixthVariable)) {
            				$_SESSION[$sessionName][] = array(
								'first_item'=>$firstVariable, 
								'second_item' => trim($secondVariable),
								'third_item' => trim($thirdVariable),
								'forth_item' => trim($forthVariable),
								'fifth_item' => trim($fifthVariable),
								'sixth_item' => trim($sixthVariable)
							);
            			} elseif(!empty($fifthVariable) && empty($sixthVariable)) {
            				$_SESSION[$sessionName][] = array(
								'first_item'=>$firstVariable, 
								'second_item' => trim($secondVariable),
								'third_item' => trim($thirdVariable),
								'forth_item' => trim($forthVariable),
								'fifth_item' => trim($fifthVariable)
							);
            			} else {
	            			$_SESSION[$sessionName][] = array(
								'first_item'=>$firstVariable, 
								'second_item' => trim($secondVariable),
								'third_item' => trim($thirdVariable),
								'forth_item' => trim($forthVariable),
							);
	            		}
            		} else {
	            		$_SESSION[$sessionName][] = array(
							'first_item'=>$firstVariable, 
							'second_item' => trim($secondVariable),
							'third_item' => trim($thirdVariable)
						);
	            	}
            	}
            	
            }

		} else {
			if(empty($thirdVariable) && empty($forthVariable)) {
				$_SESSION[$sessionName][] = array(
					'first_item' => $firstVariable,
					'second_item' => $secondVariable
				);
			} else {
				if(empty($forthVariable)) {
					$_SESSION[$sessionName][] = array(
						'first_item' => $firstVariable,
						'second_item' => $secondVariable,
						'third_item' => trim($thirdVariable)
					);
				} else {
					if(!empty($sixthVariable)) {
						$_SESSION[$sessionName][] = array(
							'first_item'=>$firstVariable, 
							'second_item' => trim($secondVariable),
							'third_item' => trim($thirdVariable),
							'forth_item' => trim($forthVariable),
							'fifth_item' => trim($fifthVariable),
							'sixth_item' => trim($sixthVariable)
						);
					} elseif(!empty($fifthVariable) && empty($sixthVariable)) {
						$_SESSION[$sessionName][] = array(
							'first_item'=>$firstVariable, 
							'second_item' => trim($secondVariable),
							'third_item' => trim($thirdVariable),
							'forth_item' => trim($forthVariable),
							'fifth_item' => trim($fifthVariable)
						);
					} else {
						$_SESSION[$sessionName][] = array(
							'first_item'=>$firstVariable, 
							'second_item' => trim($secondVariable),
							'third_item' => trim($thirdVariable),
							'forth_item' => trim($forthVariable),
						);
					}
				}
			}
		}

		$this->session->set_userdata($sessionName, $_SESSION[$sessionName]);
	}

	public function removeSessionValue($sessionName, $itemId, $unlink = false) {

		if($this->countSessionData($sessionName)) {
			foreach($_SESSION[$sessionName] as $key => $value) {
				// confirm if the item id parsed is in the array
				if($value['first_item'] == $itemId) {
					// unset the session
				 	unset($_SESSION[$sessionName][$key]);
				 	// unlink the file
				 	if($unlink) {
				 		// confirm the file exists
				 		if(is_file($unlink.$itemId) && file_exists($unlink.$itemId)) {
				 			// delete the file
				 			unlink($unlink.$itemId);
				 		}
				 	}
				 	break;
				}				
			}
		}

	}


	
}
?>