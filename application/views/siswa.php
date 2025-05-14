    <div class="pagetitle">
      <h1>Data Siswa</h1>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <a href="<?= base_url('siswa/create') ?>" class="btn btn-primary">Tambah Siswa</a>
                </div>

            <table class="table datatable">
            <thead>
                <tr>
                <th>Foto</th>
                <th>NIS</th>
                <th>Nama</th>
                <th data-type="date" data-format="YYYY/DD/MM">Tanggal Lahir</th>
                <th>Detail</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($siswa as $row) : ?>
            <tr class="text-center">
                <td>
                    <?php
                        $foto = !empty($row['foto']) && file_exists(FCPATH . 'uploads/foto/' . $row['foto']) 
                                ? base_url('uploads/foto/' . $row['foto']) 
                                : base_url('uploads/foto/default.jpg');
                    ?>
                    <img src="<?= $foto ?>" alt="Foto Siswa" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                </td>
                <td><?= htmlspecialchars($row['nis']) ?></td>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['tanggal_lahir']) ?></td>
                <td>
                  <!-- Example single danger button -->
                  <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                      Aksi
                    </button>
                    <ul class="dropdown-menu">
                      <li>
                        <a class="dropdown-item" href="<?= site_url('siswa/detail?nis=' . urlencode($row['nis'])) ?>">
                          <i class="bi bi-eye"></i> lihat
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="<?= site_url('siswa/edit/' . urlencode($row['nis'])) ?>">
                          <i class="bi bi-pencil"></i> Edit
                        </a>
                      </li>
                      <li>
                        <a href="#" class="dropdown-item btn-delete" data-nis="<?= $row['nis'] ?>">
                          <i class="bi bi-trash"></i> Delete
                        </a>
                      </li>
                    </ul>
                  </div>
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

    <!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const deleteButtons = document.querySelectorAll(".btn-delete");

    deleteButtons.forEach(button => {
        button.addEventListener("click", function (e) {
            e.preventDefault();
            const nis = this.getAttribute("data-nis");

            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Data siswa akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect ke controller untuk hapus
                    window.location.href = "<?= site_url('siswa/delete/') ?>" + encodeURIComponent(nis);
                }
            });
        });
    });
});
</script>

<script>
  <?php if ($this->session->flashdata('alert_swal')): ?>
    Swal.fire({
      icon: 'success',
      title: 'Sukses!',
      text: '<?= $this->session->flashdata('alert_swal') ?>',
      showConfirmButton: false,
      timer: 2000
    });
  <?php endif; ?>
</script>
