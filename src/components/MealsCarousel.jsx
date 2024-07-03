//#region external imports
import { useEffect, useState } from "react";
import { useMediaQuery } from "react-responsive";
import Carousel from "react-bootstrap/Carousel";

//#endregion

//#region data imports
import { chunkArray } from "../services/ArrayService";
import { mapProductToMeal } from "../services/PlanService";
// import shopifyBuyClient from "../services/ShopifyClient";
import { Loading } from "./Loading";
// import client from "../services/ShopifyClient";
//#endregion

export const MealsCarousel = () => {
  const [index, setIndex] = useState(0);
  const [products, setProducts] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  // Fetch products when the component mounts
  useEffect(() => {
    const query = `
    {
      products(first: 10) {
        edges {
          node {
            id
            title
            description
            variants(first: 1) {
              edges {
                node {
                  id
                  price {
                    amount
                    currencyCode
                  }
                }
              }
            }
            images(first: 1) {
              edges {
                node {
                  src
                }
              }
            }
            sellingPlanGroups(first: 5) {
              edges {
                node {
                  name
                  options {
                    name
                    values
                  }
                  sellingPlans(first: 5) {
                    edges {
                      node {
                        id
                        name
                        description
                        options {
                          name
                          value
                        }
                        priceAdjustments {
                          adjustmentValue {
                            ... on SellingPlanPercentagePriceAdjustment {
                              adjustmentPercentage
                            }
                            ... on SellingPlanFixedAmountPriceAdjustment {
                              adjustmentAmount {
                                amount
                                currencyCode
                              }
                            }
                            ... on SellingPlanFixedPriceAdjustment {
                              price {
                                amount
                                currencyCode
                              }
                            }
                          }
                        }
                      }
                    }
                  }
                }
              }
            }
          }
        }
      }
    }`;

    fetch(`https://${import.meta.env.VITE_SHOPIFY_STORE_DOMAIN}/api/2023-01/graphql.json`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-Shopify-Storefront-Access-Token": import.meta.env.VITE_SHOPIFY_STOREFRONT_PUBLIC_ACCESS_TOKEN,
      },
      body: JSON.stringify({ query }),
    })
      .then((response) => response.json())
      .then((data) => {
        console.log(data);
        setProducts(data.data.products.edges.map((edge) => edge.node));
        setLoading(false);
      })
      .catch((err) => {
        setError(err);
        setLoading(false);
      });
  }, []);

  const isMobile = useMediaQuery({ query: `(max-width: 768px)` });
  const isMedium = useMediaQuery({ query: `(max-width: 996px)` });

  const meals = products.map(mapProductToMeal);
  const chunk_size = isMobile ? 1 : isMedium ? 3 : 6;
  const chunks = chunkArray(meals, chunk_size);

  const handleSelect = (selectedIndex) => {
    setIndex(selectedIndex);
  };

  return loading ? (
    <div className="text-center">
      <div className="text-primary" role="status">
        <Loading />
      </div>
    </div>
  ) : error ? (
    <div className="alert alert-danger" role="alert">
      {error.message}
    </div>
  ) : (
    <Carousel className="supr-meal-carousel" indicators={false} controls={true} activeIndex={index} onSelect={handleSelect}>
      {chunks.map((chunk, index) => (
        <Carousel.Item key={`meal_${index}`}>
          <div className="row row-cols-1 row-cols-sm-1 row-cols-md-3 row-cols-lg-6">
            {chunk.map((meal) => (
              <div key={meal.id} className="col mb-4 position-relative d-flex justify-content-center">
                {mealCard(meal)}
              </div>
            ))}
          </div>
        </Carousel.Item>
      ))}
    </Carousel>
  );
};

const mealCard = (meal) => (
  <div className="h-100 px-0 border rounded-3 bg-white position-relative overflow-hidden">
    <div className="d-flex flex-column justify-content-between h-100">
      <div className="mb-2">
        <img className="img-fluid w-100" src={meal.image} alt={meal.title} />
      </div>

      <div className="p-3 d-flex flex-column justify-content-between h-100">
        <h6 className="fw-bold mb-2" htmlFor={meal.id}>
          {meal.title}
        </h6>

        <div className="mb-2">
          <span className="badge text-bg-info">{meal.category}</span>
        </div>
      </div>
    </div>
  </div>
);
