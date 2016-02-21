<?php
use Site\Components as Components;
use Site\Helper as Helper;
use Site\Objects as Objects;

$token = Helper\Protection::viewPrivateToken();

?>
<!-- Navbar -->
<nav class="navbar navbar-static">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="glyphicon glyphicon-menu-hamburger"></span>
            </button>
            <a class="navbar-brand" href="<?=Helper\Link::route()?>"><?=Helper\Page::siteTitle()?></a>
        </div>
        
        <div id="navbar" class="navbar-collapse collapse">
            
            <?php if (Components\Auth::isAuth()) : ?>
                <ul class="nav navbar-nav main-navbar-nav">
                    <li class="<?=Helper\Selection::isIndex('patterns')?>">
                        <a href="<?=Helper\Link::route('workflow/pattern')?>">Patterns</a>
                    </li>
                    <li><a href="#">Pages</a></li>
                    <li><a href="#">Activity</a></li>
                    <li><a href="#">Reports</a></li>
                </ul>
            <?php endif; ?>
            
            <ul class="nav navbar-nav navbar-right">
                
                <?php if (Components\Permission::inRoles([Objects\Role::SUPER_ADMIN, Objects\Role::ADMIN])) : ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Project Name <span class="glyphicon glyphicon-menu-down"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">New Way Airlines</a></li>
                            <li><a href="#">Karigar CRM</a></li>
                            <li><a href="#">New Service CRM</a></li>
                            <li><a href="#">Sports Testing System</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="<?=Helper\Link::route('project')?>">View All</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
                
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle setting-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon glyphicon-cog"></span><span class="hidden-md hidden-lg hidden-sm">Manage</span></a>
                    <ul class="dropdown-menu">
                        
                        <?php if (Components\Permission::inRoles([Objects\Role::SUPER_ADMIN, Objects\Role::ADMIN, Objects\Role::MANAGER])) : ?>
                            <li><a href="<?=Helper\Link::route('user/manage')?>">Manage Users</a></li>
                            <li><a href="<?=Helper\Link::route('template/manage')?>">Templates</a></li>
                        <?php endif; ?>
                        
                        <?php if (Components\Permission::inRoles([Objects\Role::SUPER_ADMIN, Objects\Role::ADMIN])) : ?>
                            <li><a href="<?=Helper\Link::route('project')?>">Projects</a></li>
                        <?php endif; ?>
                        
                        <li role="separator" class="divider"></li>
                        
                        <?php if (Components\Auth::isAuth()) : ?>
                            <li><a href="<?=Helper\Link::route('user/setting')?>">My Account</a></li>
                            <li><a href="<?=Helper\Link::route('user/account/logout', $token, true)?>">Logout</a></li>
                        <?php else : ?>
                            <li><a href="<?=Helper\Link::route('user/account/login')?>">Login</a></li>
                        <?php endif; ?>
                    </ul>
                </li>

            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">
    
<?php Helper\Page::includes('message'); ?>