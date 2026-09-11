<?php
// models/Cart.php

/**
 * Class Cart
 * Handles shopping cart logic using PHP sessions.
 */
class Cart
{
    /**
     * Retrieve all items in the cart.
     *
     * @return array
     */
    public static function getItems()
    {
        return isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    }

    /**
     * Add a product to the cart.
     *
     * @param array $product
     * @param int $quantity
     */
    public static function addItem($product, $quantity)
    {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $productId = $product['id'];

        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$productId] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $quantity
            ];
        }
    }

    /**
     * Remove a product from the cart by its ID.
     *
     * @param int $productId
     */
    public static function removeItem($productId)
    {
        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }
    }

    /**
     * Update quantities of multiple products in the cart.
     *
     * @param array $quantities
     */
    public static function updateQuantities($quantities)
    {
        foreach ($quantities as $productId => $quantity) {
            if (isset($_SESSION['cart'][$productId])) {
                $_SESSION['cart'][$productId]['quantity'] = max(1, (int)$quantity);
            }
        }
    }

    /**
     * Clear the entire cart.
     */
    public static function clear()
    {
        $_SESSION['cart'] = [];
    }
}
