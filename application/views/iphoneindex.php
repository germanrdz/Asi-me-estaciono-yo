<images>
 <? foreach($model as $item): ?>
	<image id="<?= $item->id; ?>">
        
        <title><?= $item->title; ?></title>
		<user><?= $item->name; ?> </user>
        <userId><?= $item->userid; ?></userId>
		<location><?= $item->location; ?></location>
		<uploadedDate><?= $item->created; ?></uploadedDate>
		<votes><?= $item->votes; ?></votes>

	</image>
 <? endforeach; ?>
</images>