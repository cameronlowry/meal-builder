import { forwardRef } from "react";
import PropTypes from "prop-types";

export const Heading = forwardRef(function Heading({ title = "No title provided", justify = "justify-content-center", showHr = true, className, ...props }) {
  return (
    <div {...props} className={`d-grid ${justify} ${className}`}>
      <h4 className="oswald-font text-uppercase">{title}</h4>
      {showHr && <hr className="supr-hr mx-auto" />}
    </div>
  );
});

Heading.propTypes = {
  justify: PropTypes.string,
  showHr: PropTypes.bool,
  title: PropTypes.string,
  className: PropTypes.string,
};

Heading.displayName = "Heading";
