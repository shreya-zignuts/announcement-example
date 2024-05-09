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

        $validator = Validator::make($request->all(), [
            'per_page'  => ['nullable', 'integer', 'min:1'],
        ]);

        $perPage = $request->input('per_page');

        $announcements = Announcement::orderBy('date')->orderBy('time')->paginate($perPage);

        return response()->json($announcements);

    }

    /**
     * Display the specified announcement for the user.
     */
    public function show($id) : JsonResponse
    {
        $announcement = Announcement::findOrFail($id);

        $announcement->status = 'V'; // status updated to Visible when viewed by user
        $announcement->save();

        return response()->json($announcement);
    }
}
