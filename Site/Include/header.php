<?php
use Site\Components as Components;
use Site\Helper as Helper;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <!--<link rel="icon" href="/favicon.ico">-->

        <title><?=Helper\Page::title()?></title>

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" 
            integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <link href="/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

        <?=Helper\Section::view('head')?>

        <link href="/assets/css/bootstrap-reset.css" rel="stylesheet">
        
        <link href="/assets/css/common.css" rel="stylesheet">
        <link href="/assets/css/custom.css?rev=6" rel="stylesheet">
        

        <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
        <!--[if lt IE 9]><script src="/assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
        <script src="/assets/js/ie-emulation-modes-warning.js"></script>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>
        
    <!--<img src="/assets/images/loading.gif" id="loading-indicator" style="display:none" />-->
    