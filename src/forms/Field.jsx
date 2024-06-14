import PropTypes from "prop-types";

import { getChildId } from "../services/FieldService";

export const Field = ({ children, label, error }) => {
  Field.propTypes = {
    children: PropTypes.node,
    label: PropTypes.string,
    error: PropTypes.object,
  };
  const id = getChildId(children);

  return (
    <div className="col-sm-12 mb-3">
      <label htmlFor={id} className="form-label">
        {label}
      </label>
      {children}
      {error && <small className="error">{error.message}</small>}
    </div>
  );
};
