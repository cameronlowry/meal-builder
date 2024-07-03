//#region external imports
import { useForm } from "react-hook-form";
import { useNavigate } from "react-router-dom";
import { useEffect, useRef, useState } from "react";
import { Accordion } from "react-bootstrap";
//#endregion

//#region data imports
import frequencyData from "../data/frequency_data.json";
import preferencesData from "../data/preferences_data.json";
import peopleData from "../data/people_data.json";
import subscriptionData from "../data/subscription_data.json";
//#endregion

//#region internal imports
import { Button, Form } from "../forms";
import { FREQUENCY_KEY, PEOPLE_KEY, PREFERENCES_KEY, SUBSCRIPTION_KEY } from "../constants";
import { useAppState } from "../state/state";
import { Heading } from "../components/Heading";
import { CheckMark } from "../components/CheckMark";
import { YourSelection } from "../components/YourSelection";
import { CartIcon } from "../components/CartIcon";
import ScrollToTop from "../components/ScrollToTop";
import { validateSteps } from "../services/PlanService";
//#endregion

const STEP_KEY = "/build";

export const PersonalizePlan = () => {
  const [state, setState] = useAppState();
  const [preferences] = useState(preferencesData);
  const [frequency] = useState(frequencyData);
  const [people] = useState(peopleData);
  const [subscriptions] = useState(subscriptionData);

  const { handleSubmit, register, watch, getValues } = useForm({ defaultValues: state, mode: "onBlur" });

  const navigate = useNavigate();
  const accordionTrigger = useRef(null);

  const saveData = (data) => {
    const steps = validateSteps({ ...state, ...data });

    if (!steps.find((step) => step.path === STEP_KEY).isComplete) {
      setState({ ...state, steps });
      return;
    }
    setState({ ...state, ...data, steps });
    navigate("/register");
  };

  useEffect(() => {
    accordionTrigger.current?.click();
    setState({ ...state, summaryDisplayed: true });
    validateSteps(state);
  }, []);
  useEffect(() => {
    if (state.summaryDisplayed) {
      setTimeout(() => {
        accordionTrigger.current?.click();
      }, 1600);
    }
  }, [state.summaryDisplayed]);

  return (
    <Form className="" onSubmit={handleSubmit(saveData)}>
      <ScrollToTop />

      <fieldset>
        <Heading title="Personalize Your Plan" />

        <div className="row">
          <div id="plan-choices" className="col-sm-12 col-lg-8 p-4 p-md-5 p-lg-5">
            <div>
              <h4>Choose your preferences</h4>
              <p>Your preferences will help us show you the most relevant meals first. You will still have access to all the meals each week!</p>

              <div className="row g-3">
                {preferences.map((button) => preferenceButton(button, register, watch(PREFERENCES_KEY).includes(button.value)))}
              </div>
            </div>

            <hr className="my-5" />

            <div>
              <h4>Customize your Plan size</h4>

              <label className="mb-2">Number of people</label>
              <div className="row mb-4">{people.map((button) => radioButton(button, register, watch(PEOPLE_KEY) === button.value))}</div>

              <label className="mb-2">Meals per week</label>
              <div className="row mb-4">
                {frequency.map((button) => (
                  <label htmlFor={button.labelid} key={button.id} className={`col`}>
                    <div
                      className={`text-center p-3 border rounded-1 position-relative ${
                        watch(FREQUENCY_KEY) === button.value ? "border-secondary border-2 bg-primary-lighter" : "border-dark"
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
                        watch(SUBSCRIPTION_KEY) === button.value ? "border-secondary border-2 bg-primary-lighter" : "border-dark"
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

          <aside id="selected-choices" className="d-none d-lg-block d-xl-block col-4 sticky-top" style={{ height: "fit-content" }}>
            <div className="p-4 border rounded-1 mb-4">
              <h6 className="d-flex align-items-center gap-3">
                <CartIcon width="24px" /> Your selection
              </h6>
              <hr />
              <YourSelection selectedValues={getValues()} />
            </div>

            <Button>SELECT THIS PLAN</Button>
          </aside>

          <Accordion className="fixed-bottom d-sm-block d-md-block d-lg-none d-xl-none px-0">
            <Accordion.Item eventKey="0" className="shadow-xl">
              <Accordion.Button className="d-none" ref={accordionTrigger}></Accordion.Button>
              <Accordion.Header>
                <div className="d-flex align-items-end gap-2">
                  <CartIcon width="24px" />
                  <span className="h-100">Your selection</span>
                </div>
              </Accordion.Header>

              <hr className="mx-3 my-2" />

              <Accordion.Body>
                <YourSelection selectedValues={getValues()} />
              </Accordion.Body>

              <div className="p-3">
                <Button>SELECT THIS PLAN</Button>
              </div>
            </Accordion.Item>
          </Accordion>
        </div>
      </fieldset>
    </Form>
  );
};

const preferenceButton = (button, register, isActive) => (
  <label htmlFor={button.labelid} key={button.id} className={`col-sm-6 col-lg-4`}>
    <div
      className={`border ${
        isActive ? "border-secondary border-2 bg-primary-lighter" : "border-dark"
      } rounded-1 d-flex flex-column text-center p-3 position-relative`}
    >
      {isActive && <CheckMark className="position-absolute" />}

      <span>
        <img style={{ height: "24px" }} className="" src={button.image} alt={button.title} /> {/* Add alt tag */}
      </span>

      <span className="fw-bold mt-2">{button.title}</span>

      <input {...register(PREFERENCES_KEY)} id={button.id} type="checkbox" className="d-none" value={button.value} data-field={PREFERENCES_KEY} />
    </div>
  </label>
);

const radioButton = (button, register, isActive) => (
  <label htmlFor={button.labelid} key={button.id} className={`col-6`}>
    <div className={`border rounded-1 position-relative ${isActive ? "border-secondary border-2 bg-primary-lighter" : "border-dark"}`}>
      <div className="text-center p-3">
        <input {...register(PEOPLE_KEY)} id={button.id} className="d-none" type="radio" value={button.value} data-field={PEOPLE_KEY} />
        {button.title}
      </div>
      {isActive && <CheckMark className="position-absolute" />}
    </div>
  </label>
);
