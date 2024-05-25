<?php

namespace App\Helpers;

use App\Models\Product;
use Illuminate\Support\Facades\Cookie;

class CartManagement
{
    // Add item to cart
    static public function addItemToCart($product_id)
    {
        $cart_items = self::getCartItemsFromCookies();
        $existing_item = null;
        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                $existing_item = $key;
                break;
            }
        }

        if ($existing_item !== null) {
            $cart_items[$existing_item]['quantity'] += 1;
            $cart_items[$existing_item]['total_amount'] = $cart_items[$existing_item]['quantity'] * $cart_items[$existing_item]['unit_amount'];
        } else {
            $product = Product::find($product_id);
            $cart_items[] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'image' => $product->image,
                'quantity' => 1,
                'unit_amount' => $product->price,
                'total_amount' => $product->price
            ];
        }

        self::addCardItemsToCookies($cart_items);
        return count($cart_items);
    }

    // Remove item from cart
    static public function removeItemFromCart($product_id)
    {
        $cart_items = self::getCartItemsFromCookies();
        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                unset($cart_items[$key]);
            }
        }
        self::addCardItemsToCookies($cart_items);
        return count($cart_items);
    }

    // Add cart items to cookies
    static public function addCardItemsToCookies($cart_items)
    {
        Cookie::queue('cart_items', json_encode($cart_items), 60 * 24 * 30);
    }

    // Remove cart items from cookies
    static public function removeCartItemsFromCookies()
    {
        Cookie::queue(Cookie::forget('cart_items'));
    }

    // Get all cart items from cookies
    static public function getCartItemsFromCookies()
    {
        $cart_items = json_decode(Cookie::get('cart_items'), true);
        if (!$cart_items) {
            return [];
        }
        return $cart_items;
    }

    // Increment cart items quantity
    static public function incrementCartItemToQuantity($product_id)
    {
        $cart_items = self::getCartItemsFromCookies();
        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                $cart_items[$key]['quantity'] += 1;
                $cart_items[$key]['total_amount'] = $cart_items[$key]['quantity'] * $cart_items[$key]['unit_amount'];
            }
        }

        self::addCardItemsToCookies($cart_items);
        return $cart_items;
    }

    // Decrement cart items quantity
    static public function decrementCartItemToQuantity($product_id)
    {
        $cart_items = self::getCartItemsFromCookies();
        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                $cart_items[$key]['quantity'] -= 1;
                $cart_items[$key]['total_amount'] = $cart_items[$key]['quantity'] * $cart_items[$key]['unit_amount'];
            }
        }

        self::addCardItemsToCookies($cart_items);
        return $cart_items;
    }

    // Calculate cart total
    static public function calculateCartTotal($items)
    {
        return array_sum(array_column($items, 'total_amount'));
    }
}
