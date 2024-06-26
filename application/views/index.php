<!DOCTYPE html>
<html lang="en">

   
    <head>
        			<!-- Chartist -->
                                <?php $this->load->view('template/css.php'); ?>

    </head>

    <body class="infobar-offcanvas">

       <!--header-->
       
       <?php $this->load->view('template/header.php'); ?>
       
       <!--end header-->

        <div id="wrapper">
            <div id="layout-static">
                <div class="static-sidebar-wrapper sidebar-midnightblue">
                    <div class="static-sidebar">
                        <div class="sidebar">
                            <div class="widget stay-on-collapse" id="widget-welcomebox">
                                <div class="widget-body welcome-box tabular">
                                    <div class="tabular-row">
                                        <div class="tabular-cell welcome-avatar">
                                            <a href="#"><img src="assets/demo/avatar/avatar_02.png" class="avatar"></a>
                                        </div>
                                        <div class="tabular-cell welcome-options">
                                            <span class="welcome-text">Welcome,</span>
                                            <a href="#" class="name">Jonathan Smith</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="widget stay-on-collapse" id="widget-sidebar">
                                <nav role="navigation" class="widget-body">
                                    <ul class="acc-menu">
                                        <li class="nav-separator">Explore</li>
                                        <li><a href="index.html"><i class="fa fa-home"></i><span>Dashboard</span></a></li>
                                        <!-- <li><a href="javascript:;"><i class="fa fa-user"></i><span>More Dashboard Pages</span></a>
                                                <ul class="acc-menu">
                                                        <li><a href="sales-force.html">Sales Force</a></li>
                                                        <li><a href="sales-performance.html">Sales Performance</a></li>
                                                        <li><a href="kpi-dashboard.html">KPI Dashboard</a></li>
                                                        <li><a href="shipping-status.html">Shipping Status</a></li>
                                                        <li><a href="metrics-dashboard.html">Metrics Dashboard</a></li>
                                                </ul>
                                        </li> -->
                                        <li><a href="javascript:;"><i class="fa fa-columns"></i><span>Layouts</span><span class="badge badge-primary">8</span></a>
                                            <ul class="acc-menu">
                                                <li><a href="layout-grids.html">Grid Scaffolding</a></li>

                                                <li><a href="layout-fixed-sidebars.html">Stretch Sidebars</a></li>

                                                <li><a href="layout-sidebar-scroll.html">Sidebar Scroll</a></li>
                                                <li><a href="layout-static-leftbar.html">Static Sidebar</a></li>

                                                <li><a href="layout-infobar-offcanvas.html">Offcanvas Infobar</a></li>
                                                <li><a href="layout-infobar-overlay.html">Overlay Infobar</a></li>

                                                <li><a href="layout-page-tabs.html">Page Tabs</a></li>

                                                <li><a href="layout-fullheight-content.html">Fixed Height Content</a></li>
                                                <li><a href="layout-fullheight-panel.html">Fixed Height Panel</a></li>

                                                <li><a href="layout-leftbar-widgets.html">Leftbar Widgets <span class="label label-grape">Cool</span></a></li>
                                                <li><a href="layout-rightbar-widgets.html">Rightbar Widgets <span class="label label-grape">Cool</span></a></li>
                                                <li><a href="layout-topnav-options.html">Topnav Options</a></li>

                                                <li><a href="javascript:;">Horizontal Nav <span class="badge badge-dark">2</span></a>
                                                    <ul class="acc-menu">
                                                        <li><a href="layout-horizontal-small.html">Small Menu</a></li>
                                                        <li><a href="layout-horizontal-large.html">Large Menu</a></li>
                                                    </ul>
                                                </li>

                                                <li><a href="layout-chatbar-overlay.html">Chatbar</a></li>
                                                <li><a href="layout-boxed.html">Boxed</a></li>
                                                <li><a href="layout-compact.html">Compact Leftbar</a></li>

                                            </ul>
                                        </li>
                                        <li><a href="javascript:;"><i class="fa fa-flask"></i><span>Base Styles</span></a>
                                            <ul class="acc-menu">
                                                <li><a href="ui-typography.html">Typography</a></li>
                                                <li><a href="ui-buttons.html">Buttons</a></li>
                                                <li><a href="ui-tables.html">Tables</a></li>
                                                <li><a href="ui-forms.html">Forms</a></li>
                                                <li><a href="ui-images.html">Images</a></li>
                                                <li><a href="ui-panels.html">Panels</a></li>
                                                <li><a href="ui-icons.html">Font Icons</a></li>
                                                <li><a href="ui-helpers.html">Helpers</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="javascript:;"><i class="fa fa-cogs"></i><span>Bootstrap</span><span class="label label-info">UI</span></a>
                                            <ul class="acc-menu">
                                                <li><a href="ui-modals.html">Modal Box</a></li>
                                                <li><a href="ui-progress.html">Progress Bars</a></li>
                                                <li><a href="ui-paginations.html">Pagers &amp; Paginations</a></li>
                                                <li><a href="ui-breadcrumbs.html">Breadcrumbs</a></li>
                                                <li><a href="ui-labelsbadges.html">Labels &amp; Badges</a></li>
                                                <li><a href="ui-alerts.html">Alerts &amp; Notificiations</a></li>
                                                <li><a href="ui-tabs.html">Tabs &amp; Accordions</a></li>

                                                <li><a href="ui-carousel.html">Carousel</a></li>
                                                <li><a href="ui-wells.html">Wells</a></li>
                                            </ul>
                                        </li>

                                        <li class="nav-separator">Plugins</li>
                                        <li><a href="javascript:;"><i class="fa fa-random"></i><span>Components</span></a>
                                            <ul class="acc-menu">
                                                <li><a href="ui-tiles.html">Tiles</a></li>
                                                <li><a href="custom-skylo.html">Page Progress Bar</a></li>
                                                <li><a href="custom-bootbox.html">Bootbox</a></li>
                                                <li><a href="custom-datepaginator.html">Date Paginator</a></li>
                                                <li><a href="custom-pines.html">Pines Notification</a></li>
                                                <li><a href="custom-notific8.html">Notific8 Notification</a></li>
                                                <li><a href="custom-pulsate.html">Pulsating Elements</a></li>
                                                <li><a href="custom-knob.html">jQuery Knob</a></li>
                                                <li><a href="custom-jqueryui.html">jQueryUI Widgets</a></li>
                                                <li><a href="custom-ionrange.html">Ion Range Slider</a></li>
                                                <li><a href="custom-tour.html">Tour</a></li>
                                                <li><a href="ui-nestable.html">Nestable Lists</a></li>
                                                <li><a href="custom-jstree.html">Tree View</a></li>
                                                <li><a href="custom-weather.html">Weather</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="javascript:;"><i class="fa fa-pencil"></i><span>Forms</span></a>
                                            <ul class="acc-menu">
                                                <li><a href="form-components.html">Form Components</a></li>
                                                <li><a href="form-pickers.html">Pickers</a></li>
                                                <li><a href="form-wizard.html">Form Wizard</a></li>
                                                <li><a href="form-validation.html">Form Validation</a></li>
                                                <li><a href="form-masks.html">Form Masks</a></li>
                                                <li><a href="form-dropzone.html">Dropzone Uploader</a></li>
                                                <li><a href="form-ckeditor.html">CKEditor</a></li>
                                                <li><a href="form-summernote.html">Summernote</a></li>
                                                <li><a href="form-markdown.html">Markdown Editor</a></li>
                                                <li><a href="form-xeditable.html">Inline Editor</a></li>
                                                <li><a href="form-imagecrop.html">Image Cropping</a></li>
                                                <li><a href="form-gridforms.html">Grid Forms</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="javascript:;"><i class="fa fa-table"></i><span>Tables</span></a>
                                            <ul class="acc-menu">
                                                <li><a href="tables-responsive.html">Responsive Tables</a></li>
                                                <li><a href="tables-editable.html">Editable Tables</a></li>
                                                <li><a href="tables-data.html">Data Tables</a></li>
                                                <li><a href="tables-advanceddatatable.html">Advanced Data Tables</a></li>
                                                <li><a href="tables-fixedheader.html">Fixed Header Tables</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="ui-advancedpanels.html"><i class="fa fa-cog fa-spin"></i><span>Panels</span><span class="label label-alizarin">HOT!</span></a></li>
                                        <li><a href="javascript:;"><i class="fa fa-bar-chart-o"></i><span>Analytics</span></a>
                                            <ul class="acc-menu">
                                                <li><a href="charts-flot.html">Flot</a></li>
                                                <li><a href="charts-sparklines.html">Sparklines</a></li>
                                                <li><a href="charts-morris.html">Morris.js</a></li>
                                                <li><a href="charts-chart.html">Chart.js</a></li>
                                                <li><a href="charts-easypiechart.html">Easy Pie Chart</a></li>
                                                <li><a href="charts-nvd3.html">nvd3 <span class="label label-info">New</span></a></li>
                                                <li><a href="charts-gantt.html">Gantt Chart</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="javascript:;"><i class="fa fa-map-marker"></i><span>Maps</span></a>
                                            <ul class="acc-menu">
                                                <li><a href="maps-google.html">Google Maps</a></li>
                                                <li><a href="maps-vector.html">Vector Maps</a></li>
                                                <li><a href="maps-mapael.html">Mapael</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="javascript:;"><i class="fa fa-files-o"></i><span>Pages</span></a>
                                            <ul class="acc-menu">
                                                <li><a href="extras-messages.html">Messages</a></li>
                                                <li><a href="extras-profile.html">Profile</a></li>
                                                <li><a href="extras-calendar.html">Calendar</a></li>
                                                <li><a href="extras-timeline.html">Timeline</a></li>
                                                <li><a href="extras-search.html">Search Page</a></li>
                                                <li><a href="extras-chatroom.html">Chat Room</a></li>
                                                <li><a href="extras-invoice.html">Invoice</a></li>
                                                <li><a href="javascript:;">Responsive Email Template</a>
                                                    <ul class="acc-menu">
                                                        <li><a href="responsive-email/basic.html">Basic</a></li>
                                                        <li><a href="responsive-email/hero.html">Hero</a></li>
                                                        <li><a href="responsive-email/sidebar.html">Sidebar</a></li>
                                                        <li><a href="responsive-email/sidebar-hero.html">Sidebar Hero</a></li>
                                                    </ul>
                                                </li>
                                                <li><a href="extras-gallery.html">Gallery</a></li>
                                                <li><a href="coming-soon.html">Coming Soon</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="javascript:;"><i class="fa fa-briefcase"></i><span>Extras</span></a>
                                            <ul class="acc-menu">
                                                <li><a href="extras-pricingtable.html">Pricing Tables</a></li>
                                                <li><a href="extras-faq.html">FAQ</a></li>
                                                <li><a href="extras-registration.html">Registration</a></li>
                                                <li><a href="extras-forgotpassword.html">Password Reset</a></li>
                                                <li><a href="extras-login.html">Login</a></li>
                                                <li><a href="extras-404.html">404 Page</a></li>
                                                <li><a href="extras-500.html">500 Page</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="javascript:;"><i class="fa fa-sitemap"></i><span>Multiple Levels</span><span class="badge badge-dark">99</span></a>
                                            <ul class="acc-menu">
                                                <li><a href="javascript:;">Menu Item 1</a></li>
                                                <li><a href="javascript:;">Menu Item 2</a>
                                                    <ul class="acc-menu">
                                                        <li><a href="javascript:;">Menu Item 2.1</a></li>
                                                        <li><a href="javascript:;">Menu Item 2.2</a>
                                                            <ul class="acc-menu">
                                                                <li><a href="javascript:;">Menu Item 2.2.1</a></li>
                                                                <li><a href="javascript:;">Menu Item 2.2.2</a>
                                                                    <ul class="acc-menu">
                                                                        <li><a href="javascript:;">And deeper yet!</a></li>
                                                                    </ul>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="disabled-link"><a href="index.html">Disabled Menu Item</a></li>
                                            </ul>
                                        </li>

                                        <li class="nav-separator">Functional Apps</li>
                                        <li><a href="app-inbox.html"><i class="fa fa-inbox"></i><span>Inbox</span><span class="badge badge-success">3</span></a></li>
                                        <li><a href="app-tasks.html"><i class="fa fa-tasks"></i><span>Tasks</span><span class="badge badge-info">7</span></a></li>
                                        <li><a href="app-notes.html"><i class="fa fa-pencil-square-o"></i><span>Notes</span></a></li>
                                        <li><a href="app-todo.html"><i class="fa fa-check"></i><span>Todo</span><span class="badge badge-dark">10</span></a></li>

                                        <li class="nav-separator">Templates</li>
                                        <li><a href="javascript:;"><i class="fa fa-coffee"></i><span>Blog</span></a>
                                            <ul class="acc-menu">
                                                <!-- <li><a href="app-blog-dashboard.html">Dashboard</a></li> -->
                                                <li><a href="app-blog-page-list.html">Page List</a></li>
                                                <li><a href="app-blog-edit.html">Page Edit</a></li>
                                                <li><a href="app-blog-comment.html">Comment Moderation</a></li>
                                                <li><a href="javascript:;">Blog Front</a>
                                                    <ul class="acc-menu">
                                                        <li><a href="app-blogfront-list.html">Blog Page</a></li>
                                                        <li><a href="app-blogfront-page.html">Blog Post</a></li>
                                                        <li><a href="app-blogfront-column.html">Blog Column</a></li>
                                                        <li><a href="app-blogfront-portfolio.html">Porfolio</a></li>
                                                    </ul>
                                                </li>


                                            </ul>
                                        </li>
                                        <li><a href="javascript:;"><i class="fa fa-shopping-cart"></i><span>eCommerce</span></a>
                                            <ul class="acc-menu">
                                                <!-- <li><a href="app-ecommerce-dashboard.html">Dashboard</a></li> -->
                                                <!-- <li><a href="app-ecommerce-order-list.html">Order List</a></li>
                                                <li><a href="app-ecommerce-order-details.html">Order Details</a></li> -->
                                                <li><a href="app-ecommerce-product-list.html">Product List</a></li>
                                                <li><a href="app-ecommerce-product-edit.html">Product Edit</a></li>
                                                <li><a href="javascript:;">Store Front</a>
                                                    <ul class="acc-menu">
                                                        <li><a href="app-store-product-list.html">Product List</a></li>
                                                        <!-- <li><a href="app-store-product-column.html">Product Column</a></li> -->
                                                        <li><a href="app-store-product-details.html">Product Details</a></li>
                                                        <li><a href="app-store-shoppingcart.html">Shopping Cart</a></li>
                                                        <li><a href="app-store-checkout.html">Checkout</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>

                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">

                                <li class=""><a href="index.html">Home</a></li>
                                <li class="active"><a href="index.html">Dashboard</a></li>

                            </ol>
                            <div class="page-heading">            
                                <h1>Dashboard</h1>
                                <div class="options">
                                    <div class="btn-toolbar">
                                        <a href="#" class="btn btn-default"><i class="fa fa-fw fa-wrench"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="container-fluid">


                                <div data-widget-group="group1">

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="amazo-tile tile-success">
                                                <div class="tile-heading">
                                                    <div class="title">Revenue</div>
                                                    <div class="secondary">past 28 days</div>
                                                </div>
                                                <div class="tile-body">
                                                    <div class="content">$75,800</div>
                                                </div>
                                                <div class="tile-footer">
                                                    <span class="info-text text-right">13.4% <i class="fa fa-level-up"></i></span>
                                                    <div id="sparkline-revenue" class="sparkline-line"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="amazo-tile tile-info" href="#"> 
                                                <div class="tile-heading">
                                                    <div class="title">Goals</div>
                                                    <div class="secondary">orders this month</div>
                                                </div>
                                                <div class="tile-body">
                                                    <div class="content">3,690</div>
                                                </div>
                                                <div class="tile-footer">
                                                    <span class="info-text text-right">82% of 4,500</span>
                                                    <div class="progress">
                                                        <div class="progress-bar" style="width: 82%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="amazo-tile tile-white">
                                                <div class="tile-heading">
                                                    <div class="title">Items</div>
                                                    <div class="secondary">past 28 days</div>
                                                </div>
                                                <div class="tile-body">
                                                    <span class="content">407</span>
                                                </div>
                                                <div class="tile-footer text-center">
                                                    <span class="info-text text-right" style="color: #f04743">13.4% <i class="fa fa-level-down"></i></span>
                                                    <div id="sparkline-item" class="sparkline-bar"></div>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="col-md-3">
                                            <div class="amazo-tile tile-white">
                                                <div class="tile-heading">
                                                    <span class="title">Commision</span>
                                                    <span class="secondary">past 28 days</span>
                                                </div>
                                                <div class="tile-body">
                                                    <span class="content">$9,500</span>
                                                </div>
                                                <div class="tile-footer">
                                                    <span class="info-text text-right" style="color: #94c355">9.2% <i class="fa fa-level-up"></i></span>
                                                    <div id="sparkline-commission" class="sparkline"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="panel panel-default demo-dashboard-graph" data-widget=''>
                                                <div class="panel-heading">
                                                    <div class="panel-ctrls button-icon-bg"
                                                         data-actions-container="" 
                                                         data-action-collapse='{"target": ".panel-body"}'
                                                         data-action-expand=''
                                                         data-action-colorpicker=''
                                                         data-action-refresh='{"type": "circular"}'
                                                         data-action-close=''
                                                         >
                                                    </div>
                                                    <h2>
                                                        <ul class="nav nav-tabs" id="chartist-tab">
                                                            <li><a href="#tab-visitor" data-toggle="tab"><i class="fa fa-user visible-xs"></i><span class="hidden-xs">Visitor Stats</span></a></li>
                                                            <li class="active"><a href="#tab-revenues" data-toggle="tab"><i class="fa fa-bar-chart-o visible-xs"></i><span class="hidden-xs">Revenues</span></a></li>
                                                        </ul>
                                                    </h2>
                                                </div>
                                                <div class="panel-editbox" data-widget-controls=""></div>
                                                <div class="panel-body">
                                                    <div class="tab-content">
                                                        <div class="clearfix mb-md">
                                                            <button class="btn btn-default pull-left" id="daterangepicker2">
                                                                <i class="fa fa-calendar visible-xs"></i> 
                                                                <span class="hidden-xs" style="text-transform: uppercase;"> - <b class="caret"></b>
                                                            </button>

                                                            <div class="btn-toolbar pull-right">
                                                                <div class="btn-group">
                                                                    <a href='#' class="btn btn-default dropdown-toggle" data-toggle='dropdown'><i class="fa fa-cloud-download visible-xs"></i><span class="hidden-xs">Export as </span> <span class="caret"></span></a>
                                                                    <ul class="dropdown-menu">
                                                                        <li><a href="#">Text File (*.txt)</a></li>
                                                                        <li><a href="#">Excel File (*.xlsx)</a></li>
                                                                        <li><a href="#">PDF File (*.pdf)</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="tab-visitor" class="tab-pane">
                                                            <div class="demo-chartist" id="chart1"></div>
                                                        </div>
                                                        <div id="tab-revenues" class="tab-pane active">
                                                            <div class="demo-chartist-sales" id="chart2"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="tile-sparkline">
                                                <div class="tile-sparkline-heading clearfix">
                                                    <div class="pull-left">
                                                        <h2 class="block">9,172</h2>
                                                        <span class="tile-sparkline-subheading block">Page Views <span class="text-muted">This week</span></span class="block">
                                                    </div>
                                                    <div class="pull-right">
                                                        <span class="label label-success">+121%</span>
                                                    </div>
                                                </div>
                                                <div class="tile-sparkline-body">
                                                    <div id="tiles-sparkline-stats-pageviews"></div>
                                                    <div class="tabular">
                                                        <div class="tabular-row">
                                                            <div class="tabular-cell">
                                                                <div class="week-day sun">S</div>
                                                            </div>
                                                            <div class="tabular-cell">
                                                                <div class="week-day mon">M</div>
                                                            </div>
                                                            <div class="tabular-cell">
                                                                <div class="week-day tue">T</div>
                                                            </div>
                                                            <div class="tabular-cell">
                                                                <div class="week-day wed">W</div>
                                                            </div>
                                                            <div class="tabular-cell">
                                                                <div class="week-day thu">T</div>
                                                            </div>
                                                            <div class="tabular-cell">
                                                                <div class="week-day fri">F</div>
                                                            </div>
                                                            <div class="tabular-cell">
                                                                <div class="week-day sat">S</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tile-sparkline-footer">
                                                    <a href="#">Go to analytics</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="tile-sparkline">
                                                <div class="tile-sparkline-heading clearfix">
                                                    <div class="pull-left">
                                                        <h2 class="block">$19,501</h2>
                                                        <span class="tile-sparkline-subheading block">Total Sales <span class="text-muted">This week</span></span class="block">
                                                    </div>
                                                    <div class="pull-right">
                                                        <span class="label label-danger">-37%</span>
                                                    </div>
                                                </div>
                                                <div class="tile-sparkline-body">
                                                    <div id="tiles-sparkline-stats-totalsales"></div>
                                                    <div class="tabular">
                                                        <div class="tabular-row">
                                                            <div class="tabular-cell">
                                                                <div class="week-day sun">S</div>
                                                            </div>
                                                            <div class="tabular-cell">
                                                                <div class="week-day mon">M</div>
                                                            </div>
                                                            <div class="tabular-cell">
                                                                <div class="week-day tue">T</div>
                                                            </div>
                                                            <div class="tabular-cell">
                                                                <div class="week-day wed">W</div>
                                                            </div>
                                                            <div class="tabular-cell">
                                                                <div class="week-day thu">T</div>
                                                            </div>
                                                            <div class="tabular-cell">
                                                                <div class="week-day fri">F</div>
                                                            </div>
                                                            <div class="tabular-cell">
                                                                <div class="week-day sat">S</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tile-sparkline-footer">
                                                    <a href="#">Go to accounts</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="widget-weather">
                                                <div class="weather-heading">
                                                    <div class="weather-heading-top">
                                                        <h4 class="pull-left m-n">Cloudy</h4>
                                                        <a class="weather-settings pull-right" style="line-height:25px; height: 25px; width: 25px;"><i class="fa fa-wrench"></i></a>
                                                    </div><!-- weather-heading-top -->
                                                    <div class="weather-heading-bottom">
                                                        <div class="weather-symbol pull-left"><i class="fa fa-cloud"></i></div>
                                                        <div class="pull-right">
                                                            <h1 class="weather-result">41°
                                                                <span class="weather-details">
                                                                    <h4>Today</h4>
                                                                    <p>Cloudy</p>
                                                                    <p class="degree-range">42°-34°</p>
                                                                </span><!-- weather-details -->
                                                            </h1><!-- weather-result -->
                                                        </div>
                                                    </div><!-- weather-heading-bottom -->
                                                </div><!-- weather-heading -->
                                                <div class="weather-body">
                                                    <div class="col-sm-6">
                                                        <div class="input-group location-search">
                                                            <span class="input-group-btn">
                                                                <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
                                                            </span>
                                                            <input type="text" class="form-control" placeholder="Location">
                                                        </div><!-- /input-group -->
                                                    </div><!-- /.col-lg-6 -->
                                                    <div class="location-name pull-right">
                                                        <p><span>London,</span><br>United Kindom</p>
                                                    </div> 
                                                </div><!-- weather-body -->
                                                <div class="weather-footer">
                                                    <div class="day-list">
                                                        <ul>
                                                            <li>
                                                                <p><i class="fa fa-sun-o"></i></p> <p>Sat</p>
                                                            </li>
                                                            <li>
                                                                <p><i class="fa fa-cloud"></i></p> <p>Sun</p>
                                                            </li>
                                                            <li>
                                                                <p><i class="fa fa-bolt"></i></p> <p>Mon</p>
                                                            </li>
                                                            <li>
                                                                <p><i class="fa fa-bolt"></i></p> <p>Tue</p>
                                                            </li>
                                                            <li>
                                                                <p><i class="fa fa-cloud"></i></p> <p>Wed</p>
                                                            </li>
                                                            <li>
                                                                <p><i class="fa fa-sun-o"></i></p> <p>Thu</p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div><!-- weather-footer -->
                                            </div><!-- widget-weather -->
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="panel panel-default" data-widget=''>
                                                <div class="panel-heading">
                                                    <h2>Todo List</h2>
                                                    <div class="panel-ctrls button-icon-bg"
                                                         data-actions-container="" 
                                                         data-action-collapse='{"target": ".panel-body"}'
                                                         data-action-expand=''
                                                         data-action-colorpicker=''
                                                         data-action-edit=''
                                                         data-action-close=''
                                                         >
                                                    </div>
                                                </div>
                                                <div class="panel-editbox" data-widget-controls=""></div>
                                                <div class="panel-body panel-no-padding panel-todo">
                                                    <ul class="connectedSortable" id="sortable-todo">
                                                        <li class="">
                                                            <span class="drag-todo"> 
                                                                <div class="checkbox-inline icheck"><input type="checkbox"></div>
                                                            </span>
                                                            <p class="todo-description">
                                                                Send project demo files to client
                                                            </p>

                                                        </li>
                                                        <li class="">
                                                            <span class="drag-todo"> 
                                                                <div class="checkbox-inline icheck"><input type="checkbox"></div>
                                                            </span>
                                                            <p class="todo-description">
                                                                Sketch wireframes for new project and send it to client as soon as possible
                                                            </p>

                                                        </li>
                                                        <li class="">
                                                            <span class="drag-todo"> 
                                                                <div class="checkbox-inline icheck"><input type="checkbox"></div>
                                                            </span>
                                                            <p class="todo-description">
                                                                Buy some milk
                                                            </p>

                                                        </li>
                                                        <li class="">
                                                            <span class="drag-todo"> 
                                                                <div class="checkbox-inline icheck"><input type="checkbox"></div>
                                                            </span>
                                                            <p class="todo-description">
                                                                Prepare documentation for completed project
                                                            </p>

                                                        </li>
                                                        <li class="">
                                                            <span class="drag-todo"> 
                                                                <div class="checkbox-inline icheck"><input type="checkbox"></div>
                                                            </span>
                                                            <p class="todo-description">
                                                                Buy some drinks
                                                            </p>

                                                        </li>
                                                        <li class="">
                                                            <span class="drag-todo"> 
                                                                <div class="checkbox-inline icheck"><input type="checkbox"></div>
                                                            </span>
                                                            <p class="todo-description">
                                                                Prepare presentation slides
                                                            </p>

                                                        </li>
                                                        <li class="">
                                                            <span class="drag-todo"> 
                                                                <div class="checkbox-inline icheck"><input type="checkbox"></div>
                                                            </span>
                                                            <p class="todo-description">
                                                                Meeting with the development team
                                                            </p>

                                                        </li>

                                                    </ul>
                                                    <span class="todo-header"></span>
                                                    <ul class="todo-completed connectedSortable" id="completed-todo">

                                                        <li class="">
                                                            <span class="drag-todo"> 
                                                                <div class="checkbox-inline icheck"><input type="checkbox" checked></div>
                                                                <span class="drag-image"></span>
                                                            </span>
                                                            <p class="todo-description">
                                                                Assign todo to designers
                                                            </p>

                                                        </li>
                                                        <li class="">
                                                            <span class="drag-todo"> 
                                                                <div class="checkbox-inline icheck"><input type="checkbox" checked></div>
                                                                <span class="drag-image"></span>
                                                            </span>
                                                            <p class="todo-description">
                                                                Backend bug fixes
                                                            </p>

                                                        </li>
                                                        <li class="">
                                                            <span class="drag-todo"> 
                                                                <div class="checkbox-inline icheck"><input type="checkbox" checked></div>
                                                                <span class="drag-image"></span>
                                                            </span>
                                                            <p class="todo-description">
                                                                Set up a meeting with new client
                                                            </p>

                                                        </li>

                                                    </ul>
                                                    <div class="todo-footer clearfix">
                                                        <a href="#" class="btn btn-sm btn-success"><i class="visible-xs fa fa-plus"></i> <span class="hidden-xs">New</span></a>
                                                        <a href="#" class="btn btn-sm btn-default"><i class="visible-xs fa fa-check"></i> <span class="hidden-xs">Mark All Done</span></a>
                                                        <a href="app-todo.html" class="btn-link btn-sm pull-right" style="padding-right: 0">Go to todo page</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="panel panel-default" data-widget=''>
                                                <div class="panel-heading">
                                                    <h2>Calendar</h2>
                                                    <div class="panel-ctrls button-icon-bg"
                                                         data-actions-container=""
                                                         data-action-collapse='{"target": ".panel-body"}'
                                                         data-action-expand=''
                                                         data-action-colorpicker=''
                                                         data-action-edit=''
                                                         data-action-close=''
                                                         >
                                                        <a href="#" class="button-icon custom-icon has-bg"><i class="fa fa-cog"></i></a>
                                                    </div>
                                                </div>
                                                <div class="panel-editbox" data-widget-controls=""></div>
                                                <div class="panel-body">
                                                    <div id="calendar-drag"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                            </div> <!-- .container-fluid -->
                        </div> <!-- #page-content -->
                    </div>
                    <footer role="contentinfo">
                        <div class="clearfix">
                            <ul class="list-unstyled list-inline pull-left">
                                <li><h6 style="margin: 0;"> &copy; 2015 Avenger</h6></li>
                            </ul>
                            <button class="pull-right btn btn-link btn-xs hidden-print" id="back-to-top"><i class="fa fa-arrow-up"></i></button>
                        </div>
                    </footer>
                </div>
            </div>
        </div>


        <div class="infobar-wrapper scroll-pane">
            <div class="infobar scroll-content">

                <div id="widgetarea">

                    <div class="widget" id="widget-sparkline">
                        <div class="widget-heading">
                            <a href="javascript:;" data-toggle="collapse" data-target="#sparklinestats"><h4>Sparkline Stats</h4></a>
                        </div>
                        <div id="sparklinestats" class="collapse in">
                            <div class="widget-body">
                                <ul class="sparklinestats">
                                    <li>
                                        <div class="title">Earnings</div>
                                        <div class="stats">$22,500</div>
                                        <div class="sparkline" id="infobar-earningsstats" style=""></div>
                                    </li>
                                    <li>
                                        <div class="title">Orders</div>
                                        <div class="stats">4,750</div>
                                        <div class="sparkline" id="infobar-orderstats" style=""></div>
                                    </li>
                                </ul>
                                <a href="#" class="more">More Sparklines</a>
                            </div>
                        </div>
                    </div>

                    <div class="widget">
                        <div class="widget-heading">
                            <a href="javascript:;" data-toggle="collapse" data-target="#recentactivity"><h4>Recent Activity</h4></a>
                        </div>
                        <div id="recentactivity" class="collapse in">
                            <div class="widget-body">
                                <ul class="recent-activities">
                                    <li>
                                        <div class="avatar">
                                            <img src="assets/demo/avatar/avatar_11.png" class="img-responsive img-circle">
                                        </div>
                                        <div class="content">
                                            <span class="msg"><a href="#" class="person">Jean Alanis</a> invited 3 unconfirmed members</span>
                                            <span class="time">2 mins ago</span>

                                        </div>
                                    </li>
                                    <li>
                                        <div class="avatar">
                                            <img src="assets/demo/avatar/avatar_09.png" class="img-responsive img-circle">
                                        </div>
                                        <div class="content">
                                            <span class="msg"><a href="#" class="person">Anthony Ware</a> is now following you</span>
                                            <span class="time">4 hours ago</span>

                                        </div>
                                    </li>
                                    <li>
                                        <div class="avatar">
                                            <img src="assets/demo/avatar/avatar_04.png" class="img-responsive img-circle">
                                        </div>
                                        <div class="content">
                                            <span class="msg"><a href="#" class="person">Bruce Ory</a> commented on <a href="#">Dashboard UI</a></span>
                                            <span class="time">16 hours ago</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="avatar">
                                            <img src="assets/demo/avatar/avatar_01.png" class="img-responsive img-circle">
                                        </div>
                                        <div class="content">
                                            <span class="msg"><a href="#" class="person">Roxann Hollingworth</a>is now following you</span>
                                            <span class="time">Feb 13, 2015</span>
                                        </div>
                                    </li>
                                </ul>
                                <a href="#" class="more">See all activities</a>
                            </div>
                        </div>
                    </div>

                    <div class="widget" >
                        <div class="widget-heading">
                            <a href="javascript:;" data-toggle="collapse" data-target="#widget-milestones"><h4>Milestones</h4></a>
                        </div>
                        <div id="widget-milestones" class="collapse in">
                            <div class="widget-body">
                                <div class="contextual-progress">
                                    <div class="clearfix">
                                        <div class="progress-title">UI Design</div>
                                        <div class="progress-percentage">12/16</div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-lime" style="width: 75%"></div>
                                    </div>
                                </div>
                                <div class="contextual-progress">
                                    <div class="clearfix">
                                        <div class="progress-title">UX Design</div>
                                        <div class="progress-percentage">8/24</div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-orange" style="width: 33.3%"></div>
                                    </div>
                                </div>
                                <div class="contextual-progress">
                                    <div class="clearfix">
                                        <div class="progress-title">Frontend Development</div>
                                        <div class="progress-percentage">8/40</div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-purple" style="width: 20%"></div>
                                    </div>
                                </div>
                                <div class="contextual-progress m0">
                                    <div class="clearfix">
                                        <div class="progress-title">Backend Development</div>
                                        <div class="progress-percentage">24/48</div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-danger" style="width: 50%"></div>
                                    </div>
                                </div>
                                <a href="#" class="more">See All</a>
                            </div>
                        </div>
                    </div>

                    <div class="widget">
                        <div class="widget-heading">
                            <a href="javascript:;" data-toggle="collapse" data-target="#widget-contact"><h4>Contacts</h4></a>
                        </div>
                        <div id="widget-contact" class="collapse in">
                            <div class="widget-body">
                                <ul class="contact-list">
                                    <li id="contact-1">
                                        <a href="javascript:;"><img src="assets/demo/avatar/avatar_02.png" alt=""><span>Jeremy Potter</span></a>
                                        <!-- <div class="contact-card contactdetails" data-child-of="contact-1">
                                            <div class="avatar">
                                                <img src="assets/demo/avatar/avatar_11.png" class="img-responsive img-circle">
                                            </div>
                                            <span class="contact-name">Jeremy Potter</span>
                                            <span class="contact-status">Client Representative</span>
                                            <ul class="details">
                                                <li><a href="#"><i class="fa fa-envelope-o"></i>&nbsp;p.bateman@gmail.com</a></li>
                                                <li><i class="fa fa-phone"></i>&nbsp;+1 234 567 890</li>
                                                <li><i class="fa fa-map-marker"></i>&nbsp;Hollywood Hills, California</li>
                                            </ul>
                                        </div> -->
                                    </li>
                                    <li id="contact-2">
                                        <a href="javascript:;"><img src="assets/demo/avatar/avatar_07.png" alt=""><span>David Tennant</span></a>
                                        <!-- <div class="contact-card contactdetails" data-child-of="contact-2">
                                            <div class="avatar">
                                                <img src="assets/demo/avatar/avatar_11.png" class="img-responsive img-circle">
                                            </div>
                                            <span class="contact-name">David Tennant</span>
                                            <span class="contact-status">Client Representative</span>
                                            <ul class="details">
                                                <li><a href="#"><i class="fa fa-envelope-o"></i>&nbsp;p.bateman@gmail.com</a></li>
                                                <li><i class="fa fa-phone"></i>&nbsp;+1 234 567 890</li>
                                                <li><i class="fa fa-map-marker"></i>&nbsp;Hollywood Hills, California</li>
                                            </ul>
                                        </div> -->
                                    </li>
                                    <li id="contact-3">
                                        <a href="javascript:;"><img src="assets/demo/avatar/avatar_03.png" alt=""><span>Anna Johansson</span></a>
                                        <!-- <div class="contact-card contactdetails" data-child-of="contact-3">
                                            <div class="avatar">
                                                <img src="assets/demo/avatar/avatar_11.png" class="img-responsive img-circle">
                                            </div>
                                            <span class="contact-name">Anna Johansson</span>
                                            <span class="contact-status">Client Representative</span>
                                            <ul class="details">
                                                <li><a href="#"><i class="fa fa-envelope-o"></i>&nbsp;p.bateman@gmail.com</a></li>
                                                <li><i class="fa fa-phone"></i>&nbsp;+1 234 567 890</li>
                                                <li><i class="fa fa-map-marker"></i>&nbsp;Hollywood Hills, California</li>
                                            </ul>
                                        </div> -->
                                    </li>
                                    <li id="contact-4">
                                        <a href="javascript:;"><img src="assets/demo/avatar/avatar_09.png" alt=""><span>Alan Doyle</span></a>
                                        <!-- <div class="contact-card contactdetails" data-child-of="contact-4">
                                            <div class="avatar">
                                                <img src="assets/demo/avatar/avatar_11.png" class="img-responsive img-circle">
                                            </div>
                                            <span class="contact-name">Alan Doyle</span>
                                            <span class="contact-status">Client Representative</span>
                                            <ul class="details">
                                                <li><a href="#"><i class="fa fa-envelope-o"></i>&nbsp;p.bateman@gmail.com</a></li>
                                                <li><i class="fa fa-phone"></i>&nbsp;+1 234 567 890</li>
                                                <li><i class="fa fa-map-marker"></i>&nbsp;Hollywood Hills, California</li>
                                            </ul>
                                        </div> -->
                                    </li>
                                    <li id="contact-5">
                                        <a href="javascript:;"><img src="assets/demo/avatar/avatar_05.png" alt=""><span>Simon Corbett</span></a>
                                        <!-- <div class="contact-card contactdetails" data-child-of="contact-5">
                                            <div class="avatar">
                                                <img src="assets/demo/avatar/avatar_11.png" class="img-responsive img-circle">
                                            </div>
                                            <span class="contact-name">Simon Corbett</span>
                                            <span class="contact-status">Client Representative</span>
                                            <ul class="details">
                                                <li><a href="#"><i class="fa fa-envelope-o"></i>&nbsp;p.bateman@gmail.com</a></li>
                                                <li><i class="fa fa-phone"></i>&nbsp;+1 234 567 890</li>
                                                <li><i class="fa fa-map-marker"></i>&nbsp;Hollywood Hills, California</li>
                                            </ul>
                                        </div> -->
                                    </li>
                                    <li id="contact-6">
                                        <a href="javascript:;"><img src="assets/demo/avatar/avatar_01.png" alt=""><span>Polly Paton</span></a>
                                        <!-- <div class="contact-card contactdetails" data-child-of="contact-6">
                                            <div class="avatar">
                                                <img src="assets/demo/avatar/avatar_11.png" class="img-responsive img-circle">
                                            </div>
                                            <span class="contact-name">Polly Paton</span>
                                            <span class="contact-status">Client Representative</span>
                                            <ul class="details">
                                                <li><a href="#"><i class="fa fa-envelope-o"></i>&nbsp;p.bateman@gmail.com</a></li>
                                                <li><i class="fa fa-phone"></i>&nbsp;+1 234 567 890</li>
                                                <li><i class="fa fa-map-marker"></i>&nbsp;Hollywood Hills, California</li>
                                            </ul>
                                        </div> -->
                                    </li>
                                </ul>
                                <a href="#" class="more">See All</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- Switcher -->
        <div class="demo-options">
            <div class="demo-options-icon"><i class="fa fa-spin fa-fw fa-smile-o"></i></div>
            <div class="demo-heading">Demo Settings</div>

            <div class="demo-body">
                <div class="tabular">
                    <div class="tabular-row">
                        <div class="tabular-cell">Fixed Header</div>
                        <div class="tabular-cell demo-switches"><input class="bootstrap-switch" type="checkbox" checked data-size="mini" data-on-color="success" data-off-color="default" name="demo-fixedheader" data-on-text="I" data-off-text="O"></div>
                    </div>
                    <div class="tabular-row">
                        <div class="tabular-cell">Boxed Layout</div>
                        <div class="tabular-cell demo-switches"><input class="bootstrap-switch" type="checkbox" data-size="mini" data-on-color="success" data-off-color="default" name="demo-boxedlayout" data-on-text="I" data-off-text="O"></div>
                    </div>
                    <div class="tabular-row">
                        <div class="tabular-cell">Collapse Leftbar</div>
                        <div class="tabular-cell demo-switches"><input class="bootstrap-switch" type="checkbox" data-size="mini" data-on-color="success" data-off-color="default" name="demo-collapseleftbar" data-on-text="I" data-off-text="O"></div>
                    </div>
                    <div class="tabular-row">
                        <div class="tabular-cell">Collapse Rightbar</div>
                        <div class="tabular-cell demo-switches"><input class="bootstrap-switch" type="checkbox" checked data-size="mini" data-on-color="success" data-off-color="default" name="demo-collapserightbar" data-on-text="I" data-off-text="O"></div>
                    </div>
                    <div class="tabular-row hide" id="demo-horizicon">
                        <div class="tabular-cell">Horizontal Icons</div>
                        <div class="tabular-cell demo-switches"><input class="bootstrap-switch" type="checkbox" checked data-size="mini" data-on-color="primary" data-off-color="warning" data-on-text="S" data-off-text="L" name="demo-horizicons" ></div>
                    </div>
                </div>

            </div>

            <div class="demo-body">
                <div class="option-title">Header Colors</div>
                <ul id="demo-header-color" class="demo-color-list">
                    <li><span class="demo-white"></span></li>
                    <li><span class="demo-black"></span></li>
                    <li><span class="demo-midnightblue"></span></li>
                    <li><span class="demo-primary"></span></li>
                    <li><span class="demo-info"></span></li>
                    <li><span class="demo-alizarin"></span></li>
                    <li><span class="demo-green"></span></li>
                    <li><span class="demo-violet"></span></li>                
                    <li><span class="demo-indigo"></span></li> 
                </ul>
            </div>

            <div class="demo-body">
                <div class="option-title">Sidebar Colors</div>
                <ul id="demo-sidebar-color" class="demo-color-list">
                    <li><span class="demo-white"></span></li>
                    <li><span class="demo-black"></span></li>
                    <li><span class="demo-midnightblue"></span></li>
                    <li><span class="demo-primary"></span></li>
                    <li><span class="demo-info"></span></li>
                    <li><span class="demo-alizarin"></span></li>
                    <li><span class="demo-green"></span></li>
                    <li><span class="demo-violet"></span></li>                
                    <li><span class="demo-indigo"></span></li> 
                </ul>
            </div>

            <div class="demo-body hide" id="demo-boxes">
                <div class="option-title">Boxed Layout Options</div>
                <ul id="demo-boxed-bg" class="demo-color-list">
                    <li><span class="pattern-brickwall"></span></li>
                    <li><span class="pattern-dark-stripes"></span></li>
                    <li><span class="pattern-rockywall"></span></li>
                    <li><span class="pattern-subtle-carbon"></span></li>
                    <li><span class="pattern-tweed"></span></li>
                    <li><span class="pattern-vertical-cloth"></span></li>
                    <li><span class="pattern-grey_wash_wall"></span></li>
                    <li><span class="pattern-pw_maze_black"></span></li>
                    <li><span class="patther-wild_oliva"></span></li>
                    <li><span class="pattern-stressed_linen"></span></li>
                    <li><span class="pattern-sos"></span></li>
                </ul>
            </div>

        </div>
        <!-- /Switcher -->
        <!-- Load site level scripts -->

			 <?php $this->load->view('template/js.php'); ?>							<!-- Initialize scripts for this page-->

        <!-- End loading page level scripts-->

    </body>

    
</html>