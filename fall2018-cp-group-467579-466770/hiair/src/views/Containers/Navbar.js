import React,{Component} from 'react';
import {Redirect} from 'react-router-dom';
import {Route,Link} from 'react-router-dom';
import axios from 'axios'
import { connect } from 'react-redux';
import * as actions from '../../store/actions/index';

import { setLogoutStatus } from '../../store/actions/index';

class Navbar extends Component {
    constructor(props){
        super(props)
         this.state={
            username: this.props.username,
            redirectTo: null
          }
        this.logout = this.logout.bind(this)
        this.handleOrderHistory = this.handleOrderHistory.bind(this)
        
    }
    
    logout(event){
        event.preventDefault();
        console.log('You are logging out');
        axios.post('/logout').then(response => {
            console.log(response.data)
            if(response.status=200){

                this.props.actions.setLogoutStatus();
                console.log(this.props)
            }
        }).catch(error => {
            console.log(error)
        })
    }
    handleOrderHistory(event){
        // event.preventDefault();
        console.log(this.props)
        console.log('YOU ARE LOGGING OUT')
        console.log(this.state.username)
        axios.post('/order-history',{
            username:this.state.username
          }).then(res=>{
            console.log(this.state.username)
            this.setState({
                redirectTo:'/order'
            });});
        //     if(this.state.username){
        //     return <Redirect to="/order"></Redirect>
        //     //   this.props.history.push({
        //     //     pathname:'/order',
        //     //     state:res.data,
        //     //   })
        //       }else{
        //         // this.props.history.push({
        //         //   pathname:'/',
        //         // })
        //       }
        //   })
    }

  render(){
      const islogin = this.props.islogin;
      const username = this.props.username;
      if (this.state.redirectTo) {
        return <Redirect to={{ pathname: this.state.redirectTo }} />
    } else {
      return(
        <header className="masthead mb-auto">
          <div className="inner">
            <nav className="nav nav-masthead row">
            
            <section className="navbar-section col">

            <Link className="nav-link active" to="/">
            Flights
            </Link>
            </section>
            {islogin ? 
                (<section className="navbar-section col">
                <span className="nav-link" >{username}</span>
                <Link to="#" className="nav-link" onClick={this.handleOrderHistory}>order</Link>
                <Link to="#" className="nav-link" onClick={this.logout}>
                logout
                </Link>
                </section>)
                : 
                (<section className="navbar-section col">
                <Link to="/signup" className="nav-link" >
                signup
                </Link>
                <Link to="/login" className="nav-link" >
                login
                </Link>

                </section>)
                }

            </nav>
          </div>
       </header>
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
        setLogoutStatus: function(){
            dispatch(setLogoutStatus());
        }
    }
    return {
        actions: dispatchActions,
      };
  };
  
  export default connect(mapStateToProps, mapDispatchToProps)(Navbar);