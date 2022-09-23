<div class="">
    <div>
        <?php
        if (is_array($content)) {
            ?>
            <div class="spaceStr">Всего места на диске: <span
                        class="free-space"><?= get_file_size($content['totalSize']) ?></span>
            </div>
            <div class="spaceStr">Свободно места на диске: <span
                        class="free-space"><?= get_file_size($content['freeSpace']) ?></span>
            </div>
            <div class="">
                <?php
                foreach ($content['items'] as $item) {
                    ?>
                    <div class="item" data-path="<?= $item->get('path') ?>">
                        <div class="name"><?= $item->get('name') ?></div>
                        <div class="size"><?= get_file_size($item->get('size')) ?></div>
                        <div class="actbtn">
                            <div>Удалить файл</div>
                            <div>Скачать файл</div>
                            <div>Переименовать файл</div>
                        </div>
                    </div>
                    <?php
                }
                ?>
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
    <div>
        download from
    </div>
</div>
<style>
    .item {
        display: flex;
    }
</style>
