async function createDiscountCode() {
  const query = `
    mutation discountCodeBasicCreate($basicCodeDiscount: DiscountCodeBasicInput!) {
      discountCodeBasicCreate(basicCodeDiscount: $basicCodeDiscount) {
        codeDiscountNode {
          codeDiscount {
            ... on DiscountCodeBasic {
              codes(first: 1) {
                edges {
                  node {
                    code
                  }
                }
              }
            }
          }
        }
        userErrors {
          field
          message
        }
      }
    }
  `;

  const variables = {
    basicCodeDiscount: {
      title: "One-time 10% off",
      code: generateSecureRandomCode(),
      startsAt: new Date().toISOString(),
      customerSelection: {
        all: true,
      },
      customerGets: {
        value: {
          percentageValue: 10,
        },
        items: {
          all: true,
        },
      },
      appliesOncePerCustomer: true,
      usageLimit: 1,
    },
  };

  try {
    const response = await fetch(`https://${import.meta.env.VITE_SHOPIFY_STORE_DOMAIN}/admin/api/2024-04/graphql.json`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-Shopify-Access-Token": import.meta.env.VITE_SHOPIFY_STOREFRONT_PUBLIC_ACCESS_TOKEN,
      },
      body: JSON.stringify({ query, variables }),
    });

    const responseJson = await response.json();

    if (responseJson.data.discountCodeBasicCreate.userErrors.length > 0) {
      console.error("Error creating discount code:", responseJson.data.discountCodeBasicCreate.userErrors);
    } else {
      const discountCode = responseJson.data.discountCodeBasicCreate.codeDiscountNode.codeDiscount.codes.edges[0].node.code;
      console.debug("Created discount code:", discountCode);

      return Promise.resolve(discountCode);
    }
  } catch (error) {
    console.error("Error:", error);
  }
}

function getRandomBytes(size) {
  const array = new Uint8Array(size);
  for (let i = 0; i < size; i++) {
    array[i] = Math.floor(Math.random() * 256);
  }
  return array;
}

function generateSecureRandomCode(length = 8) {
  const characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
  const randomBytes = getRandomBytes(length);
  let code = "";

  for (let i = 0; i < length; i++) {
    const randomIndex = randomBytes[i] % characters.length;
    code += characters.charAt(randomIndex);
  }

  return code;
}

export default createDiscountCode;
