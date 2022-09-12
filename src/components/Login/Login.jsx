import { useState } from 'react';
import { Formik, Form } from 'formik';
import { FormField } from 'components';
import { useHistory } from 'react-router-dom';
import { defaultValues, validationSchema } from './FormikConfig';


export const Login = () => {
    const history = useHistory();
    const [serverError, setServerError] = useState('');

    const login = ({ email, password }, { setSubmitting }) =>
        console.log('Logging In: ', email, password);



    return (
        <div className="auth-form" style={{ backgroundColor: "white" }}>

            <h1 style={{ color: "blue" }}>Login</h1>
            <Formik
                onSubmit={login}
                validateOnMount={true}
                initialValues={defaultValues}
                validationSchema={validationSchema}
            >
                {({ isValid, isSubmitting }) => (
                    <Form style={{ color: "blue" }}>
                        <FormField name="email" label="Email" type="email" />
                        <FormField name="password" label="Password" type="password" />

                        <div className="auth-link-container">
                            Don't have an account? {' '}
                            <span
                                className="auth-link"
                                onClick={() => history.push('signup')}
                            >
                                Sign Up!
                            </span>
                        </div>
                        <button type="submit" disabled={!isValid || isSubmitting}>
                            Login
                        </button>

                    </Form>
                )}
            </Formik>
            {!!serverError && <div className="error">{serverError}</div>}
        </div>

    );

};
