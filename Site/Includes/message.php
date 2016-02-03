<?php
use Site\Objects as Objects;
?>

<?php if (isset($viewData->messages[Objects\MessageType::INFO])) : ?>
<div class="alert alert-info alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <?=Helpers\Message::showSingle($viewData->messages, Objects\MessageType::INFO)?>
</div>
<?php endif; ?>

<?php if (isset($viewData->messages[Objects\MessageType::SUCCESS])) : ?>
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <?=Helpers\Message::showSingle($viewData->messages, Objects\MessageType::SUCCESS)?>
</div>
<?php endif; ?>

<?php if (isset($viewData->messages[Objects\MessageType::WARNING])) : ?>
<div class="alert alert-warning alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <?=Helpers\Message::showSingle($viewData->messages, Objects\MessageType::WARNING)?>
</div>
<?php endif; ?>

<?php if (isset($viewData->messages[Objects\MessageType::ERROR])) : ?>
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Oops!</strong> <?=Helpers\Message::showSingle($viewData->messages, Objects\MessageType::ERROR)?>
</div>
<?php endif; ?>

<?php if (isset($viewData->messages[Objects\MessageType::OTHER])) : ?>
<div class="alert alert-default alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <?=Helpers\Message::showSingle($viewData->messages, Objects\MessageType::OTHER)?>
</div>
<?php endif; ?>