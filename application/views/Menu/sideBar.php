<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li class="text-center">
              <!-- <h4><a href="#"><i class="fa fa-user fa-fw"></i><?=$this->session->userdata('omdi-username')?></a></h4> -->
              <h4><i class="fa fa-user fa-fw"></i><?=$this->session->userdata('omdi-username')?></h4>
            </li>
            <li>
                <a href="<?=base_url()?>"><i class="fa fa-bar-chart-o fa-fw"></i> Dasbor</a>
            </li>
            <li>
                <a href="<?=base_url('jadwal')?>"><i class="fa fa-table fa-fw"></i> Jadwal Pertandingan</a>
                <!-- <a href="<?=base_url()?>"><i class="fa fa-table fa-fw"></i> Jadwal Pertandingan</a> -->
            </li>
            <li>
                <a href="<?=base_url('medali')?>"><i class="fi fi-medal fi-fw"></i> Medali</a>
            </li>
            <li>
                <a href="<?=base_url('berita')?>"><i class="fa fa-bullhorn fa-fw"></i> Berita</a>
            </li>
            <li>
                <a href="<?=base_url('lokasi')?>"><i class="fa fa-map-marker fa-fw"></i> Lokasi</a>
            </li>
            <?php if ($this->session->userdata('omdi-dev')): ?>
              <li>
                  <a href="<?=base_url('cabor')?>"><i class="fa fa-dribbble fa-fw"></i> Cabang Olahraga</a>
              </li>
            <?php endif; ?>
            <li>
                <a href="<?=base_url('pk')?>"><i class="fa fa-flag fa-fw"></i> Program Keahlian</a>
            </li>
            <li>
                <a href="<?=base_url('saran')?>"><i class="fa fa-comments fa-fw"></i> Kritik & Saran</a>
            </li>
            <li>
              <a href="<?=base_url("logout")?>"><i class="fa fa-sign-out fa-fw"></i> Keluar</a>
            </li>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->
</nav>
