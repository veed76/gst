<?php
//print_r($active[0]);
?>
<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <!--- Divider -->
        <div id="sidebar-menu">
            <ul>
                <li class="has_sub">
                    <a href="<?php echo base_url() . 'company/'; ?>" class="waves-effect <?php echo (isset($active[0]) && $active[0] == "company") ? "active" : ""; ?>"><i class="fa fa-building" aria-hidden="true"></i> <span> Companies </span> </a>
                </li>
                <li class="has_sub <?php echo (isset($active[0]) && $active[0] == "sales") ? "active" : ""; ?>">
                    <a href="#" class="waves-effect subdrop"><i class="fa fa-files-o"></i> <span> Sales </span> </a>
                    <ul class="list-unstyled" style="display: block;">
                        <li class="<?php echo (isset($active[1]) && $active[1] == "wholesale") ? "active" : ""; ?>"><a href="<?php echo base_url() . 'wholesale/'; ?>" class="waves-effect"><span> Wholesales </span> </a></li>
                        <li class="<?php echo (isset($active[1]) && $active[1] == "retail") ? "active" : ""; ?>"><a href="<?php echo base_url() . 'retail/'; ?>" class="waves-effect"><span> Retails </span> </a></li>
                    </ul>
                </li>
                <li class="has_sub">
                    <a href="<?php echo base_url() . 'customer/'; ?>" class="waves-effect <?php echo (isset($active[0]) && $active[0] == "customer") ? "active" : ""; ?>"><i class="fa fa-users" aria-hidden="true"></i> <span> Customers </span> </a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>