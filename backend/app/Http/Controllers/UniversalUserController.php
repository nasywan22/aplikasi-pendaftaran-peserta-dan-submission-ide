<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ValidateFormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UniversalUserController extends Controller
{
    public function ambilDataProfilUser()
    {
        $dataProfilUser = \DB::table("profiles")
            ->join("users", "users.id", "=", "profiles.user_id")
            ->join("provinsi", "provinsi.id","=","profiles.provinsi_id")
            ->join("kabupaten", "kabupaten.id", "=", "profiles.kabupaten_id")
            ->join("kecamatan", "kecamatan.id", "=", "profiles.kecamatan_id")
            ->join("kelurahan", "kelurahan.id", "=", "profiles.kelurahan_id")
            ->select("school", "nama_provinsi", "nama_kabupaten", "nama_kecamatan", "nama_kelurahan", "photo")
            ->get();

        if ($dataProfilUser->isEmpty()) {
            return response()->json([
                'error'=> 'Data profil user tidak ditemukan',
            ], 404);
        }

        $photoUser = $dataProfilUser[0]->photo;

        if (!Storage::disk('private')->exists($photoUser)) {
            return response()->json([
                'error'=> 'file tidak ditemukan',
            ], 404);
        }

        try {
            $ambilFoto = Storage::disk('private')->get($photoUser);
            $kontenFoto = base64_encode($ambilFoto);
            $dataProfilUser[0]->photo = $kontenFoto;

            return response()->json($dataProfilUser, 200);
        } catch (\Throwable $e) {
            response()->json([
                "error" => $e->getMessage(),
                "errMessage" => "Gagal dalam encode foto"
            ], 500);
        }
    }

    public function masukkanDataProfilUser(Request $request)
    {
        $dataHasilValidasi = $request->validate([
            'sekolah' => 'required|string|max:255',
            'provinsi' => 'required|integer|exists:provinsi,id',
            'kabupaten' => 'required|integer|exists:kabupaten,id',
            'kecamatan' => 'required|integer|exists:kecamatan,id',
            'kelurahan' => 'required|integer|exists:kelurahan,id',
            'photo' => 'required|image|mimes:jpeg,jpg|max:2048',
        ]);

        // Cast biar pasti integer
        $dataHasilValidasi['provinsi'] = (int) $dataHasilValidasi['provinsi'];
        $dataHasilValidasi['kabupaten'] = (int) $dataHasilValidasi['kabupaten'];
        $dataHasilValidasi['kecamatan'] = (int) $dataHasilValidasi['kecamatan'];
        $dataHasilValidasi['kelurahan'] = (int) $dataHasilValidasi['kelurahan'];

        $fileFoto = $dataHasilValidasi['photo'];
        $pathFoto = $fileFoto->store('public/foto');

        try {
            $userProfile = \App\Models\UserProfile::create([
                'user_id' => Auth::id(),
                'school' => $dataHasilValidasi['sekolah'],
                'provinsi_id' => $dataHasilValidasi['provinsi'],
                'kabupaten_id' => $dataHasilValidasi['kabupaten'],
                'kecamatan_id' => $dataHasilValidasi['kecamatan'],
                'kelurahan_id' => $dataHasilValidasi['kelurahan'],
                'photo' => $pathFoto,
            ]);

            return response()->json($userProfile, 200);
        } catch (\Throwable $th) {
            \Log::error($th);
            return response()->json([
                'message' => 'Gagal mengupdate profil. Error message: ' . $th->getMessage(),
            ], 500);
        }
    }


    public function register(ValidateFormRequest $request): JsonResponse
    {
        $dataHasilValidasi = $request->validated();

        if (!\App\Helpers\RecaptchaHelper::verifyCaptcha($request)) {
            return response()->json([
                "message" => "Captcha tidak valid",
            ], 401);
        }

        $nama = $dataHasilValidasi["name"];
        $telepon = $dataHasilValidasi["telepon"];
        $email = $dataHasilValidasi["email"];
        $password = $dataHasilValidasi["password"];

        try {
            $user = User::create([
                "name" => $nama,
                "email" => $email,
                "password" => bcrypt($password),
                "nomor_telepon" => $telepon,
            ]);

            return response()->json([
                "message" => "Akun berhasil dibuat",
                "data" => $user
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                "message" => "Terjadi kesalahan saat membuat akun",
                "error" => $e->getMessage()
            ], 422);
        }
    }

    public function login(ValidateFormRequest $request): JsonResponse
    {
        $dataHasilValidasi = $request->validated();

        if (!\App\Helpers\RecaptchaHelper::verifyCaptcha($request)) {
            return response()->json([
                "message" => "Captcha tidak valid",
            ], 401);
        }

        $dataHasilValidasi = [
            "email" => $dataHasilValidasi["email"],
            "password" => $dataHasilValidasi["password"],
        ];

        $rememberUser = $request->input("rememberMe", false);

        if (!Auth::attempt($dataHasilValidasi, $rememberUser)) {
            return response()->json([
                "message" => "Kayaknya antara email atau password kamu ada yang salah nih... coba cek lagi",
            ], 401);
        }

        $request->session()->regenerate();

        return response()->json([
            "message" => "Berhasil login! :D",
        ], 200);
    }

    public function logout(Request $request)
    {
        try {
            Auth::user()->setRememberToken(null);
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerate();
            return response()->json([
                "message" => "success logout",
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'errMessage' => $e->getMessage()
            ], 500);
        }
    }
}
