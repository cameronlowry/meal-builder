//#region external imports
import { useState } from "react";
import { useMediaQuery } from "react-responsive";
import Carousel from "react-bootstrap/Carousel";

//#endregion

//#region data imports
import mealsData from "../data/meals_data.json";
import { chunkArray } from "../services/ArrayService";
//#endregion

export const MealsCarousel = () => {
  const [index, setIndex] = useState(0);
  const [meals] = useState(mealsData);

  const isMobile = useMediaQuery({ query: `(max-width: 768px)` });
  const isMedium = useMediaQuery({ query: `(max-width: 996px)` });

  const chunk_size = isMobile ? 1 : isMedium ? 3 : 6;
  const chunks = chunkArray(meals, chunk_size);

  const handleSelect = (selectedIndex) => {
    setIndex(selectedIndex);
  };

  return (
    <Carousel className="supr-meal-carousel" indicators={false} controls={true} activeIndex={index} onSelect={handleSelect}>
      {chunks.map((chunk, index) => (
        <Carousel.Item key={`meal_${index}`}>
          <div className="row row-cols-1 row-cols-sm-1 row-cols-md-3 row-cols-lg-6">
            {chunk.map((meal) => (
              <div key={meal.id} className="col mb-4 position-relative d-flex justify-content-center">
                {mealCard(meal)}
              </div>
            ))}
          </div>
        </Carousel.Item>
      ))}
    </Carousel>
  );
};

const mealCard = (meal) => (
  <div className="h-100 px-0 border rounded-3 bg-white position-relative overflow-hidden">
    <div className="d-flex flex-column justify-content-between h-100">
      <div className="mb-2">
        <img className="img-fluid w-100" src={meal.image} alt={meal.title} />
      </div>

      <div className="p-3 d-flex flex-column justify-content-between h-100">
        <h6 className="fw-bold mb-2" htmlFor={meal.id}>
          {meal.title}
        </h6>

        <div className="mb-2">
          <span className="badge text-bg-info">{meal.category}</span>
        </div>
      </div>
    </div>
  </div>
);
