import React, {
  createContext,
  useState,
  useContext,
  useEffect,
  useMemo,
} from "react";
import { gql, useQuery } from "@apollo/client";

// GraphQL Query for fetching categories
const GET_CATEGORIES = gql`
  query GetCategories {
    categories {
      name
    }
  }
`;

// Create the context
const CategoryContext = createContext();

// Custom hook for accessing the context
export const useCategory = () => useContext(CategoryContext);

// Provider Component
export const CategoryProvider = ({ children }) => {
  // Load selected category from localStorage (if available) or set to null
  const [selectedCategory, setSelectedCategory] = useState(
    () => localStorage.getItem("selectedCategory") || null
  );

  // Fetch categories using Apollo Client
  const { loading, error, data } = useQuery(GET_CATEGORIES);

  // Persist selected category in localStorage
  useEffect(() => {
    if (selectedCategory) {
      localStorage.setItem("selectedCategory", selectedCategory);
    }
  }, [selectedCategory]);

  // Set default category only if none is selected
  useEffect(() => {
    if (data?.categories.length > 0 && !selectedCategory) {
      setSelectedCategory(data.categories[0].name);
    }
  }, [data, selectedCategory]);

  // Optimize performance with useMemo
  const contextValue = useMemo(
    () => ({
      selectedCategory,
      setSelectedCategory,
      categories: data?.categories || [],
      loading,
      error,
    }),
    [selectedCategory, data, loading, error]
  );

  return (
    <CategoryContext.Provider value={contextValue}>
      {children}
    </CategoryContext.Provider>
  );
};
