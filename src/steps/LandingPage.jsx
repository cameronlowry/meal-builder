//#region external imports
import { Link } from "react-router-dom";
import { Heading } from "../components/Heading";
import { CartIcon } from "../components/CartIcon";
//#endregion

//#region internal imports

//#endregion

//#region image imports
import heroImage from "/public/meal-builder-hero.jpg";
import cookImage from "/public/cook.png";
import heatImage from "/public/heat.png";
import cookingImage from "/public/meal-builder-cooking.png";
import leafImage from "/public/leaf.png";
import { Offer } from "../forms/Offer";
import { MealsCarousel } from "../components/MealsCarousel";
//#endregion

export const LandingPage = () => {
  return (
    <div className="">
      <Offer />

      <div
        className="row align-items-center p-sm-5 p-md-5 p-lg-5"
        style={{
          backgroundImage: `url(${heroImage})`,
          backgroundSize: "cover",
          backgroundRepeat: "no-repeat",
          backgroundPosition: "center",
          minHeight: "670px",
          maxHeight: "70vh",
        }}
      >
        <div className="col-sm-12">
          <div className="container">
            <h1 className="fw-bold text-white mb-3 lh-1 text-uppercase oswald-font col-sm-12 col-md-9 col-lg-8 col-xl-7 col-xxl-6">
              Healthy Eating Made Easy
            </h1>
            <h6 className="mb-5 text-white opensans-font fw-light">Your guide to convenient and healthy eating</h6>
            
            <Link className="btn btn-primary me-3 text-uppercase mb-3" to="/build">
              Build a meal
            </Link>
            
            <a className="btn btn-outline-light text-uppercase mb-3" href="#all-meals">
              See all meals
            </a>
          </div>
        </div>
      </div>

      <div className="row text-center my-5">
        <div className="col p-0 mx-md-5 px-sm-4 px-md-5 px-lg-5 py-2 mt-5">
          <Heading title="How it works" />

          <div className="row px-md-5 px-lg-0 px-xl-5 mx-5 mx-lg-0 mx-md-5 mx-sm-5 my-3">
            <div className="col-sm-12 col-md-12 col-lg-4">
              <div className="d-flex flex-column align-items-center gap-2">
                <div className="bg-primary-light rounded-circle p-3" style={{ width: "80px" }}>
                  <CartIcon />
                </div>

                <div className="opensans-font fw-bold">Pick your meals</div>
                <p className="px-sm-0 px-md-3 px-lg-5 mb-5">A new menu of 35 dietitian-designed options every week</p>
              </div>
            </div>

            <div className="col-sm-12 col-md-12 col-lg-4">
              <div className="d-flex flex-column align-items-center gap-2">
                <div className="bg-primary-light rounded-circle p-3" style={{ width: "80px" }}>
                  <img src={cookImage} width="48px" height="48px" alt="Cooked to perfection" />
                </div>

                <div className="opensans-font fw-bold">Cooked to perfection</div>
                <p className="px-sm-0 px-md-3 px-lg-5 mb-5">Our gourmet chefs do the prep, so you can do you</p>
              </div>
            </div>

            <div className="col-sm-12 col-md-12 col-lg-4">
              <div className="d-flex flex-column align-items-center gap-2">
                <div className="bg-primary-light rounded-circle p-3" style={{ width: "80px" }}>
                  <img src={heatImage} width="48px" height="48px" alt="Heat, eat and enjoy" />
                </div>

                <div className="opensans-font fw-bold">Heat, eat and enjoy</div>
                <p className="px-sm-0 px-md-3 px-lg-5">No prep. No mess. Our meals arrive ready to heat and eat in minutes</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div className="row bg-primary-light py-5 px-0" style={{ paddingLeft: "100px", paddingRight: "100px" }}>
        <div className="col-sm-12 col-md-12 col-lg-6 p-4 pe-md-4 pe-lg-5 d-flex">
          <div className="w-100 d-grid justify-content-end justify-content-md-center justify-content-sm-center">
            <img className="img-fluid w-100 mw-lg-450" src={cookingImage} alt="Pick your meals" />
          </div>
        </div>
        <div className="col-sm-12 col-md-12 col-lg-6 py-4 ps-lg-0 ps-sm-4 ps-md-5">
          <h2 className="oswald-font text-uppercase mb-4">HEALTHY, EASY, DELICIOUS</h2>

          <div className="row me-sm-0 me-md-0 pe-sm-0 pe-md-5 pe-lg-0 pe-xl-5">
            <div className="col-12 d-flex gap-2 mb-3 pe-lg-3">
              <img src={leafImage} width="32px" height="32px" alt="Pick your meals" />
              <div>
                <h6 className="opensans-font fw-bold">Fresh, Never-Frozen Meals</h6>
                <p className="pe-5">
                  We only use premium ingredients from our network of trusted partners. All meals are Chef-prepared and Dietitian-approved.
                </p>
              </div>
            </div>
            <div className="col-12 d-flex gap-2 mb-3 pe-lg-3">
              <img src={leafImage} width="32px" height="32px" alt="Pick your meals" />
              <div>
                <h6 className="opensans-font fw-bold">Chef - Crafted Meals</h6>
                <p className="pe-5">
                  We only use premium ingredients from our network of trusted partners. All meals are Chef-prepared and Dietitian-approved.
                </p>
              </div>
            </div>
            <div className="col-12 d-flex gap-2 mb-3 pe-lg-3">
              <img src={leafImage} width="32px" height="32px" alt="Pick your meals" />
              <div>
                <h6 className="opensans-font fw-bold">Designed by Dietitians</h6>
                <p className="pe-5">
                  We only use premium ingredients from our network of trusted partners. All meals are Chef-prepared and Dietitian-approved.
                </p>
              </div>
            </div>
          </div>

          <Link className="btn btn-outline-dark text-uppercase ms-4 mt-3" to="/build">
            Build a meal
          </Link>
        </div>
      </div>

      <div id="all-meals" className="row text-center">
        <div className="col-12 py-5 my-5">
          <div className="container">
            <Heading title="EXPLORE OUR MENU" className="mb-5" />
            
            <div className="mb-5">
              <MealsCarousel />
            </div>
            
            <Link className="btn btn-primary" to="/build">
              BROWSE OUR MEALS
            </Link>
          </div>
        </div>
      </div>
    </div>
  );
};
