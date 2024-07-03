import Spinner from "react-bootstrap/Spinner";
import PropTypes from "prop-types";

export const Loading = ({ animation = "border" }) => {
  return <Spinner {...animation} role="status" />;
}

Loading.propTypes = {
  animation: PropTypes.string,
};

Loading.displayName = "Loading";
