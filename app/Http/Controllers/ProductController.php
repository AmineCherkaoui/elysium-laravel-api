<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\Produit;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Enums\ProductCategory;


class ProductController extends Controller
{


    use ApiResponses;
    public function index(Request $request)
    {
        $query = Produit::query();

         if ($request->filled('ids')) {
        $ids = explode(',', $request->query('ids'));
        $products = $query->whereIn('id', $ids)->get();

        return $this->success("Produits trouvés avec succès.", [
            "products" => $products,
        ]);
    }

        $limit = $request->query('limit', 8);




        if ($request->filled('category')) {
            $category = $request->query('category');
            if (!in_array($category, array_column(ProductCategory::cases(), 'value'))) {
                return $this->error("Catégorie invalide.",400);
            }
            $query->where('category', $category);
        }

        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('fabricant', 'like', "%{$search}%");
            });
        }

        $products = $query->latest()->paginate($limit);



        return $this->success("Produits trouvés avec succès.", [
            "products"=> $products->items(),
            "totalPages"=>$products->lastPage(),
            "total"=> $products->total(),
        ]);
    }

     use ApiResponses;
    public function showBySlug(string $slug)
    {
            $product = Produit::where('slug', $slug)->first();

        if (!$product) {
             return $this->error("Produit non trouvé.",404);

        }

        return $this->success("Produit trouvé avec succès.", $product);
    }

    use ApiResponses;
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        $slug = Str::slug($validated['nom']);
        if (Produit::where('slug', $slug)->exists()) {
            $slug .= '-'.time();
        }

        $imageUrl = null;
        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = $slug.'.'.$extension;
            $request->file('image')->storeAs('images', $filename, 'public');
            $imageUrl = asset("storage/images/{$filename}");
        }

        $product = Produit::create([
            ...$validated,
            'slug' => $slug,
            'imageUrl' => $imageUrl,
        ]);


        return $this->success('Produit créé avec succès.', $product);


    }

    use ApiResponses;
    public function update(UpdateProductRequest $request, string $slug)
    {

                 $product = Produit::where('slug', $slug)->first();

        if (!$product) {
            return $this->error("Produit introuvable.",404);
        }

        $validated = $request->validated();

        if (isset($validated['nom'])) {
        $newSlug = Str::slug($validated['nom']);
        if ($newSlug !== $product->slug && Produit::where('slug', $newSlug)->exists()) {
            $newSlug .= '-' . time();
        }
    } else {
        $newSlug = $product->slug;
    }


        if ($request->hasFile('image')) {
            if ($product->imageUrl) {
                $oldPath = str_replace(asset('storage').'/', '', $product->imageUrl);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = $newSlug.'.'.$extension;
            $request->file('image')->storeAs('images', $filename, 'public');
            $validated['imageUrl'] = asset("storage/images/{$filename}");
        }

        $product->update([
            ...$validated,
            'slug' => $newSlug,
        ]);

        return $this->success('Produit mis à jour avec succès.',$product);

    }

    use ApiResponses;
    public function destroy(string $slug)
    {

        $product = Produit::where('slug', $slug)->first();

        if (!$product) {
           return $this->error("Produit introuvable.",404);
        }

        if ($product->imageUrl) {
            $imagePath = str_replace(asset('storage').'/', '', $product->imageUrl);
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
        }

        $product->delete();

        return $this->success('Produit supprimé avec succès.');
    }
}
