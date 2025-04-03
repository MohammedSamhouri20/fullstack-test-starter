import React from "react";
import CartIcon from "../assets/CartIcon.jsx";
import { useCart } from "../context/CartContext.jsx";
function CartButton({ toggleCartOverlay }) {
  const { getTotalItems } = useCart();
  return (
    <button
      className="btn border-0 p-0 position-relative"
      data-testid="cart-btn"
      onClick={() => toggleCartOverlay()}
    >
      <CartIcon />
      {getTotalItems() != 0 && (
        <span
          style={{
            width: "20px",
            height: "20px",
            lineHeight: "100%",
          }}
          className="position-absolute top-0 start-100 d-flex align-items-center justify-content-center text-center translate-middle badge text-white rounded-circle bg-black"
        >
          {getTotalItems()}
        </span>
      )}
    </button>
  );
}

export default CartButton;
