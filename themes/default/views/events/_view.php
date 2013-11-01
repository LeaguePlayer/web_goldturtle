<div class="item bordered">
	<div class="date"><strong><?php echo $data->getDay('public_date'); ?></strong> <?php echo $data->getMonth('public_date'); ?></div>
	<div class="content">
		<div class="image">
			<a href="<?php echo $data->viewUrl($this->place); ?>"><img src="<?php echo $data->getThumb('medium'); ?>" alt=""></a>
		</div>
		<div class="description">
			<h3><a href="<?php echo $data->viewUrl($this->place); ?>"><?php echo $data->title; ?></a></h3>
			<div class="text">
				<p><?php echo $data->description; ?></p>
			</div>
		</div>
	</div>
</div>