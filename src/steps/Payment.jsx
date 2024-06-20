import { useForm } from "react-hook-form";
import { Link, useNavigate } from "react-router-dom";
// import { PaymentForm } from "react-square-web-payments-sdk";

import { Button, Form } from "../forms";
import { useAppState } from "../state/state";
import { Heading } from "../components/Heading";
import { ShippingEstimate } from "../components/ShippingEstimate";
import { CartIcon } from "../components/CartIcon";

export const Payment = () => {
  const [state, setState] = useAppState();
  const { handleSubmit, getValues } = useForm({ defaultValues: state, mode: "onSubmit" });

  const navigate = useNavigate();

  const saveData = (data) => {
    setState({ ...state, ...data });
    navigate("/complete");
  };

  return (
    <Form className="" onSubmit={handleSubmit(saveData)}>
      <fieldset>
        <Heading title="Payment" />

        <div className="row">
          <div className="col-sm-12 col-lg-8 p-5">
            {/* <PaymentForm applicationId="sq0idp-Y0QZQ-test" /> */}
            PAYMENT FORM HERE
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
              <Button>PLACE ORDER</Button>

              <div className="mt-2">
                <Link className={``} to="/pickmeals">
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
