<div class="pagetitle">
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">Tagihan</li>
    </ol>
  </nav>
</div>

<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h4 class="card-title mb-0">Daftar Tagihan</h4>
        </div>

        <?php
        $start_date_value = $this->input->get('start_date') ?? '';
        $end_date_value   = $this->input->get('end_date') ?? '';
        ?>

        <!-- Form Filter -->
        <form class="row g-3 mb-4" method="get" action="<?= base_url('tagihan/kepsek') ?>">
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

        <!-- Tabel Tagihan -->
        <div class="table-responsive">
          <table class="table table-hover table-bordered datatable w-100">
            <thead class="table-dark">
              <tr>
                <th>Tanggal</th>
                <th>ID Tagihan</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($tagihan as $row): ?>
              <tr>
                <td><?= date('d-m-Y H:i', strtotime($row->created_at)) ?></td>
                <td><?= htmlspecialchars($row->id_tagihan) ?></td>
                <td><?= htmlspecialchars($row->jenis_tagihan) ?></td>
                <td>Rp <?= number_format($row->jumlah, 0, ',', '.') ?></td>
                <td>
                  <span class="badge text-bg-<?= $row->status == 'lunas' ? 'success' : 'warning' ?>">
                    <?= htmlspecialchars($row->status) ?>
                  </span>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>
</section>

<!-- Script & Plugin -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="//cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  $(document).ready(function () {

    $('#btnCetak').on('click', function () {
      const start = $('#start_date').val();
      const end = $('#end_date').val();

      if (!start || !end) {
        Swal.fire({
          icon: 'warning',
          title: 'Tanggal belum lengkap!',
          text: 'Silakan isi tanggal awal dan akhir terlebih dahulu.',
        });
        return;
      }

      const baseUrl = "<?= base_url('tagihan/laporan') ?>";
      const query = `?start_date=${encodeURIComponent(start)}&end_date=${encodeURIComponent(end)}`;
      window.open(baseUrl + query, '_blank');
    });
  });
</script>
