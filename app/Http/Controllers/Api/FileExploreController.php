<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;
use Illuminate\Support\Facades\File;

class FileExploreController extends Controller
{
    public function index(Request $request)
    {
        $path = $request->query('path', '/documents');
        $files = Storage::files($path);
        $folders = Storage::directories($path);

        return response()->json([
            'files' => $files,
            'folders' => $folders,
            'path' => $path
        ]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file.*' => 'required|file',
            'path' => 'nullable|string'
        ]);

        $path = $request->input('path', '/');

        foreach ($request->file('file') as $file) {
            Storage::putFileAs($path, $file, $file->getClientOriginalName());
        }

        return response()->json(['message' => 'Files uploaded successfully.'], 200);
    }

    public function createFolder(Request $request)
    {
        $request->validate([
            'folder_name' => 'required|string',
            'path' => 'nullable|string'
        ]);

        $path = $request->input('path', '/');
        Storage::makeDirectory($path . '/' . $request->input('folder_name'));

        return response()->json(['message' => 'Folder created successfully.'], 200);
    }

    public function folder($path)
    {
        $path = str_replace('-', '/', $path);
        $files = Storage::files($path);
        $folders = Storage::directories($path);

        return response()->json([
            'files' => $files,
            'folders' => $folders,
            'path' => $path
        ]);
    }

    public function rename(Request $request)
    {
        $request->validate([
            'old_name' => 'required|string',
            'new_name' => 'required|string',
            'old_path' => 'required|string'
        ]);

        $oldPath = $request->input('old_path');
        $newName = $request->input('new_name');
        $newPath = dirname($oldPath) . '/' . $newName;

        if (Storage::exists($oldPath)) {
            $extension = pathinfo($oldPath, PATHINFO_EXTENSION);
            if ($extension) {
                $newPath .= '.' . $extension;
            }
            if (Storage::exists($newPath)) {
                return response()->json(['message' => 'Name already exists.'], 200);
            }

            Storage::move($oldPath, $newPath);
            return response()->json(['message' => 'Rename successful.'], 200);
        }

        return response()->json(['message' => 'The specified path does not exist.'], 404);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'path' => 'required|string'
        ]);

        $path = rtrim($request->input('path'), '/');
        $fullPath = $path . '/' . $request->input('name');

        if (Storage::exists($fullPath)) {
            if (Storage::disk('local')->directoryExists($fullPath)) {
                Storage::deleteDirectory($fullPath);
            } else {
                Storage::delete($fullPath);
            }
        }

        return response()->json(['message' => 'Delete successful.'], 200);
    }
}
