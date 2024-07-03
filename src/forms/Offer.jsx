//#region external imports
import Modal from "react-bootstrap/Modal";
import { useLocation, useNavigate } from "react-router-dom";
//#endregion

//#region internal imports
import { createCookie } from "../services/CookieService";
import { useAppState } from "../state/state";
//#endregion

//#region image imports
import suprFoodLogo from "/public/logo.svg";
import offerImage from "/public/offer.jpg";
//#endregion

/**
 *
 * @description Shows a discount offer in a popup modal when the user visits the site for the first time.
 * @constructs A cookie is set to prevent the modal from showing again.
 * @returns {JSX.Element}
 */
export const Offer = () => {
  const [state, setState] = useAppState();
  const location = useLocation();
  const navigate = useNavigate();

  const handleClose = () => {
    createCookie("offer_dismissed", true);
    setState({ ...state, offerDismissed: true });

    if (location.pathname === "/offer") {
      navigate("/build");
    }
  };

  // useState(() => {
  //   createDiscountCode().then((discountCode) => {
  //     setState({ ...state, discountCode });
  //   });
  // }, []);

  return (
    <Modal
      className=""
      size="xl"
      enforceFocus={true}
      fullscreen="lg-down"
      show={!state.offerDismissed || location.pathname === "/offer"}
      onHide={handleClose}
    >
      <Modal.Body className="">
        <div className="position-relative">
          <button type="button" className="btn-close position-absolute" style={{ top: 0, right: 0 }} aria-label="Close" onClick={handleClose} />

          <div className="row">
            <div className="col-sm-12 col-md-12 col-lg-7 col-xl-8 order-1 order-lg-0">
              <img src={offerImage} className="img-fluid w-100" />
            </div>

            <div className="col-sm-12 col-md-12 col-lg-5 col-xl-4 d-flex flex-column justify-content-center py-4 px-lg-4 order-0 order-lg-1">
              <div>
                <img className="img-fluid w-auto" src={suprFoodLogo} alt="Supr. Food Kitchen Logo" />
              </div>

              <div className="mt-3">Welcome to SUPR Food Kitchen</div>

              <h1 className="mt-3 mb-0 oswald-font">50% OFF</h1>
              <span className="">+20% off next month</span>

              <form className="mt-4">
                <input type="email" placeholder="Email address" className="form-control" />

                <div className="d-flex align-items-center gap-2 mt-4">
                  <button className="btn btn-primary">UNLOCK OFFER</button>
                </div>

                {/* <div className="">{state.discountCode}</div> */}

                <p className="mt-3">
                  <small>*Only valid for first time subscribers</small>
                </p>
              </form>
            </div>
          </div>
        </div>
      </Modal.Body>
    </Modal>
  );
};
