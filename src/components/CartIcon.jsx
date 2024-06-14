import { forwardRef } from "react";
import PropTypes from "prop-types";

export const CartIcon = forwardRef(function CartIcon({ width = "48px", ...props }) {
  return (
    <img {...props} width={width} src="shopping-basket.png" alt="Shopping basket icon" />
  );
});

CartIcon.propTypes = {
    width: PropTypes.string,
};

CartIcon.displayName = "CartIcon";
