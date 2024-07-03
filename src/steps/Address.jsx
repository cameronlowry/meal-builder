//#region external imports
import { useForm } from "react-hook-form";
import { useState } from "react";
import { useNavigate, Link } from "react-router-dom";
import { Accordion } from "react-bootstrap";
// import Autocomplete, { usePlacesWidget } from "react-google-autocomplete";
//#endregion

//#region internal imports
import { Button, Field, Form, Input } from "../forms";
import { useAppState } from "../state/state";
import { DATE_KEY, DAY_KEY } from "../constants";
//#endregion

//#region data imports
import dayData from "../data/day_data.json";
import datesData from "../data/dates_data.json";
import { ShippingEstimate } from "../components/ShippingEstimate";
import { CartIcon } from "../components/CartIcon";
import ScrollToTop from "../components/ScrollToTop";
import { Heading } from "../components/Heading";
import { validateSteps } from "../services/PlanService";
//#endregion

const STEP_KEY = "/address";

export const Address = () => {
  const [state, setState] = useAppState();
  const [days] = useState(dayData);
  const [dates] = useState(datesData);

  const {
    handleSubmit,
    register,
    formState: { errors },
    watch,
    getValues,
  } = useForm({ defaultValues: state });
  const navigate = useNavigate();

  const saveData = (data) => {
    const steps = validateSteps({ ...state, ...data });

    if (!steps.find((step) => step.path === STEP_KEY).isComplete) {
      setState({ ...state, steps });
      return;
    }
    setState({ ...state, ...data, steps });
    navigate("/pickmeals");
  };

  // const { ref, autocompleteRef } = usePlacesWidget({
  //   apiKey: "",
  //   onPlaceSelected: (place) => {
  //     console.log(place);
  //   },
  // });

  return (
    <Form className="" onSubmit={handleSubmit(saveData)}>
      <ScrollToTop />

      <fieldset>
        <Heading title="Address" />

        <div className="row">
          <div id="address-column" className="col-sm-12 col-lg-8 px--sm-0 px-md-5">
            <h6 className="mb-4">Delivery Address</h6>

            <div className="row">
              <div className="col-sm-12 col-md-6">
                <Field label="First name*" error={errors?.firstName}>
                  <Input {...register("firstName", { required: "First name is required" })} id="first-name" />
                </Field>
              </div>
              <div className="col-sm-12 col-md-6">
                <Field label="Last name" error={errors?.lastName}>
                  <Input {...register("lastName", { required: "Last name is required" })} id="last-name" />
                </Field>
              </div>
            </div>

            <div className="row">
              <div className="col-sm-12 col-md-6">
                <Field label="Address*" error={errors?.addressLine1}>
                  {/* <Autocomplete
                    id="addressLine1Autocomplete"
                    className="d-block w-100 form-control"
                    apiKey={"TODO"}
                    onPlaceSelected={(place) => {
                      console.log(place);
                    }}
                  /> */}
                  <Input {...register("addressLine1", { required: "Address is required" })} id="addressLine1" />
                </Field>
              </div>
              <div className="col-sm-12 col-md-6">
                <Field label="Address Line 2" error={errors?.addressLine2}>
                  <Input {...register("addressLine2")} id="addressLine2" />
                </Field>
              </div>
            </div>

            <div className="row">
              <div className="col-sm-12 col-md-4">
                <Field label="City*" error={errors?.city}>
                  <Input {...register("city", { required: "City is required" })} id="city" />
                </Field>
              </div>
              <div className="col-sm-12 col-md-4">
                <Field label="State*" error={errors?.useAppState}>
                  <Input {...register("state", { required: "State is required" })} id="state" />
                </Field>
              </div>
              <div className="col-sm-12 col-md-4">
                <Field label="ZIP code*" error={errors?.zipCode}>
                  <Input {...register("zipCode", { required: "ZIP code is required" })} id="zip-code" type="number" />
                </Field>
              </div>
            </div>

            <div className="row">
              <div className="col">
                <Field label="Phone Number*" error={errors?.phoneNumber}>
                  <Input {...register("phoneNumber", { required: "Phone Number is required" })} id="phone-number" type="tel" />
                </Field>
              </div>
            </div>

            <hr />

            <div>
              <h6 className="mb-4">Delivery Day</h6>

              <div className="d-flex align-items-center gap-4 mb-5">
                <label className="">When do you want your weekly delivery?</label>
                {days.map((button) => (
                  <label
                    htmlFor={button.labelid}
                    key={button.id}
                    className={`col border rounded-1 position-relative ${
                      watch(DAY_KEY) === button.value ? "border-secondary border-2 bg-primary-lighter" : "border-dark"
                    }`}
                  >
                    <div className="text-center p-3">
                      <input
                        {...register(DAY_KEY, { required: "Delivery Day is required" })}
                        id={button.id}
                        className="d-none"
                        type="radio"
                        value={button.value}
                        data-field={DAY_KEY}
                      />

                      {button.title}
                    </div>
                    {watch(DAY_KEY) === button.value && (
                      <span className="supr-checkmark position-absolute">
                        <div className="supr-checkmark_stem"></div>
                        <div className="supr-checkmark_kick"></div>
                      </span>
                    )}
                  </label>
                ))}
                {errors[DAY_KEY] && <small className="error">{errors[DAY_KEY]?.message}</small>}
              </div>

              <div className="d-flex align-items-center gap-4 mb-5">
                <label>Pick your first day</label>
                {dates.map((button) => (
                  <label
                    htmlFor={button.labelid}
                    key={button.id}
                    className={`col border rounded-1 position-relative ${
                      watch(DATE_KEY) === button.value ? "border-secondary border-2 bg-primary-lighter" : "border-dark"
                    }`}
                  >
                    <div className="text-center p-3">
                      <input
                        {...register(DATE_KEY, { required: "Delivery Date is required" })}
                        id={button.id}
                        className="d-none"
                        type="radio"
                        value={button.value}
                        data-field={DATE_KEY}
                      />
                      <span className="text-capitalize">{watch(DAY_KEY)}</span> {button.title}
                    </div>
                    {watch(DATE_KEY) === button.value && (
                      <span className="supr-checkmark position-absolute">
                        <div className="supr-checkmark_stem"></div>
                        <div className="supr-checkmark_kick"></div>
                      </span>
                    )}
                  </label>
                ))}
                {errors[DATE_KEY] && <small className="error">{errors[DATE_KEY]?.message}</small>}
              </div>
            </div>
          </div>

          <aside id="selected-choices" className="d-none d-lg-block d-xl-block col-4 sticky-top" style={{ height: "fit-content" }}>
            <div className="p-4 border rounded-1 mb-4">
              <h6 className="d-flex align-items-center gap-3">
                <CartIcon width="24px" /> Your selection
              </h6>
              <hr />

              <ShippingEstimate selectedValues={getValues()} />
            </div>

            <div className="text-center">
              <Button>SAVE & CONTINUE</Button>

              <div className="mt-2">
                <Link className={``} to="/register">
                  Previous
                </Link>
              </div>
            </div>
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

              <Accordion.Body>
                <ShippingEstimate selectedValues={getValues()} />
              </Accordion.Body>

              <div className="p-3 text-center">
                <Button>SAVE & CONTINUE</Button>

                <div className="mt-3">
                  <Link className={``} to="/register">
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
