import { useCart } from "../hooks/useCart";

function AddToCartButton({ product, selectedAttributes, requiredAttributes }) {
  const { addToCart, setIsCartOpen } = useCart();
  const allAttributesSelected =
    requiredAttributes.length === Object.keys(selectedAttributes).length;

  const handleAddToCart = () => {
    if (!allAttributesSelected) return;
    addToCart(product, selectedAttributes);
    setIsCartOpen(true);
  };

  return (
    <button
      data-testid="add-to-cart"
      className="btn btn-primary py-3 px-2 fw-semibold text-white rounded-0 text-uppercase mt-3"
      disabled={!allAttributesSelected || !product.inStock}
      onClick={handleAddToCart}
    >
      Add to Cart
    </button>
  );
}
export default AddToCartButton;
