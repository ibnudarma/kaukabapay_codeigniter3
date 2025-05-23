<section class="section">
    <a href="<?= base_url('pengeluaran') ?>" class="btn btn-secondary mb-3">Kembali</a>
  <div class="row">
    <div class="col-lg-12">
      <div class="card p-4">
        <h4 class="card-title mb-4">Detail Pengeluaran</h4>

        <form action="<?= base_url('pengeluaran/update') ?>" method="post">
          <input type="hidden" name="id_pengeluaran" value="<?= htmlspecialchars($pengeluaran['id_pengeluaran']) ?>">

          <div class="mb-3">
            <label for="tanggal_pengeluaran" class="form-label">Tanggal Pengeluaran</label>
            <input type="datetime-local" class="form-control" id="tanggal_pengeluaran" name="tanggal_pengeluaran" 
              value="<?= date('Y-m-d\TH:i', strtotime($pengeluaran['tanggal_pengeluaran'])) ?>" required>
          </div>

          <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" class="form-control" id="jumlah" name="jumlah" min="0" step="1000" value="<?= htmlspecialchars($pengeluaran['jumlah']) ?>" required>
          </div>

          <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required><?= htmlspecialchars($pengeluaran['deskripsi']) ?></textarea>
          </div>

              <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
              <button type="button" class="btn btn-danger" id="btnDelete">Delete</button>
        </form>

      </div>
    </div>
  </div>
</section>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  $(document).ready(function() {
    $('#btnDelete').click(function() {
      Swal.fire({
        title: 'Konfirmasi',
        text: "Apakah Anda yakin ingin menghapus pengeluaran ini?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "<?= base_url('pengeluaran/delete/' . urlencode($pengeluaran['id_pengeluaran'])) ?>";
        }
      });
    });
  });
</script>
