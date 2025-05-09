import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import "bootstrap/dist/css/bootstrap.min.css";
import "./styles/custom.css";
import "./App.css";
import Header from "./components/Header";
import ProductListingPage from "./pages/ProductListingPage";
import ProductDetailsPage from "./pages/ProductDetailsPage";
import { CategoryProvider } from "./context/CategoryProvider";
import { ProductProvider } from "./context/ProductProvider";
import { useCart } from "./hooks/useCart";

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
