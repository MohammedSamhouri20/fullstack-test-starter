// src/components/ProductListing.jsx
import React from "react";
import ProductCard from "./ProductCard";
import { useProducts } from "../context/ProductContext"; // Import useProducts
import { useCategory } from "../context/CategoryContext"; // Import useCategory

function ProductListing() {
  const { products, loading, error } = useProducts(); // Fetch products
  const { selectedCategory } = useCategory(); // Get the selected category
  if (loading)
    return (
      <div className="d-flex justify-content-center align-items-center vh-100">
        <div className="spinner-grow text-primary" role="status">
          <span className="visually-hidden">Loading...</span>
        </div>
      </div>
    );

  if (error)
    return (
      <p className="text-danger">Error loading products: {error.message}</p>
    );

  return (
    <div className="container">
      <div className="row mb-3">
        <h2 className="col-auto fw-normal p-3 lh-lg text-capitalize">
          {selectedCategory === "all" ? "All" : selectedCategory}
        </h2>
      </div>
      <div className="row gx-2 gy-4 p-0">
        {products.map((product) => (
          <div
            key={product.id}
            className="col-lg-4 col-md-6 col-sm-6 d-flex justify-content-center"
          >
            <ProductCard product={product} />
          </div>
        ))}
      </div>
    </div>
  );
}

export default ProductListing;
