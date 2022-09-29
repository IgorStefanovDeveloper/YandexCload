<div class="disk">
    <?php
    if ($hasContent) {
        ?>
        <div class="disk-info">
            <div class="disk-info-space">Свободно места на диске: <span
                        class="disk-info-space-free"><?= $this->getFileSize($content['freeSpace']) ?></span>
                из <span
                        class="disk-info-space-free"><?= $this->getFileSize($content['totalSize']) ?></span>
            </div>
            <div class="disk-info-table">
                <?php
                foreach ($content['items'] as $key => $item) {
                    $strNum = $key + 1 + ($content['nav'] * ($currentPage - 1));
                    ?>
                    <div class="disk-info-table-item" data-name="<?= $item->get('name') ?>"
                         data-path="<?= $item->get('path') ?>">
                        <div class="disk-info-table-item-name">
                            <span><?= $strNum . ". " ?></span><input type="text" value="<?= $item->get('name') ?>"
                                                                     readonly></div>
                        <div class="disk-info-table-item-size"><?= $this->getFileSize($item->get('size')) ?></div>
                        <div class="disk-info-table-item-actions">
                            <div class="disk-info-table-item-actions-btn js-delete">Удалить</div>
                            <div class="disk-info-table-item-actions-btn js-download">Скачать</div>
                            <div class="disk-info-table-item-actions-btn js-rename">Переименовать</div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <div class="nav">
                    <?php
                    //TODO need do it in indexController
                    if ($content['count'] > $content['nav']) {
                        ?>
                        <ul>
                            <?
                            for ($i = 1; $i <= $pageCount; $i++) {
                                if ($i != $currentPage)
                                    echo "<li><a href='?provider=" . $_REQUEST['provider'] . "&page=" . $i . "'>" . $i . "</a></li>";
                                else
                                    echo "<li>" . $i . "</li>";
                            }
                            ?>
                        </ul>
                        <?
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="disk-upload">
            <form class="disk-upload-form" enctype="multipart/form-data" action="/?action=load" method="POST">
                <input type="hidden" name="MAX_FILE_SIZE" value="10000"/>
                Отправить этот файл: <input class="userfile" name="userfile" type="file"/>
                <input type="submit" value="Отправить файл"/>
                <p class="disk-upload-text"></p>
            </form>
        </div>
        <?php
    } else {
        echo $content;
    }
    ?>
</div>
