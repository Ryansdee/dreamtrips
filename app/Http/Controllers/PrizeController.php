<?php

namespace App\Http\Controllers;

use App\Models\Contest;
use App\Models\Prize;
use Illuminate\Http\Request;

class PrizeController extends Controller
{
    public function create(Contest $contest)
    {
        return view('prizes.create', compact('contest'));
    }

    public function store(Request $request, Contest $contest)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric',
        ]);

        $contest->prizes()->create($request->all());

        return redirect()->route('contests.show', $contest->id)->with('success', 'Prize added successfully.');
    }
}
