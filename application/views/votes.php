					<span id="votescount">
					<? if ($model >= 0): ?>
						<span class="count green">+<?= $model ?></span>
					<? else: ?>
						<span class="count red"><?= $model ?></span>
					<? endif; ?>
					</span>