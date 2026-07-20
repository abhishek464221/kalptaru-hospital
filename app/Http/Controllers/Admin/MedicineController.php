<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function index(Request $request)
    {
        $medicines = Medicine::search(
                $request->search,
                [
                    'name',
                    'category',
                    'supplier',
                    'batch_number',
                    'description'
                ]
            )
            ->latest()
            ->paginate(10);

        return view('admin.medicine.index', compact('medicines'));
    }

    public function create()
    {
        return view('admin.medicine.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'supplier' => 'nullable|string|max:255',
            'batch_number' => 'nullable|string|max:100',
            'purchase_price' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'nullable|integer|min:0',
            'reorder_level' => 'nullable|integer|min:0',
            'manufacture_date' => 'nullable|date',
            'expiry_date' => 'nullable|date|after:manufacture_date',
            'description' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        Medicine::create($data);

        return redirect()->route('admin.medicines.index')
            ->with('success', 'Medicine created successfully.');
    }

    public function edit(Medicine $medicine)
    {
        return view('admin.medicine.edit', compact('medicine'));
    }

    public function update(Request $request, Medicine $medicine)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'supplier' => 'nullable|string|max:255',
            'batch_number' => 'nullable|string|max:100',
            'purchase_price' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'nullable|integer|min:0',
            'reorder_level' => 'nullable|integer|min:0',
            'manufacture_date' => 'nullable|date',
            'expiry_date' => 'nullable|date|after:manufacture_date',
            'description' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        $medicine->update($data);

        return redirect()->route('admin.medicines.index')
            ->with('success', 'Medicine updated successfully.');
    }

    public function destroy(Medicine $medicine)
    {
        $medicine->delete();
        return redirect()->route('admin.medicines.index')
            ->with('success', 'Medicine deleted successfully.');
    }
}