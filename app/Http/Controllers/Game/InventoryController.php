<?php

namespace App\Http\Controllers\Game;

use App\Events\GameUpdated;
use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Item;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function show()
    {
        return view('game.inventory', [
            'materials' => auth()->user()->materials,
            'items' => auth()->user()->items
        ]);
    }

    public function sellItem(Request $request){
        $item_id = (int)$request->input('item_id');
        $amount = (int)$request->input('amount');
        if($item_id <= 0)
            return redirect()->back();
        if($amount <= 0)
            return redirect()->back();
        auth()->user()->sellItem(Item::where('id', $item_id)->first(), $amount);
        return redirect()->back();

    }
    public function sellMaterial(Request $request){
        $material_id = (int)$request->input('material_id');
        $amount = (int)$request->input('amount');
        if($material_id <= 0)
            return redirect()->back();
        if($amount <= 0)
            return redirect()->back();
        auth()->user()->sellMaterial(Material::where('id', $material_id)->first(), $amount);
        return redirect()->back();
    }
}
