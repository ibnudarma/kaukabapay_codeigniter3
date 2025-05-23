<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h4 class="card-title mb-0">Daftar Pengeluaran</h4>
          <?php if ($this->session->userdata('role') == 'bendahara') :?>
          <a href="<?= base_url('pengeluaran/tambah') ?>" class="btn btn-success">+ Tambah Pengeluaran</a>
          <?php endif ?>
        </div>

        <?php
        $start_date_value = $this->input->get('start_date') ?? '';
        $end_date_value   = $this->input->get('end_date') ?? '';
        ?>
        <!-- Form Filter -->
        <form class="row g-3 mb-4" method="get" action="<?= base_url('pengeluaran/kepsek') ?>">
        <div class="col-md-3">
            <label for="start_date" class="form-label">Tanggal Awal</label>
            <input type="date" name="start_date" id="start_date" class="form-control"
                value="<?= htmlspecialchars($start_date_value) ?>">
        </div>
        <div class="col-md-3">
            <label for="end_date" class="form-label">Tanggal Akhir</label>
            <input type="date" name="end_date" id="end_date" class="form-control"
                value="<?= htmlspecialchars($end_date_value) ?>">
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary me-2">Filter</button>
        </div>
        <div class="col-md-3 d-flex align-items-end justify-content-end">
            <button type="button" id="btnCetak" class="btn btn-info">Cetak Laporan</button>
        </div>
        </form>

        <!-- Tabel Data -->
        <div class="table-responsive">
          <table class="table table-hover table-bordered datatable w-100">
            <thead class="table-dark">
              <tr>
                <th>Tanggal Pengeluaran</th>
                <th>Jumlah</th>
                <th>Deskripsi</th>
                <?php if ($this->session->userdata('role') == 'bendahara') :?>
                <th>Detail</th>
                <?php endif ?>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($pengeluaran as $row): ?>
                <tr>
                  <td><?= htmlspecialchars($row['tanggal_pengeluaran']) ?></td>
                  <td>Rp <?= number_format($row['jumlah'], 0, ',', '.') ?></td>
                  <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                  <?php if ($this->session->userdata('role') == 'bendahara') :?>
                  <td>
                    <a href="<?= site_url('pengeluaran/detail?id_pengeluaran=' . urlencode($row['id_pengeluaran'])) ?>" class="btn btn-sm btn-primary">Detail</a>
                  </td>
                  <?php endif ?>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>
</section>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
  $(document).ready(function () {
    $('#btnCetak').on('click', function () {
      const startDate = $('#start_date').val();
      const endDate = $('#end_date').val();

      const baseUrl = "<?= base_url('pengeluaran/laporan') ?>";
      const queryString = `?start_date=${encodeURIComponent(startDate)}&end_date=${encodeURIComponent(endDate)}`;
      window.open(baseUrl + queryString, '_blank');
    });
  });
</script>



