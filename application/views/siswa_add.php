<div class="pagetitle">
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">Tambah Siswa</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12 card">
        <div class="card-title">
            <a href="<?= base_url('siswa') ?>" class="btn btn-danger">Batal</a>
        </div>
      <div class="card-body px-3">
        <?php if ($this->session->flashdata('alert')): ?>
          <?= $this->session->flashdata('alert'); ?>
        <?php endif; ?>

    <form action="<?= base_url('siswa/add') ?>" method="post" enctype="multipart/form-data">
          <div class="row mb-3">
            <label for="email" class="col-sm-3 col-form-label">Email</label>
            <div class="col-sm-9">
              <input type="text" name="email" class="form-control" id="email" value="<?= set_value('email') ?>">
            </div>
          </div>

          <div class="row mb-3">
            <label for="password" class="col-sm-3 col-form-label">Password</label>
            <div class="col-sm-9">
              <input type="text" name="password" class="form-control" id="password" value="<?= set_value('password') ?>">
            </div>
          </div>

          <div class="row mb-3">
            <label for="nama" class="col-sm-3 col-form-label">Nama</label>
            <div class="col-sm-9">
              <input type="text" name="nama" class="form-control" id="nama" value="<?= set_value('nama') ?>">
            </div>
          </div>

          <div class="row mb-3">
            <label for="tempat_lahir" class="col-sm-3 col-form-label">Tempat Lahir</label>
            <div class="col-sm-9">
              <input type="text" name="tempat_lahir" class="form-control" id="tempat_lahir" value="<?= set_value('tempat_lahir') ?>">
            </div>
          </div>

          <div class="row mb-3">
            <label for="tanggal_lahir" class="col-sm-3 col-form-label">Tanggal Lahir</label>
            <div class="col-sm-9">
              <input type="date" name="tanggal_lahir" class="form-control" id="tanggal_lahir" value="<?= set_value('tanggal_lahir') ?>">
            </div>
          </div>

          <div class="row mb-3">
            <label for="jenis_kelamin" class="col-sm-3 col-form-label">Jenis Kelamin</label>
            <div class="col-sm-9">
              <select name="jenis_kelamin" class="form-control" id="jenis_kelamin">
                <option value="">-- Pilih Jenis Kelamin --</option>
                <option value="Laki-laki" <?= set_value('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                <option value="Perempuan" <?= set_value('jenis_kelamin') == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
            <div class="col-sm-9">
              <input type="text" name="alamat" class="form-control" id="alamat" value="<?= set_value('alamat') ?>">
            </div>
          </div>

          <div class="row mb-3">
            <label for="nama_orang_tua" class="col-sm-3 col-form-label">Nama Orang Tua</label>
            <div class="col-sm-9">
              <input type="text" name="nama_orang_tua" class="form-control" id="nama_orang_tua" value="<?= set_value('nama_orang_tua') ?>">
            </div>
          </div>

          <div class="row mb-3">
            <label for="kontak_orang_tua" class="col-sm-3 col-form-label">Kontak Orang Tua</label>
            <div class="col-sm-9">
              <input type="text" name="kontak_orang_tua" class="form-control" id="kontak_orang_tua" value="<?= set_value('kontak_orang_tua') ?>">
            </div>
          </div>

          <div class="row mb-3">
            <label for="pekerjaan_orang_tua" class="col-sm-3 col-form-label">Pekerjaan Orang Tua</label>
            <div class="col-sm-9">
              <input type="text" name="pekerjaan_orang_tua" class="form-control" id="pekerjaan_orang_tua" value="<?= set_value('pekerjaan_orang_tua') ?>">
            </div>
          </div>
          <div class="row mb-3">
            <label for="foto" class="col-sm-3 col-form-label">Foto</label>
            <div class="col-sm-9">
              <input type="file" name="foto" class="form-control" id="foto" accept="image/*">
            </div>
          </div>

          <button type="submit" class="btn btn-success">Tambahkan Siswa</button>
        </form>
      </div>
    </div>
  </div>
</section>
