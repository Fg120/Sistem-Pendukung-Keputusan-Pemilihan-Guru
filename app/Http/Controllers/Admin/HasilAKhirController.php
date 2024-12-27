<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class HasilAKhirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.hasil_akhir.index');
    }

    public function data()
    {
        // $type = 0;
        $matrix = [];
        $bobot = [];
        $normalisasi = [];
        $ktt = [];
        $sip = [];
        $sin = [];
        $dp = [];
        $dn = [];

        $kriterias = Kriteria::all();
        $alternatifs = Alternatif::all();
        $penilaians = Penilaian::all();

        // START MATRIX
        foreach ($alternatifs as $a) {
            $matrix_proc['nama'] = $a->nama;
            foreach ($kriterias as $k) {
                $alt = $penilaians->where('alternatif_id', $a->id)->where('kriteria_id', $k->id)->first();
                $matrix_proc[$k->sys_name] = $alt->sub->nilai;
            }
            $matrix[] = $matrix_proc;
        }
        // RETURN
        // END MATRIX


        // START BOBOT
        foreach ($kriterias as $k) {
            $bobot_proc[$k->sys_name] = $k->bobot;
        }
        $bobot[] = $bobot_proc;
        // RETURN
        // END BOBOT


        // START PEMBAGI
        foreach ($kriterias as $k) {
            $calculate = 0;
            $names = $k->sys_name;

            foreach ($k->penilaian as $p) {
                $calculate = $calculate + ($p->sub->nilai ** 2);
            }
            $pembagi[$names] = sqrt($calculate);
        }
        // dd($pembagi);
        // END PEMBAGI


        // START NORMALISASI
        foreach ($alternatifs as $a) {
            $norm3['alternatif_id'] = $a->id;
            $norm3['nama'] = $a->nama;
            foreach ($kriterias as $k) {
                $norm = $penilaians->where('alternatif_id', $a->id)->where('kriteria_id', $k->id)->first()->sub->nilai;
                $norm2 = $norm / $pembagi[$k->sys_name];
                $norm3[$k->sys_name] = number_format($norm2, 9, '.', '');
            }
            $normalisasi[$a->id] = $norm3;
        }
        // RETURN
        // dd($normalisasi);
        // END NORMALISASI


        // START TERNORMALISASI DAN TERBOBOT
        foreach ($normalisasi as $n) {
            $ktt_proc['alternatif_id'] = $n['alternatif_id'];
            $ktt_proc['nama'] = $n['nama'];
            foreach ($kriterias as $k) {
                $ktt_calc = number_format($n[$k->sys_name] * $k->bobot, 9, '.', '');
                $ktt_proc[$k->sys_name] = $ktt_calc;
            }
            $ktt[$n['alternatif_id']] = $ktt_proc;
        }
        // RETURN
        // dd($ktt);
        // END TERNORMALISASI DAN TERBOBOT


        // START SOLUSI IDEAL POSITIF DAN SOLUSI IDEAL NEGATIF
        foreach ($kriterias as $k) {
            $vals = array_column($ktt, $k['sys_name']);
            $sip_calc[$k['sys_name']] = max($vals);
            $sin_calc[$k['sys_name']] = min($vals);
        }
        $sip[] = $sip_calc;
        $sin[] = $sin_calc;
        // RETURN
        // dd($sip);
        // END SOLUSI IDEAL POSITIF DAN SOLUSI IDEAL NEGATIF

        foreach ($alternatifs as $a) {
            $d_positive_calc = 0;
            $d_negative_calc = 0;
            $ktt_data = $ktt[$a->id];
            foreach ($kriterias as $k) {
                $d_positive_calc += ($sip[0][$k->sys_name] - $ktt_data[$k->sys_name]) ** 2;
                $d_negative_calc += ($ktt_data[$k->sys_name] - $sin[0][$k->sys_name]) ** 2;
            }
            // POSITIF
            $dp_proc['nama'] = $a->nama;
            $dp_proc['nilai'] = sqrt($d_positive_calc);
            $dp[$a->id] = $dp_proc;
            // NEGATIF
            $dn_calc['nama'] = $a->nama;
            $dn_calc['nilai'] = sqrt($d_negative_calc);
            $dn[$a->id] = $dn_calc;
        }
        // RETURN
        // dd($dp);
        foreach ($alternatifs as $a) {
            $data_dp = $dp[$a->id]['nilai'];
            $data_dn = $dn[$a->id]['nilai'];
            // $hasil[] = ['nilai' => $data_dn / ($data_dn + $data_dp), 'nama' => $a->nama];
            if ($data_dn + $data_dp > 0) {
                $hasil[$a->id] = [
                    'nilai' => $data_dn / ($data_dn + $data_dp),
                    'nama' => $a->nama,
                    'rank' => null,
                ];
            }
        }
        $has = array_column($hasil, 'nilai');
        array_multisort($hasil, SORT_DESC, $has);
        $i = 0;
        foreach ($hasil as $h) {
            $hasil[$i]['rank'] = $i + 1;
            $i++;
        }
        // dd($hasil);
        return DataTables::of($hasil)->make(true);
    }
}
