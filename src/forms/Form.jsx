import PropTypes from "prop-types";

export const Form = ({ children, className, ...props }) => {
  return (
    <form {...props} noValidate className={`container py-5 ${className}`}>
      {children}
    </form>
  );
};

Form.propTypes = {
  children: PropTypes.node,
  className: PropTypes.string,
};

Form.displayName = "Form";