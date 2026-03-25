<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Burger;
use App\Models\Categorie;

class BurgerController extends Controller
{
    public function index()
    {
        $burgers = Burger::with('categorie')->latest()->get();
        return view('gestionnaire.burgers.index', compact('burgers'));
    }

    public function create()
    {
        $categories = Categorie::all();
        return view('gestionnaire.burgers.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'          => 'required|string|max:255',
            'prix'         => 'required|numeric|min:0',
            'description'  => 'nullable|string',
            'categorie_id' => 'required|exists:categories,id',
            'stock'        => 'required|integer|min:0',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->all();

        // Upload image
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('burgers', 'public');
        }

        Burger::create($data);

        return redirect()->route('gestionnaire.burgers.index')
            ->with('success', 'Burger ajouté avec succès !');
    }

    public function edit($id)
    {
        $burger     = Burger::findOrFail($id);
        $categories = Categorie::all();
        return view('gestionnaire.burgers.edit', compact('burger', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $burger = Burger::findOrFail($id);

        $request->validate([
            'nom'          => 'required|string|max:255',
            'prix'         => 'required|numeric|min:0',
            'description'  => 'nullable|string',
            'categorie_id' => 'required|exists:categories,id',
            'stock'        => 'required|integer|min:0',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->all();

        // Upload nouvelle image
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('burgers', 'public');
        }

        $burger->update($data);

        return redirect()->route('gestionnaire.burgers.index')
            ->with('success', 'Burger modifié avec succès !');
    }

    public function destroy($id)
    {
        $burger = Burger::findOrFail($id);
        $burger->update(['actif' => false]);

        return redirect()->route('gestionnaire.burgers.index')
            ->with('success', 'Burger archivé avec succès !');
    }

    public function show($id)
    {
        return back();
    }

    public function catalogue(Request $request)
    {
        $query = Burger::with('categorie')->where('actif', true);

        if ($request->search) {
            $query->where('nom', 'like', '%' . $request->search . '%');
        }

        if ($request->categorie) {
            $query->where('categorie_id', $request->categorie);
        }

        if ($request->tri === 'asc') {
            $query->orderBy('prix', 'asc');
        } elseif ($request->tri === 'desc') {
            $query->orderBy('prix', 'desc');
        }

        $burgers    = $query->get();
        $categories = Categorie::all();

        return view('client.catalogue', compact('burgers', 'categories'));
    }

    public function detail($id)
    {
        $burger = Burger::with('categorie')->findOrFail($id);
        return view('client.burger-detail', compact('burger'));
    }
}
