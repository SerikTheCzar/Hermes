import { useState } from 'react';
import { Formik, Form } from "formik";
import { FormField } from 'components';
import { useHistory } from 'react-router-dom';
import { defaultValues, validationSchema } from './FormikConfig';



export const Signup = () => {
    const history = useHistory();
    const [serverError, setServerError] = useState('');

    const signup = ({ email, userName, password }, { setSubmitting }) =>
        console.log('Signing Up: ', email, userName, password);

    return (
        <div className="auth-form">
            <h1>Signup</h1>
            <Formik
                onSubmit={signup}
                validateOnMount={true}
                initialValues={defaultValues}
                validationSchema={validationSchema}
            >
                {({ isValid, isSubmitting }) => (
                    <Form>
                        <FormField name="userName" label="User Name" />
                        <FormField name="email" label="Email" type="email" />
                        <FormField name="password" label="Password" type="password" />
                        <FormField
                            type="password"
                            name="verifyPassword"
                            label="Verify Password"
                        />
                        <div className="auth-link-container">
                            Already have account? {' '}
                            <span className="auth-link" onClick={() => history.push('login')}>
                                Log In!
                            </span>
                        </div>

                        <button disabled={isSubmitting || !isValid} type="submit" >
                            Sign Up
                        </button>

                    </Form>

                )}
            </Formik>
            {!!serverError && <div className="error">{serverError}</div>}
        </div>
    );
};
