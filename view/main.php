<div class="disk">
    <?php
    if ($hasContent) {
        ?>
        <div class="disk__info">

            <div class="space-info">
                Свободно места на диске:
                <span class="space-info__space"><?= $this->getFileSize($content['freeSpace']) ?></span>
                из
                <span class="space-info__space"><?= $this->getFileSize($content['totalSize']) ?></span>
            </div>

            <div class="mod-table disk-info__table">
                <?php
                foreach ($content['items'] as $key => $item) {
                    $strNum = $key + 1 + ($content['nav'] * ($currentPage - 1));
                    ?>
                    <div class="mod-table__item js-item" data-name="<?= $item->get('name') ?>"
                         data-path="<?= $item->get('path') ?>">
                        <div class="mod-table__name">
                            <span class="mod-table__iterator"><?= $strNum . ". " ?></span>
                            <input class="mod-table__input" type="text" value="<?= $item->get('name') ?>" readonly>
                        </div>
                        <div class="mod-table_size"><?= $this->getFileSize($item->get('size')) ?></div>
                        <div class="mod-table__actions">
                            <div class="mod-table__btn js-delete">Удалить</div>
                            <div class="mod-table__btn js-download">Скачать</div>
                            <div class="mod-table__btn js-rename">Переименовать</div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <div class="nav disk-info__nav">
                    <?php
                    if ($content['count'] > $content['nav']) {
                        ?>
                        <ul class="nav__list">
                            <?
                            for ($i = 1; $i <= $pageCount; $i++) {
                                if ($i != $currentPage)
                                    echo "<li class='nav__item'><a class='nav__link' href='?provider=" . $_REQUEST['provider'] . "&page=" . $i . "'>" . $i . "</a></li>";
                                else
                                    echo "<li class='nav__item'>" . $i . "</li>";
                            }
                            ?>
                        </ul>
                        <?
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="disk__upload">
            <form class="uploader js-uploader" enctype="multipart/form-data" action="/?action=load" method="POST">
                Отправить этот файл: <input class="uploader__user-file js-file" name="userfile" type="file"/>
                <input class="uploader__submit" type="submit" value="Отправить файл"/>
                <p class="uploader__text js-res-upload"></p>
            </form>
        </div>
        <?php
    } else {
        echo $content;
    }
    ?>
</div>
