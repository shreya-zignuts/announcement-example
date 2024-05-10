<?php

namespace App\Http\Controllers\API;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserAnnouncementController extends Controller
{
    /**
     * Display a listing of the announcements for the user.
     */
    public function index(Request $request) : JsonResponse
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'per_page'  => ['nullable', 'integer', 'min:1'],
        ]);

        $perPage = $request->input('per_page'); //request field for per_page pagination user wants

        $announcements = Announcement::orderBy('date')->orderBy('time')->paginate($perPage); //pagination using per page data

        return response()->json($announcements);

    }

    /**
     * Display the specified announcement for the user.
     */
    public function show($id) : JsonResponse
    {
        $announcement = Announcement::findOrFail($id);

        // updating status to Visible when viewed by user
        $announcement->status = 'V'; // V = Visible
        $announcement->save();

        return response()->json($announcement);
    }
}
