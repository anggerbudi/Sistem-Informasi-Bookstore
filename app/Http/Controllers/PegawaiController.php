<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    //
    public function index()
    {
        return view('pegawai', [
            'title' => 'Kelola Pegawai',
            'data' => User::where('akses', 'kasir')->get(),
        ]);
    }

    public function tambah()
    {
        $counter = intval(Carbon::NOW()->format('y')*1000)+1;
        $pegawai = User::orderBy('id', 'ASC')->get();
        foreach ($pegawai as $index) {
            if ($index['id'] != $counter) {
                break;
            } else {
                $counter += 1;
            }
        }
        User::create([
            'id' => $counter,
            'name' => $_POST['name_akun'],
            'email' => $_POST['email_akun'],
            'password' => $_POST['password_akun'],
            'foto' => strtolower(str_replace(' ', '_', $_POST['name_akun'])),
        ]);
        return redirect('pegawai');
    }

//    public function edit_profil()
//    {
////        $pegawai = User::where('email', 'AnggerBudi@gmail.com')->get();
//        $pegawai = User::where('email', Auth::user()->email)->get();
//        $password_lama_akun = bcrypt($_POST['password_lama_akun']);
//        if ($_POST['password_baru_akun'].isset()) {
//            dd(bcrypt($_POST['password_lama_akun']));
//            if ($pegawai[0]['password'] == bcrypt($_POST['password_lama_akun'])){
//            dd('pw lama');
//                if ($_POST['password_baru_akun'] == $_POST['password_baru2_akun']) {
//                    $pegawai->update([
//                        'password' => $_POST['new_password'],
//                    ]);
//                } else {
//                    return redirect()->withErrors(['password', 'Password baru tidak sama']);
//                }
//            } else {
//                return redirect()->withErrors(['password', 'Password lama invalid']);
//            }
//        }
//        $pegawai->update([
//           'email' => $_POST['new_email'],
//        ]);
//        return redirect(url()->previous());
//    }

    public function edit_profil(Request $request)
    {
        if(isset($_POST['password_baru_akun'])) {
//            dd('hello');
//            dd(bcrypt($_POST['password_lama_akun']));
            if (Hash::check($_POST['password_lama_akun'], Auth::user()->password)) {
//                dd('yeay');
                if ($_POST['password_baru_akun'] == $_POST['password_baru2_akun']) {
                    User::where('id', Auth::id())->update([
                        'password' => bcrypt($_POST['password_baru_akun']),
                    ]);
                } else {
                    return redirect()->back()->withErrors(['Password', 'Password baru tidak sesuai']);
                }
            } else {
                return redirect()->back()->withErrors(['Password', 'Password lama tidak sesuai']);
            }
        }
        User::where('id', Auth::id())->update([
            'email' => $_POST['email_akun'],
        ]);
        return redirect(url()->previous());
    }

    public function hapus($kode)
    {
        User::where('id', $kode)->delete();
        return redirect('pegawai');
    }
}
