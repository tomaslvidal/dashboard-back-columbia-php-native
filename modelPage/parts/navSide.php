<div class="collapse navbar-collapse" id="navbarResponsive">
  <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Users">
      <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseUsers">
        <i class="fa fa-user-circle"></i>
        <span class="nav-link-text">Usuarios</span>
      </a>
      <ul class="sidenav-second-level collapse" id="collapseUsers">
        <li>
          <a href="<?=$dir_?>users/list.php">Listado</a>
        </li>
        <li>
          <a href="<?=$dir_?>users/add.php">Agregar</a>
        </li>
      </ul>
    </li>
    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Companies">
      <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseCompanies">
        <i class="fa fa-building"></i>
        <span class="nav-link-text">Empresas</span>
      </a>
      <ul class="sidenav-second-level collapse" id="collapseCompanies">
        <li>
          <a href="<?=$dir_?>companies/list.php">Listado</a>
        </li>
        <li>
          <a href="<?=$dir_?>companies/add.php">Agregar</a>
        </li>
      </ul>
    </li>

    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="packages">
      <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapsePackages">
        <i class="fa fa-archive"></i>
        <span class="nav-link-text">Paquetes</span>
      </a>
      <ul class="sidenav-second-level collapse" id="collapsePackages">
        <li>
          <a href="<?=$dir_?>packages/list.php">Listado</a>
        </li>
        <li>
          <a href="<?=$dir_?>packages/add.php">Agregar</a>
        </li>
      </ul>
    </li>

    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="" data-original-title="categories">
      <a class="nav-link" href="<?=$dir_?>categories/list.php">
        <i class="fa fa-window-maximize"></i>
        <span class="nav-link-text">Categorías</span>
      </a>
    </li>

    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="" data-original-title="subcategories" title="subcategories">
      <a class="nav-link" href="<?=$dir_?>subcategories/list.php">
        <i class="fa fa-window-restore"></i>
        <span class="nav-link-text">Subcategorías</span>
      </a>
    </li>

  </ul>
  <ul class="navbar-nav sidenav-toggler">
    <li class="nav-item">
      <a class="nav-link text-center" id="sidenavToggler">
        <i class="fa fa-fw fa-angle-left"></i>
      </a>
    </li>
  </ul>
  <ul class="navbar-nav ml-auto">
    <li class="nav-item">
      <a class="nav-link" data-toggle="modal" data-target="#logoutModal">
        <i class="fa fa-fw fa-sign-out"></i>Cerrar Sesión</a>
    </li>
  </ul>
</div>
