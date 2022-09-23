<div>
    <?php foreach ($providersList as $provider) { ?>
        <a class="yandex-button" href="<?= $provider['link'] ?>">
            <img src="/upload/img/yandex.svg"
                 alt="yandex button"><?= $provider['label'] ?>
        </a>
    <?php } ?>
</div>