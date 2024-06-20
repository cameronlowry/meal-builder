import { useState } from "react";
import Carousel from "react-bootstrap/Carousel";

//#region data imports
import mealsData from "../data/meals_data.json";
import { chunk } from "../services/MealsService";
//#endregion

export const MealsCarousel = () => {
  const [index, setIndex] = useState(0);
  const [meals] = useState(mealsData);
  const chunk_size = 5;
  const chunks = chunk(meals, chunk_size);

  const handleSelect = (selectedIndex) => {
    setIndex(selectedIndex);
  };

  return (
    <Carousel indicators={false} controls={true} activeIndex={index} onSelect={handleSelect}>
      {chunks.map((chunk, index) => (
        <Carousel.Item key={`meal_${index}`}>
          <div className="row row-cols-sm-2 row-cols-md-5 row-cols-lg-5">
            {chunk.map((meal) => (
              <div key={meal.id} className="col mb-4 position-relative">
                <div className="h-100 px-0 border rounded-3 bg-white position-relative overflow-hidden">
                  <div className="d-flex flex-column justify-content-between h-100">
                    <div className="h-33 mb-2">
                      <img className="img-fluid" src={meal.image} alt={meal.title} />
                    </div>

                    <div className="p-3 d-flex flex-column justify-content-between h-100">
                      <h6 className="fw-bold mb-2" htmlFor={meal.id}>
                        {meal.title}
                      </h6>

                      <div className="mb-2">
                        <span className="badge text-bg-info">{meal.type}</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </Carousel.Item>
      ))}
    </Carousel>
  );
};
