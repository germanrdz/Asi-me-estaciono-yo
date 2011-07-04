<?php

	class Main extends Controller
	{
		
		function Main()
		{
			parent::Controller();
			
			//$this->load->scaffolding('entries');
			$this->load->model('entries');
			$this->load->helper('date');	
			$this->load->library('session');	
			$this->load->helper('form');			
            
            $this->load->library('facebook');

			date_default_timezone_set('America/Hermosillo');
			
			define('FACEBOOK_APP_ID', '133512650062074');
			define('FACEBOOK_SECRET', '98dc67b994a453e68788a501c36612be');

		}
		
		function top() {
			// load main header
			$include["stylesheets"] = array();
			$include["scripts"] = array();
			$include["active_page"] = "top";
						
			// bussines logic 
			$view_data['model'] = $this->entries->top(100);

            $fbcookie =  $this->facebook->get_facebook_cookie(FACEBOOK_APP_ID, FACEBOOK_SECRET); 

            if ($fbcookie) {
                $user = $this->facebook->getCurrentUser($fbcookie);
            }
            else {
                $user = array();
            }
            
            $include["user"] = $user;
            $include["title"] = "Mejor votadas";

			// load view
            $this->load->view('header', $include);
            $this->load->view('random', $view_data);
		
			// load footer
			$this->load->view('footer');
		}
		
		function random()
		{
			// load main header
			$include["stylesheets"] = array();
			$include["scripts"] = array();
			$include["active_page"] = "random";	
			
			// bussines logic 
			$view_data['model'] = $this->entries->random(100);	

            $fbcookie =  $this->facebook->get_facebook_cookie(FACEBOOK_APP_ID, FACEBOOK_SECRET); 
            if ($fbcookie) {
                $user = $this->facebook->getCurrentUser($fbcookie);
            }
            else {
                $user = array();
            }
			
            $include["user"] = $user;

			// load view
            $this->load->view('header', $include);
			$this->load->view('random', $view_data);
		
			// load footer
			$this->load->view('footer');
		}
		
		function view($id) 
		{
			if ($id)
			{
				$this->load->helper("random");
			
				// load main header
				$include["stylesheets"] = array('view');
				$include["scripts"] = array("view");
				$include["active_page"] = "view";
				
				
				// bussines logic 
				$view_data['model'] = $this->entries->getId($id);	
				$view_data['previous'] = $this->entries->getPrevious($id);
				$view_data['next'] = $this->entries->getNext($id);
				
				if (count($view_data["model"]) > 0) 
				{
					$include["title"] = $view_data["model"][0]->title;
				}
				else
				{
					$include["title"] = "NOT FOUND";
				}

                $fbcookie =  $this->facebook->get_facebook_cookie(FACEBOOK_APP_ID, FACEBOOK_SECRET);

                if ($fbcookie) {
                    $user = $this->facebook->getCurrentUser($fbcookie);
                }
                else {
                    $user = array();
                }

                $include["user"] = $user;
            
				
				// load views
				$this->load->view('header', $include);
				$this->load->view('view', $view_data);
				$this->load->view('footer');
			}
			else 
			{
				redirect('//main', 'location');
			}
		}
		
		function index($page = 0)
		{
			
			// process Upload
			if ($_POST) {
				$this->load->helper("random");
				$error = $this->entries->insert();
				
				if ($error == "OK") {
					$this->session->set_flashdata('success', "Tu foto ha sido guardada satisfactoriamente");
					redirect('//main', 'location');
				}
				else
				{
					$this->session->set_flashdata('error', $error);
					redirect('//main', 'location');
				}
			}

            $fbcookie =  $this->facebook->get_facebook_cookie(FACEBOOK_APP_ID, FACEBOOK_SECRET);
            
			if ($fbcookie) {
				$user = $this->facebook->getCurrentUser($fbcookie);
			}
			else {
				$user = array();
			}	

			// load main header
			$include["stylesheets"] = array();
			$include["scripts"] = array();
			$include["active_page"] = "home";
			
			$include["title"] = "";
			$include["user"] = $user;
            
			$this->load->view('header', $include);
			
			// bussines logic 
			$view_data['model'] = $this->entries->selectLast(36);	
			
			// load view
			$this->load->view('home', $view_data);
		
			// load footer
			$this->load->view('footer');
		}
		
		function voteup($id)
		{
			$view_data["model"] = $this->entries->voteUp($id);
			
			//print_r($view_data["model"]);
			//die();
			
			$this->load->view('votes', $view_data);
		}
		
		function votedown($id) 
		{
			$view_data["model"] = $this->entries->voteDown($id);
			$this->load->view('votes', $view_data);
		}
		
		function contact()
		{
			redirect('http://www.germanrdz.com');
		}

		function logout()
		{
			$this->session->sess_destroy();
			redirect('/', 'refresh');	
		}
	

	}

?>