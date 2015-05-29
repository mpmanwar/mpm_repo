<header class="header">
    <a href="/dashboard" class="logo">
      <img src="{{ URL :: asset('img/logo.png') }}" class="" alt="" width="100"/>
    </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <!-- <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a> -->
                <div class="col_display">
                    <p class="display_name">{{ $practice_name }}</p>
                </div>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span>{{ $admin_name }} <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <img src="{{ URL :: asset('img/user3.jpg') }}" class="img-circle" alt="User Image" />
                                    <p>
                                       {{ $admin_name }}
                                    </p>
                                </li>
                                
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="/admin-profile" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-left" style="margin-left: 3px;">
                                        <a href="/change-password" class="btn btn-default btn-flat">Edit Password</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="/admin-logout" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>