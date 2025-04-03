import CategoriesList from "./CategoriesList";
import CartButton from "./CartButton";
import CartOverlay from "./CartOverlay"; // Import the CartOverlay component
import { useCart } from "../context/CartContext";

function Header() {
  const { isCartOpen, setIsCartOpen } = useCart();
  const toggleCartOverlay = () => {
    setIsCartOpen((prev) => !prev);
  };

  return (
    <>
      <header className="bg-white p-0 position-relative pt-3 container-fluid">
        <div className="container d-flex justify-content-between align-items-center">
          <div className="col-3">
            <CategoriesList />
          </div>
          <div className="col-3 text-center">
            <img src="/logo.svg" alt="logo" />
          </div>

          <div className="col-3 d-flex position-relative justify-content-end align-items-center">
            {/* Cart Button with toggle function */}
            <CartButton toggleCartOverlay={toggleCartOverlay} />
            {isCartOpen && (
              <CartOverlay className="position-absolute text-wrap text-break bg-white mt-3 z-1 top-100 start-0 w-100" />
            )}
          </div>
        </div>
      </header>
    </>
  );
}

export default Header;
