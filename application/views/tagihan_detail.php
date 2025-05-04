<div class="pagetitle">
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">Tagihan Detail</li>
    </ol>
  </nav>
</div>

<a href="<?= base_url('tagihan') ?>" class="btn btn-danger mb-3">Kembali</a>

<section class="section">
  <div class="row">
    <div class="col-lg-12 card">
        <h4 class="card-title px-3">Detail Tagihan</h4>
        <div class="card-body px-3">

            <div class="row mb-3">
                <label for="id_tagihan" class="col-sm-2 col-form-label">ID Tagihan</label>
                <div class="col-sm-10">
                <input type="text" name="id_tagihan" class="form-control" id="id_tagihan" value="<?= $tagihan->id_tagihan ?>" readonly>
                </div>
            </div>
            
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Nama Siswa</label>
                <div class="col-sm-10">
                    <input type="text"  class="form-control" value="<?= $tagihan->nama ?>" readonly>
                </div>
            </div>

            <div class="row mb-3">
                <label for="jenis_tagihan" class="col-sm-2 col-form-label">Jenis Tagihan</label>
                <div class="col-sm-10">
                <input type="text" name="jenis_tagihan" class="form-control" id="jenis_tagihan" value="<?= $tagihan->jenis_tagihan ?>" readonly>
                </div>
            </div>

            <div class="row mb-3">
                <label for="jumlah" class="col-sm-2 col-form-label">Jumlah Tagihan</label>
                <div class="col-sm-10">
                <input type="text" name="jumlah" class="form-control" id="jumlah" value="Rp. <?= $tagihan->jumlah ?>" readonly>
                </div>
            </div>

            <div class="row mb-3">
                <label for="dibayar" class="col-sm-2 col-form-label">Pembayaran</label>
                <div class="col-sm-10">
                <input type="text" name="dibayar" class="form-control" id="dibayar" value="Rp. <?= $tagihan->dibayar ?>" readonly>
                </div>
            </div>

            <div class="row mb-3">
                <label for="sisa_tagihan" class="col-sm-2 col-form-label">Sisa Tagihan</label>
                <div class="col-sm-10">
                <input type="text" name="sisa_tagihan" class="form-control" id="sisa_tagihan" value="Rp. <?= $tagihan->sisa_tagihan ?>" readonly>
                </div>
            </div>

            <div class="row mb-3">
                <label for="status" class="col-sm-2 col-form-label">Status Tagihan</label>
                <div class="col-sm-10">
                    <span class="badge text-bg-<?= $tagihan->status == 'lunas' ? 'success' : 'warning' ?>"><?= $tagihan->status ?></span>
                </div>
            </div>

        </div>
    </div>
  </div>
</section>