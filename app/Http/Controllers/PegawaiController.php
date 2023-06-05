<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Carbon\Carbon;
use Hash;

class PegawaiController extends Controller
{

    private static string $state;
    private User $user;

    public function __construct(User $user)
    {
        self::$state = 'pegawai';
        $this->user = $user;
    }

    public function index()
    {
        return view('pegawai.index', [
            'title' => 'Kelola Pegawai',
            'data' => $this->user->where('akses', 'kasir')->get(),
            'state' => self::$state
        ]);
    }

    public function tambah()
    {
        $counter = intval(Carbon::NOW()->format('y') * 1000) + 1;
        $pegawai = $this->user->orderBy('id', 'ASC')->get();
        foreach ($pegawai as $index) {
            if ($index['id'] != $counter) {
                break;
            } else {
                $counter += 1;
            }
        }
        if (!$this->user->where('email', $_POST['email_akun'])->exists()) {
            $this->user->create([
                'id' => $counter,
                'name' => $_POST['name_akun'],
                'email' => $_POST['email_akun'],
                'password' => $_POST['password_akun'],
                'foto' => strtolower(str_replace(' ', '_', $_POST['name_akun'])),
            ]);
        } else {
            return redirect()->back()->withErrors(['tambah_akun', 'Akun dengan email tersebut sudah tersedia!']);
        }
        return redirect('pegawai');
    }

    public function edit_profil()
    {
        if (isset($_POST['password_baru_akun'])) {
            if (Hash::check($_POST['password_lama_akun'], Auth::user()->password)) {
                if ($_POST['password_baru_akun'] == $_POST['password_baru2_akun']) {
                    $this->user->where('id', Auth::id())->update([
                        'password' => bcrypt($_POST['password_baru_akun']),
                    ]);
                } else {
                    return redirect()->back()->withErrors(['Password', 'Password baru tidak sesuai']);
                }
            } else {
                return redirect()->back()->withErrors(['Password', 'Password lama tidak sesuai']);
            }
        }
        if (Auth::user()->email != $_POST['email_akun']) {
            if (!$this->user->where('email', $_POST['email_akun'])) {
                Auth::user()->update([
                    'email' => $_POST['email_akun'],
                ]);
            } else {
                return redirect()->back()->withErrors(['Email', 'Sudah ada akun yang menggunakan email tersebut']);
            }
        }
        return redirect(url()->previous());
    }

    public function hapus($kode)
    {
        $this->user->where('id', $kode)->delete();
        return redirect('pegawai');
    }
}
