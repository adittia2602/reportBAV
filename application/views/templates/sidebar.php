<!-- Left Sidebar - style you can find in sidebar.scss  -->
<aside class="left-sidebar" data-sidebarbg="skin6">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar" data-sidebarbg="skin6">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <?php
                            $role_id = $this->session->userdata('role_id');
                            $queryGroup = "SELECT DISTINCT(user_menu.group)";
                            $query = "FROM user_menu JOIN `user_access_menu`
                                      ON `user_menu`.`id` = `user_access_menu`.`menu_id`
                                      WHERE `user_access_menu`.`role_id` = $role_id
                                      ORDER BY user_menu.urutan ASC";
                            $grupMenu = $this->db->query($queryGroup.$query)->result_array();
                        ?>
                        <?php foreach ($grupMenu as $gr) : ?>
                        <li class="nav-small-cap"><span class="hide-menu"><?= $gr['group'];?></span></li>
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
                              $queryID = "SELECT menu_id FROM user_sub_menu WHERE title = '$title' ";
                              $idmenu = $this->db->query($queryID)->row_array();
                        ?>
                        <!-- Menu with no Dropdown -->
                        <li class="sidebar-item <?php echo $is_active = $subMenu['title'] === $title ? "active" : ""; ?>"> 
                            <a class="sidebar-link sidebar-link" href="<?= base_URL($subMenu['url']); ?>" aria-expanded="false">
                                <i class="<?= $subMenu['icon'];?>"></i><span class="hide-menu"><?= $subMenu['title'];?></span>
                            </a>
                        </li>

                        <?php else : ?>
                        <!-- Menu with Dropdown -->
                        <li class="sidebar-item <?php echo $is_active = $m['id'] === $idmenu['menu_id'] ? "active" : ""; ?>">
                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                              <i class="<?= $subMenu['icon'];?>"></i><span class="hide-menu"><?= $m['menu'];?></span>
                            </a>

                            <ul aria-expanded="false" class="collapse first-level base-level-line">
                              <?php
                                  $subMenu = $this->db->query($querySubMenu)->result_array();
                                  foreach ( $subMenu as $sm ) :
                              ?>
                                  <li class="sidebar-item <?php echo $is_active = $sm['title']==$title ? "active" : ""; ?>">
                                      <a href="<?= base_URL($sm['url']); ?>" class="sidebar-link">
                                        <span class="hide-menu"> <?= $sm['title']; ?> </span>
                                      </a>
                                  </li>
                              <?php endforeach ?>
                            </ul>
                        </li>
                        <?php endif;?>
                        <?php endforeach ?>
                        <?php endforeach ?>
                        
                        
                        <li class="list-divider"></li>
                        <li class="sidebar-item">
                            <a class="sidebar-link sidebar-link" href="<?= base_url('auth/logout')?>" aria-expanded="false">
                              <i data-feather="log-out" class="feather-icon"></i><span class="hide-menu">Logout</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
        </aside>

        <!-- BREADCRUMB  -->
        <!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb and right sidebar toggle -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-7 align-self-center">
                        <h2 class="page-title text-truncate text-dark font-weight-medium mb-1"><?=$title?></h2>
                        <?php if ($title == 'Dashboard' || $title == 'Overview' || $title == 'Wilayah' || 
                                $title == 'List Debitur' || $title == 'Akad-Pencairan' || $title == 'Data Tagihan Bulan ini' || 
                                $title == 'Debitur' ) { ?>
                            <p class="text-muted">Data update per: <?= $time['last_update'];?></p>
                        <?php } ?>
                    </div>
                    <div class="col-5 align-self-center">
                        <div class="customize-input float-right">
                            <div class="d-flex align-items-center">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb m-0 p-0">
                                        <li class="breadcrumb-item"><a href="<?= base_url(); ?>"><?= $bc['group']?></a>
                                        </li>
                                        <?php if ( $bc['menu'] == $bc['title'] ) {?>
                                          <li class="breadcrumb-item"><?= $bc['menu']?></li>
                                        <?php } else { ?>
                                          <li class="breadcrumb-item"><?= $bc['menu']?></li>
                                          <li class="breadcrumb-item"><?= $bc['title']?></li>
                                        <?php } ?>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>