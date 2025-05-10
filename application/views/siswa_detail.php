<div class="pagetitle">
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">Detail Siswa</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12 card">
      <div class="card-title">
        <a href="<?= base_url('siswa') ?>" class="btn btn-secondary">Kembali</a>
      </div>
      <div class="card-body px-3">

        <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Foto</label>
          <div class="col-sm-9">
            <img src="<?= base_url('uploads/foto/' . ($siswa['foto'] ?: 'default.png')) ?>" 
                 class="img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Email</label>
          <div class="col-sm-9">
            <p class="form-control-plaintext"><?= htmlspecialchars($siswa['email']) ?></p>
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Nama</label>
          <div class="col-sm-9">
            <p class="form-control-plaintext"><?= htmlspecialchars($siswa['nama']) ?></p>
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Tempat Lahir</label>
          <div class="col-sm-9">
            <p class="form-control-plaintext"><?= htmlspecialchars($siswa['tempat_lahir']) ?></p>
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Tanggal Lahir</label>
          <div class="col-sm-9">
            <p class="form-control-plaintext"><?= htmlspecialchars($siswa['tanggal_lahir']) ?></p>
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Jenis Kelamin</label>
          <div class="col-sm-9">
            <p class="form-control-plaintext"><?= htmlspecialchars($siswa['jenis_kelamin']) ?></p>
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Alamat</label>
          <div class="col-sm-9">
            <p class="form-control-plaintext"><?= htmlspecialchars($siswa['alamat']) ?></p>
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Nama Orang Tua</label>
          <div class="col-sm-9">
            <p class="form-control-plaintext"><?= htmlspecialchars($siswa['nama_orang_tua']) ?></p>
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Kontak Orang Tua</label>
          <div class="col-sm-9">
            <p class="form-control-plaintext"><?= htmlspecialchars($siswa['kontak_orang_tua']) ?></p>
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Pekerjaan Orang Tua</label>
          <div class="col-sm-9">
            <p class="form-control-plaintext"><?= htmlspecialchars($siswa['pekerjaan_orang_tua']) ?></p>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
