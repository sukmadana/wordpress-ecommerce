<?php
$class = $data->class ?? '';
$id = $data->id ?? '';
$title = $data->title ?? '';
$text = $data->text ?? '';
?>
<div class="ExampleView <?= $class ?>" id="<?= $id ?>">

	<?php if ( $title ): ?>
		<h2 class="pt-8 text-2xl font-display font-extrabold text-gray-400 sm:text-3xl"><?= $title ?></h2>
	<?php endif; ?>

	<?php if ( $text ): ?>
		<p class="mt-4 text-lg leading-6 text-purple-200"><?= $text ?></p>
	<?php endif; ?>

</div>