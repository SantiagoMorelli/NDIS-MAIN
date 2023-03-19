<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use Illuminate\Http\Request;

class CourierController extends Controller
{
    public function index()
    {
        $couriers = Courier::all();
        return view('couriers.index', ['couriers' => $couriers]);
    }

    public function create()
    {
        return view('couriers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'link' => 'required|max:255'
        ]);

        $courier = new Courier();
        $courier->name = $request->input('name');
        $courier->link = $request->input('link');
        $courier->save();

        return redirect()->route('couriers.index')->with('success', 'Courier created successfully!');
    }

    public function edit($id)
    {
        $courier = Courier::findOrFail($id);
        return view('couriers.edit', ['courier' => $courier]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'link' => 'required|max:255'
        ]);

        $courier = Courier::findOrFail($id);
        $courier->name = $request->input('name');
        $courier->link = $request->input('link');
        $courier->save();

        return redirect()->route('couriers.index')->with('success', 'Courier updated successfully!');
    }

    public function destroy($id)
    {
        $courier = Courier::findOrFail($id);
        $courier->delete();

        return redirect()->route('couriers.index')->with('success', 'Courier deleted successfully!');
    }
}

