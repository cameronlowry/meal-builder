import { forwardRef } from "react";
import PropTypes from "prop-types";

//#region image imports
import basketImage from "/shopping-basket.png";
//#endregion

export const CartIcon = forwardRef(function CartIcon({ width = "48px", ...props }) {
  return (
    <img {...props} width={width} src={basketImage} alt="Shopping basket icon" />
  );
});

CartIcon.propTypes = {
    width: PropTypes.string,
};

CartIcon.displayName = "CartIcon";
