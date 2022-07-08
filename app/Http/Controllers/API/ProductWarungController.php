<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormmater;
use App\Http\Controllers\Controller;
use App\Models\ProductWarung;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductWarungController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'name_warung' => 'required|string|max:255',
            'alamat_warung' => 'required|string|max:255',
            'lat' => '',
            'long' => '',
            'photo_warung' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5048'
        ]);

        $product = ProductWarung::create([
            'name_warung' => $request->name_warung,
            'alamat_warung' => $request->alamat_warung,
            'lat' => $request->lat,
            'long' => $request->long,
            'photo_warung' => $request->photo_warung
        ]);


        if($request->file('photo_warung')->isValid()) {
            $photoComment = $request->file('photo_warung');
            $extesions = $photoComment->getClientOriginalExtension();
            $komentarPhoto = "photo/".date('YmdHis').".".$extesions;
            $uploadPath = env('UPLOAD_PATH')."/photo";
            $request->file('photo_warung')->move($uploadPath, $komentarPhoto);
            $product['photo_warung'] = $komentarPhoto;
        }


        try {
            $product->save();
            return ResponseFormmater::success(
                $product,
                'Daftar warung berhasil di tambahkan'
            );
        }

        catch(Exception $error) {
            return ResponseFormmater::error(
                $error->getMessage(),
                'Daftar Warung gagal ditambahkan'
            );
        }
    }


    public function get(Request $request)
    {
        $id = $request->input('id');

        if($id)
        {
            $product = ProductWarung::find($id);

            if($product)
            {
                return ResponseFormmater::success(
                    $product,
                    'Data Product berhasil diambil'
                );
            }

            else {
                return ResponseFormmater::error(
                    null,
                    'Data Product tidak ditemukan',
                );
            }
        }

        $product = ProductWarung::query();

        return ResponseFormmater::success(
            $product->get(),
            'Data Product berhasil diambil'
        );
    }


    public function update(Request $request ,$id)
    {
        $product = ProductWarung::findOrFail($id);
        $data = $request->all();

        if($request->hasFile('photo_warung'))
        {
           if($request->file('photo_warung')->isValid())
           {
               Storage::disk('upload')->delete($request->photo_warung);
               $photoComment = $request->file('photo_warung');
               $extesions = $photoComment->getClientOriginalExtension();
               $komentarPhoto = "photo/".date('YmdHis').".".$extesions;
               $uploadPath = env('UPLOAD_PATH')."/photo";
               $request->file('photo_warung')->move($uploadPath, $komentarPhoto);
               $data['photo_warung'] = $komentarPhoto;
           }

        }

        $product->update($data);
        return ResponseFormmater::success(
            $product,
            'Success Update Product'
        );
    }


    public function delete (Request $request, $id)
    {
        $product = ProductWarung::findOrFail($id);
        $product->delete($request->all());
        return ResponseFormmater::success(
            $product,
            'Success Delete Product'
        );
    }


}
