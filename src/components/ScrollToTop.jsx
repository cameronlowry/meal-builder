import { useEffect } from "react";

const ScrollToTop = () => {
  useEffect(() => {
    setTimeout(() => {
      window.scrollTo(0, 0);
    });
  });

  return null;
}

export default ScrollToTop;