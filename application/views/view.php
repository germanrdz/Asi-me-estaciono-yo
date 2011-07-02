<div id="content">

	<? foreach($model as $toilet): ?>
		<div id="toilet">
		
			<a name="show"></a>
			<div class="image">
				<? if ($previous > 0): ?>
					<span class="previous"><?= anchor("//view/" . $previous . "#show","<");?></span>
				<? endif; ?>
				<?= img("public/toilets/" . $toilet->image .".jpg"); ?>
				<? if ($next > 0): ?>
				<span class="next"><?= anchor("//view/" . $next . "#show",">");?></span>
				<? endif; ?>
			</div>
		
			<div class="toiletinfo">.
			
				<div class="uploaded">
					<span class="location"><?= $toilet->location; ?></span><br />
					<span class="name"><?= time_since($toilet->created) ?> ago<br />
					by: <?= $toilet->name; ?></span>
				</div>
		
				<div class="votes">

					<? if ($this->session->userdata($toilet->id) > 0 || $this->session->userdata($toilet->id) == 0): ?>
						<?= anchor("/main/voteup/" . $toilet->id, img("public/images/up.png"), 'id="voteup" onclick="javascript: return false;"'); ?> 
					<? endif; ?>

					<span id="votescount">
					<? if ($toilet->votes >= 0): ?>
						<span class="count green">+<?= $toilet->votes ?></span>
					<? else: ?>
						<span class="count red"><?= $toilet->votes ?></span>
					<? endif; ?>
					</span>
					
					<? if ($this->session->userdata($toilet->id) < 0 || $this->session->userdata($toilet->id) == 0): ?>
						<?= anchor("/main/votedown/" . $toilet->id, img("public/images/down.png"), 'id="votedown" onclick="javascript: return false;"'); ?> 
					<? endif; ?>
				</div>
		
			</div>
			
			<div class="comments">
				<?
					$url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
				?>				
			     <div id="fb-root"></div>
			     <script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
			     <fb:comments href="<?= $url; ?>" num_posts="15" width="700"></fb:comments>
			</div>


		</div>
		
	<? endforeach; ?>

</div>