//#region external imports
import { MemoryRouter as Router, Routes, Route } from "react-router-dom";
// import { createHashHistory } from "history";
//#endregion

//#region internal imports
import { Address } from "./steps/Address";
import { AppProvider } from "./state/state";
import { Complete } from "./steps/Complete";
import { Payment } from "./steps/Payment";
import { PersonalizePlan } from "./steps/PersonalizePlan";
import { PickMeals } from "./steps/PickMeals";
import { Register } from "./steps/Register";
import { Stepper } from "./steps/Stepper";
import { Error } from "./steps/Error";
import { LandingPage } from "./steps/LandingPage";
import ScrollToTop from "./services/ScrollToTop";
import { Offer } from "./forms/Offer";
//#endregion

function App() {
  // const memoryHistory = createHashHistory({});

  return (
    <div className="meal-builder-app">
      <AppProvider>
        <Router>
          <>
            <ScrollToTop />
            <Stepper />

            <Routes>
              <Route path="/" element={<LandingPage />} />
              <Route path="/build" element={<PersonalizePlan />} />
              <Route path="/register" element={<Register />} />
              <Route path="/address" element={<Address />} />
              <Route path="/pickmeals" element={<PickMeals />} />
              <Route path="/payment" element={<Payment />} />

              <Route path="/complete" element={<Complete />} />
              <Route path="/error" element={<Error />} />

              <Route path="/offer" element={<Offer />} />
            </Routes>
          </>
        </Router>
      </AppProvider>
    </div>
  );
}

export default App;
