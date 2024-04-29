<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Mod_el;
use App\Http\Models\Make;
use DB;

class Displaymodel extends Controller
{
    function display(Request $req)
    {
        // $data = Make::with('model')->where('id',$id)->get();
        $data12 = Mod_el::where('make_id', $req->make_id)->where('is_active', '1')->where('is_delete', '0')->orderBy('model_name')->get();
        foreach ($data12 as $dat) {
            if (empty($dat['image'])) {
                $dat['image'] = 'xyz';
            }
            $file = public_path() . '/images/settings/' . $dat['image'];
            if (!empty($dat['image']) && file_exists($file)) {
                $dat['image'] = getImageUrl($dat->image, 'model');
            } else {
                $dat['image'] = getImageUrl('parts.png', 'partss');
            }

        }
        // return $data12;
        if ($data12) {
            return response()->json(['success' => 1, 'message' => 'model display successfully', 'data' => $data12]);
        } else {
            return response()->json(['success' => 0, 'message' => "model didn't displayl", 'data' => $data12]);
        }
    }
}
