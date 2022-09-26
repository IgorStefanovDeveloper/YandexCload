<div class="providers">
    <div class="providers-text">Выбирите сервис:</div>
    <?php foreach ($providersList as $provider) { ?>
        <a class="providers-button" href="<?= $provider['link'] ?>">
            <img src="/upload/img/yandex.svg"
                 alt="<?= $provider['label'] ?>"><?= $provider['label'] ?>
        </a>
    <?php } ?>
</div>