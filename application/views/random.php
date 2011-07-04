		<div id="content">

             <div id="ads">
             <script type="text/javascript">
             <!--
             google_ad_client = "ca-pub-3191102604317181";
             google_ad_slot = "6319234176";
             google_ad_width = 728;
             google_ad_height = 90;
             //-->
             </script>
             <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
             </div>

			<div class="gallery">
				<table>
					<tr>
					<? $i = 0 ?>
					<? foreach($model as $image): ?>
						<? $i++; ?>
						<td valign="top">
							<span class="thumbnail">
								<?= anchor("//view/" . $image->id, img("public/uploaded/small/". $image->image .".jpg")); ?>
								<? if ($image->votes >= 0): ?>
									<span class="votes green">+<?= $image->votes ?></span>
								<? else: ?>
									<span class="votes red"><?= $image->votes ?></span>
								<? endif; ?>
								</span>
							</span>
                            
                            <div class="title"><?= $image->title ?></div>
							<div class="name">
								por: <i><?= anchor("http://www.facebook.com/profile.php?id=" . $image->userid, $image->name); ?></i>
							</div>
							

						</td>
						
						<? if (($i % 7) == 0): ?>
							</tr><tr>
						<? endif; ?>
						
					<? endforeach; ?>
					</tr>
				</table>

			</div>
			
		</div> <!-- content -->