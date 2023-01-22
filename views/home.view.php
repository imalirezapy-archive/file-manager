<?php require __DIR__ . '/layouts/header.view.php' ?>
<div class="file-manager-actions container-p-x py-2">
    <div>

        <div class="btn-group mr-2">
            <button type="button" class="btn btn-primary mr-2 md-btn-flat dropdown-toggle px-2"
                    data-toggle="dropdown"><i class="fa fa-plus mr-2"></i>Create</button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="/createFile?address=<?=query('address')?>">New File</a>
                <a class="dropdown-item" href="/createDir?address=<?= query('address')?>">New Folder</a>
            </div>
        </div>
    </div>
    <div>
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-default icon-btn md-btn-flat active"> <input type="radio"
                                                                               name="file-manager-view"
        </div>
    </div>
</div>
<hr class="m-0"/>

<div class="file-manager-container file-manager-col-view ">



        <table class="table">
            <thead>
                <tr>
                    <th scope="col" class="pl-5">name</th>
                    <th scope="col" >extension</th>
                    <th scope="col">type</th>
                    <th scope="col">size</th>
                </tr>
            </thead>
            <tbody>

            <?php foreach ($files as $file ) { ?>

                <?php if ($file['name'] == '..' ) {?>
                    <tr>
                        <th>
                            <div class="ml-4 file-item">
                                <div class="file-item-icon file-item-level-up fas fa-level-up-alt text-secondary"></div>
                                <a href="<?= $files[0]['href'] ?>" class="file-item-name">
                                    ..
                                </a>
                            </div>
                        </th>
                    </tr>
                <?php continue; }?>

                <tr>
                    <th class="d-flex">
                        <button type="button"
                                class="btn btn-default btn-sm rounded-pill icon-btn borderless md-btn-flat hide-arrow "
                                data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="/rename?address=<?= $file['href']?>">Rename</a>
                            <a class="dropdown-item" href="/move?address=<?= $file['href']?>">Move</a>
                            <a class="dropdown-item" href="/copy?address=<?= $file['href']?>">Copy</a>
                            <a class="dropdown-item" href="/remove?address=<?= $file['href']?>">Remove</a>
                        </div>
                        <div class="m-2">
                        <div class="file-item-select-bg bg-primary"></div>
                         <?php if ($file['is_dir']) {?>

                            <div class="file-item-icon far fa-folder text-secondary"></div>
                            <a href="/?address=<?= $file['href']?>" class="file-item-name">
                                <?= $file['name'] ?>
                            </a>

                         <?php } else {?>

                            <div class="text-black-50 file-item-icon far fa-file text-secondary"></div>
                            <span>
                                <?= $file['name'] ?>
                            </span>

                        <?php }?>
                        </div>

                    </th>

                    <td>
                        <div class="file-item-changed"><?= $file['extension'] ?></div>
                    </td>
                    <td>
                        <div class="file-item-changed"><?= $file['mime']?></div>
                    </td>
                    <td>
                        <div class="file-item-changed"><?= number_format($file['size'])?></div>
                    </td>
                </tr>
            <?php } ?>

            </tbody>
        </table>
</div>

<?php require __DIR__ . '/layouts/footer.view.php' ?>
