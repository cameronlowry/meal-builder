import { forwardRef } from "react";
import PropTypes from "prop-types";

export const Button = forwardRef(
  function Button({ children, variant = "primary", ...props }) {
    return (
      <button className={`btn btn-${variant} w-100`} {...props}>
        {children}
      </button>
    );
  }
);

Button.propTypes = {
  children: PropTypes.node,
  variant: PropTypes.string
};

Button.displayName = "Button";
