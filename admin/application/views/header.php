<!doctype html>
<html lang="en-US">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <title>Typing Certification</title>
    <meta name="description" content="" />
    <meta name="Author" content="Dorin Grigoras [www.stepofweb.com]" />
    <!-- mobile settings -->
    <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0" />
    <!-- WEB FONTS -->

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800&amp;subset=latin,latin-ext,cyrillic,cyrillic-ext" rel="stylesheet" type="text/css" />
    <!-- CORE CSS -->

    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- THEME CSS -->
    <link href="<?php echo base_url(); ?>assets/css/essentials.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/layout.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/color_scheme/green.css" rel="stylesheet" type="text/css" id="color_scheme" />
    <link href="<?php echo base_url(); ?>assets/css/layout-datatables.css" rel="stylesheet" type="text/css" />
    <style>
        .loading{
            display: none;
        }
    </style>
</head>
<body>
<!-- WRAPPER -->
<div id="wrapper" class="clearfix">
    <aside id="aside">
        <nav id="sideNav"><!-- MAIN MENU -->
            <br>
            <ul class="nav nav-list">

                <li>
                    <a href="#">
                        <i class="fa fa-menu-arrow pull-right"></i>
                        <i class="main-icon fa fa-user"></i> <span>Admin User Management</span>
                    </a>
                    <ul>
                        <li><a href="<?php echo base_url(); ?>user/add">Add User</a></li>
                        <li><a href="<?php echo base_url(); ?>user/index">View Users</a></li>

                    </ul>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-menu-arrow pull-right"></i>
                        <i class="main-icon fa fa-ticket"></i> <span>Product Management</span>
                    </a>
                    <ul>
                        <li><a href="<?php echo base_url(); ?>product/add">Add Product</a></li>
                        <li><a href="<?php echo base_url(); ?>product/index">View Products</a></li>

                    </ul>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-menu-arrow pull-right"></i>
                        <i class="main-icon fa fa-group"></i> <span>Member Management</span>
                    </a>
                    <ul>
                        <li><a href="<?php echo base_url(); ?>member/add">Add Member</a></li>
                        <li><a href="<?php echo base_url(); ?>member/index">View Members</a></li>
                        <li><a href="<?php echo base_url(); ?>">Export Members</a></li>

                    </ul>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-menu-arrow pull-right"></i>
                        <i class="main-icon fa fa-indent"></i> <span>Test Management</span>
                    </a>
                    <ul>
                        <li><a href="<?php echo base_url(); ?>test/add">Add Test</a></li>
                        <li><a href="<?php echo base_url(); ?>test/index">View Tests</a></li>

                    </ul>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-menu-arrow pull-right"></i>
                        <i class="main-icon fa fa-rss"></i> <span>Article Management</span>
                    </a>
                    <ul>
                        <li><a href="<?php echo base_url(); ?>article/add">Add Article</a></li>
                        <li><a href="<?php echo base_url(); ?>article/index">View Articles</a></li>

                    </ul>
                </li>
            </ul>

            <h3>MORE</h3>

            <ul class="nav nav-list">
                <li><a href="<?php echo base_url(); ?>">Find Order</a></li>
                <li><a href="<?php echo base_url(); ?>">Print Order</a></li>
                <li><a href="<?php echo base_url(); ?>sales/index">Traffic Splitter</a></li>
                <li><a href="<?php echo base_url(); ?>content/index">Content Management</a></li>
            </ul>

        </nav>
        <span id="asidebg"><!-- aside fixed background --></span>
    </aside>
    <!-- /ASIDE -->
    <!-- HEADER -->
    <header id="header">
        <!-- Mobile Button -->
        <button id="mobileMenuBtn"></button>
        <!-- Logo -->
        <span class="logo pull-left">
					<h3 style="color:white;margin-top: 6px;">Typing</h3>
				</span>
        <form method="get" action="page-search.html" class="search pull-left hidden-xs">

            <input type="text" class="form-control" name="k" placeholder="Search for something..." />

        </form>
        <nav>
            <!-- OPTIONS LIST -->
            <ul class="nav pull-right">
                <!-- USER OPTIONS -->

                <li class="dropdown pull-left">

                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">

                        <img class="user-avatar" alt="" src="<?php echo base_url(); ?>assets/images/noavatar.jpg" height="34" />

                        <span class="user-name">

									<span class="hidden-xs">

										<?php echo $this->session->userdata('logged_username');?> <i class="fa fa-angle-down"></i>

									</span>

								</span>

                    </a>

                    <ul class="dropdown-menu hold-on-click">
                        <li><!-- logout -->
                            <a href="<?php echo base_url(); ?>passwordreset/index"><i class="fa fa-user"></i> Reset Password</a>
                            <a href="<?php echo base_url(); ?>login/logout"><i class="fa fa-power-off"></i> Log Out</a>

                        </li>

                    </ul>
                </li>
            </ul>
        </nav>
    </header>

    <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery/jquery-2.1.4.min.js"></script>
    <script type="text/javascript">var plugin_path = '<?php echo base_url(); ?>assets/plugins/';</script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/app.js"></script>
    <!-- /HEADER -->
