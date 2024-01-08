<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    // image upload
    public function upload(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:1024',
        ]);

        $image = $request->image->store('public/image');
        $imageUrl = asset(str_replace('public/', 'storage/', $image));
        $imagePath = ["url" => $imageUrl];
        Image::create(['image' => $imageUrl]);
        return response()->json($imagePath, 201);
    }
}
