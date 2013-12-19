
<div class="item">
	<img src="<?php echo $data->getImage(); ?>" alt="<?php echo $data->name; ?>">
	<a title="<?php echo $data->description; ?>" href="<?php echo $data->site; ?>" <?php if (!empty($data->site)) echo "target='_blank'"; ?>><?php echo $data->name; ?></a>
</div>