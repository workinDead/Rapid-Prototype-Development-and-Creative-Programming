import React, { Component } from 'react'
import { Redirect } from 'react-router-dom'
import axios from 'axios'
import { connect } from 'react-redux';
// import * as actions from '../../store/actions/index';
import { getLoginData } from '../../store/actions/index';
class LoginForm extends Component {
    constructor(props) {
        super(props)
        this.state={
            username: '',
            password: '',
            redirectTo: null
          }
          this.handleSubmit = this.handleSubmit.bind(this)
          this.handleChange = this.handleChange.bind(this)
    }

    handleChange(event) {
        
        this.setState({
            [event.target.name]: event.target.value
        })
    }

    handleSubmit(event) {
        event.preventDefault()
        console.log('handleSubmit')
        axios
            .post('/login', {
                username: this.state.username,
                password: this.state.password
            })
            .then(response => {
                console.log('LoginForm response: ')
                console.log(response)
                if (response.status === 200) {
                    console.log(response.data.username);
                    this.props.actions.getLoginData({
                        username:response.data.username
                    });
                  
                    // update the state to redirect to home
                    this.setState({
                        redirectTo: '/'
                    })
                }
            }).catch(error => {
                console.log('login error: ')
                console.log(error);
                
            })
    }

    render() {
        if (this.state.redirectTo) {
            return <Redirect to={{ pathname: this.state.redirectTo }} />
        } else {
            return (
                <div class="flight-search">
                    
                <div className="card custom-card">
                <div className="card-header">
                    <div>
                        <h3> Log in </h3>
                        <div className="card-body">
                       
                            <form className="form-horizontal">


                                <div class="input-group form-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="material-icons">account_box</i></span>
                                    </div>
                                    <input type="text" className="form-control" placeholder="Username" id="username" name="username" value={this.state.username} onChange={this.handleChange}  required autoFocus/>
                                    
                                </div>
                            <div class="input-group form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="material-icons">vpn_key</i></span>
                                </div>
                                <input type="password" className="form-control" placeholder="Password" id="password" name="password" value={this.state.password} onChange={this.handleChange} required/>
                                
                            </div>
                            <div class="form-group">
                                <button className="btn btn-primary btn-block" onClick={this.handleSubmit} type="submit">Log in</button>
					        </div>
                        
                            </form>
                        </div>
                    </div>
                 </div>
             </div>
                </div>
            )
        }
    }
}
const mapStateToProps = function(state) {
    const {  logged ,username} = state;
    return {
      ...state,
        logged: logged,
        username:username
    };
    
  };
  
  const mapDispatchToProps = function(dispatch) {
    const dispatchActions = {
        getLoginData: function(loginData){
            dispatch(getLoginData(loginData));
        }
    }

    return {
        actions: dispatchActions,
      };
  };
  
  export default connect(mapStateToProps, mapDispatchToProps)(LoginForm);
