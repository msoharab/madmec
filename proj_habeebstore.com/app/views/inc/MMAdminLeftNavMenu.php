<?php ?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <!--<img src="<?php // echo $this->GymDets["short_logo"]; ?>"  alt="User Image" width="45" height="45">-->
            </div>
            <div class="pull-left info">
                <p>
                    <?php // echo ucfirst($this->GymDets["gymname"]); ?>
                </p>
                <a href="#">
                    <i class="fa fa-circle text-success">
                    </i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li>
                <a href="<?php echo $this->config["EGPCSURL"] . $this->config["CTRL_19"]; ?>">
                    <i class="fa fa-arrow-right">
                    </i> <span>Dashboard</span>
                </a>
            </li>

            <li>
                <a href="<?php echo $this->config["EGPCSURL"] . $this->config["CTRL_20"] ; ?>">
                    <i class="fa fa-arrow-right">
                    </i> <span>Stock</span>
                </a>
            </li>
            <li>
                <a href="<?php echo $this->config["EGPCSURL"] . $this->config["CTRL_21"] ; ?>">
                    <i class="fa fa-arrow-right">
                    </i> <span>Sales</span>
                </a>
            </li>
<!--            <li>
                <a href="<?php echo $this->config["EGPCSURL"] . $this->config["CTRL_20"] ; ?>">
                    <i class="fa fa-arrow-right">
                    </i> <span>Bills</span>
                </a>
            </li>-->
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
