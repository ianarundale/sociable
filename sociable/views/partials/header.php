<?php defined('SYSPATH') or die('No direct access allowed.');
if (!isset($page)) $page = "";
?>

<div class="header-clear visible-desktop"></div>
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="/">Sociable</a>

            <form class="navbar-search pull-left" action="">
                <input type="text" class="search-query span2" placeholder="Search">
            </form>
            <div class="nav-collapse collapse navbar-responsive-collapse">
                <ul class="nav pull-right">
                    <li><a href="/profile">Discover</a></li>
                    <li class="divider-vertical"></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class=" icon-cog"></i>Account<b
                                class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- /.nav-collapse -->
        </div>
    </div>
    <!-- /navbar-inner -->
</div>