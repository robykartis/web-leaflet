<?php

namespace App\Http\Controllers;

use App\Models\Maps;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class MapsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['public_maps', 'get_maps']]);
    }
    public function get_maps()
    {
        $maps = Maps::all()->toArray();

        // Membuat array data marker dalam format yang diinginkan
        $initialMarkers = [];
        foreach ($maps as $map) {
            $initialMarkers[] = [
                'position' => [
                    'id' => $map['id'],
                    'lat' => $map['lat'],
                    'lng' => $map['lng'],
                    'title' => $map['title'],
                    'description' => $map['description'],
                    'image' => $map['image']
                ],
                'draggable' => true
            ];
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'initialMarkers' => [
                    'position' => $initialMarkers
                ]
            ]
        ]);
    }
    public function get_map_by_id(Request $request, $id)
    {
        // Mengambil data peta berdasarkan ID
        $map = Maps::find($id);

        // Memeriksa apakah peta dengan ID tersebut ditemukan
        if (!$map) {
            return response()->json([
                'status' => 'error',
                'message' => 'Peta tidak ditemukan.'
            ], 404); // Mengembalikan respons 404 jika peta tidak ditemukan
        }

        // Mengubah data peta menjadi format yang diinginkan
        $mapData = [
            'position' => [
                'lat' => $map->lat,
                'lng' => $map->lng,
                'title' => $map->title,
                'description' => $map->description,
                'image' => $map->image
            ],
            'draggable' => true
        ];

        return response()->json([
            'status' => 'success',
            'data' => [
                'map' => $mapData
            ]
        ]);
    }

    public function public_maps()
    {
        return view('maps.index');
    }
    public function index(Request $request)
    {
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
        $title = 'Maps';
        return view('admin.maps.index', compact('title', 'maps', 'perPage', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Add Mark';
        $initialMarkers = [
            [
                'position' => [
                    'lat' => 0.4888556,
                    'lng' => 101.4548226
                ],
                'draggable' => true
            ],
        ];
        return view('admin.maps.create', compact('title', 'initialMarkers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:8048',
        ], [
            'title.required' => 'Title tidak boleh kosong',
            'description.required' => 'Description tidak boleh kosong',
            'lat.required' => 'Latitude tidak boleh kosong',
            'lng.required' => 'Longitude tidak boleh kosong',
            'image.required' => 'Image tidak boleh kosong',
            'image.image' => 'Image harus berupa gambar',
            'image.mimes' => 'Image harus berupa jpeg,png,jpg,gif,svg',
            'image.max' => 'Image maksimal 2MB',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        try {
            $image = $request->file('image');
            $file_name = rand(1000, 9999) . $image->getClientOriginalName();
            $img = Image::make($image->path());
            $img->resize('760', '760')
                ->save(public_path('assets/image/mark/thumbnail') . '/mark_' . $file_name);
            $image->move(public_path('assets/image/mark'), $file_name);
            $map = new Maps();
            $map->title = $request->title;
            $map->description = $request->description;
            $map->lat = $request->lat;
            $map->lng = $request->lng;
            $map->image = $file_name;
            $map->save();
            toastr()->success('Berhasil Menambahkan Maps ', 'SUCCESS', ['timeOut' => 5000]);
            return redirect()->route('maps.index');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with('error', 'Email Sudah Terdaftar')->withInput();
            }
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

    public function edit(string $id)
    {
        $title = 'Edit Maps';
        $maps = Maps::find($id);

        if (!$maps) {
            // Tambahkan pesan log jika data tidak ditemukan
            \Log::error('Data peta dengan ID ' . $id . ' tidak ditemukan.');
            // Mungkin Anda ingin mengembalikan pesan kesalahan atau mengarahkan ke halaman lain di sini
        }

        // Mengambil data peta dalam format yang sesuai
        $initialMarkers = [
            [
                'position' => [
                    'id' => $maps->id,
                    'lat' => $maps->lat,
                    'lng' => $maps->lng,
                    'title' => $maps->title,
                    'description' => $maps->description,
                    'image' => $maps->image
                ],
                'draggable' => true
            ]
        ];
        // dd($initialMarkers);
        return view('admin.maps.edit', compact('title', 'maps', 'initialMarkers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
