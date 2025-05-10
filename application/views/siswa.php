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
                    <a href="<?= site_url('siswa/detail?nis=' . urlencode($row['nis'])) ?>" class="btn btn-sm btn-primary">Lihat</a>
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