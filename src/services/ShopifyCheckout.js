import shopifyBuyClient from "./ShopifyClient";

class ShopifyCheckoutService {
  constructor() {
    this.shopifyCheckout = null;
  }

  async createCheckout() {
    if (!this.shopifyCheckout) {
      this.shopifyCheckout = await shopifyBuyClient.checkout.create({
        email: "customer@test.com",
        presentmentCurrencyCode: "USD",
        customAttributes: [
          {
            key: "subscription_type",
            value: "weekly",
          },
        ],
      });
    }
    return this.shopifyCheckout;
  }
}

const shopifyCheckoutService = new ShopifyCheckoutService();

export default shopifyCheckoutService;
