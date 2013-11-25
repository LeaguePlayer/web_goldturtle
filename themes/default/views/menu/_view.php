<div class="item">
	<img src="<?php echo $data->getThumb('medium'); ?>" alt="">
	<p class="title"><?php echo $data->name; ?></p>
	<a href="<?php echo $data->getViewUrl($this->place); ?>"></a>
</div>