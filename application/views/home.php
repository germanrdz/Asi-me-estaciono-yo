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
                <h3> Imagenes Agregadas Recientemente </h3>
				<table>
					<tr>
                    <? $i = 0; ?>

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

                            <div class="title"><?= $image->title; ?></div>
							<div class="name">
                               por: <i><?= anchor("http://www.facebook.com/profile.php?id=" . $image->userid, $image->name); ?></i>
							</div>
							
						</td>
						
						<? if (($i % 5) == 0): ?>
							</tr><tr>						    
                        <? endif; ?>

					<? endforeach; ?>
					</tr>
				</table>
				
			</div>

            <div class="right">


                 <h3>Imagenes mejor votadas</h3>
                 <ul>
                 <? $i = 0; ?>
                 <? foreach($top_voted as $top): ?>
                 <? $i++; ?>
                 <li>
                 <span class="avatar">
                 <?= img("public/uploaded/small/". $top->image .".jpg"); ?>
                 
                 <? if ($top->votes >= 0): ?>
                 <span class="votes green">+<?= $top->votes ?></span>
                 <? else: ?>
                 <span class="votes red"><?= $top->votes ?></span>
                 <? endif; ?>
                 
                 </span>
                 <span class="name">
                 <?= anchor("//view/" . $top->id, $top->title) ?></span><br />
                 <span class="count"><b><?= $top->name ?></b></span>
                 </li>
                 <? endforeach; ?>
                </ul>


                <h3>Top de Contribuidores</h3>
                <ul>
                 <? $i = 0; ?>
                 <? foreach($top_contributors as $top): ?>
                 <? $i++; ?>
                 <li>
                 <span class="avatar">
                 <img class="picture" src="http://graph.facebook.com/<?= $top->userid ?>/picture?type=square" />
                 <span class="votes green"><?= $i ?></span>                 
                 </span>
                 <span class="name">
                 <?= anchor("http://www.facebook.com/profile.php?id=" . $top->userid, $top->name) ?></span><br />
                 <span class="count"><b><?= $top->count?></b> imagenes</span>
                 </li>
                 
                 <? endforeach; ?>
                </ul>

            </div>
			
		</div> <!-- content -->