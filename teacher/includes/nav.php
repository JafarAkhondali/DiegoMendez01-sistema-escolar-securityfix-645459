<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
  <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="https://randomuser.me/api/portraits/men/1.jpg" alt="User Image">
    <div>
      <p class="app-sidebar__user-name"><?php echo $_SESSION['name']; ?></p>
      <p class="app-sidebar__user-designation">Profesor</p>
    </div>
  </div>
  <ul class="app-menu">
    <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fas fa-laptop"></i><span class="app-menu__label">UI Elements</span><i class="treeview-indicator bi bi-chevron-right"></i></a>
      <ul class="treeview-menu">
        <li><a class="treeview-item" href="#"><i class="icon fas fa-circle"></i> Bootstrap Elements</a></li>
        <li><a class="treeview-item" href="#" target="_blank" rel="noopener"><i class="icon fas fa-circle"></i> Font Icons</a></li>
        <li><a class="treeview-item" href="#"><i class="icon fas fa-circle"></i> Cards</a></li>
        <li><a class="treeview-item" href="#"><i class="icon fas fa-circle"></i> Widgets</a></li>
      </ul>
    </li>
    <li><a class="app-menu__item" href="../logout.php"><i class="app-menu__icon fas fa-sign-out-alt"></i><span
    class="app-menu__label">Logout</span></a></li>
  </ul>
</aside>