//#region external imports
import { MemoryRouter, BrowserRouter, Routes, Route } from "react-router-dom";
//#endregion

//#region internal imports
import { Address } from "./steps/Address";
import { AppProvider } from "./state/state";
import { Complete } from "./steps/Complete";
import { Payment } from "./steps/Payment";
import { PersonalizePlan } from "./steps/Build";
import { PickMeals } from "./steps/PickMeals";
import { Register } from "./steps/Register";
import { Stepper } from "./steps/Stepper";
import { Error } from "./steps/Error";
import { LandingPage } from "./steps/LandingPage";
import { Offer } from "./forms/Offer";
//#endregion

function App() {
  return (
    <div className="meal-builder-app">
      <AppProvider>
        <BrowserRouter>
          <Stepper />

          <Routes>
            <Route path="/build" element={<PersonalizePlan />} />
            <Route path="/register" element={<Register />} />
            <Route path="/address" element={<Address />} />
            <Route path="/pickmeals" element={<PickMeals />} />
            <Route path="/payment" element={<Payment />} />

            <Route path="/" element={<LandingPage />} />
            <Route path="/complete" element={<Complete />} />
            <Route path="/offer" element={<Offer />} />
            <Route path="/error" element={<Error />} />
          </Routes>
        </BrowserRouter>
      </AppProvider>
    </div>
  );
}

export default App;
