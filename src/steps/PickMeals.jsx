//#region external imports
import { useForm } from "react-hook-form";
import { Link, useNavigate } from "react-router-dom";
import { useState } from "react";
//#endregion

//#region internal imports
import { Button, Form } from "../forms";
import { CartIcon } from "../components/CartIcon";
import { CheckMark } from "../components/CheckMark";
import { FREQUENCY_KEY, MEALS_KEY } from "../constants";
import { Heading } from "../components/Heading";
import { useAppState } from "../state/state";
//#endregion

//#region data imports
import mealsData from "../data/meals_data.json";
import ScrollToTop from "../components/ScrollToTop";
import { Accordion, Alert } from "react-bootstrap";
//#endregion

export const PickMeals = () => {
  const [state, setState] = useAppState();
  const [meals] = useState(mealsData);

  const { handleSubmit, setValue, getValues, watch, register } = useForm({ defaultValues: state });
  const navigate = useNavigate();
  const selectedFrequency = parseInt(getValues(FREQUENCY_KEY), 10);
  const selectedMealCount = watch(MEALS_KEY).reduce((acc, meal) => acc + parseInt(meal.count), 0);
  const showMaxReachedAlert = selectedMealCount > 0 && selectedMealCount >= selectedFrequency;

  const saveData = (data) => {
    setState({ ...state, ...data });
    navigate("/payment");
  };

  const mealCard = (meal) => (
    <div key={meal.id} className="col-sm-9 col-md-4 col-lg-4 col-xl-4 position-relative">
      {watch(MEALS_KEY).find((x) => meal.id === x.id) && <CheckMark className="position-absolute" />}

      <div className="h-100 px-0 border rounded-3 position-relative overflow-hidden">
        <div className="d-flex flex-column justify-content-between h-100">
          <input style={{ display: "none" }} {...register(MEALS_KEY)} id={meal.id} type="checkbox" value={meal.value} data-field={MEALS_KEY} />

          <div className="mb-2">
            <img className="img-fluid w-100" src={meal.image} alt={meal.title} />
          </div>

          <div className="p-3 d-flex flex-column justify-content-between h-100">
            <h6 className="fw-bold mb-2" htmlFor={meal.id}>
              {meal.title}
            </h6>

            <div className="mb-1">{meal.description}</div>
            <div className="mb-2">
              <span className="badge text-bg-info">{meal.category}</span>
            </div>
            <div className="mb-2">${meal.price.toFixed(2)}</div>

            {!getValues(MEALS_KEY).find((selectedMeal) => selectedMeal.value === meal.value) && (
              <a
                className="btn btn-outline-secondary w-100"
                onClick={() => {
                  const selectedMealCount = watch(MEALS_KEY).reduce((acc, meal) => acc + parseInt(meal.count), 0);
                  if (selectedMealCount >= parseInt(watch(FREQUENCY_KEY))) {
                    return;
                  }
                  setValue(MEALS_KEY, [...getValues(MEALS_KEY), { ...meal, count: 1 }]);
                }}
              >
                Add to box
              </a>
            )}

            {getValues(MEALS_KEY).find((selectedMeal) => selectedMeal.value === meal.value) && (
              <div className="d-flex align-items-center justify-content-between w-100">
                <a
                  className="link"
                  onClick={() =>
                    setValue(
                      MEALS_KEY,
                      getValues(MEALS_KEY).filter((selectedMeal) => selectedMeal.value !== meal.value)
                    )
                  }
                >
                  Remove
                </a>

                <select
                  className="p-2 rounded-1"
                  onChange={(event) => {
                    const selectedMealCount = watch(MEALS_KEY)
                      .filter((x) => x.id !== event.target.dataset.id)
                      .reduce((acc, meal) => acc + parseInt(meal.count), 0);
                    const additionalCount = parseInt(event.target.value);
                    if (selectedMealCount + additionalCount > parseInt(watch(FREQUENCY_KEY))) {
                      return;
                    }
                    setValue(
                      MEALS_KEY,
                      getValues(MEALS_KEY).map((selectedMeal) => ({
                        ...selectedMeal,
                        count: selectedMeal.value === meal.value ? event.target.value : selectedMeal.count,
                      }))
                    );
                  }}
                  value={getValues(MEALS_KEY).find((selectedMeal) => selectedMeal.value === meal.value).count}
                  data-id={meal.id}
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
    </div>
  );

  const accordionBody = (
    <div className="p-4 border rounded-1 mb-4">
      {!watch(MEALS_KEY).length && <span className="">Nothing selected</span>}
      {watch(MEALS_KEY).map((selectedMeal) => (
        <div className="d-flex align-items-center justify-content-between" key={selectedMeal.value}>
          <select
            className="p-2 rounded-1"
            onChange={(event) =>
              setValue(
                MEALS_KEY,
                getValues(MEALS_KEY).map((onChangeMeal) => ({
                  ...onChangeMeal,
                  count: onChangeMeal.value === selectedMeal.value ? event.target.value : onChangeMeal.count,
                }))
              )
            }
            value={getValues(MEALS_KEY).find((onChangeMeal) => onChangeMeal.value === selectedMeal.value).count}
            aria-label={`Select quantity for ${selectedMeal.title}`}
          >
            <option value={1}>1</option>
            <option value={2}>2</option>
            <option value={3}>3</option>
          </select>
          <div>{selectedMeal.title}</div>
          <a
            type="button"
            className="btn-close"
            aria-label={`Remove ${selectedMeal.title}`}
            onClick={() =>
              setValue(
                MEALS_KEY,
                getValues(MEALS_KEY).filter((x) => x.value !== selectedMeal.value)
              )
            }
          ></a>
        </div>
      ))}
    </div>
  );

  const selectedMealRow = (selectedMeal) => (
    <div className="d-flex align-items-center justify-content-between mb-4" key={selectedMeal.value}>
      <select
        className="p-2 rounded-1"
        onChange={(event) => {
          if (state[MEALS_KEY].reduce((acc, meal) => acc + meal.count, 0) === state[FREQUENCY_KEY] - 1) {
            return;
          }
          setValue(
            MEALS_KEY,
            getValues(MEALS_KEY).map((onChangeMeal) => ({
              ...onChangeMeal,
              count: onChangeMeal.value === selectedMeal.value ? event.target.value : onChangeMeal.count,
            }))
          );
        }}
        value={getValues(MEALS_KEY).find((onChangeMeal) => onChangeMeal.value === selectedMeal.value).count}
        aria-label={`Select quantity for ${selectedMeal.title}`}
      >
        <option value={1}>1</option>
        <option value={2}>2</option>
        <option value={3}>3</option>
      </select>
      <div className="flex-grow-1 px-3 text-align-left">{selectedMeal.title}</div>
      <a
        type="button"
        className="btn-close"
        aria-label="Close"
        onClick={() =>
          setValue(
            MEALS_KEY,
            getValues(MEALS_KEY).filter((x) => x.value !== selectedMeal.value)
          )
        }
      ></a>
    </div>
  );

  return (
    <Form className="pick-meals" onSubmit={handleSubmit(saveData)}>
      <ScrollToTop />

      <fieldset>
        <Heading title="Pick Your Meals" />

        <div className="row">
          <div className="col-sm-12 col-lg-8">
            <h6>Full Meals</h6>

            <div className="row g-4 flex-nowrap flex-sm-nowrap flex-md-wrap overflow-x-auto p-2">{meals.map(mealCard)}</div>
          </div>

          <aside id="selected-choices" className="col-4 d-none d-lg-block d-xl-block sticky-top" style={{ height: "fit-content" }}>
            <div className="p-4 border rounded-1 mb-4">
              <h6 className="d-flex align-items-center gap-3">
                <CartIcon width="24px" /> Your selection
              </h6>

              <hr />

              {watch(MEALS_KEY).map(selectedMealRow)}

              {selectedMealCount === 0 && <span className="text-grey">Select up to {selectedFrequency} meals</span>}
              {(!showMaxReachedAlert && selectedMealCount > 0) && <span className="text-grey">Select up to {selectedFrequency - selectedMealCount} more</span>}

              <Alert show={showMaxReachedAlert} key={"meals-limit-alert"} variant={"primary"}>
                You've picked all your meals. Thanks!
              </Alert>
            </div>

            <div className="text-center">
              <Button>SAVE & CONTINUE</Button>

              <div className="mt-2">
                <Link className={``} to="/address">
                  Previous
                </Link>
              </div>
            </div>

            <Link className={``} to="/address"></Link>
          </aside>

          <Accordion className="fixed-bottom d-sm-block d-md-block d-lg-none d-xl-none px-0 ">
            <Accordion.Item eventKey="0" className="shadow-xl">
              <Accordion.Header>
                <div className="d-flex align-items-end gap-2">
                  <CartIcon width="24px" />
                  <span className="h-100">Your selection</span>
                </div>
              </Accordion.Header>

              <hr className="mx-3 my-2" />

              <Accordion.Body>{accordionBody}</Accordion.Body>

              <div className="p-3 text-center">
                <Button>SAVE & CONTINUE</Button>

                <div className="mt-3">
                  <Link className={``} to="/address">
                    Previous
                  </Link>
                </div>
              </div>
            </Accordion.Item>
          </Accordion>
        </div>
      </fieldset>
    </Form>
  );
};
