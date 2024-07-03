//#region external imports
import { useForm } from "react-hook-form";
import { useNavigate } from "react-router-dom";
//#endregion

//#region internal imports
import { Button, Field, Form, Input } from "../forms";
import { useAppState } from "../state/state";
import { Heading } from "../components/Heading";
import ScrollToTop from "../components/ScrollToTop";
import { useState } from "react";
import { validateSteps } from "../services/PlanService";
//#endregion

const STEP_KEY = "/register";

export const Register = () => {
  const [state, setState] = useAppState();
  const [showLogin, setShowLogin] = useState(false);

  const {
    handleSubmit,
    register,
    formState: { errors },
  } = useForm({ defaultValues: state });

  const navigate = useNavigate();

  // const watchPassword = watch("password");

  const saveData = (data) => {
    const steps = validateSteps({ ...state, ...data });

    if (!steps.find((step) => step.path === STEP_KEY).isComplete) {
      setState({ ...state, steps });
      return;
    }
    setState({ ...state, ...data, steps });
    navigate("/address");
  };

  return (
    <Form className="mw-432-px" onSubmit={handleSubmit(saveData)}>
      <ScrollToTop />

      <fieldset className="">
        <Heading title={showLogin ? "Login" : "Get Started"} />

        <h6 className="text-center pt-5">{showLogin ? "Email" : "Add your email"}</h6>

        <Field label="Email address" error={errors?.email}>
          <Input {...register("email", { required: "Email is required" })} type="email" id="email" placeholder="example@email.com" />
        </Field>

        {/* <h6 className="text-center pt-5">{showLogin ? "Password" : "Create a password"}</h6>

        <Field label="Password" error={errors?.password}>
          <Input {...register("password", { required: "Password is required" })} type="password" id="password" />
        </Field> */}

        {/* <Field label="Confirm password" error={errors?.confirmPassword}>
            <Input
              {...register("confirmPassword", {
                required: "Confirm the password",
                validate: (value) => value === watchPassword || "The passwords do not match",
              })}
              type="password"
              id="password-confirm"
            />
          </Field> */}

        <div className="pt-5">
          <Button>CONTINUE</Button>
        </div>

        <div className="mt-5">
          Existing customer?{" "}
          <a
            className="link-primary"
            href={`https://shopify.com/57455509638/account/pages/e85ad72a-1b9d-4038-8e07-a4d61164ed72/`}
          >
            Manage subscription
          </a>
        </div>
      </fieldset>
    </Form>
  );
};
