import { useCart } from "../context/CartContext";

function CartItem({ item }) {
  const { updateQuantity } = useCart();
  return (
    <div className="col-12 container-fluid">
      <div className="row justify-content-between gap-2">
        {/* Left Section */}
        <div className="col-5 d-flex flex-column gap-2 p-0 m-0 ">
          <div className="d-flex flex-column gap-1">
            <div className="fw-light">{item.name}</div>
            <div className="fw-medium">
              {item.prices[0].currency.symbol}
              {item.prices[0].amount.toFixed(2)}
            </div>
          </div>

          {/* Attributes */}
          {item.attributes.map((attribute) => (
            <div
              key={attribute.name}
              data-testid={`cart-item-attribute-${attribute.name
                .toLowerCase()
                .replace(/\s+/g, "-")}`}
              style={{ fontSize: "14px" }}
              className="d-flex flex-column gap-2"
            >
              <div className="fw-normal">{attribute.name}:</div>

              {/* Text-based attributes (Size, Capacity, etc.) */}
              {attribute.type === "text" ? (
                <div className="d-flex gap-2">
                  {attribute.items.map((attributeItem) => (
                    <div
                      data-testid={
                        item.selectedOptions[attribute.name] ===
                        attributeItem.value
                          ? `cart-item-attribute-${attribute.name
                              .toLowerCase()
                              .replace(/\s+/g, "-")}-${attribute.name
                              .toLowerCase()
                              .replace(/\s+/g, "-")}-selected`
                          : `cart-item-attribute-${attribute.name
                              .toLowerCase()
                              .replace(/\s+/g, "-")}-${attribute.name
                              .toLowerCase()
                              .replace(/\s+/g, "-")}`
                      }
                      key={attributeItem.value}
                      className={`border border-black w-100 text-center ${
                        item.selectedOptions[attribute.name] ===
                        attributeItem.value
                          ? "bg-black text-white"
                          : ""
                      }`}
                    >
                      {attributeItem.value}
                    </div>
                  ))}
                </div>
              ) : (
                /* Color-based attributes */
                <div className="d-flex flex-wrap gap-2">
                  {attribute.items.map((attributeItem) => (
                    <div
                      key={attributeItem.value}
                      data-testid={
                        item.selectedOptions[attribute.name] ===
                        attributeItem.value
                          ? `cart-item-attribute-${attribute.name
                              .toLowerCase()
                              .replace(/\s+/g, "-")}-${attribute.name
                              .toLowerCase()
                              .replace(/\s+/g, "-")}-selected`
                          : `cart-item-attribute-${attribute.name
                              .toLowerCase()
                              .replace(/\s+/g, "-")}-${attribute.name
                              .toLowerCase()
                              .replace(/\s+/g, "-")}`
                      }
                      className={`border border-1 ${
                        item.selectedOptions[attribute.name] ===
                        attributeItem.value
                          ? "border-primary border-2"
                          : ""
                      }`}
                      style={{
                        width: "16px",
                        height: "16px",
                        background: attributeItem.value,
                      }}
                    ></div>
                  ))}
                </div>
              )}
            </div>
          ))}
        </div>

        {/* Right Section */}
        <div className="col-6 d-flex p-0 m-0 gap-2 justify-content-between">
          {/* Quantity Control */}
          <div className="d-flex flex-column fw-medium align-items-center justify-content-between">
            <button
              data-testid="cart-item-amount-increase"
              className="btn border border-black border-1 rounded-0 p-0"
              style={{ width: "24px", height: "24px" }}
              onClick={() =>
                updateQuantity(item.id, item.selectedOptions, item.quantity + 1)
              }
            >
              +
            </button>
            <div data-testid="cart-item-amount">{item.quantity}</div>
            <button
              className="btn border border-black border-1 rounded-0 p-0"
              style={{ width: "24px", height: "24px" }}
              data-testid="cart-item-amount-decrease"
              onClick={() =>
                updateQuantity(item.id, item.selectedOptions, item.quantity - 1)
              }
            >
              -
            </button>
          </div>

          {/* Product Image */}
          <div>
            <img
              className="w-100 h-100 object-fit-cover"
              src={item.gallery[0]}
              alt="Product"
            />
          </div>
        </div>
      </div>
    </div>
  );
}
export default CartItem;
