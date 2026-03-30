  <!-- ================= Sidebar ================= -->
  <ul class="navbar-nav bg-primary sidebar sidebar-dark">

    <!-- Logo -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center"
       href="index.php">

      <div class="sidebar-brand-icon">
        <img src="assets/images/logo.png" width="40" alt="Logo">
      </div>

      <div class="sidebar-brand-text mx-2 font-weight-bold">
        SE ADMIN
      </div>

    </a>

    <hr class="sidebar-divider">

    <li class="nav-item <?= ($activePage=="dashboard") ? "active" : "" ?>">
        <a class="nav-link" href="index.php">Dashboard</a>
    </li>


    <li class="nav-item <?= ($activePage=="orders") ? "active" : "" ?>">
      <a class="nav-link" href="orders.php">Orders</a>
    </li>

    <li class="nav-item <?= ($activePage=="packages") ? "active" : "" ?>">
      <a class="nav-link" href="packages.php">Packages</a>
    </li>

    <li class="nav-item <?= ($activePage=="games") ? "active" : "" ?>">
      <a class="nav-link" href="games.php">Games</a>
    </li>
    <li class="nav-item <?= ($activePage=="transactions") ? "active" : "" ?>">
      <a class="nav-link" href="transactions.php">Transactions</a>
    </li>
    <li class="nav-item <?= ($activePage=="rewards") ? "active" : "" ?>">
      <a class="nav-link" href="rewards.php">Rewards</a>
    </li>
    <!-- Logout Trigger -->
    <li class="nav-item">
      <a class="nav-link"
        href="#"
        data-toggle="modal"
        data-target="#logoutModal">
        Logout
      </a>
    </li>

  </ul>
  
  <!-- ============== End Sidebar ============== -->