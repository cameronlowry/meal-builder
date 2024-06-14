//#region external imports
import PropTypes from "prop-types";
//#endregion

//#region internal imports
import { FREQUENCY_KEY, PEOPLE_KEY, PREFERENCES_KEY, PRICE_PER_MEAL_DISCOUNTED } from "../constants";
import { mapKeyToDisplayName } from "../services/PlanService";
//#endregion

//#region data imports
import preferencesData from "../data/preferences_data.json";
import { useState } from "react";
//#endregion

export const ShippingEstimate = ({ selectedValues }) => {
  const [preferences] = useState(preferencesData);

  const {
    [PREFERENCES_KEY]: selectedPreferences,
    [FREQUENCY_KEY]: selectedFrequency,
    [PEOPLE_KEY]: selectedPeople,
  } = selectedValues;

  return (
    <>
      <div className="fw-bold mb-2">
        {selectedFrequency} meals per week, {selectedPeople} people
      </div>

      <div className="mb-2">{selectedPreferences.map((x) => mapKeyToDisplayName(preferences, x)).join(", ")}</div>

      <div className="mb-2">
        {parseInt(selectedFrequency, 10) * parseInt(selectedPeople, 10)} total servings at{" "}
        <span className="fw-bold">${PRICE_PER_MEAL_DISCOUNTED.toFixed(2)}</span> per serving
      </div>

      <hr />

      <div className="mb-2 d-flex justify-content-between">
        <label className="fw-bold">Shipping</label> $10.99
      </div>
      <div className="mb-2 d-flex justify-content-between">
        <label className="fw-bold">Tax</label> $4.99
      </div>
      <div className="mb-2 d-flex justify-content-between">
        <label className="fw-bold">Discount</label> <span className="fw-bold">$30.99</span>
      </div>

      <hr />

      <div className="mt-1 py-4 px-3 d-flex justify-content-between bg-primary-light">
        <label className="fw-bold">First box total</label>
        <span>${(parseInt(selectedFrequency, 10) * parseInt(selectedPeople, 10) * PRICE_PER_MEAL_DISCOUNTED).toFixed(2)}</span>
      </div>
    </>
  );
};

ShippingEstimate.propTypes = {
  selectedValues: PropTypes.any,
};

ShippingEstimate.displayName = "ShippingEstimate";
