import { Link } from "react-router-dom";
import styles from "../styles/ProductCard.module.css";
import CartIcon from "../assets/CartIcon";
import { useCart } from "../context/CartContext"; // Import the useCart hook

function ProductCard({ product }) {
  const { addToCart } = useCart(); // Access the addToCart function from the CartContext

  const getDefaultSelectedOptions = () => {
    const selectedOptions = {};

    product.attributes.forEach((attribute) => {
      selectedOptions[attribute.name] = attribute.items[0].value; // Select the first option for each attribute
    });

    return selectedOptions;
  };

  const handleQuickShopClick = (e) => {
    e.preventDefault(); // Prevent default link behavior
    const selectedOptions = getDefaultSelectedOptions(); // Get default selected options
    addToCart(product, selectedOptions); // Add the product to the cart
  };

  return (
    <Link
      data-testid={`product-${product.name.toLowerCase().replace(/\s+/g, "-")}`}
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

        {/* Quick Shop Button */}
        {product.inStock && (
          <button
            style={{ width: "52px", height: "52px", left: "87%" }}
            className={`btn btn-primary ${styles.quickShopBtn} position-absolute translate-middle border-0 rounded-circle align-items-center justify-content-center`}
            onClick={handleQuickShopClick}
          >
            <CartIcon color="white" size="24" />
          </button>
        )}
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
