import { Link } from "react-router-dom";
import styles from "../styles/ProductCard.module.css";
import { toKebabCase } from "../utils/toKebabCase";
import QuickShopButton from "./QuickShopButton";

function ProductCard({ product }) {
  return (
    <Link
      data-testid={`product-${toKebabCase(product.name)}`}
      to={`/product/${product.id}`}
      className={`card ${styles.productCard} border-0 rounded-0 p-3 text-decoration-none`}
      style={{ width: "386px", maxHeight: "444px", cursor: "pointer" }}
    >
      <div className="position-relative" style={{ height: "330px" }}>
        <img
          src={product.gallery[0]}
          className={`card-img-top rounded-0 object-fit-cover ${
            product.inStock ? "" : styles.outOfStockImage
          }`}
          style={{ height: "100%", width: "100%" }}
          alt="Product"
        />
        {!product.inStock && (
          <div className={styles.outOfStockLabel}>out of stock</div>
        )}
        {product.inStock && <QuickShopButton product={product} />}
      </div>
      <div className="card-body p-0 mt-4">
        <h5 className="card-title m-0 fw-light">{product.name}</h5>
        <p
          className={`card-text fs-5 ${
            product.inStock ? "" : styles.outOfStockPrice
          }`}
        >
          {product.prices[0].currency.symbol}
          {product.prices[0].amount.toFixed(2)}
        </p>
      </div>
    </Link>
  );
}
export default ProductCard;
