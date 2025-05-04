<div class="pagetitle">
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">Profile</li>
    </ol>
  </nav>
</div>

<section class="section">
    <div class="card p-5">
        <div class="row mb-3">
            <label for="nip" class="col-sm-2 col-form-label">NIP</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" id="nip" value="<?= $user->nip ?>" disabled>
            </div>
        </div>
        <div class="row mb-3">
            <label for="nama_lengkap" class="col-sm-2 col-form-label">Nama Lengkap</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" id="nama_lengkap" value="<?= $user->nama ?>" disabled>
            </div>
        </div>
    </div>
</section>