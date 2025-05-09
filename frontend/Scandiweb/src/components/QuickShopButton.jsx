import styles from "../styles/ProductCard.module.css";
import CartIcon from "../assets/CartIcon";
import { useCart } from "../hooks/useCart";

function QuickShopButton({ product }) {
  const { addToCart } = useCart();

  const getDefaultSelectedOptions = () => {
    const selectedOptions = {};
    product.attributes.forEach((attribute) => {
      selectedOptions[attribute.name] = attribute.items[0].value;
    });
    return selectedOptions;
  };

  const handleQuickShopClick = (e) => {
    e.preventDefault();
    const selectedOptions = getDefaultSelectedOptions();
    addToCart(product, selectedOptions);
  };

  return (
    <button
      style={{ width: "52px", height: "52px", left: "87%" }}
      className={`btn btn-primary ${styles.quickShopBtn} position-absolute translate-middle border-0 rounded-circle align-items-center justify-content-center`}
      onClick={handleQuickShopClick}
    >
      <CartIcon color="white" size="24" />
    </button>
  );
}
export default QuickShopButton;
