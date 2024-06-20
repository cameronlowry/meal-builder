//#region external imports
import { useState } from "react";
import PropTypes from "prop-types";
//#endregion

//#region internal imports
import { FREQUENCY_KEY, PEOPLE_KEY, PREFERENCES_KEY, PRICE_PER_MEAL, PRICE_PER_MEAL_DISCOUNTED, SUBSCRIPTION_KEY } from "../constants";
import { mapKeyToDisplayName } from "../services/PlanService";
//#endregion

//#region data imports
import preferencesData from "../data/preferences_data.json";
import subscriptionData from "../data/subscription_data.json";
//#endregion

export const YourSelection = ({ selectedValues }) => {
  const [preferences] = useState(preferencesData);
  const [subscriptions] = useState(subscriptionData);

  const { [PREFERENCES_KEY]: selectedPreferences, [FREQUENCY_KEY]: selectedFrequency, [PEOPLE_KEY]: selectedPeople, [SUBSCRIPTION_KEY]: selectedSubscription } = selectedValues;

  return (
    <>
      <div className="fw-bold mb-2">{selectedPreferences.map((selectedPreference) => mapKeyToDisplayName(preferences, selectedPreference)).join(", ")}</div>

      <div className="">
        {selectedFrequency} meals for {selectedPeople} per week
      </div>
      <div className="mb-2">{parseInt(selectedFrequency, 10) * parseInt(selectedPeople, 10)} total servings</div>

      <div className="fw-bold mb-2">{mapKeyToDisplayName(subscriptions, selectedSubscription)}</div>

      <hr />

      <div className="mb-2 d-flex justify-content-between">
        <label className="fw-bold">Box price:</label> ${parseInt(selectedFrequency, 10) * parseInt(selectedPeople, 10) * PRICE_PER_MEAL}
      </div>
      <div className="mb-2 d-flex justify-content-between">
        <label className="fw-bold">Price per serving</label>{" "}
        <span>
          <s className="text-body-tertiary mx-3">${PRICE_PER_MEAL.toFixed(2)}</s> ${PRICE_PER_MEAL_DISCOUNTED.toFixed(2)}
        </span>
      </div>

      <hr />

      <div className="mt-1 py-4 px-3 d-flex justify-content-between bg-primary-light">
        <label className="fw-bold">First box total</label>
        <span className="fw-bold">
          ${(parseInt(selectedFrequency, 10) * parseInt(selectedPeople, 10) * PRICE_PER_MEAL_DISCOUNTED).toFixed(2)}
        </span>
      </div>
    </>
  );
};

YourSelection.propTypes = {
    selectedValues: PropTypes.any,
};

YourSelection.displayName = "YourSelection";
