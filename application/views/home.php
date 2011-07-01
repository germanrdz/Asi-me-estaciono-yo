		<div id="content">
			<div class="quote">
				<? img("public/images/toiletQuote.png"); ?>
			</div>
			
			<div id="view_window"></div>
			
			<div id="ads">
				<script type="text/javascript"><!--
				google_ad_client = "ca-pub-3191102604317181";
				/* The Toilet Project */
				google_ad_slot = "2705922976";
				google_ad_width = 120;
				google_ad_height = 600;
				//-->
				</script>
				<script type="text/javascript"
				src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
				</script>			
			</div>
			
			<div class="gallery">
				<table>
					<tr>
					<? $i = 0 ?>
					<? foreach($model as $toilet): ?>
						<? $i++; ?>
						<td valign="top" class="toilet">
					
							<span class="thumbnail">
								<?= anchor("//toilet/" . $toilet->id, img("public/toilets/small/". $toilet->image .".jpg")); ?>
								
								<? if ($toilet->votes >= 0): ?>
									<span class="votes green">+<?= $toilet->votes ?></span>
								<? else: ?>
									<span class="votes red"><?= $toilet->votes ?></span>
								<? endif; ?>
								</span>
							</span>

							<div class="location"><?= $toilet->title ?></div>
							<div class="name">
								por: <i><?= $toilet->name ?></i>
							</div>
							
						</td>
						
						<? if (($i % 6) == 0): ?>
							</tr><tr>
						<? endif; ?>
						
					<? endforeach; ?>
					</tr>
				</table>
				
				<!--
				<div class="loadmore">
					<a href="javascript:;">
					<?= img("public/images/more.png"); ?>
					</a>
				</div>
				-->
			</div>
			
		</div> <!-- content -->