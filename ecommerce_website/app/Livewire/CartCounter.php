<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cart as CartModel;
use Illuminate\Support\Facades\Auth;

class CartCounter extends Component
{
    public $count = 0;

    protected $listeners = ['cartUpdated' => '$refresh'];

    public function mount()
    {
        $this->updateCount();
    }

    public function updateCount()
    {
        if (!Auth::check()) return;

        $cart = CartModel::where('user_id', Auth::id())->first();
        if ($cart) {
            $this->count = $cart->cartItems()->sum('quantity');
        } else {
            $this->count = 0;
        }
    }

    public function render()
    {
        return view('livewire.cart-counter');
    }
}
