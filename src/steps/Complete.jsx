import { useForm } from "react-hook-form";
import { Link } from "react-router-dom";
import { useState } from "react";

import { useAppState } from "../state/state";
import { FREQUENCY_KEY, MEALS_KEY, PEOPLE_KEY, PREFERENCES_KEY, SUBSCRIPTION_KEY } from "../constants";
import { mapKeyToDisplayName } from "../services/PlanService";

//#region data imports
import preferencesData from "../data/preferences_data.json";
import subscriptionData from "../data/subscription_data.json";
import { CheckMark } from "../components/CheckMark";
import { Heading } from "../components/Heading";
//#endregion

export const Complete = () => {
  const [preferences] = useState(preferencesData);
  const [subscriptions] = useState(subscriptionData);

  const [state, setState] = useAppState();
  const { watch } = useForm({ defaultValues: state });

  return (
    <div className="py-5" style={{ width: "774px" }}>
      {state.result?.status === "success" && !state.result?.dismissed && (
        <div id="alert" className="d-flex align-items-center justify-content-between p-2 border border-primary w-100">
          <span className="d-flex align-items-center gap-2 fw-bold">
            <CheckMark /> Your Meals purchase was successful!
          </span>
          <button
            type="button"
            className="btn-close"
            aria-label="Close"
            onClick={() => setState({ ...state, result: { ...state.result, dismissed: true } })}
          ></button>
        </div>
      )}

      {state.result?.status !== "success" && (
        <div className="d-flex align-items-center justify-content-between p-2 border border-danger w-100">
          <span className="">
            Oops, something went wrong! Please <Link to="/payment">try again</Link>
          </span>

          <span className="">
            <a href="tel:+12038611150">Call us</a>
          </span>
        </div>
      )}

      <Heading className="mt-4 mb-4" title={`${watch("firstName")?.toUpperCase()}'S MEALS`} />

      <h6 className="d-flex align-items-center justify-content-between">
        My Meals{" "}
        <Link className={`btn btn-outline-dark py-1 px-2`} to="/pickmeals">
          EDIT
        </Link>
      </h6>

      <div className="row g-4 flex-nowrap flex-sm-nowrap flex-md-wrap overflow-x-auto p-2">
        {watch(MEALS_KEY).length === 0 && <span>No meals selected</span>}
        {watch(MEALS_KEY).map((meal) => (
          <div key={meal.id} className="col-sm-9 col-md-4 col-lg-4 col-xl-4 position-relative">
            {/* <MealCard meal={meal} /> */}
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

      <div className="row">
        <div className="col p-4">
          <div className="p-3 border rounded-2 bg-white">
            <div className="fw-bold">
              {watch(FREQUENCY_KEY)} meals per week, {watch(PEOPLE_KEY)} people
            </div>
            <div className="">
              {watch(PREFERENCES_KEY)
                .map((selectedPreference) => mapKeyToDisplayName(preferences, selectedPreference))
                .join(", ")}
              , {mapKeyToDisplayName(subscriptions, watch(SUBSCRIPTION_KEY))}
            </div>
          </div>
        </div>
      </div>

      <div className="row">
        <div className="col-6 p-4">
          <label className="fw-bold mb-3" htmlFor="">
            Address
          </label>
          <div className="p-2 border rounded-2 bg-white">
            <div className="fw-bold p-2">
              {state["firstName"]} {state["lastName"]}, {state["street"]}, {state["city"]}, {state["state"]} {state["zipCode"]}
            </div>
          </div>
        </div>
        <div className="col-6 p-4">
          <label className="fw-bold mb-3" htmlFor="">
            Payment Information
          </label>
          <div className="p-2 border rounded-2 bg-white">
            <div className="fx-bold p-2">
              {state["cardType"]} ending {state["cardNumber"]}
            </div>
            <div className="p-2">next payment one: {state["nextPaymentDate"]}</div>
          </div>
        </div>
      </div>

      <div className="position-absolute bg-primary-lighter bg-radius-leaf supr-landing-bg"></div>
    </div>
  );
};
