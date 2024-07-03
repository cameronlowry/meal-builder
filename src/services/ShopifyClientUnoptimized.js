// fetch the large, unoptimized version of the SDK
import Client from 'shopify-buy/index.unoptimized.umd';

const unoptimizedClient = Client.buildClient({
  domain: import.meta.env.VITE_SHOPIFY_STORE_DOMAIN,
  storefrontAccessToken: import.meta.env.VITE_SHOPIFY_STOREFRONT,
});

export default unoptimizedClient;
