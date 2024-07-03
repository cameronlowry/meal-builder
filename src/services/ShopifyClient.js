// import Client from "shopify-buy";

// // Initialize the Shopify Buy client
// const shopifyBuyClient = Client.buildClient({
//   domain: import.meta.env.VITE_SHOPIFY_STORE_DOMAIN,
//   storefrontAccessToken: import.meta.env.VITE_SHOPIFY_STOREFRONT,
// });

// export default shopifyBuyClient;


import {createStorefrontApiClient} from '@shopify/storefront-api-client';

const client = createStorefrontApiClient({
  storeDomain: import.meta.env.VITE_SHOPIFY_STORE_DOMAIN,
  apiVersion: '2024-04',
  publicAccessToken: import.meta.env.VITE_SHOPIFY_STOREFRONT_PUBLIC,
});

export default client
