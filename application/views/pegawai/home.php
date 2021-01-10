

    <section class="content">
      <div class="container-fluid">
        <!-- Main row -->
        <div class="row">

          <section class="col-lg-6 connectedSortable">

            <!-- Map card -->
            <div class="card">
              <div class="card-header"> Notifikasi </h3>
              </div>
               <div class="card-body">
                  <?php if ($waktu != 'dilarang') { ?>
                  <p class="text-center">Hai, <b><?=$this->session->userdata('nama')?></b> anda hari ini belum melakukan absen. Silahkan lakukan absen pada tombol absen berikut <br><br><a class="btn btn-primary" href="<?=base_url('pegawai/proses_absen')?>">Absen <?=$waktu?></a></p>
                  <?php }else{ ?>
                  <p class="text-center">Hai, <b><?=$this->session->userdata('nama')?></b> anda hari ini sudah melakukan absensi </p>
                  <?php }  ?>
                </div>
            </div>
          </section>

          <section class="col-lg-6 connectedSortable">

            <!-- Map card -->
            <div class="card">
              <div class="card-header"> Slip Gaji </h3>
              </div>
               <div class="card-body">
                  
                  <p class="text-center">Hai, <b><?=$this->session->userdata('nama')?></b> silahkan download slip gaji anda pada tombol berikut <br><br><a class="btn btn-info" href="<?=base_url('pegawai/slip')?>">Download Slip Gaji</a></p>
                </div>
            </div>
          </section>

        </div>
      </div>
    </section>
    
          