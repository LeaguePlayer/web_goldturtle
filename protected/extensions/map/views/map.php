<section class="contacts">
    <div class="map_border">
        <div id="map-mini" class="map"></div>
    </div>
    <h2><?php echo $this->owner->place['title']; ?></h2>
    <p id="address" class="address"><?php echo $address; ?></p>
    <p class="phone"><?php echo Settings::getOption('phone'); ?></p>

</section>