<?php require __DIR__ . '/layouts/header.view.php' ?>

<?php foreach ($files as $file) { ?>
    <li><?= $file ?></li>
<?php }?>
<div class="container flex-grow-1 light-style container-p-y">
    <div class="container-m-nx container-m-ny bg-lightest mb-3">
        <ol class="breadcrumb text-big container-p-x py-3 m-0">

            <li class="breadcrumb-item">
                <a href="javascript:void(0)">home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="javascript:void(0)">projects</a>
            </li>
            <li class="breadcrumb-item active">site</li>
        </ol>
        <hr class="m-0"/>
        <div class="file-manager-actions container-p-x py-2">
            <div>
                <button type="button" class="btn btn-primary mr-2"><i class="ion ion-md-cloud-upload"></i>&nbsp; Upload
                </button>
                <button type="button" class="btn btn-secondary icon-btn mr-2" disabled=""><i
                            class="ion ion-md-cloud-download"></i></button>
                <div class="btn-group mr-2">
                    <button type="button" class="btn btn-default md-btn-flat dropdown-toggle px-2"
                            data-toggle="dropdown"><i class="ion ion-ios-settings"></i></button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="javascript:void(0)">Move</a>
                        <a class="dropdown-item" href="javascript:void(0)">Copy</a>
                        <a class="dropdown-item" href="javascript:void(0)">Remove</a>
                    </div>
                </div>
            </div>
            <div>
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-default icon-btn md-btn-flat active"> <input type="radio"
                                                                                       name="file-manager-view"
                                                                                       value="file-manager-col-view"
                                                                                       checked=""/> <span
                                class="ion ion-md-apps"></span> </label>
                    <label class="btn btn-default icon-btn md-btn-flat"> <input type="radio" name="file-manager-view"
                                                                                value="file-manager-row-view"/> <span
                                class="ion ion-md-menu"></span> </label>
                </div>
            </div>
        </div>
        <hr class="m-0"/>
    </div>
    <div class="file-manager-container file-manager-col-view row">

        <div class="col-12 mb-5 file-item">
            <div class="file-item-icon file-item-level-up fas fa-level-up-alt text-secondary"></div>
            <a href="javascript:void(0)" class="file-item-name">
                ..
            </a>
        </div>
        <?php foreach ([1, 2, 3, 4, 5, 6, 7, 8, 9] as $i) {?>
            <div class="col-4 col-lg-2 col-md-3  file-item">
                <div class="file-item-select-bg bg-primary"></div>
    <!--            <label class="file-item-checkbox custom-control custom-checkbox">-->
    <!--                <input type="checkbox" class="custom-control-input"/>-->
    <!--                <span class="custom-control-label"></span>-->
    <!--            </label>-->
                <div class="file-item-icon far fa-folder text-secondary"></div>
                <a href="javascript:void(0)" class="file-item-name">
                    Images
                </a>
                <div class="file-item-changed">02/13/2018</div>
                <div class="file-item-actions btn-group">
                    <button type="button"
                            class="btn btn-default btn-sm rounded-pill icon-btn borderless md-btn-flat hide-arrow dropdown-toggle"
                            data-toggle="dropdown"><i class="ion ion-ios-more"></i></button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="javascript:void(0)">Rename</a>
                        <a class="dropdown-item" href="javascript:void(0)">Move</a>
                        <a class="dropdown-item" href="javascript:void(0)">Copy</a>
                        <a class="dropdown-item" href="javascript:void(0)">Remove</a>
                    </div>
                </div>
            </div>
            <div class="col-4 col-lg-2 col-md-3 file-item">
            <div class="file-item-select-bg bg-primary"></div>
<!--            <label class="file-item-checkbox custom-control custom-checkbox">-->
<!--                <input type="checkbox" class="custom-control-input"/>-->
<!--                <span class="custom-control-label"></span>-->
<!--            </label>-->
            <div class="text-black-50 file-item-icon far fa-file text-secondary"></div>
            <a href="javascript:void(0)" class="file-item-name">
                MAKEFILE
            </a>
            <div class="file-item-changed">02/24/2018</div>
            <div class="file-item-actions btn-group">
                <button type="button"
                        class="btn btn-default btn-sm rounded-pill icon-btn borderless md-btn-flat hide-arrow dropdown-toggle"
                        data-toggle="dropdown"><i class="ion ion-ios-more"></i></button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="javascript:void(0)">Rename</a>
                    <a class="dropdown-item" href="javascript:void(0)">Move</a>
                    <a class="dropdown-item" href="javascript:void(0)">Copy</a>
                    <a class="dropdown-item" href="javascript:void(0)">Remove</a>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<?php require __DIR__ . '/layouts/footer.view.php' ?>
