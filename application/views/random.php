		<div id="content">

			<div class="gallery">
				<table>
					<tr>
					<? $i = 0 ?>
					<? foreach($model as $image): ?>
						<? $i++; ?>
						<td valign="top">
							<span class="thumbnail">
								<?= anchor("//view/" . $image->id, img("public/toilets/small/". $image->image .".jpg")); ?>
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