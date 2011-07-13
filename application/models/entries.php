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
		
		$this->db->insert("entries", $data);
	
		return $error;
	}

}

?>