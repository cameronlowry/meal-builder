import PropTypes from "prop-types";

export const CheckMark = ({ className, ...props }) => {
  return (
    <span {...props} className={`supr-checkmark ${className}`}>
      <div className="supr-checkmark_stem"></div>
      <div className="supr-checkmark_kick"></div>
    </span>
  );
};

CheckMark.propTypes = {
  className: PropTypes.string,
};

CheckMark.displayName = "CheckMark";
