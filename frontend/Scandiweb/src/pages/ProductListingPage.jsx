import { useEffect } from "react";
import ProductCard from "../components/ProductCard";
import { useProduct } from "../hooks/useProduct";
import { useCategory } from "../hooks/useCategory";
import { useParams } from "react-router-dom";

function ProductListingPage() {
  const { products, loading, error } = useProduct();
  const { setSelectedCategory } = useCategory();
  const { category } = useParams();

  useEffect(() => {
    setSelectedCategory(category || "all");
  }, [category, setSelectedCategory]);

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
          {category === "all" || category === undefined ? "All" : category}
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
export default ProductListingPage;
