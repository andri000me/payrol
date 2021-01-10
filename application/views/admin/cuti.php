    <section class="content">
      <div class="container-fluid">
        <!-- Main row -->
        <div class="row">

          <section class="col-lg-12 connectedSortable">

            <!-- Map card -->
            <div class="card">
              <div class="card-header"> <?=$title?> </h3>
                <a style="float: right;" href="<?=base_url('admin/pegawai_add')?>" class="btn btn-sm btn-primary">Tambah data</a>
              </div>
              <div class="card-body table-responsive">
                <table id="myTable" class="table table-bordered table-striped text-center">
                    <thead>
                      <th width="1%">No</th>
                      <th>Nama</th>
                      <th>Waktu Cuti</th>
                      <th>Keterangan</th>
                      <th>Status</th>
                      <th>Opsi</th>
                    </thead>
                    <tbody>
                      <?php $no=1; foreach ($data as $d) { ?>
                      <tr>
                        <td width="1%"><?=$no++?></td>
                        <td><?=ucfirst($d->nama)?></td>
                        <td><?=date('d/m/Y', strtotime($d->mulai))?> - <?=date('d/m/Y', strtotime($d->akhir))?></td>
                        <td><?=ucfirst($d->alasan)?></td>
                        <td><?=ucfirst($d->status)?></td>
                        <td>
                          <?php if ($d->status == 'diajukan') { ?>
                          <a onclick="return confirm('apakah anda yakin ingin menerima pengajuan cuti ini?')" href="<?=base_url('admin/cuti_terima/'.$d->id_cuti)?>" class="btn btn-primary btn-sm"><span class="fa fa-check"></span></a>
                          <a onclick="return confirm('apakah anda yakin ingin menolak pengajuan cuti ini?')" href="<?=base_url('admin/cuti_tolak/'.$d->id_cuti)?>" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></a>
                          <?php } ?>
                           <?php if ($d->status == 'diterima') { ?>
                            <button class="btn btn-primary btn-sm">Anda menerima pengajuan</button>
                          <?php } ?>
                          <?php if ($d->status == 'ditolak') { ?>
                            <button class="btn btn-danger btn-sm">Anda menolak pengajuan</button>
                          <?php } ?>
                        </td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
              </div>
            </div>
          </section>
        </div>
      </div>
    </section>