<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;

class FileExplorerController extends Controller
{
    public function index()
    {
        $files = Storage::files('/Documents');
        $folders = Storage::directories('/Documents');
        $path = '/Documents';

        return view('file_explorer.index', compact('files', 'folders', 'path'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
            'path' => 'nullable|string'
        ]);

        $path = $request->input('path', '/');
        Storage::putFileAs($path, $request->file('file'), $request->file('file')->getClientOriginalName());

        return back();
    }

    public function createFolder(Request $request)
    {
        $request->validate([
            'folder_name' => 'required|string',
            'path' => 'nullable|string'
        ]);

        $path = $request->input('path', '/');
        Storage::makeDirectory($path . '/' . $request->input('folder_name'));

        return back();
    }

    public function folder($path)
    {
        $path = str_replace('-', '/', $path);
        $files = Storage::files($path);
        $folders = Storage::directories($path);

        return view('file_explorer.index', compact('files', 'folders', 'path'));
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
                if(Storage::exists($newPath)){
                    return response()->json(['message' => 'Name Already exist.'], 200);
                }

                Storage::move($oldPath, $newPath);

            // return response()->json(['message' => 'Rename successful.'], 200);
            return back();
        }

        // return response()->json(['message' => 'The specified path does not exist.'], 404);
        return back();
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
            if (is_dir($fullPath)) {
                Storage::deleteDirectory($fullPath);
            } else {
                Storage::delete($fullPath);
            }
        }

        return back();
    }
}
