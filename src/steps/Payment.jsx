import { useForm } from "react-hook-form";
import { Link, useNavigate } from "react-router-dom";
import { Accordion } from "react-bootstrap";

import { Button } from "../forms";
import { useAppState } from "../state/state";
import { Heading } from "../components/Heading";
import { ShippingEstimate } from "../components/ShippingEstimate";
import { CartIcon } from "../components/CartIcon";
import ScrollToTop from "../components/ScrollToTop";
import PaymentRedirect from "../components/PaymentRedirect";

export const Payment = () => {
  const [state, setState] = useAppState();
  const { handleSubmit, getValues } = useForm({ defaultValues: state, mode: "onSubmit" });

  const navigate = useNavigate();

  const saveData = (data) => {
    setState({ ...state, ...data });
    navigate("/complete");
  };

  return (
    <div className="container py-5">
      <ScrollToTop />

      <fieldset>
        <Heading title="Payment" />

        <div className="row">
          <div className="col-sm-12 col-lg-8 px--sm-0 px-md-5">
            <PaymentRedirect />            
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
              {/* <Button>PLACE ORDER</Button> */}

              <div className="mt-2">
                <Link className={``} to="/pickmeals">
                  Previous
                </Link>
              </div>
            </div>
          </aside>

          <Accordion className="fixed-bottom d-sm-block d-md-block d-lg-none d-xl-none px-0">
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
    </div>
  );
};
