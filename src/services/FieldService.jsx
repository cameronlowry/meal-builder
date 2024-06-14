import React from "react";

// Get id prop from a child element
export const getChildId = (children) => {
  const child = React.Children.only(children);

  if (child && "id" in child.props) {
    return child.props.id;
  }
};

export const getFieldValue = (key, data) => {
  return data[key];
}
