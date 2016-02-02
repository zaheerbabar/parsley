<?php
use Site\Components as Components;
use Site\Helpers as Helpers;
?>
<!-- Navbar -->
<nav class="navbar navbar-static">
    <div class="container">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="glyphicon glyphicon-menu-hamburger"></span>
        </button>
        <a class="navbar-brand" href="<?=BASE_URL?>"><?=Components\Page::siteTitle()?></a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav main-navbar-nav">
            <li class="<?=Helpers\Selection::isIndex('patterns')?>">
                <a href="/workflow/patterns.php">Patterns</a>
            </li>
            <li><a href="#">Pages</a></li>
            <li><a href="#">Activity</a></li>
            <li><a href="#">Reports</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Project Name <span class="glyphicon glyphicon-menu-down"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="#">New Way Airlines</a></li>
                    <li><a href="#">Karigar CRM</a></li>
                    <li><a href="#">New Service CRM</a></li>
                    <li><a href="#">Sports Testing System</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="/project/projects.php">View All</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle setting-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon glyphicon-cog"></span><span class="hidden-md hidden-lg hidden-sm">Manage</span></a>
                <ul class="dropdown-menu">
                    <li><a href="/user/users.php">Manage Users</a></li>
                    <li><a href="/project/projects.php">Projects</a></li>
                    <li><a href="/workflow/templates.php">Workflow</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="/user/profile.php">Profile</a></li>
                    <li><a href="/user/logout.php">Logout</a></li>
                </ul>
            </li>
            
            
        </ul>
    </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">