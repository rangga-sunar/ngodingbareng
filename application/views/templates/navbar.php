<!-- start: TOP NAVIGATION MENU -->
<ul class="nav navbar-right">

    <!-- start: NOTIFICATION DROPDOWN -->
    <li class="dropdown">
        <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" data-close-others="true" href="#">
            <i class="clip-notification-2"></i>
            <span class="badge"> 0</span>
        </a>
        <ul class="dropdown-menu notifications">
            <li>
                <span class="dropdown-menu-title"> You have 0 notifications</span>
            </li>
            <li>
                <div class="drop-down-wrapper">
                    <ul>

                        <li>
                            <a href="javascript:void(0)">
                                <span class="label label-success"><i class="fa fa-comment"></i></span>
                                <span class="message"> New comment</span>
                                <span class="time"> yesterday</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="view-all">
                <a href="javascript:void(0)">
                    See all notifications <i class="fa fa-arrow-circle-o-right"></i>
                </a>
            </li>
        </ul>
    </li>
    <!-- end: NOTIFICATION DROPDOWN -->

    <!-- start: USER DROPDOWN -->
    <li class="dropdown current-user">
        <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" data-close-others="true" href="#">
            <img src="http://portal.indonesian-aerospace.com/data/foto/<?php echo $this->session->userdata('nik') . ".jpg"; ?>" height="35" width="35" class=" circle-img" alt="">
            <span class="username"><?php echo $this->session->userdata('name'); ?></span>
            <i class="clip-chevron-down"></i>
        </a>
        <ul class="dropdown-menu">
            <li>
                <a href="pages_user_profile.html">
                    <i class="clip-user-2"></i>
                    &nbsp;My Profile
                </a>
            </li>

            <li>
                <a href="<?= base_url('auth/logout'); ?>">
                    <i class="clip-exit"></i>
                    &nbsp;Log Out
                </a>
            </li>
        </ul>
    </li>
    <!-- end: USER DROPDOWN -->
</ul>
<!-- end: TOP NAVIGATION MENU -->
</div>
<!-- start: HORIZONTAL MENU -->
<div class="horizontal-menu navbar-collapse collapse">
    <ul class="nav navbar-nav">
        <li class="<?php if ($this->uri->segment(2) == "index") echo "active"; ?>">
            <a href="<?= base_url('auth/index'); ?>">
                <span class="<?php echo ($this->uri->segment(2) == 'index') ? 'selected' : ''; ?>"></span>
                DASHBOARD
            </a>
        </li>
        <?php
        $var = array('N219_controller', 'C212_controller', 'CN235_controller', 'MKII_controller', 'MALE_controller', 'C295_controller', 'SPIRIT_controller', 'ROCKET_controller', 'KFX_controller', 'NBELL_controller');
        ?>
        <li class="<?php if (in_array($this->uri->segment(1), $var)) echo "active"; ?> navbar">
            <a href="#" class="dropdown-toggle" data-close-others="true" data-hover="dropdown" data-toggle="dropdown">
                <span class="selected"></span>
                DRAWING <i class="fa fa-angle-down"></i>
            </a>

            <ul class="dropdown-menu">
                <?php
                foreach ($akses as $row) {
                    $menu = explode(",", rtrim($row->access, ","));
                    $jum = count($menu);
                    $i = 0;

                    for ($i; $i < $jum; $i++) {
                ?>
                        <li class="<?php if ($this->uri->segment(1) == $menu[$i] . "_controller") echo "active"; ?> <?= $menu[$i]; ?>">
                            <a href="<?php echo base_url($menu[$i]) . '_controller'; ?>">
                                <?php echo $menu[$i]; ?>
                            </a>
                        </li>
                <?php
                    }
                }
                ?>
                <!-- <li class="<?php if ($this->uri->segment(3) == "kfx") echo "active"; ?> kfx">
                    <a href="<?php echo base_url('user/viewdraw/kfx'); ?>">
                        KFX
                    </a>
                </li>

                <li class="<?php if ($this->uri->segment(3) == "n219") echo "active"; ?> n219">
                    <a href="<?php echo base_url('user/viewdraw/n219'); ?>">
                        N219
                    </a>
                </li>
                <li class="<?php if ($this->uri->segment(3) == "c212") echo "active"; ?> c212">
                    <a href="<?php echo base_url('user/viewdraw/c212'); ?>">
                        C212
                    </a>
                </li>
                <li class="<?php if ($this->uri->segment(3) == "mk2") echo "active"; ?> mk2">
                    <a href="<?php echo base_url('user/viewdraw/mk2'); ?>">
                        MKII
                    </a>
                </li> -->
            </ul>
        </li>
        <?php
        if ($this->session->userdata('nik') == '900300') :
        ?>
            <li class="<?php if ($this->uri->segment(2) == "viewuser") echo "active"; ?>">
                <a href="<?= base_url('admin/viewuser'); ?>">
                    <span class="<?php echo ($this->uri->segment(2) == 'viewuser') ? 'selected' : ''; ?>"></span>
                    MANAGE USERS
                </a>
            </li>
        <?php
        endif;
        ?>
    </ul>
</div>
<!-- end: HORIZONTAL MENU -->
</div>
<!-- end: TOP NAVIGATION CONTAINER -->
</div>
<!-- end: HEADER -->