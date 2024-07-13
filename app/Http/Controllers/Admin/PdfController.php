<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pdf;
use App\Models\PdfCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PdfController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        if ($search) {
            $pdfs = Pdf::where('title', 'LIKE', "%$search%")->paginate(10);
        } else {
            $pdfs = Pdf::paginate(10);
        }
        return view('admin.pdfs.index', compact('pdfs'));
    }

    public function create()
    {
        $categories = PdfCategory::all();
        return view('admin.pdfs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'title' => 'required',
            'pdf' => 'required|mimes:pdf|max:20000',
            'description' => 'nullable',
            'status' => 'required|in:free,price',
            // 'category_id' => 'required',
        ]);

        // Handle the PDF file upload
        $file = $request->file('pdf');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $destinationPath = public_path('assets/pdfs/original');
        $file->move($destinationPath, $fileName);
        $originalPath = 'assets/pdfs/original/' . $fileName;

        // Save the PDF information to the database
        Pdf::create([
            'title' => $request->title,
            'description' => $request->description,
            'original_path' => $originalPath,
            'status' => $request->status,
            // 'category_id' => $request->category_id,
        ]);

        // Redirect with success message
        return redirect()->route('admin.pdfs.index')->with('success', 'PDF uploaded successfully.');
    }

    public function show(Pdf $pdf)
    {
        return view('admin.pdfs.show', compact('pdf'));
    }

    public function edit(Pdf $pdf)
    {
        $categories = PdfCategory::all();
        return view('admin.pdfs.edit', compact('pdf', 'categories'));
    }

    public function update(Request $request, Pdf $pdf)
    {
        $request->validate([
            'title' => 'required',
            'pdf' => 'nullable|mimes:pdf|max:20000', // Allow null to skip file update
            'description' => 'nullable',
            'status' => 'required|in:free,price',
            // 'category_id' => 'required',
        ]);

        // Update the PDF fields
        $pdf->title = $request->title;
        $pdf->description = $request->description;
        $pdf->status = $request->status;
        $pdf->category_id = $request->category_id;

        // Check if a new PDF file is uploaded
        if ($request->hasFile('pdf')) {
            $file = $request->file('pdf');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('assets/pdfs/original');
            $file->move($destinationPath, $fileName);
            $originalPath = 'assets/pdfs/original/' . $fileName;

            // Update the path in the PDF model
            $pdf->original_path = $originalPath;
        }

        // Save the updated PDF record
        $pdf->save();

        return redirect()->route('admin.pdfs.index')->with('success', 'PDF updated successfully.');
    }

    public function destroy(Pdf $pdf)
    {
        // Delete PDF file from storage
        try {
            Storage::delete(public_path($pdf->original_path));
        } catch (\Exception $e) {
            // Handle file deletion error
            return redirect()->back()->with('error', 'Failed to delete PDF file.');
        }

        $pdf->delete();

        return redirect()->route('admin.pdfs.index')->with('success', 'PDF deleted successfully.');
    }

    public function stream(Pdf $pdf)
    {
        // Ensure that only authorized users can access the stream
        if (!auth()->check()) {
            abort(403);
        }

        $filePath = public_path($pdf->original_path);

        if (!file_exists($filePath)) {
            abort(404); // File not found
        }

        $stream = new \Symfony\Component\HttpFoundation\StreamedResponse(function () use ($filePath) {
            $stream = fopen($filePath, 'r');
            fpassthru($stream);
            fclose($stream);
        });

        $stream->headers->set('Content-Type', 'application/pdf');
        $stream->headers->set('Content-Length', filesize($filePath));

        return $stream;
    }
}
