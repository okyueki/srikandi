<div class="vertical-menu">

    <div data-simplebar class="h-100">
    
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">Menu</li>

                <li>
                    <a href="{{ route('dashboard'); }}">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="index.html">
                        <i data-feather="inbox"></i>
                        <span data-key="t-suratmasuk">Surat Masuk</span>
                    </a>
                </li>

                <li>
                    <a href="index.html">
                        <i data-feather="mail"></i>
                        <span data-key="t-suratmasuk">Surat Keluar</span>
                    </a>
                </li>

                <li class="menu-title" data-key="t-menu">Data Pengajuan Libur</li>
                <li>
                    <a href="{{ route('verifikasi_pengajuan_libur.index'); }}">
                        <i data-feather="check-square"></i>
                        <span data-key="t-suratmasuk">Verif. Pengajuan Libur</span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                    <i data-feather="send"></i>
                        <span data-key="t-pengajuancuti">Pengajuan Libur</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('ijin.index'); }}">
                                <span data-key="t-ijin">Ijin</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('cuti.index'); }}">
                                <span data-key="t-cuti">Cuti</span>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="menu-title" data-key="t-menu">Data Pengajuan Lembur</li>
                <li>
                    <a href="{{ route('verifikasi_pengajuan_lembur.index'); }}">
                        <i data-feather="check-square"></i>
                        <span data-key="t-suratmasuk">Verif. Pengajuan Lembur</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pengajuan_lembur.index'); }}">
                        <i data-feather="list"></i>
                        <span data-key="t-suratmasuk">Pengajuan Lemburxxxxxx</span>
                    </a>
                </li>
            
                <li class="menu-title" data-key="t-menu">Settings</li>
                <li>
                    <a href="{{ route('sifat_surat.index'); }}">
                        <i data-feather="archive"></i>
                        <span data-key="t-sifatsurat">Sifat Surat</span>
                    </a>
                </li>
             
                <li>
                    <a href="{{ route('users.index'); }}">
                        <i data-feather="users"></i>
                        <span data-key="t-users">Users</span>
                    </a>
                </li>
                
                <li>
                    <a href="{{ route('klasifikasi_surat.index'); }}">
                        <i data-feather="at-sign"></i>
                        <span data-key="t-klasifikasi">Klasifikasi Surat</span>
                    </a>
                </li>
             
                <li>
                    <a href="{{ route('struktur_organisasi.index'); }}">
                        <i data-feather="command"></i>
                        <span data-key="t-klasifikasi">Struktur Organisasi</span>
                    </a>
                </li>
                
                <li>
                    <a href="{{ route('kamar_inap.index'); }}">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard">Kamar Inap</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>