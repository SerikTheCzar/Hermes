import { Route, Switch } from 'react-router-dom';
import { Login, Signup, Chat } from 'components';



export const App = () => {
    return (
        <div className="app" style={{
            backgroundImage: `url(${process.env.PUBLIC_URL + '/landmarkcollege.jpg'})`,
            backgroundRepeat: 'no-repeat',
            backgroundPosition: 'center',
            backgroundSize: 'cover',
            width: '100vw',
            height: '100vh',


        }} >
            <Switch>
                <Chat exact path='/' component={Chat} />
                <Route path="/login" component={Login} />
                <Route path="/signup" component={Signup} />
            </Switch>
        </div>
    );

};


