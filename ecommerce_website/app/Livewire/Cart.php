<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cart as CartModel;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class Cart extends Component
{
    public $cartItems;
    public $total = 0;

    protected $listeners = ['cartUpdated' => '$refresh'];

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        if (!Auth::check()) return;

        $cart = CartModel::firstOrCreate(['user_id' => Auth::id()]);
        $this->cartItems = $cart->cartItems()->with('product')->get();
        $this->calculateTotal();
    }

    public function updateQuantity($cartItemId, $quantity)
    {
        if ($quantity <= 0) {
            $this->removeFromCart($cartItemId);
            return;
        }

        $cartItem = CartItem::find($cartItemId);
        if ($cartItem && $cartItem->cart->user_id === Auth::id()) {
            $cartItem->quantity = $quantity;
            $cartItem->save();
            
            $this->loadCart();
            $this->dispatch('cartUpdated');
        }
    }

    public function removeFromCart($cartItemId)
    {
        $cartItem = CartItem::find($cartItemId);
        if ($cartItem && $cartItem->cart->user_id === Auth::id()) {
            $cartItem->delete();
            $this->loadCart();
            $this->dispatch('cartUpdated');
        }
    }

    private function calculateTotal()
    {
        $this->total = $this->cartItems->sum(function ($item) {
            return $item->quantity * $item->product->getFinalPrice();
        });
    }

    public function render()
    {
        return view('livewire.cart');
    }
}
