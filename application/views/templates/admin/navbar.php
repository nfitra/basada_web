<body id="page-top">
  <?php ?>
  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">
      <!-- Sidebar - Brand -->
      <a href="" class="sidebar-brand d-flex align-items-center justify-content-center">
        <div class="sidebar-brand-icon rotate-n-15">
        </div>
        <div class="sidebar-brand-text mx-3">Bank Sampah</div>
      </a>
      <!-- Divider -->
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        <div class="text-white">
          <?= $user->un_name ?>
        </div>
        <div class="text-white">
          <?= $user->r_name ?>
        </div>
      </div>
      <hr class="sidebar-divider">
      <!-- QUERY MENU -->
      <?php
      $role_id = $this->session->userdata('role_id');
      $queryMenu = "SELECT DISTINCT(menus._id), menus.m_name, menus.m_order FROM menus 
                      JOIN sub_menu as sm
                        ON sm.fk_menu = menus._id
                      JOIN role_access_menu as ram
                        ON sm._id = ram.fk_subMenu
                      WHERE ram.fk_role = '$role_id'
                      ORDER BY menus.m_order ASC
                      ";
      $listMenu = $this->db->query($queryMenu)->result();
      // var_dump($listMenu);
      // die;
      ?>

      <?php foreach ($listMenu as $menu) : ?>
        <!-- Heading -->
        <div class="sidebar-heading">
          <?= $menu->m_name ?>
        </div>


        <!-- SUB MENU -->
        <?php
        $menuId = $menu->_id;
        $querySubMenu = " SELECT * FROM sub_menu as sm
                            JOIN role_access_menu as ram
                              ON sm._id = ram.fk_subMenu
                            WHERE ram.fk_role = '$role_id'
                            AND sm.fk_menu = '$menuId'
                            AND sm.sm_isActive = 1
                            ORDER BY sm.sm_order ASC
                          ";
        $listSubMenu = $this->db->query($querySubMenu)->result();
        // var_dump($listSubMenu);
        // die;
        ?>

        <?php foreach ($listSubMenu as $subMenu) : ?>
          <li class="nav-item <?= $subMenu->sm_title == $active ? "active" :  ""; ?>">
            <a class="nav-link" href="<?= base_url($subMenu->sm_url) ?>">
              <i class=" fas fa-fw <?= $subMenu->sm_icon ?> "></i>
              <span><?= $subMenu->sm_title ?></span>
            </a>
          </li>
        <?php endforeach; ?>
        <hr class="sidebar-divider">
      <?php endforeach; ?>

      <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
          <i class="fas fa-fw fa-sign-out-alt"></i>
          <span>Logout</span></a>
      </li>





      <!-- Nav Item - Pages Collapse Menu -->
      <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>Components</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Custom Components:</h6>
            <a class="collapse-item" href="#">Buttons</a>
            <a class="collapse-item" href="#">Cards</a>
          </div>
        </div>
      </li> -->

      <!-- Nav Item - Utilities Collapse Menu -->
      <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-fw fa-wrench"></i>
          <span>Utilities</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Custom Utilities:</h6>
            <a class="collapse-item" href="#">Colors</a>
            <a class="collapse-item" href="#">Borders</a>
            <a class="collapse-item" href="#">Animations</a>
            <a class="collapse-item" href="#">Other</a>
          </div>
        </div>
      </li> -->

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>


            <!-- Nav Item - User Information -->
            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Ada <span id="notif" class="badge badge-danger"></span> Notif</span>
                <i class="fas fw fa-envelope text-gray-700"></i>
              </a>
              <!-- Dropdown - User Information -->
              <div id="notifData" class="dropdown-menu dropdown-menu-right shadow animated--grow-in p-3" aria-labelledby="notifDropdown">
                
            </li>
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $user->un_name ?></span>
                <i class="fas fw fa-user text-gray-700"></i>
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <script>
    fetchData();
    
    function fetchData(){
        // fetch('./API/notifAPI')
        //     .then((res)=>res.json())
        //     .then((data)=>{
        //         displayNotif(data.data);
        //     })
        //     .catch(err => {
        //         console.log(err);
        //     })
        const a = <?= json_encode($requests) ?>;
          displayNotif(a)
    }
    setInterval(()=>{
        fetchData();
    }, 1000 * 60 * 5)
        
    function displayNotif(data) {
        const idNotif = document.getElementById("id-notifData");
        if(idNotif) {
            idNotif.remove();
        }
        const notif = document.getElementById('notif');
        const length = data.length;
        notif.innerHTML = length;
        
        const notifData = document.getElementById('notifData');
        const div = document.createElement("div");
        div.setAttribute("id", "id-notifData");
        notifData.appendChild(div);
        data.map((d)=>{
            const b = document.createElement("b");
            b.innerHTML = d.n_name;
            
            const p = document.createElement("p");
            p.innerHTML = d.j_name + `(${d.n_contact})`;
            
            const divider = document.createElement("div");
            divider.classList.add("dropdown-divider")
            
            div.appendChild(b);
            div.appendChild(p);
            div.appendChild(divider);
            // console.log(d);
            return;
        })
    }
</script>