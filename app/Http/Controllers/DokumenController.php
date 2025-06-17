<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // <-- Tambahkan ini
use Illuminate\Support\Facades\Storage;
use App\Models\DokumenPengajuan;
use Illuminate\Support\Facades\Auth;

class DokumenController extends Controller
{
    // Tambahkan Request $request
    public function show(Request $request, $path)
    {
        if (!Storage::disk('local')->exists($path)) {
            abort(404);
        }

        $dokumen = DokumenPengajuan::where('path_file', $path)->firstOrFail();
        $user = Auth::user();

        $isOwner = ($user->nasabah && $user->nasabah->id === $dokumen->pengajuanRekening->nasabah_id);
        $isAdmin = $user->isSuperAdmin() || $user->isAdmin();

        if ($isOwner || $isAdmin) {
            $filePath = Storage::disk('local')->path($path);
            
            // Cek apakah ada parameter 'download=true' di URL
            if ($request->query('download')) {
                // Jika ya, paksa download
                return response()->download($filePath, $dokumen->nama_asli_file);
            }
            
            // Jika tidak, tampilkan inline
            $mimeType = Storage::disk('local')->mimeType($path);
            $headers = ['Content-Type' => $mimeType];
            return response()->file($filePath, $headers);
        }

        abort(403, 'Anda tidak memiliki izin untuk mengakses file ini.');
    }
}