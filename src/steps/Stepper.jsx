import { useLocation, useNavigate } from "react-router-dom";

import { CheckMark } from "../components/CheckMark";

export const Stepper = () => {
  const location = useLocation();
  const navigate = useNavigate();

  if (location.pathname === "/") {
    return null;
  }

  const getLinkClass = (path) => {
    return "nav-link disabled " + (isCurrentStep(path) ? "active" : undefined);
  };

  const isCurrentStep = (path) => {
    return path === location.pathname;
  };

  //TODO: Implement this function
  const isStepComplete = (path) => {
    return false;
  };

  return (
    <nav className="supr-stepper w-100 navbar navbar-expand-lg">
      <div className="collapse navbar-collapse justify-content-center">
        <ol className="navbar-nav gap-3">
          <li className={`step nav-item d-flex align-items-center`} onClick={() => navigate("/build")}>
            {!isStepComplete("/build") && (
              <span className={`step-number border rounded-circle ${isCurrentStep("/build") ? "bg-primary-light border-dark" : ""}`}>1</span>
            )}
            {!isCurrentStep("/build") && isStepComplete("/build") && <CheckMark className={"supr-checkmark--dark"} />}
            <span className={getLinkClass("/build")}>Personalize</span>
          </li>
          <li className="step nav-item d-flex align-items-center" onClick={() => navigate("/register")}>
            {!isStepComplete("/register") && (
              <span className={`step-number border rounded-circle ${isCurrentStep("/register") ? "bg-primary-light border-dark" : ""}`}>2</span>
            )}
            {!isCurrentStep("/register") && isStepComplete("/register") && <CheckMark className={"supr-checkmark--dark"} />}
            <span className={getLinkClass("/register")}>Register</span>
          </li>
          <li className="step nav-item d-flex align-items-center" onClick={() => navigate("/address")}>
            {!isStepComplete("/address") && (
              <span className={`step-number border rounded-circle ${isCurrentStep("/address") ? "bg-primary-light border-dark" : ""}`}>3</span>
            )}
            {!isCurrentStep("/address") && isStepComplete("/address") && <CheckMark className={"supr-checkmark--dark"} />}
            <span className={getLinkClass("/address")}>Address</span>
          </li>
          <li className="step nav-item d-flex align-items-center" onClick={() => navigate("/pickmeals")}>
            {!isStepComplete("/pickmeals") && (
              <span className={`step-number border rounded-circle ${isCurrentStep("/pickmeals") ? "bg-primary-light border-dark" : ""}`}>4</span>
            )}
            {!isCurrentStep("/pickmeals") && isStepComplete("/pickmeals") && <CheckMark className={"supr-checkmark--dark"} />}
            <span className={getLinkClass("/pickmeals")}>Pick your meals</span>
          </li>
          <li className="step nav-item d-flex align-items-center" onClick={() => navigate("/payment")}>
            {!isStepComplete("/payment") && (
              <span className={`step-number border rounded-circle ${isCurrentStep("/payment") ? "bg-primary-light border-dark" : ""}`}>5</span>
            )}
            {!isCurrentStep("/payment") && isStepComplete("/payment") && <CheckMark className={"supr-checkmark--dark"} />}
            <span className={getLinkClass("/payment")}>Payment</span>
          </li>
        </ol>
      </div>
    </nav>
  );
};
