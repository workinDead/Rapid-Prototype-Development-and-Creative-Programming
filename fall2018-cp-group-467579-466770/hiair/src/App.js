import React, { Component } from 'react';
// import logo from './logo.svg';
import './views/css/App.css'; // 到底是import 哪个css
import axios from 'axios';
import { Route, Link } from 'react-router-dom';
// components
import Home from './components/Home.js';

import CurrentQuery from './views/CurrentQuery';

class App extends Component {
  constructor(){
    super()
    this.state={
      islogin:false,
      username:null
    }
    this.getUser = this.getUser.bind(this)
    this.componentDidMount = this.componentDidMount.bind(this)
    // this. = this.updateUser.bind(this)

  }

  componentDidMount(){
    this.getUser()
  }

  updateUser(user){
    this.setState(user)
  }

  getUser(){
    axios.get('/user/').then(response => {
      console.log('getUser: ')
      console.log(response.data)
      if(response.data.user){
        console.log('getUser: a user is saved in the server session')
        this.setState({
          islogin:true,
          username:response.data.user.username
        })
      }else{
        console.log('getUser:null')
        this.setState({
          islogin:false,
          username:null
        })
      }
    })
  }



  render() {
    return (
      <div className="App">
  
        <Route exact path='/' component = {Home}>
        
        </Route>

 
        <Route path='/search' component={CurrentQuery} />
      </div>
    );
  }
}

export default App;
