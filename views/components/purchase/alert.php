<?php
$alertType = isset($successMje) ? 'alert-success' : 'alert-danger';
$message = isset($successMje) ? $successMje : $errorMje;
?>

<div class="alert <?= $alertType ?> alert-dismissible fade show mt-3" role="alert">
    <strong><?= $message ?></strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>