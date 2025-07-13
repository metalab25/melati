<?php

namespace App\Http\Controllers;

use App\DataTables\BukuTamuDataTable;
use App\Models\BukuTamu;
use App\Models\Staf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class BukuTamuController extends Controller
{
    public function index(BukuTamuDataTable $dataTable)
    {
        return $dataTable->render('dashboard.buku_tamu.index', [
            'title' => 'Data Tamu'
        ]);
    }

    public function create()
    {
        $staf = Staf::orderBy('nama')->get();

        return view('dashboard.buku_tamu.add', [
            'title' => 'Tambah Tamu',
            'stafs' => $staf
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama'          => 'required|max:100',
            'alamat'        => 'required|max:255',
            'id_staf'       => 'required',
            'telepon'       => 'required|numeric|digits_between:10,12',
            'keperluan'     => 'required|max:255',
            'is_janji'      => 'required|boolean',
            'tgl_kunjungan' => 'required',
        ], [
            'nama.required'             => 'Nama wajib diisi.',
            'tgl_kunjungan.required'    => 'Nama wajib diisi.',
            'alamat.required'           => 'Alamat wajib diisi.',
            'id_staf.required'          => 'Silakan pilih staf yang akan ditemui.',
            'telepon.required'          => 'Nomor telepon wajib diisi.',
            'telepon.numeric'           => 'Nomor telepon harus berupa angka.',
            'telepon.digits_between'    => 'Nomor telepon harus 10-15 digit.',
            'keperluan.required'        => 'Keperluan wajib diisi.',
            'is_janji.required'         => 'Status janji wajib dipilih.',
        ]);

        $validatedData['instansi'] = $request->instansi;
        $validatedData['informasi'] = $request->informasi;

        $bukuTamu = BukuTamu::create($validatedData);
        Alert::success('Berhasil', 'Data kunjungan berhasil dikirim.');

        $staf = Staf::findOrFail($request->id_staf);

        if ($staf->telepon) {
            $this->sendFonnteWhatsApp($staf, $bukuTamu);
        }

        return redirect()->route('website');
    }

    public function storeAdmin(Request $request)
    {
        $validatedData = $request->validate([
            'nama'          => 'required|max:100',
            'alamat'        => 'required|max:255',
            'id_staf'       => 'required',
            'telepon'       => 'required|numeric|digits_between:10,12',
            'keperluan'     => 'required|max:255',
            'is_janji'      => 'required|boolean',
            'tgl_kunjungan' => 'required',
        ], [
            'nama.required'             => 'Nama wajib diisi.',
            'tgl_kunjungan.required'    => 'Nama wajib diisi.',
            'alamat.required'           => 'Alamat wajib diisi.',
            'id_staf.required'          => 'Silakan pilih staf yang akan ditemui.',
            'telepon.required'          => 'Nomor telepon wajib diisi.',
            'telepon.numeric'           => 'Nomor telepon harus berupa angka.',
            'telepon.digits_between'    => 'Nomor telepon harus 10-15 digit.',
            'keperluan.required'        => 'Keperluan wajib diisi.',
            'is_janji.required'         => 'Status janji wajib dipilih.',
        ]);

        $validatedData['instansi'] = $request->instansi;
        $validatedData['informasi'] = $request->informasi;

        $bukuTamu = BukuTamu::create($validatedData);
        Alert::success('Berhasil', 'Data kunjungan berhasil dikirim.');

        $staf = Staf::findOrFail($request->id_staf);

        if ($staf->telepon) {
            $this->sendFonnteWhatsApp($staf, $bukuTamu);
        }

        return redirect()->route('data-tamu.index');
    }

    public function cetak(Request $request)
    {
        $jenis = $request->query('jenis');
        $query = BukuTamu::with('staf')->orderBy('created_at');

        if ($jenis === 'bulanan') {
            $bulan = $request->query('bulan');
            $date = Carbon::parse($bulan);

            $query->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month);

            $title = 'Laporan Bulanan - ' . $date->translatedFormat('F Y');
        } else if ($jenis === 'mingguan') {
            $minggu = $request->query('minggu');
            list($year, $week) = explode('-W', $minggu);

            $startDate = Carbon::now()->setISODate($year, $week)->startOfWeek();
            $endDate = Carbon::now()->setISODate($year, $week)->endOfWeek();

            $query->whereBetween('created_at', [$startDate, $endDate]);

            $title = 'Laporan Mingguan - ' . $startDate->translatedFormat('d F Y') . ' s/d ' . $endDate->translatedFormat('d F Y');
        }

        $data = $query->get();

        return view('dashboard.buku_tamu.cetak', [
            'title' => $title,
            'data' => $data,
            'jenis' => $jenis
        ]);
    }

    public function show(BukuTamu $bukuTamu)
    {
        //
    }

    public function edit(BukuTamu $bukuTamu)
    {
        //
    }

    public function update(Request $request, BukuTamu $bukuTamu)
    {
        //
    }

    public function updateStatus($id)
    {
        $bukuTamu = BukuTamu::findOrFail($id);
        $newStatus = $bukuTamu->status ? 0 : 1;
        $bukuTamu->status = $newStatus;
        $bukuTamu->save();

        if ($newStatus == 1) {
            $this->sendSurveyLink($bukuTamu);
        }

        return response()->json([
            'message' => 'Status kunjungan berhasil diperbarui',
            'status' => $bukuTamu->status,
        ]);
    }

    protected function sendSurveyLink(BukuTamu $bukuTamu)
    {
        $phone = $this->formatPhoneNumber($bukuTamu->telepon);

        $surveyToken = Str::uuid();

        $bukuTamu->survey_token = $surveyToken;
        $bukuTamu->save();

        $message = "Halo *" . $bukuTamu->nama . "*,\n\n";
        $message .= "Terima kasih telah berkunjung ke *" . config('app.name') . "*.\n";
        $message .= "Kami mohon kesediaan Anda untuk mengisi survei kepuasan layanan kami melalui link berikut:\n\n";
        $message .= route('reaction.show', ['token' => $surveyToken]) . "\n\n";
        $message .= "Link ini bersifat pribadi dan hanya dapat diakses oleh Anda.\n\n";
        $message .= "Terima kasih atas partisipasi Anda.\n\n";
        $message .= "_Pesan otomatis dari *SIMELATI*_";

        try {
            $response = Http::withHeaders([
                'Authorization' => env('FONNTE_API_KEY')
            ])->post('https://api.fonnte.com/send', [
                'target' => $phone,
                'message' => $message,
                'delay' => '5-10',
                'countryCode' => '62',
            ]);

            Log::info('Fonnte Survey Response: ', [
                'status' => $response->status(),
                'response' => $response->json()
            ]);

            if ($response->failed()) {
                Log::error('Gagal mengirim survey WhatsApp: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('Error mengirim survey WhatsApp: ' . $e->getMessage());
        }
    }

    public function submitReaction(Request $request, $token)
    {
        $request->validate([
            'reaction' => 'required|integer|between:1,5'
        ]);

        $bukuTamu = BukuTamu::where('survey_token', $token)->firstOrFail();

        $bukuTamu->update([
            'reaction' => $request->reaction,
            'survey_token' => null,
            'reaction_submitted_at' => now()
        ]);

        Alert::success('Terimakasih', 'Anda sudah memberikan umpan balik atas layaman kami.');
        return redirect()->route('website');
    }

    public function destroy(BukuTamu $bukuTamu)
    {
        //
    }

    protected function sendFonnteWhatsApp(Staf $staf, BukuTamu $bukuTamu)
    {
        $phone = $this->formatPhoneNumber($staf->telepon);
        $message = $this->kirimPesan($staf, $bukuTamu);

        try {
            $response = Http::withHeaders([
                'Authorization' => env('FONNTE_API_KEY')
            ])->post('https://api.fonnte.com/send', [
                'target' => $phone,
                'message' => $message,
                'delay' => '5-10',
                'countryCode' => '62',
            ]);

            Log::info('Fonnte API Response: ', [
                'status' => $response->status(),
                'response' => $response->json()
            ]);

            if ($response->failed()) {
                Log::error('Gagal mengirim WhatsApp: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('Error mengirim WhatsApp: ' . $e->getMessage());
        }
    }

    protected function formatPhoneNumber($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }

        return $phone;
    }

    protected function kirimPesan(Staf $staf, BukuTamu $bukuTamu)
    {
        $message = "*NOTIFIKASI KUNJUNGAN TAMU*\n\n";
        $message .= "Halo *" . $staf->nama . "*,\n";
        $message .= "Anda memiliki tamu baru dengan detail berikut:\n\n";
        $message .= "*Nama Tamu*: " . $bukuTamu->nama . "\n";
        $message .= "*Alamat*: " . $bukuTamu->alamat . "\n";

        if ($bukuTamu->instansi) {
            $message .= "*Instansi*: " . $bukuTamu->instansi . "\n";
        }

        $message .= "*No. Telepon*: " . $bukuTamu->telepon . "\n";
        $message .= "*Keperluan*: " . $bukuTamu->keperluan . "\n";
        $message .= "*Status*: " . ($bukuTamu->is_janji ? "Dengan Janji" : "Tanpa Janji") . "\n";
        $message .= "Silakan siapkan diri Anda untuk menerima tamu ini.\n\n";
        $message .= "_Pesan otomatis dari *SIMELATI*_";

        return $message;
    }
}
