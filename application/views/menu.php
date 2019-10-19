
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <span class="brand-text font-weight-light">Nama Toko</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image" style="padding-left: .5rem;">
          <img style="width: 3.1rem;" src="<?php echo base_url(); ?>app-assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $nama; ?></a>
          <small><a href="#" class="d-block"><?php echo $email; ?> </a></small>
        </div>
        
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link ">
              <p>
                Master
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>barang" class="nav-link">
                  <p>Barang</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="" class="nav-link">
                  <p>Suppliyer</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="" class="nav-link">
                  <p>Menu 3</p>
                </a>
              </li>
            </ul>
          </li>
          
          <li class="nav-header">Actions</li>
          <li class="nav-item">
            <a href="<?php echo base_url(); ?>new_member" class="nav-link">
              <p>New Member</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <p>Change Password</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url(); ?>home/logout"  class="nav-link">
              <p>Logout</p>
            </a>
          </li>
    
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>