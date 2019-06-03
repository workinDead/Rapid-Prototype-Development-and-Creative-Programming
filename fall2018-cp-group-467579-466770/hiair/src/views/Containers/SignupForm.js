import React, {Component} from 'react'
import { Redirect } from 'react-router-dom'
import { InputError } from './InputError';

import axios from 'axios' // make http requests from node.js, automatic transforms for JSON data and client side support for protecting against XSRF

class SignupForm extends Component{
    
    constructor(){
        super()
        this.state = {
            username:'',
            password:'',
            confirmPassword:'',
            redirectTo: null,
            inputError: {username: '', password: ''},
            usernameValid: false,
            passwordValid: false,
            formValid: false
        }
        this.handleChange = this.handleChange.bind(this)
        this.handleSubmit = this.handleSubmit.bind(this)
    }
/////////////////////
handleChange (event) {
    const name = event.target.name;
    const value = event.target.value;
    this.setState({[name]: value}, 
                () => { this.verifyField(name, value) });
}

verifyField(input, value) {
let inputfield = this.state.inputError;
let usernameValid = this.state.usernameValid;
let passwordValid = this.state.passwordValid;

switch(input) {
  case 'username':
    usernameValid = value.match(/^([\w.%+-]+)@([\w-]+\.)+([\w]{2,})$/i);
    inputfield.username = usernameValid ? '' : ' should enter an email address';
    break;
  case 'password':
    passwordValid = value.length >= 7;
    inputfield.password = passwordValid ? '': ' should be longer';
    break;
  default:
    break;
}
this.setState({inputError: inputfield,
                usernameValid: usernameValid,
                passwordValid: passwordValid
              }, this.verifyInput);
}

verifyInput() {
this.setState({formValid: this.state.usernameValid && this.state.passwordValid});
}

///////////////////////


    handleSubmit(event){
        console.log('SignupForm handlSubmit, username: ')
        console.log(this.state.username)
        event.preventDefault()


        // add a new username/password
        axios.post('/signup',{
            username:this.state.username,
            password:this.state.password
        }).then(
            response => {
                console.log(response)
                if(!response.data.errmsg){
                    console.log('You have signed up successfully')
                    this.setState({ 
                        redirectTo:'/login'
                    })
                }else{
                }
            }
        ).catch(error => {
      
        })
    }

    render(){
        if (this.state.redirectTo) {
            return <Redirect to={{ pathname: this.state.redirectTo }} />
        } else {
            return(
                <div className="flight-search">
                    <div className="card custom-card">
                        <div className="card-header">
                        <div>
                            <h3> Sign in to hiAir</h3>
                            <div className="card-body">
                                {/* <span className="glyphicon glyphicon-user">
                                </span> */}
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
                                        <button className="btn btn-lg btn-primary btn-block" onClick={this.handleSubmit} type="submit">Sign in</button>
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
export default SignupForm