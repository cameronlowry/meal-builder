//#region external imports
import { useForm } from "react-hook-form";
import { forwardRef } from "react";
import PropTypes from "prop-types";
//#endregion

//#region internal imports
import { useAppState } from "../services/state";
//#endregion

//#region data imports
import { MEALS_KEY } from "../constants";
//#endregion

export const MealCard = forwardRef(function MealCard({ meal, className, ...props }, ref) {
  const [state, setState] = useAppState();
  const { register, getValues, setValue } = useForm({ defaultValues: state, mode: "onTouched"});

  return (
    <div ref={ref} {...props} className={`h-100 px-0 border rounded-3 position-relative overflow-hidden ${className}`}>
      <div className="d-flex flex-column justify-content-between h-100">
        <input style={{ display: "none" }} {...register(MEALS_KEY)} id={meal.id} type="checkbox" value={meal.value} data-field={MEALS_KEY} />

        <div className="h-33 mb-2">
          <img className="img-fluid" src={meal.image} alt={meal.title} />
        </div>

        <div className="p-3 d-flex flex-column justify-content-between h-100">
          <h5 className="fw-bold mb-2" htmlFor={meal.id}>
            {meal.title}
          </h5>

          <div className="mb-1">{meal.description}</div>
          <div className="mb-2">
            <span className="badge text-bg-info">{meal.type}</span>
          </div>
          <div className="mb-2">${meal.price.toFixed(2)}</div>

          {!getValues(MEALS_KEY).find((selectedMeal) => selectedMeal.value === meal.value) && (
            <a
              href="#"
              className="btn btn-outline-secondary w-100"
              onClick={() => {
                setValue(MEALS_KEY, [...getValues(MEALS_KEY), { ...meal, count: 1 }]);
                setState({ ...state, [MEALS_KEY]: [...getValues(MEALS_KEY), { ...meal, count: 1 }] });
              }}
            >
              Add to box
            </a>
          )}

          {getValues(MEALS_KEY).find((selectedMeal) => selectedMeal.value === meal.value) && (
            <div className="d-flex align-items-center justify-content-between w-100">
              <a
                href="#"
                className="link"
                onClick={() => {
                  setValue(
                    MEALS_KEY,
                    getValues(MEALS_KEY).filter((selectedMeal) => selectedMeal.value !== meal.value)
                  );
                  setState({ ...state, [MEALS_KEY]: getValues(MEALS_KEY).filter((selectedMeal) => selectedMeal.value !== meal.value) });
                }}
              >
                Remove
              </a>

              <select
                className="p-2 rounded-1"
                onChange={(event) => {
                  setValue(
                    MEALS_KEY,
                    getValues(MEALS_KEY).map((selectedMeal) => ({
                      ...selectedMeal,
                      count: selectedMeal.value === meal.value ? event.target.value : selectedMeal.count,
                    }))
                  );
                  setState({
                    ...state,
                    [MEALS_KEY]: getValues(MEALS_KEY).map((selectedMeal) => ({
                      ...selectedMeal,
                      count: selectedMeal.value === meal.value ? event.target.value : selectedMeal.count,
                    })),
                  });
                }}
                value={getValues(MEALS_KEY).find((selectedMeal) => selectedMeal.value === meal.value).count}
                aria-label={`Select quantity for ${meal.title}`}
              >
                <option value={1}>1</option>
                <option value={2}>2</option>
                <option value={3}>3</option>
              </select>
            </div>
          )}
        </div>
      </div>
    </div>
  );
});

MealCard.propTypes = {
  meal: PropTypes.object,
  className: PropTypes.string,
};

MealCard.displayName = "MealCard";
