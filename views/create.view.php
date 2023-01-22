<?php require __DIR__ . '/layouts/header.view.php' ?>

    <style>
        #regForm {
            background-color: #ffffff;
            margin: 0px auto;
            font-family: Raleway;
            padding: 40px;
            border-radius: 10px
        }

        #register{

            color: #6A1B9A;
        }

        h1 {
            text-align: center
        }

        .input-custom {
            padding: 10px;
            width: 100%;
            font-size: 17px;
            font-family: Raleway;
            border: 1px solid #aaaaaa;
            border-radius: 10px;
            -webkit-appearance: none;
        }



        .tab .input-custom:focus{

            border:1px solid #6a1b9a !important;
            outline: none;
        }

        .input-custom.invalid {

            border:1px solid #e03a0666;
        }


        .btn-custom {
            color: #ffffff;
            border: none;
            border-radius: 50%;
            padding: 10px 20px;
            font-size: 17px;
            font-family: Raleway;
            cursor: pointer
        }
        .submit {
            background-color: #6A1B9A;

        }

        .cancel {
            background-color: gray;
        }

        .btn-custom:hover {
            opacity: 0.8
        }

        .btn-custom:focus{
            outline: none !important;
        }


    </style>
    <div class="container mt-5">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-9">
                <form action method="post" id="regForm">
                    <input hidden name="_method" value="put">
                    <h1 id="register">
                        Create New
                        <?= $is_dir ? ' directory' : ' file' ?>
                    </h1>

                    <div class="tab">
                        <h6>Name</h6>
                        <p>
                            <input placeholder="Name..." class="input-custom" name="name"></p>

                    </div>
                    <div style="overflow:auto;" id="nextprevious">
                        <div style="float:right;">
                            <a type="button" class="btn-custom cancel text-white mr-2" href="/?address=<?= $address ?>" ><i class="fa fa-times"></i></a>
                            <button type="submit"  class="btn-custom submit" ><i class="fa fa-check"></i></button></div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php require __DIR__ . '/layouts/footer.view.php' ?>