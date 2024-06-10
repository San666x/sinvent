<?php

namespace App\Http\Controllers\Api\BarangApi;

use App\Models\Barang;
use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        //validate data
        $validator = Validator::make($request->all(), [
            'merk'     => 'required',
            'seri'   => 'required',
            'deskripsi'   => 'required',
            'stok'   => 'required',
            'kategori_id'   => 'required',
        ],
            [
                'merk.required' => 'Masukkan Merk Post !',
                'seri.required' => 'Masukkan Seri Post !',
                'deskripsi.required' => 'Masukkan Deskripsi Post !',
                'stok.required' => 'Masukkan Stok Post !',
                'kategori_id.required' => 'Masukkan Kategori_id Post !',
            ]
        );

        if($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Bidang Yang Kosong',
                'data'    => $validator->errors()
            ],401);

        } else {

            $post = Post::create([
                'merk'     => $request->input('merk'),
                'seri'   => $request->input('seri'),
                'deskripsi'   => $request->input('deskripsi'),
                'stok'   => $request->input('stok'),
                'kategori_id'   => $request->input('kategori_id'),
            ]);

            if ($post) {
                return response()->json([
                    'success' => true,
                    'message' => 'Post Berhasil Disimpan!',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Post Gagal Disimpan!',
                ], 401);
            }
        }
    }
}