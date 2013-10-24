
<div class="item">
    <div class="placelogo">
        <div class="logo_container">
            <span class="logo">
                <img src="<?php echo $data->getThumb('medium'); ?>" alt="">
            </span>
        </div>
        <a href="<?php echo $data->getChangeUrl(); ?>"></a>
    </div>
    <div class="description">
        <h3><a href="<?php echo $data->getChangeUrl(); ?>"><?php echo $data->title; ?></a></h3>
    </div>
</div>