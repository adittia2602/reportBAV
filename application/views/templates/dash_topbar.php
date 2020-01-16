<body class="layout-3">
  <div id="app">
    <div class="main-wrapper container">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <a href="<?= base_url();?>" class="navbar-brand sidebar-gone-hide">RUMi</a>
        <div class="navbar-nav">
          <a href="#" class="nav-link sidebar-gone-show" data-toggle="sidebar"><i class="fas fa-bars"></i></a>
        </div>
        <form class="form-inline ml-auto">
        </form>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="<?php echo base_url('assets-report/'); ?>img/avatar/avatar-1.png" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">Hi, <?= $user['name'];?></div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <a href="<?= base_url('account'); ?>" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Account
              </a>
              <div class="dropdown-divider"></div>
              <a href="<?= base_url('auth/logout'); ?>" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>

      <nav class="navbar navbar-secondary navbar-expand-lg">
        <div class="container">
          <ul class="navbar-nav">
            
            <li class="nav-item active">
              <a href="<?= base_url('account'); ?>" class="nav-link"><i class="far fa-chart-bar"></i><span>Dashboard</span></a>
            </li>

            <?php
                $role_id = $this->session->userdata('role_id');
                $queryGroup = "SELECT DISTINCT(user_menu.group)";
                $query = "FROM user_menu JOIN `user_access_menu`
                          ON `user_menu`.`id` = `user_access_menu`.`menu_id`
                          WHERE `user_access_menu`.`role_id` = $role_id 
                          ORDER BY user_menu.urutan ASC";
                $grupMenu = $this->db->query($queryGroup.$query)->result_array();
                foreach ($grupMenu as $gr) : 
                    if($gr['group'] == "Dashboard") continue;  
            ?>
              <li class="nav-item dropdown">
                <a href="#" data-toggle="dropdown" class="nav-link has-dropdown"><i class="fas fa-bars"></i><span><?= $gr['group']?></span></a>
                <ul class="dropdown-menu">
                  <?php 
                    $grup = $gr['group'];
                    $queryMenu = "SELECT user_menu.id, user_menu.menu 
                                  FROM user_menu JOIN `user_access_menu`
                                  ON `user_menu`.`id` = `user_access_menu`.`menu_id`
                                  WHERE `user_access_menu`.`role_id` = $role_id AND user_menu.group = '$grup'
                                  ORDER BY user_menu.urutan ASC";
                    $menu = $this->db->query($queryMenu)->result_array();
                    // prepare Menu
                    foreach ($menu as $m) : 
                      $menuId = $m['id'];
                      $querySubMenu = "SELECT * FROM `user_sub_menu` 
                                        WHERE `menu_id` = '$menuId'
                                        AND `is_active` = 1";
                      $subMenu = $this->db->query($querySubMenu)->row_array();
                      if ( $m['menu'] == $subMenu['title'] ) :
                  ?>
                    <!-- Menu with no Dropdown -->
                    <li class="nav-item"> <a href="<?= $subMenu['url']; ?>" class="nav-link"><?= $m['menu'];?></a> </li>
                  <?php else : ?>
                    <!-- Menu with Dropdown -->
                    <li class="nav-item dropdown"> <a href="#" class="nav-link has-dropdown"><?= $m['menu'];?></a>
                      <ul class="dropdown-menu">
                        <?php 
                            $subMenu = $this->db->query($querySubMenu)->result_array();
                            foreach ( $subMenu as $sm ) :
                        ?>
                          <li class="nav-item"> <a class="nav-link" href="<?= base_URL($sm['url']); ?>"> <?= $sm['title']; ?></a> </li>
                        <?php endforeach ?>
                      </ul>
                    </li>
                  <?php endif; ?>
                  <?php endforeach ?>
                </ul>
              </li>
            <?php endforeach ?>
          </ul>
        </div>
      </nav>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">