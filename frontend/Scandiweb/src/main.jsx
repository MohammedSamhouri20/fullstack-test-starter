import { StrictMode } from "react";
import { createRoot } from "react-dom/client";
import { ApolloProvider } from "@apollo/client";
import client from "./apolloClient.js";
import "./index.css";
import App from "./App.jsx";
import { CartProvider } from "./context/CartContext.jsx";

createRoot(document.getElementById("root")).render(
  <ApolloProvider client={client}>
    <CartProvider>
      <App />
    </CartProvider>
  </ApolloProvider>
);
