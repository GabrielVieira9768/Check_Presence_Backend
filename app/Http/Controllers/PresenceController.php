<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use Illuminate\Http\Request;

class PresenceController extends Controller
{
    public function index()
    {
        return Presence::with(['classroom', 'user'])->get();
    }

    public function store(Request $request)
    {
        return Presence::create($request->all());
    }

    public function show(Presence $presence)
    {
        return $presence->load('classroom', 'user');
    }

    public function update(Request $request, Presence $presence)
    {
        $presence->update($request->all());
        return $presence;
    }

    public function destroy(Presence $presence)
    {
        $presence->delete();
        return response()->noContent();
    }
}
