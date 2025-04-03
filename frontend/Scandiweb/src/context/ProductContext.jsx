import { createContext, useContext, useEffect, useState } from "react";
import { gql, useQuery, useLazyQuery } from "@apollo/client";
import { useCategory } from "./CategoryContext";

const ProductContext = createContext();

// GraphQL query to fetch products by category
const GET_PRODUCTS = gql`
  query GetProducts($category: String) {
    products(category: $category) {
      id
      name
      category
      prices {
        amount
        currency {
          symbol
        }
      }
      gallery
      inStock
      attributes {
        name
        type
        items {
          value
          displayValue
        }
      }
    }
  }
`;

// GraphQL query to fetch a single product by ID
const GET_PRODUCT = gql`
  query GetProduct($id: String!) {
    products(id: $id) {
      id
      name
      category
      description
      prices {
        amount
        currency {
          symbol
        }
      }
      gallery
      inStock
      attributes {
        name
        type
        items {
          value
          displayValue
        }
      }
    }
  }
`;

export function ProductProvider({ children }) {
  const { selectedCategory } = useCategory();
  const [products, setProducts] = useState([]);

  // Fetch products based on the selected category
  const { loading, error, data } = useQuery(GET_PRODUCTS, {
    variables: {
      category: selectedCategory === "all" ? null : selectedCategory,
    },
    skip: !selectedCategory,
  });

  // Fetch a single product by ID (Lazy Query)
  const [
    fetchProduct,
    { loading: productLoading, error: productError, data: productData },
  ] = useLazyQuery(GET_PRODUCT);

  // Update products when data changes
  useEffect(() => {
    if (data && data.products) {
      setProducts(data.products);
    }
  }, [data]);

  return (
    <ProductContext.Provider
      value={{
        products,
        loading,
        error,
        fetchProduct,
        productData,
        productLoading,
        productError,
      }}
    >
      {children}
    </ProductContext.Provider>
  );
}

export function useProducts() {
  return useContext(ProductContext);
}
