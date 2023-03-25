<?php if ($this->previewMode): ?>

    <div
        id="<?= $this->getId('map'); ?>"
        class="gmaps-location-picker"
        disabled="true"
        data-control="gmaps-location-picker"
        data-lat="<?= $this->lat; ?>"
        data-lng="<?= $this->lng; ?>"
        data-read-only="true"
    ></div>

<?php else: ?>

    <div
        id="<?= $this->getId('map'); ?>"
        class="gmaps-location-picker"
        data-control="gmaps-location-picker"
        data-lat-id="<?= $this->getId('lat'); ?>"
        data-lng-id="<?= $this->getId('lng'); ?>"
        data-lat="<?= $this->lat; ?>"
        data-lng="<?= $this->lng; ?>"
    ></div>

    <input
        type="hidden"
        id="<?= $this->getId('lat') ?>"
        name="<?= $name . '[lat]' ?>"
        value="<?= @$value['lat'] ?>"
    />

    <input
        type="hidden"
        id="<?= $this->getId('lng') ?>"
        name="<?= $name . '[lng]' ?>"
        value="<?= @$value['lng'] ?>"
    />

<?php endif ?>
