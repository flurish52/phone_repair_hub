<?php

namespace App\Http\Controllers;

use App\Models\Repairs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RepairsController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard', [
            'repairs' => Repairs::orderBy('created_at', 'DESC')->where('user_id', Auth::id())
                ->get(),
        ]);
    }


    public function updateStatus(Request $request, Repairs $repair)
    {
        if (Auth::id() !== $repair->user_id) {
            return response()->json(['message' => 'Unauthorized access'], 403);
        }
        $validated = $request->validate([
            'status' => 'required|string|in:picked,ready,pending',
        ]);

        $repair->update([
            'status' => $validated['status'],
        ]);

        return response()->json(['message' => 'Status updated successfully'], 200);

    }

    public function sortAndFilter(Request $request)
    {
        $query = Repairs::where('user_id', Auth::id());

        // Filter by status if provided
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Sorting logic
        if ($request->has('sort')) {
            if ($request->sort === 'oldest') {
                $query->orderBy('created_at', 'ASC');
            } else {
                $query->orderBy('created_at', 'DESC');
            }
        } else {
            $query->orderBy('created_at', 'DESC');
        }

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('client_name', 'like', '%' . $request->search . '%')
                    ->orWhere('device', 'like', '%' . $request->search . '%')
                    ->orWhere('staff', 'like', '%' . $request->search . '%');
            });
        }

        $repairs = $query->get();

        return response()->json($repairs);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_phone' => 'nullable|string|max:255',
            'device' => 'required|string|max:255',
            'issue' => 'required|string|max:255',
            'pickup_pin' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'staff' => 'nullable|string|max:255',
            'cost' => 'nullable|numeric|min:0',
            'status' => 'required|in:pending,ready,picked',
            'images' => 'nullable|array',
            'images.*' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:15360',
        ]);


        $paths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('repairs', 'public'); // returns repairs/filename.jpg
                $paths[] = $path;
            }
        }
        $validated['images'] = json_encode($paths);

        $validated['user_id'] = auth()->id();

        $repair = Repairs::create($validated);

        return response()->json([
            'message' => 'Repair record saved successfully',
            'data' => $repair,
        ]);
    }

    public function update(Request $request, Repairs $repair)
    {
        // Check ownership
        if ($repair->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized access'], 403);
        }

        // Decode existing images sent from frontend (after removals)
        $existingImages = $request->has('existing_images')
            ? json_decode($request->existing_images, true) ?? []
            : [];

        // Get old images currently in DB
        $currentImages = $repair->images ? json_decode($repair->images, true) : [];

        // Delete any images that were removed on frontend
        $imagesToDelete = array_diff($currentImages, $existingImages);
        foreach ($imagesToDelete as $img) {
            $fullPath = storage_path('app/public/' . $img);
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }

        // Validate input
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'device' => 'required|string|max:255',
            'issue' => 'required|string|max:255',
            'pickup_pin' => 'required|string|max:255',
            'client_phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
            'staff' => 'nullable|string|max:255',
            'cost' => 'nullable|numeric',
            'status' => 'required|in:pending,ready,picked',
            'images' => 'nullable|array',
            'images.*' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:15360',
        ]);

        // Start with remaining existing images
        $allImages = $existingImages;

        // Handle newly uploaded images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('repairs', 'public');
                $allImages[] = $path;
            }
        }

        // Save updated images
        $validated['images'] = json_encode($allImages);

        // Update repair
        $repair->update($validated);

        return response()->json([
            'message' => 'Repair updated successfully',
            'repair' => $repair
        ]);
    }




    public function destroy(Repairs $repair)
    {
        if (Auth::id() !== $repair->user_id) {
            return response()->json(['message' => 'Unauthorized access'], 403);
        }
        $repair->delete();

        return response()->json(['message' => 'Repair deleted successfully']);
    }

}
