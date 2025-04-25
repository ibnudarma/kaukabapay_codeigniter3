<aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

  <li class="nav-item">
    <a class="nav-link <?= current_url() == base_url('app/dashboard') ? '' : 'collapsed' ?>" href="<?= base_url('app/dashboard') ?>">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link <?= current_url() == base_url('app/tagihan') ? '' : 'collapsed' ?>" href="<?= base_url('tagihan') ?>">
    <i class="bi bi-receipt"></i>
      <span>Tagihan</span>
    </a>
  </li>

  <li class="nav-heading">More menu</li>

  <li class="nav-item">
    <a class="nav-link collapsed" href="<?= base_url() ?>">
      <i class="bi bi-question-circle"></i>
      <span>Bantuan</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link collapsed" href="<?= base_url('app/signout') ?>">
    <i class="bi bi-box-arrow-right"></i>
      <span>Sign Out</span>
    </a>
  </li>

</ul>

</aside><!-- End Sidebar-->