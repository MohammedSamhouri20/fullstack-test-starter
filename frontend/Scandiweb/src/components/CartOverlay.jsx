import React from "react";
import { useCart } from "../context/CartContext";
import CartItem from "./CartItem";

function CartOverlay({ className }) {
  const { cartItems, getTotalPrice, placeOrder, getTotalItems } = useCart();

  return (
    <div className={className}>
      <div className="container-fluid py-4 px-3">
        <div className="row justify-content-between gap-4">
          <div className="col-12">
            <strong>My Bag</strong>
            <span data-testid="cart-total" className="fw-medium">
              , {getTotalItems()} {getTotalItems() <= 1 ? "item" : "items"}
            </span>
          </div>

          <div className="col-12 d-flex flex-column gap-4">
            {cartItems.map((item, index) => (
              <CartItem key={index} item={item} />
            ))}
          </div>

          <div className="col-12 d-flex justify-content-between">
            <span className="fw-medium">Total</span>
            <span className="fw-bold">${getTotalPrice().toFixed(2)}</span>
          </div>

          <div className="col-12">
            <button
              className="btn btn-primary rounded-0 border-0 text-white fw-semibold w-100 py-3 px-4"
              onClick={placeOrder}
              disabled={cartItems.length < 1}
            >
              Place Order
            </button>
          </div>
        </div>
      </div>
    </div>
  );
}

export default CartOverlay;
