import { DATE_KEY, DAY_KEY } from "../constants";

export const mapKeyToDisplayName = (data, key) => {
  return data.find((x) => x.id === key)?.title;
};

export const mapProductToMeal = (product) => ({
  id: product.id,
  variantId: product.variants?.edges?.length > 0 ? product.variants.edges[0].node.id : null,
  sellingPlanId:
    product.sellingPlanGroups.edges?.length > 0 && product.sellingPlanGroups.edges[0].node.sellingPlans.edges?.length > 0
      ? product.sellingPlanGroups.edges[0].node.sellingPlans.edges[0].node.id
      : null,
  title: product.title,
  description: product.description,
  category: product.productType,
  price: product.variants?.edges?.length > 0 ? product.variants?.edges[0].node.price : 0,
  image: product.images?.edges?.length > 0 ? product.images.edges[0].node.src : "",
  value: product.id,
});

export const isFieldComplete = (field) => {
  return field !== null && field !== undefined && field !== "";
}

export const validateStep = (step, state) => {
  switch (step) {
    case "/build":
      return state.preferences.length > 0 && isFieldComplete(state.frequency) && isFieldComplete(state.people) && isFieldComplete(state.subscription);
    case "/register":
      return isFieldComplete(state.email);
    case "/address":
      return (
        isFieldComplete(state.firstName) &&
        isFieldComplete(state.lastName) &&
        isFieldComplete(state.addressLine1) &&
        isFieldComplete(state.city) &&
        isFieldComplete(state.state) &&
        isFieldComplete(state.zipCode) &&
        isFieldComplete(state.phoneNumber) &&
        isFieldComplete(state[DAY_KEY]) &&
        isFieldComplete(state[DATE_KEY])
      );
    case "/pickmeals":
      return state.meals.length > 0;
    case "/payment":
    default:
      return false;
  }
};
export const validateSteps = (state) => {
  if (!state.steps) return [];
  return state.steps.map((step) => ({ ...step, isComplete: validateStep(step.path, state) }));
};
