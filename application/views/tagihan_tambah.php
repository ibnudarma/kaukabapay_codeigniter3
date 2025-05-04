<div class="pagetitle">
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">Tambah Tagihan</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12 card">
        <h4 class="card-title px-3">Tambah Tagihan</h4>
        <div class="card-body px-3">
        <?php if ($this->session->flashdata('alert')): ?>
            <?= $this->session->flashdata('alert'); ?>
        <?php endif; ?>
            <form action="<?= base_url('tagihan/simpan') ?>" method="post">

                <div class="row mb-3">
                    <label for="jenis_tagihan" class="col-sm-2 col-form-label">Jenis Tagihan</label>
                    <div class="col-sm-10">
                    <input type="text" name="jenis_tagihan" class="form-control" id="jenis_tagihan">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="jumlah_tagihan" class="col-sm-2 col-form-label">Jumlah Tagihan</label>
                    <div class="col-sm-10">
                    <input type="text" name="jumlah_tagihan" class="form-control" id="jumlah_tagihan">
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Tambahkan Tagihan</button>
                </form>

        </div>
    </div>
  </div>
</section>