<section class="section">
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
                    <input type="text" name="jumlah" class="form-control" id="jumlah">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="deskripsi" class="col-sm-2 col-form-label">Keterangan</label>
                    <div class="col-sm-10">
                    <textarea class="form-control" placeholder="keterangan pengeluaran..." id="deskripsi" name="deskripsi"></textarea>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Tambahkan</button>
                </form>

        </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="row">
    <div class="col-lg-12 card p-3">
            <table class="table datatable">
            <thead>
                <tr>
                    <th data-type="date" data-format="YYYY/DD/MM">Tanggal Pengeluaran</th>
                    <th>Jumlah</th>
                    <th>Deskripsi</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($pengeluaran as $row) : ?>
            <tr>
                <td><?= htmlspecialchars($row['tanggal_pengeluaran']) ?></td>
                <td><?= htmlspecialchars($row['jumlah']) ?></td>
                <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                <td>
                    <a href="<?= site_url('pengeluaran/detail?id_pengeluaran=' . urlencode($row['id_pengeluaran'])) ?>" class="btn btn-sm btn-primary">Detail</a>
                </td>
            </tr>
        <?php endforeach; ?>
            </tbody>
            </table>
    </div>
  </div>
</section>