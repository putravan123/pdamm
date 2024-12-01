<?php

namespace App\Http\Controllers;

use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SlideController extends Controller
{
    public function index()
    {
        $slides = Slide::all();
        return view('dashboard.slides.index', compact('slides'));
    }

    public function create()
    {
        return view('dashboard.slides.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);


        Slide::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('slides.index')->with('success', 'Slide berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $slide = Slide::find($id);
        return view('dashboard.slides.edit', compact('slide'));
    }

    public function update(Request $request, Slide $slide, )
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        $slide->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('slides.index')->with('success', 'Slide berhasil diupdate.');
    }

    public function destroy(Slide $slide)
    {
        Storage::disk('public')->delete($slide->image);

        $slide->delete();

        return redirect()->route('slides.index')->with('success', 'Slide berhasil dihapus.');
    }
}
