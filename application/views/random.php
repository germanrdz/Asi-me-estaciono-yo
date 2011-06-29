		<div id="content">

			<div class="gallery">
				<table>
					<tr>
					<? $i = 0 ?>
					<? foreach($model as $toilet): ?>
						<? $i++; ?>
						<td valign="top" class="toilet">
							<div class="location"><?= $toilet->location ?></div>
							<span class="thumbnail">
								<?= anchor("//toilet/" . $toilet->id, img("public/toilets/small/". $toilet->image .".jpg")); ?>
								
								<? if ($toilet->votes >= 0): ?>
									<span class="votes green">+<?= $toilet->votes ?></span>
								<? else: ?>
									<span class="votes red"><?= $toilet->votes ?></span>
								<? endif; ?>
								</span>
							</span>

							<div class="name">
								by: <i><?= $toilet->name ?></i>
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