//#region external imports
import { Link } from "react-router-dom";
import { Heading } from "../components/Heading";
import { CartIcon } from "../components/CartIcon";
//#endregion

//#region internal imports

//#endregion

//#region data imports

//#endregion

export const LandingPage = () => {
  return (
    <div className="container">
      <div
        className="row align-items-center p-5"
        style={{
          backgroundImage: "url(meal-builder-hero.jpg)",
          backgroundSize: "cover",
          backgroundRepeat: "no-repeat",
          minHeight: "670px",
          maxHeight: "70vh",
        }}
      >
        <div className="col-sm-12 col-md-6 px-3">
          <h1 className="fw-bold text-white mb-3 lh-1 text-uppercase">Health Eating Made Easy</h1>
          <h6 className="mb-5 text-white opensans-font fw-light">Your guide to convenient and healthy eating</h6>

          <Link className="btn btn-primary me-3 text-uppercase" to="/build">
            Build a meal
          </Link>
          <Link className="btn btn-outline-light text-uppercase" to="/build">
            See all meals
          </Link>
        </div>
      </div>

      <div className="row text-center p-5 my-2">
        <div className="col px-5 py-2 mt-5">
          <Heading title="How it works" />

          <div className="row px-5 mx-5 my-3">
            <div className="col-sm-12 col-md-4">
              <div className="d-flex flex-column align-items-center gap-2">
                <div className="bg-primary-light rounded-circle p-3" style={{ width: "80px" }}>
                  <CartIcon />
                </div>

                <div className="opensans-font fw-bold">Pick your meals</div>
                <p className="px-5">A new menu of 35 dietitian-designed options every week</p>
              </div>
            </div>
            <div className="col-sm-12 col-md-4">
              <div className="d-flex flex-column align-items-center gap-2">
                <div className="bg-primary-light rounded-circle p-3" style={{ width: "80px" }}>
                  <img src="cook.png" width="48px" height="48px" alt="Cooked to perfection" />
                </div>

                <div className="opensans-font fw-bold">Cooked to perfection</div>
                <p className="px-5">Our gourmet chefs do the prep, so you can do you</p>
              </div>
            </div>
            <div className="col-sm-12 col-md-4">
              <div className="d-flex flex-column align-items-center gap-2">
                <div className="bg-primary-light rounded-circle p-3" style={{ width: "80px" }}>
                  <img src="heat.png" width="48px" height="48px" alt="Heat, eat and enjoy" />
                </div>

                <div className="opensans-font fw-bold">Heat, eat and enjoy</div>
                <p className="px-5">No prep. No mess. Our meals arrive ready to heat and eat in minutes</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div className="row bg-primary-light py-5" style={{paddingLeft: "100px", paddingRight: "100px"}}>
        <div className="col-sm-12 col-md-6 py-4 pe-0 ps-5">
          <div className="">
            <img className="img-fluid" src="meal-builder-cooking.png" alt="Pick your meals" />
          </div>
        </div>
        <div className="col-sm-12 col-md-6 py-4 ps-0">
          <h2 className="oswald-font text-uppercase mb-4">HEALTHY, EASY, DELICIOUS</h2>

          <div className="row">
            <div className="col-12 d-flex gap-2">
              <img src="leaf.png" width="32px" height="32px" alt="Pick your meals" />
              <div>
                <h6 className="opensans-font fw-bold">Fresh, Never-Frozen Meals</h6>
                <p className="pe-5">We only use premium ingredients from our network of trusted partners. All meals are Chef-prepared and Dietitian-approved.</p>
              </div>
            </div>
            <div className="col-12 d-flex gap-1">
              <img src="leaf.png" width="32px" height="32px" alt="Pick your meals" />
              <div>
                <h6 className="opensans-font fw-bold">Chef - Crafted Meals</h6>
                <p className="pe-5">We only use premium ingredients from our network of trusted partners. All meals are Chef-prepared and Dietitian-approved.</p>
              </div>
            </div>
            <div className="col-12 d-flex gap-1">
              <img src="leaf.png" width="32px" height="32px" alt="Pick your meals" />
              <div>
                <h6 className="opensans-font fw-bold">Designed by Dietitians</h6>
                <p className="pe-5">We only use premium ingredients from our network of trusted partners. All meals are Chef-prepared and Dietitian-approved.</p>
              </div>
            </div>
          </div>

          <Link className="btn btn-outline-dark text-uppercase ms-4 mt-3" to="/build">
            Build a meal
          </Link>
        </div>
      </div>

      <div className="row p-5 text-center">
        <div className="col p-5 m-5">
          <Heading title="EXPLORE OUR MENU" className="mb-5" />

          <div className="p-5">MEAL SLIDER</div>

          <Link className="btn btn-primary" to="/build">
            BROWSE OUR MEALS
          </Link>
        </div>
      </div>
    </div>
  );
};
