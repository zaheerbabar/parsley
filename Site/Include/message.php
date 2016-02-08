<?php
use Site\Helper as Helper;
use Site\Objects as Objects;
?>

<?php foreach ($viewData->messages->global as $message) : ?>

    <?php if ($message['type'] == Objects\MessageType::INFO) : ?>
    <div class="alert alert-info alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?=Helper\Message::view($message)?>
    </div>
    <?php endif; ?>
    
    <?php if ($message['type'] == Objects\MessageType::SUCCESS) : ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?=Helper\Message::view($message)?>
    </div>
    <?php endif; ?>
    
    <?php if ($message['type'] == Objects\MessageType::WARNING) : ?>
    <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?=Helper\Message::view($message)?>
    </div>
    <?php endif; ?>
    
    <?php if ($message['type'] == Objects\MessageType::ERROR) : ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?=Helper\Message::view($message)?>
    </div>
    <?php endif; ?>
    
    <?php if ($message['type'] == Objects\MessageType::OTHER) : ?>
    <div class="alert alert-default alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?=Helper\Message::view($message)?>
    </div>
    <?php endif; ?>

<?php endforeach; ?>