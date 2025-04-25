<div class="pagetitle">
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">Tagihan</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-12 card">
      <h4 class="card-title px-3">Filter</h4>
      <div class="card-body px-3">

      <div class="row">

        <div class="col-md-6 mb-2">
        <form action="<?= base_url('tagihan') ?>">
          <input type="text" class="form-control" name="filter" placeholder="Ketik disini ..." autocomplete="off" required>
        </div>
        
        <div class="col-md-4 mb-2">
          <select class="form-select" name="jenis_filter" aria-label="FilterTagihan" required>
            <option selected value="">Cari Berdasarkan</option>
            <option value="id_tagihan">ID Tagihan</option>
            <option value="nis">NIS Siswa</option>
            <option value="nama">Nama Siswa</option>
            <option value="jenis_tagihan">Jenis Tagihan</option>
          </select>
        </div>
        
        <div class="col-md-2 mb-2">
          <button type="submit" class="btn btn-success h-80 w-100">Cari</button>
        </div>
      </form>
        
        </div>

      </div>
    </div>

    <?php if (count($tagihan) > 0): ?>
        <?php $no = 1; foreach ($tagihan as $row): ?>
      
          <div class="col-12 card p-3">
          <table>
            <tr>
              <td>ID Tagihan</td>
              <td>:</td>
              <td><?= $row->id_tagihan ?></td>
            </tr>
            <tr>
              <td>Nama Siswa</td>
              <td>:</td>
              <td><?= $row->nama ?></td>
            </tr>
            <tr>
              <td>Jenis Tagihan</td>
              <td>:</td>
              <td><?= $row->jenis_tagihan ?></td>
            </tr>
            <tr>
              <td>Jumlah Tagihan</td>
              <td>:</td>
              <td>Rp <?= number_format($row->jumlah, 0, ',', '.') ?></td>
            </tr>
            <tr>
              <td>Status Tagihan</td>
              <td>:</td>
              <td><span class="badge text-bg-<?= $row->status == 'lunas' ? 'success' : 'warning' ?>"><?= $row->status ?></span></td>
            </tr>
            <tr>
              <td class="text-end" colspan="3"><a href="<?= base_url('tagihan/detail/').$row->id_tagihan ?>" class="btn btn-sm btn-secondary">Detail Tagihan</a></td>
            </tr>
          </table>
        </div>

        <?php endforeach; ?>
      <?php else: ?>
        <p colspan="5" class="text-center">Tidak ada data.</p>
      <?php endif; ?>

      <div class="pagination">
          <?= $this->pagination->create_links(); ?>
      </div>


  </div>
</section>