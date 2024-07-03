import { useLocation, useNavigate } from "react-router-dom";

import { CheckMark } from "../components/CheckMark";
import { useAppState } from "../state/state";

export const Stepper = () => {
  const [state] = useAppState();
  const location = useLocation();
  const navigate = useNavigate();

  if (location.pathname === "/") {
    return null;
  }

  const getLinkClass = (path) => {
    return "nav-link disabled " + (isCurrentStep(path) ? "active" : undefined);
  };

  const isCurrentStep = (path) => {
    if (path === null || path == undefined) {
      return false;
    }
    return location.pathname.includes(path);
  };

  const isStepComplete = (path) => {
    if (path === null || path == undefined) {
      return false;
    }
    return state.steps.find((step) => step.path === path).isComplete;
  };

  return (
    <nav className="supr-stepper w-100 navbar navbar-expand-lg">
      <div className="collapse navbar-collapse justify-content-center">
        <ol className="navbar-nav gap-3">
          <li className={`step nav-item d-flex align-items-center`} onClick={() => navigate("/build", { relative: "path" })}>
            {(!isStepComplete("/build") || isCurrentStep("/build")) && (
              <span className={`step-number border rounded-circle ${isCurrentStep("/build") ? "bg-primary-light border-dark" : ""}`}>1</span>
            )}
            {!isCurrentStep("/build") && isStepComplete("/build") && <CheckMark className={"supr-checkmark--dark small"} />}
            <span className={getLinkClass("/build")}>Personalize</span>
          </li>
          <li className="step nav-item d-flex align-items-center" onClick={() => navigate("/register")}>
            {(!isStepComplete("/register") || isCurrentStep("/register")) && (
              <span className={`step-number border rounded-circle ${isCurrentStep("/register") ? "bg-primary-light border-dark" : ""}`}>2</span>
            )}
            {!isCurrentStep("/register") && isStepComplete("/register") && <CheckMark className={"supr-checkmark--dark small"} />}
            <span className={getLinkClass("/register")}>Register</span>
          </li>
          <li className="step nav-item d-flex align-items-center" onClick={() => navigate("/address")}>
            {(!isStepComplete("/address") || isCurrentStep("/address")) && (
              <span className={`step-number border rounded-circle ${isCurrentStep("/address") ? "bg-primary-light border-dark" : ""}`}>3</span>
            )}
            {!isCurrentStep("/address") && isStepComplete("/address") && <CheckMark className={"supr-checkmark--dark small"} />}
            <span className={getLinkClass("/address")}>Address</span>
          </li>
          <li className="step nav-item d-flex align-items-center" onClick={() => navigate("/pickmeals")}>
            {(!isStepComplete("/pickmeals") || isCurrentStep("/pickmeals")) && (
              <span className={`step-number border rounded-circle ${isCurrentStep("/pickmeals") ? "bg-primary-light border-dark" : ""}`}>4</span>
            )}
            {!isCurrentStep("/pickmeals") && isStepComplete("/pickmeals") && <CheckMark className={"supr-checkmark--dark small"} />}
            <span className={getLinkClass("/pickmeals")}>Pick your meals</span>
          </li>
          <li className="step nav-item d-flex align-items-center" onClick={() => navigate("/payment")}>
            {(!isStepComplete("/payment") || isCurrentStep("/payment")) && (
              <span className={`step-number border rounded-circle ${isCurrentStep("/payment") ? "bg-primary-light border-dark" : ""}`}>5</span>
            )}
            {!isCurrentStep("/payment") && isStepComplete("/payment") && <CheckMark className={"supr-checkmark--dark small"} />}
            <span className={getLinkClass("/payment")}>Payment</span>
          </li>
        </ol>
      </div>
    </nav>
  );
};
