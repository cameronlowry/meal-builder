//#region external imports
import { useForm } from "react-hook-form";
import { useState } from "react";
import { useNavigate, Link } from "react-router-dom";
// import Autocomplete, { usePlacesWidget } from "react-google-autocomplete";
//#endregion

//#region internal imports
import { Button, Field, Form, Input } from "../forms";
import { useAppState } from "../state/state";
import { DATE_KEY, DAY_KEY } from "../constants";
import { Heading } from "../components/Heading";
//#endregion

//#region data imports
import dayData from "../data/day_data.json";
import datesData from "../data/dates_data.json";
import { ShippingEstimate } from "../components/ShippingEstimate";
import { CartIcon } from "../components/CartIcon";
//#endregion

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
    setState({ ...state, ...data });
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
      <fieldset>
        <Heading title="Address" />

        <div className="row">
          <div id="address-column" className="col-sm-12 col-lg-8 px-5">
            <h6 className="mb-4">Delivery Address</h6>

            <div className="row">
              <div className="col-6">
                <Field label="First name*" error={errors?.firstName}>
                  <Input {...register("firstName", { required: "First name is required" })} id="first-name" />
                </Field>
              </div>
              <div className="col-6">
                <Field label="Last name" error={errors?.lastName}>
                  <Input {...register("lastName", { required: "Last name is required" })} id="last-name" />
                </Field>
              </div>
            </div>

            <div className="row">
              <div className="col-6">
                <Field label="Address*" error={errors?.street}>
                  {/* <Autocomplete
                    id="address"
                    className="d-block w-100 form-control"
                    apiKey={"TODO"}
                    onPlaceSelected={(place) => {
                      console.log(place);
                    }}
                  /> */}
                  <Input {...register("address")} id="address" />
                </Field>
              </div>
              <div className="col-6">
                <Field label="Address Line 2" error={errors?.addressLine2}>
                  <Input {...register("addressLine2")} id="addressLine2" />
                </Field>
              </div>
            </div>

            <div className="row">
              <div className="col-4">
                <Field label="City*" error={errors?.city}>
                  <Input {...register("city", { required: "city is required" })} id="city" />
                </Field>
              </div>
              <div className="col-4">
                <Field label="State*" error={errors?.useAppState}>
                  <Input {...register("state", { required: "State is required" })} id="state" />
                </Field>
              </div>
              <div className="col-4">
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

            <div>
              <h6 className="mb-4">Delivery Day</h6>

              <div className="d-flex align-items-center gap-4 mb-5">
                <label className="">Number of people per week</label>
                {days.map((button) => (
                  <label
                    htmlFor={button.labelid}
                    key={button.id}
                    className={`col border rounded-1 position-relative ${watch(DAY_KEY) === button.value ? "border-secondary border-2" : "border-dark"}`}
                  >
                    <div className="text-center p-3">
                      <input {...register(DAY_KEY)} id={button.id} className="d-none" type="radio" value={button.value} data-field={DAY_KEY} />

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
              </div>

              <div className="d-flex align-items-center gap-4 mb-5">
                <label>Number of people per week</label>
                {dates.map((button) => (
                  <label
                    htmlFor={button.labelid}
                    key={button.id}
                    className={`col border rounded-1 position-relative ${watch(DATE_KEY) === button.value ? "border-secondary border-2" : "border-dark"}`}
                  >
                    <div className="text-center p-3">
                      <input {...register(DATE_KEY)} id={button.id} className="d-none" type="radio" value={button.value} data-field={DATE_KEY} />

                      {button.title}
                    </div>
                    {watch(DATE_KEY) === button.value && (
                      <span className="supr-checkmark position-absolute">
                        <div className="supr-checkmark_stem"></div>
                        <div className="supr-checkmark_kick"></div>
                      </span>
                    )}
                  </label>
                ))}
              </div>
            </div>
          </div>

          <aside id="selected-choices" className="d-sm-none d-m-none d-lg-block d-xl-block col-4 sticky-top" style={{ height: "fit-content" }}>
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
                  {"<"} Previous
                </Link>
              </div>
            </div>
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
                  <ShippingEstimate selectedValues={getValues()} />
                </div>
              </div>

              <div className="p-4">
                <Button>SAVE & CONTINUE</Button>
              </div>
            </div>
          </div>
        </div>
      </fieldset>
    </Form>
  );
};
