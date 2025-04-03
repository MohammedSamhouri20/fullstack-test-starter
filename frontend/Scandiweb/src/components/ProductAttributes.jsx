import { useState } from "react";
import styles from "../styles/ProductDetails.module.css";

function ProductAttributes({ attributes, setSelectedAttributes }) {
  const [selectedAttribute, setSelectedAttribute] = useState({});

  const handleAttributeSelect = (attributeName, itemValue) => {
    const updatedAttributes = {
      ...selectedAttribute,
      [attributeName]: itemValue,
    };
    setSelectedAttribute(updatedAttributes);
    setSelectedAttributes(updatedAttributes); // Update parent state
  };

  return (
    <>
      {attributes.map((attribute) => (
        <div
          key={attribute.name}
          data-testid={`product-attribute-${attribute.name
            .toLowerCase()
            .replace(/\s+/g, "-")}`}
          className="text-uppercase "
        >
          {/* Text-based attributes */}
          {attribute.type === "text" ? (
            <>
              <div className={`fw-bold mb-2  ${styles.productAttribute}`}>
                {attribute.name}:
              </div>
              <div className="d-flex fw-normal">
                {attribute.items.map((item) => (
                  <button
                    key={item.value}
                    className={`btn border border-1 border-black w-100 rounded-0 me-2 ${
                      selectedAttribute[attribute.name] === item.value
                        ? "btn-dark text-white"
                        : "btn-outline-dark"
                    }`}
                    onClick={() =>
                      handleAttributeSelect(attribute.name, item.value)
                    }
                  >
                    {item.value}
                  </button>
                ))}
              </div>
            </>
          ) : (
            <>
              {/* Color-based attributes */}
              <div className={`fw-bold mb-2 ${styles.productAttribute}`}>
                {attribute.name}:
              </div>
              <div className="d-flex">
                {attribute.items.map((item) => (
                  <button
                    key={item.value}
                    className={`border ${
                      selectedAttribute[attribute.name] === item.value
                        ? "border-primary border-1"
                        : "border-1"
                    } me-2`}
                    style={{
                      backgroundColor: item.value,
                      width: "36px",
                      height: "36px",
                    }}
                    onClick={() =>
                      handleAttributeSelect(attribute.name, item.value)
                    }
                  />
                ))}
              </div>
            </>
          )}
        </div>
      ))}
    </>
  );
}

export default ProductAttributes;
