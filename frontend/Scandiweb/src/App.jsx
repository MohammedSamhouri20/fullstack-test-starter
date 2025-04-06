import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import "bootstrap/dist/css/bootstrap.min.css";
import "./styles/main.css";
import "./App.css";
import Header from "./components/Header.jsx";
import ProductListingPage from "./pages/ProductListingPage.jsx";
import ProductDetailsPage from "./pages/ProductDetailsPage.jsx";
import { CategoryProvider } from "./context/CategoryContext.jsx";
import { ProductProvider } from "./context/ProductContext.jsx";
import { useCart } from "./context/CartContext";
function App() {
  const { isCartOpen } = useCart();

  return (
    <Router>
      <CategoryProvider>
        <div className="header">
          <Header />
        </div>

        {isCartOpen && <div className="greyed-out-overlay"></div>}

        <ProductProvider>
          <Routes>
            <Route path="/:category" element={<ProductListingPage />} />
            <Route path="/" element={<ProductListingPage />} />
            <Route path="/product/:id" element={<ProductDetailsPage />} />
          </Routes>
        </ProductProvider>
      </CategoryProvider>
    </Router>
  );
}

export default App;
