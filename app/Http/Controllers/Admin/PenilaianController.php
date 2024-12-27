<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\User;
use App\Repositories\PenilaianRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class PenilaianController extends Controller
{
    private $penilaianRepo, $userRepo;

    public function __construct()
    {
        $this->penilaianRepo = new PenilaianRepository;
        $this->userRepo = new UserRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penilaians = $this->penilaianRepo->all();
        return view('admin.penilaian.index', compact('penilaians'));
    }

    public function data()
    {
        $alternatifs = Alternatif::query();
        return DataTables::of($alternatifs)->addColumn('action', function ($alternatifs) {
            // Add custom action buttons (edit, delete, etc.)
            if ($alternatifs->penilaian->isEmpty()) {
                return '
                    <a class="btn btn-success btn-sm" href="' . route('admin.penilaian.create', Crypt::encrypt($alternatifs->id)) . '">Create</a>
                ';
            } else {
                return '
                    <a class="btn btn-warning btn-sm" href="' . route('admin.penilaian.edit', Crypt::encrypt($alternatifs->id)) . '">Edit</a>
                ';
            }
        })->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $enc_id)
    {
        $alternatifs = Alternatif::find(Crypt::decrypt($enc_id));
        $kriterias = Kriteria::all();
        return view('admin.penilaian.create', compact('alternatifs', 'kriterias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $enc_id)
    {
        // dd($request->all());
        $data = $request->all(); // Get all form data

        DB::beginTransaction();
        try {
            foreach ($data as $key => $value) {
                if (strpos($key, '_id') !== false) { // Check if key ends with "_id"
                    $kr = explode('_', $key);
                    // dd($value);
                    Penilaian::updateOrCreate([
                        'alternatif_id' => Crypt::decrypt($enc_id), // Assuming "alternatif_id" exists in $data
                        'kriteria_id' => $kr[0], // Extract kriteria_id from key
                        'sub_kriteria_id' => $value, // Extract sub_kriteria_id from value
                    ]);
                }
            }
            DB::commit();
            Alert::success('Penilaian Berhasil Dibuat!');
            return redirect(route('admin.penilaian.index'));
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::error('Penilaian Gagal Dibuat!');
            return back();
            //throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $enc_id)
    {
        $id = Crypt::decrypt($enc_id);
        $alternatifs = Alternatif::find($id);
        $kriterias = Kriteria::all();
        $penilaians = Penilaian::where('alternatif_id', $id)->get();

        foreach ($penilaians as $p) {
            $data[$p->kriteria_id] = $p->sub_kriteria_id;
        }
        // dd($data);
        return view('admin.penilaian.edit', compact('alternatifs', 'kriterias', 'penilaians', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $enc_id)
    {
        $id = Crypt::decrypt($enc_id);
        $data = $request->all(); // Get all form data

        DB::beginTransaction();
        try {
            foreach ($data as $key => $value) {
                if (strpos($key, '_id') !== false && $key !== 'alternatif_id') { // Check if key ends with "_id"
                    $kr = explode('_', $key);
                    // dd($value);
                    Penilaian::updateOrCreate([
                        'alternatif_id' => $id,
                        'kriteria_id' => $kr[0], // Extract kriteria_id from key
                    ], [
                        'sub_kriteria_id' => $value, // Extract sub_kriteria_id from value
                    ]);
                }
            }
            DB::commit();
            Alert::success('Penilaian Berhasil Diubah!');
            return redirect(route('admin.penilaian.index'));
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
            Alert::success('Penilaian Berhasil Diubah!');
            return back();
        }
    }
}
