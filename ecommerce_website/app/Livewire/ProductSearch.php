<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class ProductSearch extends Component
{
    public $search = '';
    public $category = '';
    public $sort = 'featured';
    public $products;

    protected $queryString = ['search', 'category', 'sort'];

    protected $listeners = ['updateProducts' => 'filterProducts'];

    public function mount()
    {
        $this->filterProducts();
    }

    public function filterProducts()
    {
        $query = Product::where('is_active', true)
            ->where('is_approved', true)
            ->with('category', 'vendor');

        if ($this->category) {
            $query->whereHas('category', function (Builder $q) {
                $q->where('slug', $this->category);
            });
        }

        if ($this->search) {
            $search = $this->search;
            $query->where(function (Builder $q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        switch ($this->sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->latest();
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            default:
                $query->orderBy('sales', 'desc');
        }

        $this->products = $query->paginate(12);
    }

    public function render()
    {
        return view('livewire.product-search');
    }
}