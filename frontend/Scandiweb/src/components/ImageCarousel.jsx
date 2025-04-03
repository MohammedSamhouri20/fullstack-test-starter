import { useState } from "react";
import styles from "../styles/ImageCarousel.module.css";

function ImageCarousel({ images }) {
  const [selectedIndex, setSelectedIndex] = useState(0);

  return (
    <div
      data-testid="product-gallery"
      style={{ maxWidth: "655px", maxHeight: "478px" }}
      className="d-flex gap-3 h-100 p-0"
    >
      {/* Left Thumbnails */}
      <div
        style={{ maxWidth: "80px" }}
        className={`d-flex flex-column h-100 gap-2 p-0 ${styles.scrollContainer}`}
      >
        {images.map((img, index) => (
          <img
            key={index}
            src={img}
            alt={`Thumbnail ${index}`}
            className={`img-thumbnail rounded-0 object-fit-cover ${
              styles.thumbnail
            } ${index === selectedIndex ? styles.activeThumbnail : ""}`}
            onClick={() => setSelectedIndex(index)}
            style={{ width: "80px", height: "80px", cursor: "pointer" }}
          />
        ))}
      </div>

      {/* Bootstrap Carousel */}
      <div id="ImageCarousel" className="carousel w-100 slide">
        <div className="carousel-inner d-flex h-100">
          {images.map((img, index) => (
            <div
              key={index}
              className={`carousel-item  ${
                index === selectedIndex ? "active" : ""
              }`}
            >
              <img
                src={img}
                className="h-100 object-fit-contain w-100"
                alt={`Slide ${index}`}
              />
            </div>
          ))}
        </div>

        {/* Carousel Controls */}
        <button
          style={{ left: "1rem" }}
          className={"carousel-control-prev " + styles.carouselControl}
          type="button"
          data-bs-target="#ImageCarousel"
          data-bs-slide="prev"
          onClick={() =>
            setSelectedIndex((prev) =>
              prev > 0 ? prev - 1 : images.length - 1
            )
          }
        >
          <span className="carousel-control-prev-icon"></span>
        </button>
        <button
          style={{ right: "1rem" }}
          className={"carousel-control-next " + styles.carouselControl}
          type="button"
          data-bs-target="#ImageCarousel"
          data-bs-slide="next"
          onClick={() =>
            setSelectedIndex((prev) =>
              prev < images.length - 1 ? prev + 1 : 0
            )
          }
        >
          <span className="carousel-control-next-icon"></span>
        </button>
      </div>
    </div>
  );
}

export default ImageCarousel;
