import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";

import { useAppState } from "../state/state";
import { MEALS_KEY } from "../constants";
import { Loading } from "./Loading";

const PaymentRedirect = () => {
  const [error, setError] = useState("");
  const [state, setState] = useAppState();
  const navigate = useNavigate();

  async function createCart() {
    try {
      const createCartQuery = `
        mutation {
          cartCreate {
            cart {
              id
              createdAt
              updatedAt
              checkoutUrl
            }
          }
      }`;

      const response = await fetch(`https://${import.meta.env.VITE_SHOPIFY_STORE_DOMAIN}/api/2023-01/graphql.json`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-Shopify-Storefront-Access-Token": import.meta.env.VITE_SHOPIFY_STOREFRONT_PUBLIC_ACCESS_TOKEN,
        },
        body: JSON.stringify({ query: createCartQuery }),
      });
      const data = await response.json();
      console.log(data);

      return data.data.cartCreate.cart;
    } catch (error) {
      console.error("Error creating cart:", error);
    }
  }

  async function updateShippingAddress(cartId, state) {
    const updateShippingAddressQuery = `mutation($checkoutId: ID!, $shippingAddress: MailingAddressInput!) {
      checkoutShippingAddressUpdateV2(checkoutId: $checkoutId, shippingAddress: $shippingAddress) {
        checkout {
          id
          shippingAddress {
            address1
            address2
            city
            country
            firstName
            lastName
            phone
            province
            zip
          }
        }
      }
    }`;

    const variables = {
      cartId: cartId,
      shippingAddress: {
        address1: state["addressLine1"],
        address2: state["addressLine2"],
        city: state["city"],
        country: "US",
        firstName: state["firstName"],
        lastName: state["lastName"],
        phone: state["phone"],
        province: state["state"],
        zip: state["zipCode"],
      },
    };

    const response = await fetch(`https://${import.meta.env.VITE_SHOPIFY_STORE_DOMAIN}/api/2023-01/graphql.json`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-Shopify-Storefront-Access-Token": import.meta.env.VITE_SHOPIFY_STOREFRONT_PUBLIC_ACCESS_TOKEN,
      },
      body: JSON.stringify({ query: updateShippingAddressQuery, variables }),
    });

    const data = await response.json();
    console.log(data);
    // TODO: Add error handling

    return data;
  }

  async function addLineItems(cartId, meals) {
    const addLineItemsMutation = `
      mutation($cartId: ID!, $lines: [CartLineInput!]!) {
        cartLinesAdd(cartId: $cartId, lines: $lines) {
          cart {
            id
            checkoutUrl
            lines(first: 5) {
              edges {
                node {
                  id
                  quantity
                  merchandise {
                    ... on ProductVariant {
                      id
                      title
                      product {
                        title
                      }
                    }
                  }
                }
              }
            }
          }
        }
      }`;

    const lineItemsToAdd = meals.map((meal) => ({
      merchandiseId: meal.variantId,
      sellingPlanId: meal.sellingPlanId,
      quantity: parseInt(meal.count),
    }));

    const cartLinesAddVariables = {
      cartId: cartId,
      lines: lineItemsToAdd,
    };

    const addLineItemsResponse = await fetch(`https://${import.meta.env.VITE_SHOPIFY_STORE_DOMAIN}/api/2023-01/graphql.json`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-Shopify-Storefront-Access-Token": import.meta.env.VITE_SHOPIFY_STOREFRONT_PUBLIC_ACCESS_TOKEN,
      },
      body: JSON.stringify({ query: addLineItemsMutation, variables: cartLinesAddVariables }),
    });

    // if (addLineItemsResponse.ok) {
    //   throw new Error("Error adding line items to cart");
    // }
    // TODO: Add error handling

    return Promise.resolve(addLineItemsResponse.json());
  }

  const buildCheckoutUrl = (url, state) => {
    return `${url}?&checkout[email]=${state["email"]}&checkout[shipping_address][first_name]=${state["firstName"]}&checkout[shipping_address][last_name]=${state["lastName"]}&checkout[shipping_address][address1]=${state["addressLine1"]}&checkout[shipping_address][address2]=${state["addressLine2"]}&checkout[shipping_address][city]=${state["city"]}&checkout[shipping_address][zip]=${state["zipCode"]}&checkout[shipping_address][country]=${state["country"]}&checkout[shipping_address][province]=${state["state"]}`;
  };

  async function redirectToCheckout(state, meals) {
    const cart = await createCart(state, meals);
    await addLineItems(cart.id, meals);

    const checkoutUrl = buildCheckoutUrl(cart.checkoutUrl, state);
    console.debug("Successfully created checkout: ", checkoutUrl);
    const stateJSON = JSON.stringify({ ...state, password: null, confirmPassword: null, redirectedToCheckout: true });
    localStorage.setItem("appState", stateJSON);
    // Redirect to Shopify checkout url with query params pre-filled
    window.location.href = checkoutUrl;
  }

  useEffect(() => {
    const meals = state[MEALS_KEY];

    if (state.redirectedToCheckout) {
      const stateJSON = JSON.stringify({ ...state, redirectedToCheckout: false });
      localStorage.setItem("appState", stateJSON);
      setState({ ...state, redirectedToCheckout: false });
      navigate("/pickmeals");
      return;
    }
    if (meals.length === 0) {
      setError("No meals in cart");
      navigate("/pickmeals");
      return;
    }

    redirectToCheckout(state, meals);
  }, []);

  return (
    <div>
      {
        <p className="d-flex gap-2 align-items-center text-success">
          <Loading /> Redirecting to checkout...
        </p>
      }
      {error && <p style={{ color: "red" }}>{error}</p>}
    </div>
  );
};

export default PaymentRedirect;
