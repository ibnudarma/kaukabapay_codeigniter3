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

    <?php if (count($tagihan) > 0): ?>
        <?php $no = 1; foreach ($tagihan as $row): ?>
      
          <div class="col-12 card p-3">
          <table>
            <tr>
              <td>ID Tagihan</td>
              <td>:</td>
              <td><?= $row->id_tagihan ?></td>
            </tr>
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
            <?php if($row->status !== 'lunas') :?>
            <tr>
              <td class="text-end" colspan="3"><a href="<?= base_url('tagihan/bayar/').$row->id_tagihan ?>" target="_blank" class="btn btn-success">Bayar Tagihan</a></td>
            </tr>
            <?php else :?>
            <tr>
              <td class="text-end" colspan="3"><a href="<?= base_url('pembayaran/cetak/').$row->id_pembayaran ?>" target="_blank" class="btn btn-secondary">Cetak Bukti Pembayaran</a></td>
            </tr>
            <?php endif ?>
          </table>
        </div>

        <?php endforeach; ?>
      <?php else: ?>
        <p colspan="5" class="text-center">Tidak ada data.</p>
      <?php endif; ?>

  </div>
</section>