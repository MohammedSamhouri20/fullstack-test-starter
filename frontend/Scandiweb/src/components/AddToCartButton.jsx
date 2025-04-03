import React from "react";
import { useCart } from "../context/CartContext"; // Import Cart Context

function AddToCartButton({ product, selectedAttributes, requiredAttributes }) {
  const { addToCart, setIsCartOpen } = useCart(); // Use the Cart Context

  // Check if all required attributes have been selected
  const allAttributesSelected =
    requiredAttributes.length === Object.keys(selectedAttributes).length;

  const handleAddToCart = () => {
    if (!allAttributesSelected) return; // Prevent adding if attributes aren't selected
    addToCart(product, selectedAttributes); // Add product with selected attributes
    setIsCartOpen(true);
  };

  return (
    <button
      data-testid="add-to-cart"
      className="btn btn-primary py-3 px-2 fw-semibold text-white rounded-0 text-uppercase mt-3"
      disabled={!allAttributesSelected || !product.inStock} // Disable button if attributes aren't selected
      onClick={handleAddToCart} // Add product to cart when clicked
    >
      Add to Cart
    </button>
  );
}

export default AddToCartButton;
