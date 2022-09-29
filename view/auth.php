<div class="providers">
    <div class="providers__text">Выбирите сервис:</div>
    <?php foreach ($providersList as $provider) { ?>
        <a class="providers__item" href="<?= $provider['link'] ?>">
            <img class="providers__img" src="/upload/img/yandex.svg"
                 alt="<?= $provider['label'] ?>"><?= $provider['label'] ?>
        </a>
    <?php } ?>
</div>