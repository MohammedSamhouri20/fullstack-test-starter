import { useState, useEffect } from "react";
import { gql, useQuery } from "@apollo/client";
import { CategoryContext } from "./CategoryContext";

const GET_CATEGORIES = gql`
  query GetCategories {
    categories {
      name
    }
  }
`;

export function CategoryProvider({ children }) {
  const [selectedCategory, setSelectedCategory] = useState(
    () => localStorage.getItem("selectedCategory") || null
  );

  const { loading, error, data } = useQuery(GET_CATEGORIES);

  useEffect(() => {
    if (selectedCategory) {
      localStorage.setItem("selectedCategory", selectedCategory);
    }
  }, [selectedCategory]);

  useEffect(() => {
    if (data?.categories.length > 0 && !selectedCategory) {
      setSelectedCategory(data.categories[0].name);
    }
  }, [data, selectedCategory]);

  return (
    <CategoryContext.Provider
      value={{
        selectedCategory,
        setSelectedCategory,
        categories: data?.categories || [],
        loading,
        error,
      }}
    >
      {children}
    </CategoryContext.Provider>
  );
}
