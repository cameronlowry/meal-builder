import { createContext, useContext, useState } from "react";
import { FREQUENCY_KEY, MEALS_KEY, PEOPLE_KEY, PREFERENCES_KEY, SUBSCRIPTION_KEY } from "../constants";
import { readCookie } from "../services/CookieService";

export const AppStateContext = createContext({});

// eslint-disable-next-line react/prop-types
export function AppProvider({ children }) {
  const value = useState({
    // default values
    [PREFERENCES_KEY]: ["meat-vegetable"],
    [FREQUENCY_KEY]: "4",
    [PEOPLE_KEY]: "2",
    [SUBSCRIPTION_KEY]: "aLaCarte",
    [MEALS_KEY]: [],

    // register form
    email: "",
    password: "",
    confirmPassword: "",

    // address form
    firstName: "",
    lastName: "",
    street: "",
    addressLine2: "",
    city: "",
    state: "",
    zipCode: "",
    phoneNumber: "",

    result: {
      status: "error",
      dismissed: false,
    },
    offerDismissed: readCookie("offer_dismissed") === "true",
    offerClosed: false,
  });

  return <AppStateContext.Provider value={value}>{children}</AppStateContext.Provider>;
}

export function useAppState() {
  const context = useContext(AppStateContext);
  if (!context) {
    throw new Error("useAppState must be used within the AppProvider");
  }
  return context;
}
