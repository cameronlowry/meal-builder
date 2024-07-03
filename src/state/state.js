import { createContext, useContext, useState } from "react";
import { DATE_KEY, DAY_KEY, FREQUENCY_KEY, MEALS_KEY, PEOPLE_KEY, PREFERENCES_KEY, SUBSCRIPTION_KEY } from "../constants";
import { readCookie } from "../services/CookieService";

export const AppStateContext = createContext({});

// eslint-disable-next-line react/prop-types
export function AppProvider({ children }) {
  let retrievedStateJSON;
  try {
    retrievedStateJSON = JSON.parse(localStorage.getItem("appState"));
  } catch (error) {
    console.error("Error parsing JSON from localStorage");
  }

  const value = useState(
    retrievedStateJSON || {
      // default values
      [PREFERENCES_KEY]: ["meat-vegetable"],
      [FREQUENCY_KEY]: "4",
      [PEOPLE_KEY]: "2",
      [SUBSCRIPTION_KEY]: "weekly",
      [DAY_KEY]: null,
      [DATE_KEY]: null,
      [MEALS_KEY]: [],
      steps: [
        { order: 1, path: "/build", isComplete: false },
        { order: 2, path: "/register", isComplete: false },
        { order: 3, path: "/address", isComplete: false },
        { order: 4, path: "/pickmeals", isComplete: false },
        { order: 5, path: "/payment", isComplete: false },
      ],

      // register form
      email: "",
      password: "",
      confirmPassword: "",

      // address form
      firstName: "",
      lastName: "",
      addressLine1: "",
      addressLine2: "",
      city: "",
      state: "",
      zipCode: "",
      phoneNumber: "",

      result: {
        status: "success",
        dismissed: false,
      },
      offerDismissed: readCookie("offer_dismissed") === "true",
      offerClosed: false,
    }
  );

  return <AppStateContext.Provider value={value}>{children}</AppStateContext.Provider>;
}

export function useAppState() {
  const context = useContext(AppStateContext);
  if (!context) {
    throw new Error("useAppState must be used within the AppProvider");
  }
  return context;
}
