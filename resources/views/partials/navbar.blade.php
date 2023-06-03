<nav class="navbar bg-body-tertiary fixed-top" style="background-color: #2f4f4f;box-shadow: 0 4px 8px 0 rgba(0,0,0,.2)">
    <div class="container-fluid">
        <a class="navbar-brand" href="/dashboard" style="margin-left:auto;margin-right:auto">
            <h4 style="font-stretch:expanded;font-family: vogue,sans-serif;font-weight: 300">SISTEM INFORMASI TOKO BUKU
                GULLIVER</h4>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse">
            Hello
        </div>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                @guest()
                    <h5 class="offcanvas-title me-auto ms-auto" id="offcanvasNavbarLabel"> &ensp; Guest</h5>
                @endguest
                @auth()
                    <div class="logoutContainer">
                        <form action="/logout" method="post" class="mt-auto mb-auto" style="padding-top: 7px">
                            @csrf
                            <input type="image" src="{{asset('images/svg/box-arrow-left.svg')}}" width="27"
                                   value="Logout" alt="logout">
                        </form>
                    </div>
                    <h5 class="offcanvas-title me-auto ms-auto" id="offcanvasNavbarLabel" style="font-family: itc-avant-garde-gothic-std-book, serif;color: white">PROFIL</h5>
                @endauth
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                @guest()
                    <div class="modal-body">
                        <div class="me-auto ms-auto mb-3">
                            <img src="{{asset('images/svg/person-circle.svg')}}"
                                 style="width: 75px; margin-left: 50%; transform: translate(-50%, 0%)" alt="profile">
                        </div>
                        <form action="/login" method="post">
                            @csrf
                            <div class="form-floating w-75 me-auto ms-auto">
                                <input type="email" name="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       id="email" placeholder="pegawai@kantor.com" autofocus required
                                       value="{{ old('email') }}">
                                <label for=email>Email Address</label>
                                @if(session()->has('login_error'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('login_error') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-floating w-75 me-auto ms-auto mt-2">
                                <input type="password" name="password" class="form-control" id="password"
                                       placeholder="Password"
                                       required>
                                <label for="password">Password</label>
                                <input type="submit" class="me-auto ms-auto btn btn-lg btn-primary w-100 mt-3" style=""
                                       value="Log in">
                            </div>
                        </form>
                    </div>
                @endguest
                @auth()
                    <style>
                        .wrap:after{
                            font-family: 'Font Awesome 5 Free';
                            font-weight: 900;
                            content: "\f044";
                            position: absolute;
                            width: 30px;
                            height: 30px;
                            border-radius: 50%;
                            border: 1px solid grey;
                            top: 0;
                            right: 113px;
                            background: white;
                            color: black;
                            align-items: center;
                            display: flex;
                            justify-content: center;
                            cursor:pointer;
                        }

                        li.nav-item{
                            padding-top: 10px;
                            padding-bottom: 10px;
                            border-radius: 7px;
                        }
                        li.nav-item:hover{
                            cursor:pointer;
                            background-color: #464746;
                            color: white;
                        }
                        a.nav-link{
                            padding: 0px;
                        }
                    </style>

                    <div class="wrap" style="position: relative" data-bs-toggle="modal"
                         data-bs-target="#popUpFormProfil">
                        <img src="{{asset('images/profile/angger.jpg')}}" alt="profil"
                             class="card-img-top rounded-circle"
                             style="object-fit: cover; object-position: center; position: relative;width: 150px; height: 150px; margin-left: 50%; transform: translate(-49%, 0%)">
                    </div>



                    <div class="modal-body" style="padding-bottom: 40px">
                        <table class="text-center" style="font-family:itc-avant-garde-gothic-std-book, serif;margin-left: 50%; transform: translate(-50%, 0%)">
                            <tr>
                                <th>
                                    {{Auth::user()->name}}
                                </th>
                            </tr>
                            <tr>
                                <th>
                                    Akses {{Auth::user()->akses}}
                                </th>
                            </tr>
                            <tr>
                                <th>
                                    {{Auth::user()->email}}
                                </th>
                            </tr>
                            <tr>
                                <th>

                                </th>
                            </tr>
                        </table>

                    </div>

                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3"
                        style="font-family: itc-avant-garde-gothic-std-book, serif;font-size: 16px;color: #ffffff;">
                        <li class="nav-item">
                            <a class="nav-link @if(isset($state)) @if($state==='transaksi') {{'active'}} @endif @endif"
                               aria-current="page" href="/transaksi">&nbsp&nbspTRANSAKSI</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(isset($state)) @if($state==='barang') {{'active'}} @endif @endif"
                               href="/barang">&nbsp&nbspKELOLA BARANG</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(isset($state)) @if($state==='pegawai') {{'active'}} @endif @endif"
                               href="/pegawai">&nbsp&nbspKELOLA PEGAWAI</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(isset($state)) @if($state==='keuangan') {{'active'}} @endif @endif"
                               href="/keuangan">&nbsp&nbspLAPORAN KEUANGAN</a>
                        </li>
                        {{--<li class="nav-item">
                            <a class="nav-link @if(isset($state)) @if($state==='sandbox') {{'active'}} @endif @endif" href="/sandbox">Sandbox</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(isset($state)) @if($state==='test') {{'active'}} @endif @endif" href="/test">Test</a>
                        </li>--}}
                    </ul>
                    <!-- Modal -->
                    <div class="modalProfil">
                        <div class="modal fade" id="popUpFormProfil" tabindex="-1"
                             aria-labelledby="popupFormLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="popupFormLabel">
                                            Edit {{Auth::user()->name}}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="formProfil" method="post"
                                              action="/pegawai/edit{{Auth::user()->id}}">
                                            @csrf <!-- {{ csrf_field() }} -->
                                            <div class="mb-3">
                                                <label for="nama_barang"
                                                       class="form-label">Nama</label>
                                                <input type="text" class="form-control"
                                                       id="nama_barang"
                                                       name="nama_barang"
                                                       value="{{Auth::user()->name}}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="email_akun" class="form-label">Email</label>
                                                <input type="email" class="form-control"
                                                       id="email_akun"
                                                       name="email_akun"
                                                       value="{{Auth::user()->email}}"
                                                >
                                            </div>
                                            <div class="mb-3">
                                                <label for="password_lama_akun" class="form-label">Password Lama</label>
                                                <input type="password" class="form-control"
                                                       id="password_lama_akun"
                                                       name="password_lama_akun"
                                                       placeholder="Password Lama"
                                                >
                                            </div>
                                            <div class="mb-3">
                                                <label for="password_baru_akun" class="form-label">Password Baru</label>
                                                <input type="password" class="form-control"
                                                       id="password_baru_akun"
                                                       name="password_baru_akun"
                                                       placeholder="Password Baru"
                                                >
                                            </div>
                                            <div class="mb-3">
                                                <label for="password_baru2_akun" class="form-label">Masukkan kembali
                                                    Password Baru</label>
                                                <input type="password" class="form-control"
                                                       id="password_baru2_akun"
                                                       name="password_baru2_akun"
                                                       placeholder="Password Baru"
                                                >
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                                        </button>
                                        <button type="submit" form="formProfil"
                                                class="btn btn-primary">Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <style>
                        .modal-open .navbar {
                            z-index: 1051;
                        }
                    </style>
                @endauth
            </div>
        </div>
    </div>
</nav>
