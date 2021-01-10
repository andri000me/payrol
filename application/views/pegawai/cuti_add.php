    <section class="content">
      <div class="container-fluid">
        <!-- Main row -->
        <div class="row">

          <section class="col-lg-12 connectedSortable">
            <form method="post" action="<?=base_url('pegawai/cuti_simpan')?>">
            <!-- Map card -->
            <div class="card">
              <div class="card-header"> <?=$title?> </h3>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label>Mulai Cuti</label>
                  <input type="date" name="mulai" class="form-control" required="">
                </div>
                <div class="form-group">
                  <label>Selesai Cuti</label>
                  <input type="date" name="akhir" class="form-control" required="">
                </div>
                <div class="form-group">
                  <label>Alasan Cuti</label>
                  <textarea class="form-control" required="" name="alasan"></textarea>
                </div>
              </div>
              <div class="card-footer">
                <a href="<?=base_url('pegawai/curi')?>" class="btn btn-danger">Kembali</a>
                <button class="btn btn-primary">Simpan</button>
              </div>
            </div>
            </form>
          </section>
        </div>
      </div>
    </section>