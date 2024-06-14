import { forwardRef } from "react";

export const Input = forwardRef(function InputComponent(props, ref) {
  return <input ref={ref} className="form-control" {...props} />;
});
