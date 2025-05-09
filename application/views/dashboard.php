<div class="pagetitle">
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">Dashboard</li>
    </ol>
  </nav>
</div>

<section class="section dashboard">
  <div class="row">

    <div class="col-lg-12">
      <div class="row">

        <div class="col-xxl-4 col-md-4">
          <div class="card info-card siswa-card">

            <div class="card-body">
              <h5 class="card-title">Total Siswa</h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-people"></i>
                </div>
                <div class="ps-3">
                  <h6><?= $jumlah_siswa ?></h6>

                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="col-xxl-4 col-md-4">
          <div class="card info-card tagihan-unpaid-card">

            <div class="card-body">
              <h5 class="card-title">Tagihan Belum Lunas</h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-file-earmark"></i>
                </div>
                <div class="ps-3">
                  <h6><?= $tagihan_belum_lunas ?></h6>

                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="col-xxl-4 col-md-4">
          <div class="card info-card tagihan-paid-card">

            <div class="card-body">
              <h5 class="card-title">Tagihan Sudah Lunas</h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-file-earmark-check"></i>
                </div>
                <div class="ps-3">
                  <h6><?= $tagihan_lunas ?></h6>
                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="col-xxl-4 col-xl-6">

          <div class="card info-card pemasukan-card">

            <div class="card-body">
              <h5 class="card-title">Total Pemasukan</h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-wallet2"></i>
                </div>
                <div class="ps-3">
                  <h6>IDR 12.440.000</h6>

                </div>
              </div>

            </div>
          </div>

        </div>

        <div class="col-xxl-4 col-xl-6">

          <div class="card info-card pengeluaran-card">

            <div class="card-body">
              <h5 class="card-title">Total Pengeluaran</h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-wallet2"></i>
                </div>
                <div class="ps-3">
                  <h6>IDR 6.340.000</h6>

                </div>
              </div>

            </div>
          </div>

        </div>

      </div>
    </div>

  </div>
</section>