import { useEffect, useState } from "react";
import { useMutation } from "@apollo/client";
import gql from "graphql-tag";
import { CartContext } from "./CartContext";

const PLACE_ORDER_MUTATION = gql`
  mutation PlaceOrder($input: OrderInput!) {
    placeOrder(input: $input) {
      id
      items {
        id
        quantity
        product {
          id
          name
          prices {
            amount
          }
        }
      }
    }
  }
`;

export function CartProvider({ children }) {
  const [cartItems, setCartItems] = useState(() => {
    const savedCart = sessionStorage.getItem("cart");
    return savedCart ? JSON.parse(savedCart) : [];
  });
  const [placeOrderMutation] = useMutation(PLACE_ORDER_MUTATION);
  const [isCartOpen, setIsCartOpen] = useState(false);

  useEffect(() => {
    sessionStorage.setItem("cart", JSON.stringify(cartItems));
  }, [cartItems]);

  const addToCart = (product, selectedOptions) => {
    const existingItem = cartItems.find(
      (item) =>
        item.id === product.id &&
        JSON.stringify(item.selectedOptions) === JSON.stringify(selectedOptions)
    );
    if (existingItem) {
      setCartItems(
        cartItems.map((item) =>
          item.id === product.id
            ? { ...item, quantity: item.quantity + 1 }
            : item
        )
      );
    } else {
      setCartItems([
        ...cartItems,
        { ...product, selectedOptions, quantity: 1 },
      ]);
    }
  };

  const updateQuantity = (id, selectedOptions, quantity) => {
    setCartItems(
      cartItems
        .map((item) =>
          item.id === id &&
          JSON.stringify(item.selectedOptions) ===
            JSON.stringify(selectedOptions)
            ? { ...item, quantity }
            : item
        )
        .filter((item) => item.quantity > 0)
    );
  };

  const getTotalItems = () => {
    return cartItems.reduce((total, item) => total + item.quantity, 0);
  };

  const getTotalPrice = () => {
    return cartItems.reduce(
      (total, item) => total + item.prices[0].amount * item.quantity,
      0
    );
  };

  const placeOrder = async () => {
    if (cartItems.length === 0) return;
    const itemsForOrder = cartItems.map((item) => ({
      productId: item.id,
      quantity: item.quantity,
      selectedAttributes: Object.entries(item.selectedOptions).map(
        ([key, value]) => ({
          key,
          value,
        })
      ),
    }));
    try {
      await placeOrderMutation({
        variables: { input: { items: itemsForOrder } },
      });
      setCartItems([]);
    } catch (error) {
      console.error("Order failed", error);
    }
  };

  return (
    <CartContext.Provider
      value={{
        cartItems,
        addToCart,
        isCartOpen,
        setIsCartOpen,
        updateQuantity,
        getTotalPrice,
        getTotalItems,
        placeOrder,
      }}
    >
      {children}
    </CartContext.Provider>
  );
}
