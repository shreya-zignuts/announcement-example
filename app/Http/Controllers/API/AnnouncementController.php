<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the announcements.
     */
    public function index(Request $request): JsonResponse
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'filter' => ['nullable', Rule::in(['all', 'past', 'upcoming'])], // Validate the 'filter' parameter
            'per_page' => ['nullable', 'integer', 'min:1'], // Validate the 'per_page' parameter
        ]);

        // Redirect back with errors if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Get validated data or set defaults
        $filter = $request->input('filter');

        $perPage = $request->input('per_page');

        // Get the current date and time
        $currentDateTime = Carbon::now();

        // Initialize query builder
        $query = Announcement::query();

        // Apply filter conditions
        if ($filter === 'past') {
            $query->where(function ($q) use ($currentDateTime) {
                $q->where('date', '<', $currentDateTime->toDateString())->orWhere(function ($q2) use ($currentDateTime) {
                    $q2->where('date', '=', $currentDateTime->toDateString())->where('time', '<', $currentDateTime->toTimeString());
                });
            });
        } elseif ($filter === 'upcoming') {
            $query->where(function ($q) use ($currentDateTime) {
                $q->where('date', '>', $currentDateTime->toDateString())->orWhere(function ($q2) use ($currentDateTime) {
                    $q2->where('date', '=', $currentDateTime->toDateString())->where('time', '>=', $currentDateTime->toTimeString());
                });
            });
        }

        // Get announcements based on filter with pagination
        $announcements = $query->orderBy('date')->orderBy('time')->paginate($perPage);

        return response()->json($announcements);
    }

    /**
     * Store a newly created announcement in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'message'   => 'required|string|max:255',
            'date'      => 'required|date|after_or_equal:today',
            'time'      => 'required|date_format:H:i',
        ]);

        $announcement = new Announcement($request->only(['message', 'date', 'time']));

        $announcement->save();

        return response()->json(['message' => 'Announcement created successfully', 'announcement' => $announcement], 201);
    }

    /**
     * Display the specified announcement from storage.
     */
    public function show($id): JsonResponse
    {
        $announcement = Announcement::findOrFail($id);
        return response()->json($announcement);
    }

    /**
     * Update the specified announcement in storage.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'message'   => 'required|string|max:255',
            'date'      => 'required|date',
            'time'      => 'required|date_format:H:i',
        ]);

        $validator->after(function ($validator) use ($request, $id) {
            $date = $request->input('date');
            $time = $request->input('time');

            $dateTime = Carbon::parse($date . ' ' . $time);
            $now = Carbon::now();

            // dd($now);
            $announcement = Announcement::findOrFail($id);
            $announcementDateTime = Carbon::parse($announcement->date . ' ' . $announcement->time);

            if ($dateTime < $now || $announcementDateTime < $now) {
                $validator->errors()->add('Announcement', 'Past announcements cannot be edited');
            }
        });

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $announcement = Announcement::findOrFail($id);
        $announcement->update($request->only(['message', 'date', 'time']));

        return response()->json(['message' => 'Announcement updated successfully', 'announcement' => $announcement]);
    }

    /**
     * Remove the specified announcement from storage.
     */
    public function delete(Request $request, $id) : JsonResponse
    {
        $request->validate([
            'forceDelete' => 'nullable|boolean',
        ]);

        $announcement = Announcement::findOrFail($id);

        $dateTime = Carbon::parse($announcement->date . ' ' . $announcement->time);
        $now = Carbon::now();

        if ($dateTime < $now) {
            return response()->json(['error' => 'Past Announcement cannot be deleted.']);
        }

        if ($request->has('forceDelete')) {
            $announcement->forceDelete();
        } else {
            $announcement->delete();
        }

        return response()->json(['success' => 'Announcement deleted successfully.']);
    }
}
