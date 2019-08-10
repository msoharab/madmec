<?php ?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo $this->UserDets["profic"]; ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?php echo ucfirst($this->UserDets["user_name"]); ?>
                </p>
                <a href="#">
                    <i class="fa fa-circle text-success">
                    </i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">
                <span>Welcome</span>
            </li>
            <li>
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_35"]; ?>">
                    <i class="fa fa-arrow-right">
                    </i> <span>Home</span>
                </a>
            </li>
            <li class="header">
                <span>Add / Choose new <br />Gyms to continue</span>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
