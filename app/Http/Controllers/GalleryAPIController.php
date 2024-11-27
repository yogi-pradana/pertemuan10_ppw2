<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GalleryAPIController extends Controller
{
    /**
 * @OA\Get(
 *     path="/api/gallery",
 *     tags={"Gallery"},
 *     summary="Get list of gallery",
 *     description="Returns a list of gallery items with images",
 *     @OA\Response(
 *         response=200,
 *         description="successful operation",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Berhasil mengambil data gallery"),
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="title", type="string", example="Sunset at Beach"),
 *                     @OA\Property(property="image_url", type="string", example="https://example.com/images/sunset.jpg")
 *                 )
 *             )
 *         )
 *     )
 * )
 */

    public function index()
    {
        // Contoh data gallery
        $gallery = [
            [
                'id' => 1,
                'title' => 'Sunset at Beach',
                'image_url' => 'https://example.com/images/sunset.jpg',
            ],
            [
                'id' => 2,
                'title' => 'Mountain View',
                'image_url' => 'https://example.com/images/mountain.jpg',
            ],
            [
                'id' => 3,
                'title' => 'City Lights',
                'image_url' => 'https://example.com/images/citylights.jpg',
            ],
        ];

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data gallery',
            'data' => $gallery,
        ], 200);
    }
}
