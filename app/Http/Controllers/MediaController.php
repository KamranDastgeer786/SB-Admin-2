<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMediaRequest;
use App\Http\Requests\UpdateMediaRequest;
use App\Models\MediaUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Audit;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class MediaController extends Controller
{
    /**
     * Apply middleware for permissions
     */
    public function __construct()
    {
        $this->middleware('permission:show_media', ['only' => ['index', 'show']]);
        $this->middleware('permission:create_media', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_media', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_media', ['only' => ['destroy', 'massDeleteMedia']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $media = MediaUpload::all();
        // Record an audit trail for the read action
        Audit::create([
            'action_type' => 'Read',
            'resource_affected' => 'MediaUpload',
            'previous_state' => null,
            'new_state' => json_encode($media),
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->roles->pluck('name')->first(),
        ]);
        return view('media.index', compact('media'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('media.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMediaRequest $request)
    {
        $validatedData = $request->validated();

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $fileName, 'public');
            $fileType = $file->getClientOriginalExtension();
            $fileSize = $file->getSize();
        } else {
            $fileName = null;
            $fileType = null;
            $fileSize = null;
        }

        $media = MediaUpload::create([
            'file_name' => $validatedData['file_name'],
            'file_type' => $fileType,
            'file_size' => $fileSize,
            'upload_date' => now(),
            'file_path' => $fileName ? 'storage/' . $filePath : null,
        ]);

        // Log the Create action
        Log::create([
            'action_performed' => 'Create MediaUpload',
            'user_id' => Auth::id(),
            'ip_address' => request()->ip(),
        ]);

        // Log the Create action
        Audit::create([
            'action_type' => 'Create',
            'resource_affected' => 'MediaUpload',
            'previous_state' => null,
            'new_state' => json_encode($validatedData),
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->roles->pluck('name')->first(),
        ]);

        if ($media) {
            return response()->json(['message' => 'Media Created Successfully!', 'media' => $media]);
        } else {
            return response()->json(['message' => 'Media Creation Failed'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // You can return a view or perform any action to display media details
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MediaUpload $media_upload)
    {
        //dd($media_upload);
        if ($media_upload) {
            return view('media.create', compact('media_upload'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMediaRequest $request, MediaUpload $media_upload)
    {
        $validatedData = $request->validated();

        $oldState = $media_upload->toArray();

        if ($request->hasFile('file')) {
            // Delete the old file
            if ($media_upload->file_path && Storage::exists($media_upload->file_path)) {
                Storage::delete($media_upload->file_path);
            }

            // Upload the new file
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $fileName, 'public');
            $fileType = $file->getClientOriginalExtension();
            $fileSize = $file->getSize();

            $media_upload->update([
                'file_name' => $validatedData['file_name'],
                'file_type' => $fileType,
                'file_size' => $fileSize,
                'upload_date' => now(),
                'file_path' => 'storage/' . $filePath,
            ]);
        } else {
            $media_upload->update([
                'file_name' => $validatedData['file_name'],
            ]);
        }

        // Log the Update action
        Log::create([
            'action_performed' => 'Update MediaUpload',
            'user_id' => Auth::id(),
            'ip_address' => request()->ip(),
        ]);

        // Record an audit trail for the update action
        Audit::create([
            'action_type' => 'Update',
            'resource_affected' => 'MediaUpload',
            'previous_state' => json_encode($oldState),
            'new_state' => json_encode($validatedData),
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->roles->pluck('name')->first(),
        ]);

        if ($media_upload) {
            return response()->json(['message' => 'Media Updated Successfully']);
        } else {
            return response()->json(['message' => 'Media Update Failed'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MediaUpload $media_upload)
    {
        $oldData = $media_upload->toArray();
        if ($media_upload) {
            if ($media_upload->file_path && Storage::exists($media_upload->file_path)) {
                Storage::delete($media_upload->file_path);
            }

            if ($media_upload->delete()) {


                // Log the Delete action
                Log::create([
                  'action_performed' => 'Delete MediaUpload',
                   'user_id' => Auth::id(),
                  'ip_address' => request()->ip(),
                ]);

                // Record an audit trail for the delete action
                Audit::create([
                   'action_type' => 'Delete',
                   'resource_affected' => 'MediaUpload',
                   'previous_state' => json_encode($oldData),
                   'new_state' => null,
                   'user_id' => Auth::id(),
                   'user_role' => Auth::user()->roles->pluck('name')->first(),
              ]);

                return response()->json(['message' => 'Media Deleted Successfully'], 200);
            }
        }
        return response()->json(['message' => 'Media Not Found'], 404);
    }

    /**
     * Mass delete media items.
     */
    public function massDeleteMedia(Request $request)
    {
        $ids = $request->ids;
        MediaUpload::destroy($ids);

        return response()->json(['message' => 'Media Deleted Successfully']);
    }
}