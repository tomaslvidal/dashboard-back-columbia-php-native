<div class="collapse navbar-collapse" id="navbarResponsive">
  <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="" data-original-title="Usuarios">
      <a class="nav-link" href="<?=$dir_?>users/list.php">
        <i class="fa fa-window-maximize"></i>

        <span class="nav-link-text">Usuarios</span>
      </a>
    </li>

    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="" data-original-title="Destinos">
      <a class="nav-link" href="<?=$dir_?>destinations/list.php">
        <i class="fa fa-window-maximize"></i>

        <span class="nav-link-text">Destinos</span>
      </a>
    </li>

    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="" data-original-title="Vouchers">
      <a class="nav-link" href="<?=$dir_?>vouchers/list.php">
        <i class="fa fa-window-maximize"></i>

        <span class="nav-link-text">Vouchers</span>
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
          <i class="fa fa-fw fa-sign-out"></i>

          Cerrar Sesión
        </a>
    </li>
  </ul>
</div>
