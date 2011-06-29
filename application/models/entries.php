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

		$file = $_FILES["toilet"];

		// validate
		if ($file["name"] == "")
		{
			return "<p>You must provide us a picture in order to upload a toilet</p>";
		}
		
		if ($this->input->post("name") == "" || $this->input->post("name") == "Your Name") {
			return "<p>You forgot to type your name</p>";
		}
		
		if ($this->input->post("location") == "" || $this->input->post("location") == "Location") {
			return "<p>You need to tell us where you found this toilet</p>";
		}	
		
		$preview = generateRandomString(7);

		$config['image_library'] = 'gd2';
		$config['source_image'] = $file["tmp_name"];
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = 800;
		$config['height'] = 500;
		$config['new_image'] = "public/toilets/" . $preview . ".jpg";
		$config['thumb_marker'] = '';
		
		$this->image_lib->clear();
		$this->image_lib->initialize($config);
		
		if (!$this->image_lib->resize())
		{
			return $this->image_lib->display_errors();
		}

		$config['width'] = 120;
		$config['height'] = 120;
		$config['new_image'] = "public/toilets/small/" . $preview . ".jpg";

		$this->image_lib->clear();
		$this->image_lib->initialize($config);
		if (!$this->image_lib->resize())
		{
			return $this->image_lib->display_errors();
		}
			
		$data = array(
			'name'		=>	$this->input->post("name"),
			'location'	=>	$this->input->post("location"),
			'image'		=>	$preview,
			'created'	=>	time(),
			'ip'		=>	GetHostByName($_SERVER['REMOTE_ADDR']),
			'active'	=>	0
		);
		
		$this->db->insert("entries", $data);
	
		return $error;
	}

}

?>