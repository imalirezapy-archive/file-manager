<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">


    <title>check file manager - Bootdey.com</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css"
      integrity="sha256-2XFplPlrFClt0bIdPgpz8H7ojnk10H69xRqd9+uTShA=" crossorigin="anonymous"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/4.5.6/css/ionicons.min.css"
      integrity="sha512-0/rEDduZGrqo4riUlwqyuHDQzp2D1ZCgH/gFIfjMIL5az8so6ZiXyhf1Rg8i6xsjv+z/Ubc4tt1thLigEcu6Ug=="
      crossorigin="anonymous" referrerpolicy="no-referrer"/>


<div class="container-lg flex-grow-1 light-style container-p-y mt-5">
    <div class="container-m-nx container-m-ny bg-lightest mb-3">
        <ol class="breadcrumb text-big container-p-x py-3 m-0" >

            <?php
            $addressMap = addressMap();
            foreach ($addressMap as $key => $dir){
                if (($key == count($addressMap) - 1) or is_null($dir['href'])) {?>
                    <li class="breadcrumb-item active"><?= $dir['name'] ?></li>
                <?php continue; } ?>
                <li class="breadcrumb-item ">
                    <a href="/?address=<?= $dir['href'] ?>"><?= $dir['name'] ?></a>
                </li>

            <?php } ?>

        </ol>
        <hr class="m-0"/>
    </div>


