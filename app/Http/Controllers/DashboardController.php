<?php

namespace App\Http\Controllers;

use App\Models\Maps;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $title = 'Dashboard';

        // Ambil nilai 'perPage' dari query string, defaultnya 5
        $perPage = $request->input('perPage', 5);

        // Ambil nilai 'search' dari query string untuk pencarian
        $search = $request->input('search');

        // Kueri database berdasarkan pencarian dan jumlah data per halaman
        if ($search) {
            $maps = Maps::where('title', 'like', '%' . $search . '%')->paginate($perPage);
        } else {
            if ($perPage === 'all') {
                $maps = Maps::all();
            } else {
                $maps = Maps::paginate($perPage);
            }
        }

        $total = count($maps);

        return view('admin.dashboard.index', compact('title', 'maps', 'total', 'perPage', 'search'));
    }
}
