<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;

class PublicationController extends Controller
{
    public function store(Request $request)
    {
        $publication = new Publication();
        $request->validate(['img' => 'image|max:2048']);
        $img = $request->file('img');
        $route = 'images/publications/';
        $imgName = time() . '-' . str_replace(' ', '', $img->getClientOriginalName());
        $request->file('img')->move($route, $imgName);
        $publication->img = $imgName;
        if ($publication->save() >= 1) {
            return response()->json(['status' => 'OK', 'data' => $publication], 201);
        }
    }
    public function show()
    {
        try {
            $publication = Publication::select(
                    'publications.id',
                    'publications.img',
                )
                ->orderBy('id', 'desc')
                ->paginate(5)->onEachSide(1);
            return $publication;
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $errors = 0;
            $publication = Publication::findOrFail($request->id);
            $route = 'images/publications/';
            if ($publication->img !== 'no-image.svg') {
                if (unlink($route . $publication->img) < 1) $errors++;
            }
            if ($publication->delete() < 1) $errors++;
            if ($errors == 0) {
                return response()->json(['message' => 'Publication deleted successfully'], 200);
            } else {
                return response()->json(['message' => 'Publication could not be deleted'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }
}
