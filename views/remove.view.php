<?php require __DIR__ . '/layouts/header.view.php' ?>
<?php
//dd($info['name']);
?>
<form action method="post" id="delete">
    <input hidden name="_method" value="delete">
</form>

    <div class="m-auto text-center ">
        <p class="text-center mt-5 text-success" style="font-weight: bold; font-size: 20px">are you sure delete <span
                    class="text-danger">'<?= $name ?>'</span> <?= $is_dir ? 'directory' : 'file' ?> ?</p>
        <button type="submit" form="delete" class="btn btn-success text-white mr-4" >
            Yes
        </button>
        <a class="btn btn-outline-secondary" href="/?address=<?= $parent?>">
            Cancle
        </a>

    </div>

<?php require __DIR__ . '/layouts/footer.view.php' ?>