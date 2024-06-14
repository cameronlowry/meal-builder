//#region external imports
import { useForm } from "react-hook-form";
import { useNavigate } from "react-router-dom";
import { useState } from "react";
//#endregion

//#region internal imports
import { Button, Form } from "../forms";
import { FREQUENCY_KEY, PEOPLE_KEY, PREFERENCES_KEY, SUBSCRIPTION_KEY } from "../constants";
import { useAppState } from "../services/state";
import { Heading } from "../components/Heading";
//#endregion

//#region data imports
import frequencyData from "../data/frequency_data.json";
import preferencesData from "../data/preferences_data.json";
import peopleData from "../data/people_data.json";
import subscriptionData from "../data/subscription_data.json";
import { CheckMark } from "../components/CheckMark";
import { YourSelection } from "../components/YourSelection";
import { CartIcon } from "../components/CartIcon";
//#endregion

export const PersonalizePlan = () => {
  const [state, setState] = useAppState();
  const [preferences] = useState(preferencesData);
  const [frequency] = useState(frequencyData);
  const [people] = useState(peopleData);
  const [subscriptions] = useState(subscriptionData);

  const { handleSubmit, register, watch, getValues } = useForm({ defaultValues: state });
  const navigate = useNavigate();

  const saveData = (data) => {
    setState({ ...state, ...data });
    navigate("/register");
  };

  return (
    <Form className="" onSubmit={handleSubmit(saveData)}>
      <fieldset>
        <Heading title="Personalize Your Plan" />

        <div className="row">
          <div id="plan-choices" className="col-sm-12 col-lg-8 p-5">
            <div>
              <h4>Choose your preferences</h4>
              <p>Your preferences will help us show you the most relevant meals first. You will still have access to all the meals each week!</p>

              <div className="row g-3">
                {preferences.map((button) => (
                  <label htmlFor={button.labelid} key={button.id} className={`col-sm-6 col-lg-4`}>
                    <div
                      className={`border ${
                        watch(PREFERENCES_KEY).includes(button.value) ? "border-secondary border-2" : "border-dark"
                      } rounded-1 d-flex flex-column text-center p-3 position-relative`}
                    >
                      {watch(PREFERENCES_KEY).includes(button.value) && <CheckMark className="position-absolute" />}

                      <span>
                        <img style={{ height: "24px" }} className="" src={button.image} alt={button.title} /> {/* Add alt tag */}
                      </span>

                      <span className="fw-bold mt-2">{button.title}</span>

                      <input
                        {...register(PREFERENCES_KEY)}
                        id={button.id}
                        type="checkbox"
                        className="d-none"
                        value={button.value}
                        data-field={PREFERENCES_KEY}
                      />
                    </div>
                  </label>
                ))}
              </div>
            </div>

            <hr className="my-5" />

            <div>
              <h4>Customize your Plan size</h4>

              <label className="mb-2">Number of people</label>
              <div className="row mb-4">
                {people.map((button) => (
                  <label htmlFor={button.labelid} key={button.id} className={`col-6`}>
                    <div className={`border rounded-1 position-relative ${watch(PEOPLE_KEY) === button.value ? "border-secondary border-2" : "border-dark"}`}>
                      <div className="text-center p-3">
                        <input
                          {...register(PEOPLE_KEY)}
                          id={button.id}
                          className="d-none"
                          type="radio"
                          value={button.value}
                          data-field={PEOPLE_KEY}
                        />
                        {button.title}
                      </div>
                      {watch(PEOPLE_KEY) === button.value && <CheckMark className="position-absolute" />}
                    </div>
                  </label>
                ))}
              </div>

              <label className="mb-2">Meals per week</label>
              <div className="row mb-4">
                {frequency.map((button) => (
                  <label htmlFor={button.labelid} key={button.id} className={`col`}>
                    <div
                      className={`text-center p-3 border rounded-1 position-relative ${
                        watch(FREQUENCY_KEY) === button.value ? "border-secondary border-2" : "border-dark"
                      }`}
                    >
                      {watch(FREQUENCY_KEY) === button.value && <CheckMark className="position-absolute" />}

                      <input
                        {...register(FREQUENCY_KEY)}
                        id={button.id}
                        className="d-none"
                        type="radio"
                        value={button.value}
                        data-field={FREQUENCY_KEY}
                      />

                      {button.title}
                    </div>
                  </label>
                ))}
              </div>
            </div>

            <hr className="my-5" />

            <div>
              <h4>Subscription</h4>

              <label className="mb-2">Type of subscription</label>
              <div className="row">
                {subscriptions.map((button) => (
                  <label htmlFor={button.labelid} key={button.id} className={`col`}>
                    <div
                      className={`text-center p-3 border rounded-1 position-relative ${
                        watch(SUBSCRIPTION_KEY) === button.value ? "border-secondary border-2" : "border-dark"
                      }`}
                    >
                      {watch(SUBSCRIPTION_KEY) === button.value && <CheckMark className="position-absolute" />}

                      <input
                        {...register(SUBSCRIPTION_KEY)}
                        id={button.id}
                        className="d-none"
                        type="radio"
                        value={button.value}
                        data-field={SUBSCRIPTION_KEY}
                      />
                      {button.title}
                    </div>
                  </label>
                ))}
              </div>
            </div>
          </div>

          <aside id="selected-choices" className="d-sm-none d-m-none d-lg-block d-xl-block col-4 sticky-top" style={{ height: "fit-content" }}>
            <div className="p-3 border rounded-1 mb-4">
              <h6 className="d-flex align-items-center gap-3">
                <CartIcon width="24px" /> Your selection
              </h6>
              <hr />
              <YourSelection selectedValues={getValues()} />
            </div>

            <Button>SELECT THIS PLAN</Button>
          </aside>

          <div className="accordion fixed-bottom d-sm-block d-md-block d-lg-none d-xl-none" id="accordionExample">
            <div className="accordion-item collapsed">
              <h2 className="accordion-header">
                <h6
                  className="accordion-button bg-white"
                  type="button"
                  onClick={() => document.getElementById("collapseOne").classList.toggle("show")}
                  aria-expanded="true"
                  aria-controls="collapseOne"
                >
                  <CartIcon width="24px" /> Your selection
                </h6>
              </h2>

              <div id="collapseOne" className="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                <div className="accordion-body">
                  <YourSelection selectedValues={getValues()} />
                </div>
              </div>

              <div className="p-4">
                <Button>SELECT THIS PLAN</Button>
              </div>
            </div>
          </div>
        </div>
      </fieldset>
    </Form>
  );
};
