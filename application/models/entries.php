<?php

class entries extends Model {

	function selectLast($num) 
	{
		$data = array();
		
		$this->db->order_by("created", "DESC"); 
		$this->db->where("active", 1);
		$query = $this->db->get('entries', $num);
		
		if ($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				$data[] = $row;
			}
		}
		
		$query->free_result();
		
		return $data;
	}
	
	function voteUp($id) {
	
		// get if already voted in this session
		$session_votes = $this->session->userdata($id);

		if (!$session_votes)
		{
			$this->db->set('votes', 'votes+1', FALSE);
			$this->db->where('id', $id);
			$this->db->update("entries");
			
			// save voted in session to avoid many votes
			$session_votes[$id] = 1;
			$this->session->set_userdata($session_votes);		
		}
		
		$data = array();
		
		$this->db->where("active", 1);
		$this->db->where("id", $id);
		$query = $this->db->get('entries', 1);
		
		if ($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				$data = $row;
			}
			
			$query->free_result();
			return $data->votes;	
		}
		
		return 0;
		
	}
	
	function voteDown($id) {
	
		// get if already voted in this session
		$session_votes = $this->session->userdata($id);

		if (!$session_votes)
		{
			$this->db->set('votes', 'votes-1', FALSE);
			$this->db->where('id', $id);
			$this->db->update("entries");
			
			// save voted in session to avoid many votes
			$session_votes[$id] = -1;
			$this->session->set_userdata($session_votes);		
		}
		
		$data = array();
		
		$this->db->where("active", 1);
		$this->db->where("id", $id);
		$query = $this->db->get('entries', 1);
		
		if ($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				$data = $row;
			}
			
			$query->free_result();
			return $data->votes;	
		}
		
		return 0;		
	}

    function getTopContributors($limit) {
        $data = array();

        $this->db->select("name, userid, count(*) as count");
        $this->db->where("active",1);
        $this->db->order_by("count", "DESC");
        $this->db->group_by("name");
        $query = $this->db->get('entries', $limit);

        /* SELECT name, count(*) as count */
        /* FROM entries  */
        /* GROUP BY name */
        /* ORDER BY count DESC */

		if ($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				$data[] = $row;
			}
		}
		
		$query->free_result();

        return $data;
    }
	
	function top($num) 
	{
		$data = array();
		
		$this->db->order_by("votes", 'DESC'); 
		$this->db->where("active", 1);
		$query = $this->db->get('entries', $num);
		
		if ($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				$data[] = $row;
			}
		}
		
		$query->free_result();
		
		return $data;
	}		
	
	function random($num) 
	{
		$data = array();
		
		$this->db->order_by("id", 'RANDOM'); 
		$this->db->where("active", 1);
		$query = $this->db->get('entries', $num);
		
		if ($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				$data[] = $row;
			}
		}
		
		$query->free_result();
		
		return $data;
	}	
	
	function getPrevious($id)
	{	
		$this->db->where("id >", $id);
		$this->db->where("active", 1);
		$this->db->limit(1);
		$query = $this->db->get("entries");
		
		if ($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				$data = $row;
			}
			
			$query->free_result();
			return $data->id;
		}
		else
		{
			return 0;
		}

	}
	
	function getNext($id)
	{
		$this->db->order_by("created", "desc"); 
		$this->db->where("id <", $id);
		$this->db->where("active", 1);
		$query = $this->db->get("entries", 1);
		
		if ($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				$data = $row;
			}
			
			$query->free_result();
			return $data->id;
		}
		else
		{
			return 0;
		}
		
		
	}
	
	function getId($id)
	{
		$data = array();
		
		$this->db->where("active", 1);
		$this->db->where("id", $id);
		$query = $this->db->get('entries', 1);
		
		if ($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				$data[] = $row;
			}
		}
		
		$query->free_result();
		
		return $data;
	}


    function getImageLocation($image) {

        $data["coords"] = false;

        // if file exists
        if (file_exists('public/uploaded/originals/' . $image . ".jpg")) {
            
            try {
                @$exif = exif_read_data('public/uploaded/originals/' . $image . ".jpg", 0, true);

                if ($exif && isset($exif['GPS'])) {
                    $lat = $exif['GPS']['GPSLatitude']; 
                    $log = $exif['GPS']['GPSLongitude'];
                    if (!$lat || !$log) return;
                
                    // latitude values //
                    $lat_degrees = $this->divide($lat[0]);
                    $lat_minutes = $this->divide($lat[1]);
                    $lat_seconds = $this->divide($lat[2]);
                    $lat_hemi = $exif['GPS']['GPSLatitudeRef'];
                
                    // longitude values //
                    $log_degrees = $this->divide($log[0]);
                    $log_minutes = $this->divide($log[1]);
                    $log_seconds = $this->divide($log[2]);
                    $log_hemi = $exif['GPS']['GPSLongitudeRef'];
                
                    $lat_decimal = $this->toDecimal($lat_degrees, $lat_minutes, $lat_seconds, $lat_hemi);
                    $log_decimal = $this->toDecimal($log_degrees, $log_minutes, $log_seconds, $log_hemi);
                
                    $data["coords"] = $lat_decimal . "," . $log_decimal;
            
                }
            }
            catch(Exception $e) {
                // do nothing
            }
            /* foreach ($exif as $key => $section) { */
            /*     foreach ($section as $name => $val) { */
            /*         //  echo "$key.$name: $val<br />\n"; */
            /*     } */
            /* } */
        
            /* $aLat = $exif["GPS"]["GPSLatitude"]; */
            /* $aLong = $exif["GPS"]["GPSLongitude"]; */
            /* $strLatRef = $exif["GPS"]["GPSLatitudeRef"]; */
            /* $strLongRef = $exif["GPS"]["GPSLongitudeRef"]; */
            
            /* $fLat = ($aLat[0] + $aLat[1]/60 + $aLat[2]/3600) * ($strLatRef == "N" ? 1 : -1);   */
            /* $fLong = ($aLong[0] + $aLong[1]/60 + $aLong[2]/3600) * ($strLongRef == "W" ? -1 : 1);   */
            
            /* $data["coords"] = $fLat + "," + $fLong; */
            
            //print_r($exif["GPS"]["GPSLatitude"]);
            //print_r($exif["GPS"]["GPSLongitude"]);


                
                // echo $data["coords"];
        }
        
        return $data["coords"];

    }

    
    private  function toDecimal($deg, $min, $sec, $hemi) {
        $d = $deg + $min/60 + $sec/3600;
        return ($hemi=='S' || $hemi=='W') ? $d*=-1 : $d;
    }
    
    private function divide($a) {
        // evaluate the string fraction and return a float //	
        $e = explode('/', $a);
        // prevent division by zero //
        if (!$e[0] || !$e[1]) {
            return 0;
        }	else{
            return $e[0] / $e[1];
        }
    }
    
	function insert() 
	{
		$error = "OK";
	
		$this->load->library('image_lib');

		$file = $_FILES["image"];

		// validate
		if ($file["name"] == "")
		{
			return "<p>Selecciona una foto antes de picarle al boton! =/</p>";
		}
		
		if ($this->input->post("title") == "" || $this->input->post("title") == "Titulo de la foto") {
			return "<p>Olvidaste ponerle un titulo a la foto</p>";
		}
		
		if ($this->input->post("location") == "" || $this->input->post("location") == "Lugar donde fue tomada") {
			return "<p>Necesitas decirnos donde tomaste esta foto!</p>";
		}	
		
		$preview = generateRandomString(7);

		$config['image_library'] = 'gd2';
		$config['source_image'] = $file["tmp_name"];
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = 800;
		$config['height'] = 500;
		$config['new_image'] = "public/uploaded/" . $preview . ".jpg";
		$config['thumb_marker'] = '';
		
		$this->image_lib->clear();
		$this->image_lib->initialize($config);
		
		if (!$this->image_lib->resize())
		{
			return $this->image_lib->display_errors();
		}

		$config['width'] = 120;
		$config['height'] = 120;
		$config['new_image'] = "public/uploaded/small/" . $preview . ".jpg";

		$this->image_lib->clear();
		$this->image_lib->initialize($config);
		if (!$this->image_lib->resize())
		{
			return $this->image_lib->display_errors();
		}
			
		$data = array(
			'name'		=>	$this->input->post("name"),
			'location'	=>	$this->input->post("location"),
            'title'     =>  $this->input->post("title"),
            'userid'    =>  $this->input->post("userid"),
			'image'		=>	$preview,
			'created'	=>	time(),
			'ip'		=>	GetHostByName($_SERVER['REMOTE_ADDR']),
			'active'	=>	1
		);

        // saving original image
        move_uploaded_file($file["tmp_name"], "public/uploaded/originals/" . $preview . ".jpg");
		
		$this->db->insert("entries", $data);
	
		return $error;
	}

}

?>