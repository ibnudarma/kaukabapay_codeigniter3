<section class="section">
<a href="<?= base_url('pengeluaran') ?>" class="btn btn-danger mb-3">Batal</a>
  <div class="row">
    <div class="col-lg-12 card">
      <h4 class="card-title px-3">Tambah Pengeluaran</h4>
      <div class="card-body px-3">
        <?php if ($this->session->flashdata('alert')): ?>
          <?= $this->session->flashdata('alert'); ?>
        <?php endif; ?>
        <form action="<?= base_url('pengeluaran/simpan') ?>" method="post">
          <div class="row mb-3">
            <label for="jumlah" class="col-sm-2 col-form-label">Jumlah</label>
            <div class="col-sm-10">
              <input type="number" name="jumlah" class="form-control" id="jumlah" required>
            </div>
          </div>
          <div class="row mb-3">
            <label for="deskripsi" class="col-sm-2 col-form-label">Keterangan</label>
            <div class="col-sm-10">
              <textarea class="form-control" placeholder="keterangan pengeluaran..." id="deskripsi" name="deskripsi" required></textarea>
            </div>
          </div>
          <button type="submit" class="btn btn-success">Tambahkan</button>
        </form>
      </div>
    </div>
  </div>
</section>
