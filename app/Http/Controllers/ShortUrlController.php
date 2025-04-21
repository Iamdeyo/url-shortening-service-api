<?php

namespace App\Http\Controllers;

use App\Http\Resources\ShortUrlCollection;
use App\Http\Resources\ShortUrlResource;
use App\Models\ShortUrl;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShortUrlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $data = new ShortUrlCollection(ShortUrl::all());
        return response()->json([
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Validate the request
        $validated = $request->validate([
            'url' => 'required|url|max:255'
        ]);

        // Generate unique short code
        do {
            $shortCode = Str::random(6); // 6 character alphanumeric code
        } while (ShortUrl::where('short_code', $shortCode)->exists());


        // Create the short URL
        $shortUrl = ShortUrl::create([
            'url' => $validated['url'],
            'short_code' => $shortCode
        ]);

        return response()->json(
            [
                'data' => new ShortUrlResource($shortUrl),
                'message' => 'URL shortened successfully'
            ],
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $short_code)
    {
        $data = ShortUrl::where('short_code', $short_code)->first();

        if (!$data) {
            return  response()->json([
                'message' => 'Not Found'
            ], 404);
        }
        // // Increment access count 
        $data->increment('access_count');


        return response()->json([
            'data' => new ShortUrlResource($data)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function stats(string $short_code)
    {
        $data = ShortUrl::where('short_code', $short_code)->first();

        if (!$data) {
            return  response()->json([
                'message' => 'Not Found'
            ], 404);
        };

        return response()->json([
            'data' => new ShortUrlResource($data)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $short_code)
    {

        // Validate the request
        $validated = $request->validate([
            'url' => 'required|url|max:255'
        ]);

        $data = ShortUrl::where('short_code', $short_code)->first();


        if (!$data) {
            return  response()->json([
                'message' => 'Not Found'
            ], 404);
        }

        $data->url = $validated['url'];

        $data->save();

        return response()->json(
            [
                'data' => new ShortUrlResource($data),
                'message' => 'URL updated successfully'
            ],
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $short_code)
    {
        $data = ShortUrl::where('short_code', $short_code)->first();

        if (!$data) {
            return  response()->json([
                'message' => 'Not Found'
            ], 404);
        }

        $data->delete();

        return response()->noContent();
    }
}
