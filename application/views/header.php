<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml"> 
	<head> 
		<base href="<?= base_url() ?>" />
		
		<link REL="SHORTCUT ICON" HREF="public/toiletfav.ico">
		
		<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
		<meta name="robots" content="all" /> 
		<meta name="description" content="Where all the toilets join together for the world, upload your picture now and be part of the revolution">

		<?= link_tag("public/stylesheets/master.css"); ?>

		<? foreach($stylesheets as $file): ?>
		<?= link_tag("public/stylesheets/" . $file . ".css"); ?>
		<? endforeach; ?>

		<script src="public/scripts/jquery.js" type="text/javascript" charset="utf-8" ></script>
		<script src="public/scripts/jquery-dom.js" type="text/javascript" charset="utf-8" ></script>
		<script src="public/scripts/application.js" type="text/javascript" charset="utf-8" ></script>

        <script src="http://connect.facebook.net/en_US/all.js"></script>
		
		<? foreach($scripts as $file): ?>
		<script src="public/scripts/<?= $file ?>.js" type="text/javascript" charset="utf-8"></script>
		<? endforeach; ?>
		
		<title>Asi me estaciono yo
		<? if ($title != "") { echo " ^ " . $title; } ?>
		</title> 
		
		<!-- Google Analytics -->
		<!-- End Google Analytics -->
	</head>

	<body>
		<div id="menu">
			<?
				$homeclass = ($active_page == "home") ? "class='active'" : "";
				$topclass = ($active_page == "top") ? "class='active'" : "";
				$randomclass = ($active_page == "random") ? "class='active'" : "";
			?>
			<div class="navigation">
				<?= anchor("/", "Inicio", $homeclass); ?><?= anchor("top", "Las mas votadas", $topclass); ?><?= anchor("random", "100 Aleatorias", $randomclass); ?><?= anchor("main/contact", "Contacto"); ?>				
			</div>

                    <div id="login">
                    <? if (!$user): ?>
                        <fb:login-button>Login with Facebook</fb:login-button>
                    <? else: ?>
					    <a href="javascript:;"><img class="picture" src="http://graph.facebook.com/<?= $user->id ?>/picture?type=square" height="20" align="left"/> </a>
					    <?= $user->name ?>
					<?= anchor("logout", "(cerrar sesion)"); ?>
					<? endif; ?>
					</div>
		
			<div class="sharing">
				<a href="http://twitter.com/share" class="twitter-share-button" data-url="http://www.thetoiletproject.com/" data-text="where are the toilets join togheter for the world! upload your toilet picture now!" data-count="horizontal" data-via="GerManson">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
				<iframe src="http://www.facebook.com/plugins/like.php?href=htp%3A%2F%2Fwww.thetoiletproject.com&amp;layout=button_count&amp;show_faces=false&amp;width=100&amp;action=like&amp;font=lucida+grande&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>
			</div>
		
		</div>


		<div id="header" />
			<div class="wrapper">
				<div class="logo">
					<?= anchor("/",img("public/images/logo_big.jpg")); ?>
				</div>
     
				<div id="upload">
					<h2>Has visto a alguien mal estacionado? Sube tu imagen ya!</h2>
					
					<?= form_open_multipart("main"); ?>
					
						<div class="fields">
							<?= form_input("name", "Titulo de la foto", 'class="overlay" id="name"'); ?> 
							<?= form_input("location", "Lugar donde fue tomada", 'class="overlay" id="location"'); ?> 
							
							<div class="toilet_upload">
								<span>Imagen:</span>
								<?= form_upload("toilet", "", 'class="toilet overlay"'); ?>
							</div>
                    </div>
					
                    <a href="javascript:;" id="submit">
                    <?= img("/public/images/upload.png"); ?>
                    </a>
						
					<?= form_close(); ?>
				</div>
			
			</div> <!-- wrapper -->
		</div>
		
		<div class="wrapper">
			<? if ($this->session->flashdata('success')) : ?>
				<div class="success">
					<p><?= $this->session->flashdata('success'); ?></p>
				</div>
			<? endif; ?>	
		
			<? if ($this->session->flashdata('error')) : ?>
				<div class="error">
					<?= $this->session->flashdata('error'); ?>
				</div>
			<? endif; ?>
		</div>
                   