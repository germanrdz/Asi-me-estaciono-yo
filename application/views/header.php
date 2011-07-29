<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://ogp.me/ns#"> 
	<head> 
		<base href="<?= base_url() ?>" />

		<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
		<meta name="robots" content="all" /> 
		<meta name="description" content="Asi me estaciono yo! y que | Sube tus fotos de gente mal estacionada">

     <? if (isset($model)): ?>
        <? $model = $model[0]; ?>
        <meta property="og:title" content='<?= $model->title; ?>' />
        <meta property="og:type" content="landmark"/>
        <meta property="og:url" content="<?= base_url() . "view/" . $model->id; ?>" />
        <meta property="og:image" content="<?= base_url() . "public/uploaded/" . $model->image .".jpg"; ?> " />
        <meta property="og:site_name" content="Asi me estaciono yo"/>
        <meta property="fb:admins" content="757216207"/>
        <meta property="fb:app_id" content="105499334967" />
        <meta property="og:description" content="Asi me estaciono yo! y que | Sube tus fotos de gente mal estacionada."/>
        <? endif; ?>

		<?= link_tag("public/stylesheets/master.css"); ?>

		<? foreach($stylesheets as $file): ?>
		<?= link_tag("public/stylesheets/" . $file . ".css"); ?>
		<? endforeach; ?>

		<script src="public/scripts/jquery.js" type="text/javascript" charset="utf-8" ></script>
		<script src="public/scripts/jquery-dom.js" type="text/javascript" charset="utf-8" ></script>
		<script src="public/scripts/application.js" type="text/javascript" charset="utf-8" ></script>
		
		<? foreach($scripts as $file): ?>
		<script src="public/scripts/<?= $file ?>.js" type="text/javascript" charset="utf-8"></script>
		<? endforeach; ?>
		
		<title>
		<? if ($title != "") { echo $title . " ^ "; } ?> Asi me estaciono yo
		</title> 
		
		<!-- Google Analytics -->
       <script type="text/javascript">

     var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-8479264-8']);
_gaq.push(['_trackPageview']);
(function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();

</script>

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
					    <a id="fb_logout">(cerrar sesion)</a>
					<? endif; ?>
					</div>
		
			<div class="sharing">
				<a href="http://twitter.com/share" class="twitter-share-button" data-url="http://www.asimeestacionoyo.com/" data-text="Has visto a alguien mal estacionado? Tomales una foto! Reportalos en AsiMeEstacionoYo.com!" data-count="horizontal" data-via="GerManson">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
				<iframe src="http://www.facebook.com/plugins/like.php?href=htp%3A%2F%2Fwww.asimeestacionoyo.com&amp;layout=button_count&amp;show_faces=false&amp;width=100&amp;action=like&amp;font=lucida+grande&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>
			</div>
		
		</div>

		<div id="header" />
			<div class="wrapper">
				<div class="logo">
					<?= anchor("/",img("public/images/logo_big.jpg")); ?>
				</div>
     
				<div id="upload">
					<h2>Has visto a alguien mal estacionado? Sube tu imagen ya!</h2>
					
                    <div class="content">

                    <? if ($user): ?>
					<?= form_open_multipart("main"); ?>
					<div class="fields">
					    <?= form_input("title", "Titulo de la foto", 'class="overlay" id="name"'); ?> 
					    <?= form_input("location", "Lugar donde fue tomada", 'class="overlay" id="location"'); ?> 
							
                    <?= form_hidden("name", $user->name); ?>
                    <?= form_hidden("userid", $user->id); ?>

						<div class="image_upload">
                            <span>Imagen:</span>
						    <?= form_upload("image", "", 'class="overlay"'); ?>
						</div>

                    <a href="javascript:;" id="submit">
                    <?= img("/public/images/upload.jpg"); ?>
                    </a>

                    </div>											
					<?= form_close(); ?>
                    <? else: ?>
                    <p>Inicia sesion para poder subir fotos, Es muy facil!</p>
                    <p><fb:login-button>Login with Facebook</fb:login-button></p>
                    <? endif; ?>
                    </div>
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