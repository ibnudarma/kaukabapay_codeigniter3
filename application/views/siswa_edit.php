<section class="section">
  <div class="row">
    <div class="col-lg-12 card">
      <div class="card-title mx-3 mt-3">
        <a href="<?= base_url('siswa') ?>" class="btn btn-danger">Batal</a>
      </div>
      <div class="card-body px-3">
        <?php if ($this->session->flashdata('alert')): ?>
          <?= $this->session->flashdata('alert'); ?>
        <?php endif; ?>

        <form action="<?= base_url('siswa/update?nis=' . $siswa['nis']) ?>" method="post" enctype="multipart/form-data">
          
          <!-- Email -->
          <div class="row mb-3">
            <label for="email" class="col-sm-3 col-form-label">Email</label>
            <div class="col-sm-9">
              <input type="email" name="email" class="form-control" id="email"
                value="<?= set_value('email', $siswa['email']) ?>">
            </div>
          </div>

          <!-- Password -->
          <div class="row mb-3">
            <label for="password" class="col-sm-3 col-form-label">Password (Opsional)</label>
            <div class="col-sm-9">
              <input type="password" name="password" class="form-control" id="password"
                placeholder="Kosongkan jika tidak ingin mengganti">
            </div>
          </div>

          <!-- Nama -->
          <div class="row mb-3">
            <label for="nama" class="col-sm-3 col-form-label">Nama</label>
            <div class="col-sm-9">
              <input type="text" name="nama" class="form-control" id="nama"
                value="<?= set_value('nama', $siswa['nama']) ?>">
            </div>
          </div>

          <!-- Tempat Lahir -->
          <div class="row mb-3">
            <label for="tempat_lahir" class="col-sm-3 col-form-label">Tempat Lahir</label>
            <div class="col-sm-9">
              <input type="text" name="tempat_lahir" class="form-control" id="tempat_lahir"
                value="<?= set_value('tempat_lahir', $siswa['tempat_lahir']) ?>">
            </div>
          </div>

          <!-- Tanggal Lahir -->
          <div class="row mb-3">
            <label for="tanggal_lahir" class="col-sm-3 col-form-label">Tanggal Lahir</label>
            <div class="col-sm-9">
              <input type="date" name="tanggal_lahir" class="form-control" id="tanggal_lahir"
                value="<?= set_value('tanggal_lahir', $siswa['tanggal_lahir']) ?>">
            </div>
          </div>

          <!-- Jenis Kelamin -->
          <div class="row mb-3">
            <label for="jenis_kelamin" class="col-sm-3 col-form-label">Jenis Kelamin</label>
            <div class="col-sm-9">
              <select name="jenis_kelamin" class="form-control" id="jenis_kelamin">
                <option value="">-- Pilih Jenis Kelamin --</option>
                <option value="Laki-laki" <?= set_select('jenis_kelamin', 'Laki-laki', $siswa['jenis_kelamin'] == 'Laki-laki') ?>>Laki-laki</option>
                <option value="Perempuan" <?= set_select('jenis_kelamin', 'Perempuan', $siswa['jenis_kelamin'] == 'Perempuan') ?>>Perempuan</option>
              </select>
            </div>
          </div>

          <!-- Alamat -->
          <div class="row mb-3">
            <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
            <div class="col-sm-9">
              <input type="text" name="alamat" class="form-control" id="alamat"
                value="<?= set_value('alamat', $siswa['alamat']) ?>">
            </div>
          </div>

          <!-- Nama Orang Tua -->
          <div class="row mb-3">
            <label for="nama_orang_tua" class="col-sm-3 col-form-label">Nama Orang Tua</label>
            <div class="col-sm-9">
              <input type="text" name="nama_orang_tua" class="form-control" id="nama_orang_tua"
                value="<?= set_value('nama_orang_tua', $siswa['nama_orang_tua']) ?>">
            </div>
          </div>

          <!-- Kontak Orang Tua -->
          <div class="row mb-3">
            <label for="kontak_orang_tua" class="col-sm-3 col-form-label">Kontak Orang Tua</label>
            <div class="col-sm-9">
              <input type="text" name="kontak_orang_tua" class="form-control" id="kontak_orang_tua"
                value="<?= set_value('kontak_orang_tua', $siswa['kontak_orang_tua']) ?>">
            </div>
          </div>

          <!-- Pekerjaan Orang Tua -->
          <div class="row mb-3">
            <label for="pekerjaan_orang_tua" class="col-sm-3 col-form-label">Pekerjaan Orang Tua</label>
            <div class="col-sm-9">
              <input type="text" name="pekerjaan_orang_tua" class="form-control" id="pekerjaan_orang_tua"
                value="<?= set_value('pekerjaan_orang_tua', $siswa['pekerjaan_orang_tua']) ?>">
            </div>
          </div>

          <!-- Foto -->
          <div class="row mb-3">
            <label for="foto" class="col-sm-3 col-form-label">Foto</label>
            <div class="col-sm-9">
              <input type="file" name="foto" class="form-control" id="foto" accept="image/*">
              <?php if (!empty($siswa['foto'])): ?>
                <div class="mt-2">
                  <img src="<?= base_url('uploads/foto/' . $siswa['foto']) ?>" alt="Foto Siswa" width="100">
                  <br><small class="text-muted">Biarkan kosong jika tidak ingin mengganti</small>
                </div>
              <?php endif; ?>
            </div>
          </div>

          <button type="submit" class="btn btn-primary">Update Siswa</button>
        </form>
      </div>
    </div>
  </div>
</section>
