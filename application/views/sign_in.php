<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Kaukabapay | Sign In</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?= base_url() ?>assets/img/logo.png" rel="icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?= base_url() ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url() ?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

</head>

<body>

  <main>
    <div class="container">

      <section class="section min-vh-100 d-flex flex-column align-items-center justify-content-center">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-5 col-md-6 d-flex flex-column align-items-center justify-content-center">
              <div class="card px-3">

                <div class="card-body">

                  <div class="d-flex justify-content-center py-4">
                    <a href="<?= base_url('app/login') ?>" class="logo d-flex align-items-center w-auto">
                    <img src="<?= base_url() ?>assets/img/kaukabapay.png" alt="" width="150px">
                    </a>
                  </div>

                  <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
                  <?php endif; ?>

                  <form action="<?= base_url('app/sign_in') ?>" method="post" class="row g-3">

                    <div class="col-12">
                    <div class="form-floating mb-3">
                    <input type="email" class="form-control <?= form_error('email') ? 'is-invalid' : '' ?>" id="email" name="email" value="<?= set_value('email') ?>" placeholder="name@example.com">
                    <label for="email">Email</label>
                    <div class="invalid-feedback">
                        <?= form_error('email') ?>
                    </div>
                    </div>
                    </div>

                    <div class="col-12">
                    <div class="form-floating">
                    <input type="password" class="form-control <?= form_error('password') ? 'is-invalid' : '' ?>" id="floatingPassword" name="password" placeholder="Password">
                    <label for="floatingPassword">Password</label>
                    <div class="invalid-feedback">
                        <?= form_error('password') ?>
                    </div>
                    </div>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>

                    <div class="col-12">
                    <a href="<?= base_url('app/lupa_password')?>"><p class="small mb-0">Lupa Password </p></a>
                    </div>

                    <div class="col-12 pb-3">
                      <button class="btn btn-success w-100" type="submit">Sign In</button>
                    </div>
                  </form>

                </div>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <script src="<?= base_url() ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <script src="<?= base_url() ?>assets/js/main.js"></script>


</body>

</html>