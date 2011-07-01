<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Facebook {

    function get_facebook_cookie($app_id, $app_secret) { 
		if (isset($_COOKIE['fbs_' . $app_id])) {			
			$args = array();
			parse_str(trim($_COOKIE['fbs_' . $app_id], '\\"'), $args);
			ksort($args);
			$payload = '';
			
			foreach ($args as $key => $value) {
				if ($key != 'sig') {
						$payload .= $key . '=' . $value;
				}
			}
			
			if (md5($payload . $app_secret) != $args['sig']) {
				return null;
			}
			
			return $args;
		}
		
		return null;
    }

    function getCurrentUser($cookie) {
        return json_decode(file_get_contents('https://graph.facebook.com/me?access_token=' .
                $cookie['access_token']));
    }

}

?>