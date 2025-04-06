function CategoryLink({ category, onClick, className, isActive }) {
  return (
    <li
      style={{ cursor: "pointer", height: "56px" }}
      className={`list-group-item lh-sm border-0 rounded-0 ${className}`}
      onClick={onClick}
    >
      {category}
    </li>
  );
}

export default CategoryLink;
