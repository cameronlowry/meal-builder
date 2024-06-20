import { Heading } from "../components/Heading";

export const Error = () => {
  return (
    <div className="py-5" style={{ width: "774px" }}>
      <Heading className="mb-5" title="Error" />

      <h5 className="mb-4">Oops, something went wrong on our end</h5>
      <a href="/build">Start over</a>
    </div>
  );
};
