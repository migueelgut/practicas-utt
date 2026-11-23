<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $perPage = in_array((int) $request->per_page, [10, 15, 25, 50]) ? (int) $request->per_page : 10;
        $sort = $request->get('sort', 'created_at');
        $dir = $request->get('dir', 'asc') === 'desc' ? 'desc' : 'asc';

        $allowedSorts = ['nombre', 'precio', 'existencias', 'created_at'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'created_at';
        }

        $productos = Producto::with('categoria')
            ->when($request->nombre, fn($q, $v) => $q->where('nombre', 'like', "%{$v}%"))
            ->when($request->categoria_id, fn($q, $v) => $q->where('categoria_id', $v))
            ->when($request->precio_min !== null && $request->precio_min !== '', fn($q) => $q->where('precio', '>=', $request->precio_min))
            ->when($request->precio_max !== null && $request->precio_max !== '', fn($q) => $q->where('precio', '<=', $request->precio_max))
            ->when($request->estado, fn($q, $v) => $q->where('estado', $v))
            ->orderBy($sort, $dir)
            ->paginate($perPage)
            ->withQueryString();

        $categorias = Categoria::orderBy('nombre')->get();

        return view('productos.index', compact('productos', 'categorias', 'perPage', 'sort', 'dir'));
    }

    public function create()
    {
        $categorias = Categoria::orderBy('nombre')->get();
        return view('productos.create', compact('categorias'));
    }

    public function store(StoreProductoRequest $request)
    {
        Producto::create($request->validated());
        return redirect()->route('productos.index')->with('success', 'Producto registrado correctamente.');
    }

    public function edit(Producto $producto)
    {
        $categorias = Categoria::orderBy('nombre')->get();
        return view('productos.edit', compact('producto', 'categorias'));
    }

    public function update(UpdateProductoRequest $request, Producto $producto)
    {
        $producto->update($request->validated());
        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }
}