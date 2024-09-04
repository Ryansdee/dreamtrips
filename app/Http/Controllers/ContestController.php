<?php

namespace App\Http\Controllers;

use App\Models\Contest;
use Illuminate\Http\Request;
use App\Models\ContestImage;

class ContestController extends Controller
{
    public function index()
    {
        $contests = Contest::all();
        return view('contests.index', compact('contests'));
    }

    public function show($id)
    {
        $contest = Contest::findOrFail($id);
        return view('contests.show', compact('contest'));
    }

    public function create()
    {
        return view('contests.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'entry_fee' => 'required|numeric',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validation pour les images
        ]);

        $contest = Contest::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'entry_fee' => $request->input('entry_fee'),
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('contests', 'public');
                ContestImage::create([
                    'contest_id' => $contest->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('contests.index')->with('success', 'Contest created successfully!');
    }
    public function participate($id)
    {
        $contest = Contest::findOrFail($id);

        if ($contest->reserveSlot()) {
            return redirect()->back()->with('success', 'You have successfully entered the contest!');
        }

        return redirect()->back()->with('error', 'No available slots left for this contest.');
    }
}
