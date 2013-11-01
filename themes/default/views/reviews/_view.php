<div class="item bordered">
    <span class="review_date"><?=SiteHelper::russianDate($data->create_time);?></span>
    <h3 class="review name"><?=$data->name?> пишет:</h3>
    <p class="review"><?=$data->description?></p>
</div>