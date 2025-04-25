<?php include('layouts/head.php'); ?>

<body>

    <?php include('layouts/header.php') ?>
    
    <!-- ======= Sidebar ======= -->
    <?php include('layouts/sidebar.php') ?>


  <main id="main" class="main">
    <?php $this->load->view($content); ?>
  </main>

  <?php include('layouts/footer.php'); ?>

</body>

</html>