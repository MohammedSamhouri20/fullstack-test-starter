import { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import { useProduct } from "../hooks/useProduct";
import parse from "html-react-parser";
import ImageCarousel from "../components/ImageCarousel";
import styles from "../styles/ProductDetails.module.css";
import ProductAttributes from "../components/ProductAttributes";
import AddToCartButton from "../components/AddToCartButton";

function ProductDetailsPage() {
  const { id } = useParams();
  const { fetchProduct, productData, productLoading, productError } =
    useProduct();
  const [selectedAttributes, setSelectedAttributes] = useState({});

  useEffect(() => {
    if (id) {
      fetchProduct({ variables: { id } });
    }
  }, [id, fetchProduct]);

  if (productLoading || !productData)
    return (
      <div className="d-flex justify-content-center align-items-center vh-100">
        <div className="spinner-grow text-primary" role="status">
          <span className="visually-hidden">Loading...</span>
        </div>
      </div>
    );

  if (productError) return <p>Error: {productError.message}</p>;

  const product = productData?.products?.[0];

  if (!product) return <p>Product not found!</p>;

  return (
    <div className="container mt-5">
      <div className="row gap-5">
        {/* Left Section - Carousel */}
        <div className="col-md-7 col-12">
          <ImageCarousel images={product.gallery} />
        </div>
        {/* Right Section - Product Info */}
        <div className="col-md-3 col-12 d-flex flex-column gap-3 p-0">
          <h2 className="fw-semibold ">{product.name}</h2>
          {product.attributes.length > 0 && (
            <ProductAttributes
              attributes={product.attributes}
              setSelectedAttributes={setSelectedAttributes}
            />
          )}
          {/* Price Display */}
          <div className="text-uppercase fw-bold">
            <div className={`mb-2 ${styles.productAttribute}`}>Price:</div>
            <div className="fw-bold fs-4">
              {product.prices[0].currency.symbol}
              {product.prices[0].amount.toFixed(2)}
            </div>
          </div>
          <AddToCartButton
            product={product}
            selectedAttributes={selectedAttributes}
            requiredAttributes={product.attributes}
          />
          <div
            data-testid="product-description"
            className={`mt-4 ${styles.productDescription}`}
          >
            {parse(product.description)}
          </div>
        </div>
      </div>
    </div>
  );
}
export default ProductDetailsPage;
