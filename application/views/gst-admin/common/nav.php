<?php
//print_r($active[0]);
?>
<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <!--- Divider -->
        <div id="sidebar-menu">
            <ul>
                <li class="has_sub">
                    <a href="<?php echo ADMINURL . 'user/'; ?>" class="waves-effect <?php echo (isset($active[0]) && $active[0] == "user") ? "active" : ""; ?>"><i class="fa fa-users" aria-hidden="true"></i> <span> Users </span> </a>
                </li>
                <!--<li class="has_sub <?php echo (isset($active[0]) && $active[0] == "sales") ? "active" : ""; ?>">
                    <a href="#" class="waves-effect subdrop"><i class="ti-home"></i> <span> Sales </span> </a>
                    <ul class="list-unstyled" style="display: block;">
                        <li class="<?php echo (isset($active[1]) && $active[1] == "wholesale") ? "active" : ""; ?>"><a href="<?php echo ADMINURL . 'wholesale/'; ?>" class="waves-effect"><span> Wholesales </span> </a></li>
                        <li class="<?php echo (isset($active[1]) && $active[1] == "retail") ? "active" : ""; ?>"><a href="<?php echo ADMINURL. 'retail/'; ?>" class="waves-effect"><span> Retails </span> </a></li>
                    </ul>
                </li>-->
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>