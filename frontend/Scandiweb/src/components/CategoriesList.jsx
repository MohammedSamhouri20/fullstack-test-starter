import { useCategory } from "../context/CategoryContext";
import CategoryLink from "./CategoryLink";
import styles from "../styles/CategoryList.module.css";
import { Link } from "react-router-dom";

function CategoriesList() {
  const { selectedCategory, setSelectedCategory, categories, loading, error } =
    useCategory();

  if (loading)
    return (
      <span class="placeholder-glow">
        <span class="placeholder col-12 bg-primary"></span>
      </span>
    );

  if (error) return <p>Error loading categories.</p>;

  return (
    <ul className="list-group list-group-horizontal text-uppercase fw-semibold">
      {categories.map((category) => (
        <Link
          key={category.name}
          className="text-decoration-none"
          to={`/${category.name}`}
          data-testid={`${
            selectedCategory === category.name
              ? "active-category-link"
              : "category-link"
          }`}
        >
          <CategoryLink
            category={category.name}
            className={selectedCategory === category.name ? styles.active : ""}
            onClick={() => setSelectedCategory(category.name)}
          />
        </Link>
      ))}
    </ul>
  );
}

export default CategoriesList;
