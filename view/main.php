<div class="disk">
    <div class="disk-info">
        <?php
        $currentPage = $_REQUEST['page'] ?? 1;
        $pageCount = ceil($content['count'] / $content['nav']);

        if (is_array($content)) {
            ?>
            <div class="disk-info-space">Свободно места на диске: <span
                        class="disk-info-space-free"><?= get_file_size($content['freeSpace']) ?></span>
                из <span
                        class="disk-info-space-free"><?= get_file_size($content['totalSize']) ?></span>
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
                        <div class="disk-info-table-item-size"><?= get_file_size($item->get('size')) ?></div>
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
            <?php
        } else {
            echo $content;
        }

        function get_file_size($bytes)
        {
            if ($bytes < 1000 * 1024) {
                return number_format($bytes / 1024, 2) . "KB";
            } elseif ($bytes < 1000 * 1048576) {
                return number_format($bytes / 1048576, 2) . "MB";
            } elseif ($bytes < 1000 * 1073741824) {
                return number_format($bytes / 1073741824, 2) . "GB";
            } else {
                return number_format($bytes / 1099511627776, 2) . "TB";
            }
        }

        ?>
    </div>
    <div class="disk-form">
        <input type="file" name="file">
    </div>
</div>
