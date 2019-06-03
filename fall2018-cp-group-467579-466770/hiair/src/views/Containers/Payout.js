import React, { Component } from 'react';
import DatePicker from "react-datepicker";
import { Redirect } from 'react-router-dom'
import "react-datepicker/dist/react-datepicker.css";
import StripeCheckout from 'react-stripe-checkout';
import axios from 'axios'
import STRIPE_PUBLISHABLE from '../../constants/stripe';
import PAYMENT_SERVER_URL from '../../constants/server';
import { connect } from 'react-redux';
import Navbar from '../Containers/Navbar';

const CURRENCY = 'USD';

const fromUSDToCent = amount => amount * 100;

const successPayment = data => {
  console.log(data);

};

const errorPayment = data => {
  console.log(data);
};

class Payout extends Component {
  constructor(props){
    super(props);
    const ticketPrice = this.props.location.state.ticketData.value;
    const totalPrice = (82 + ticketPrice).toFixed(2);
    const ticketData = this.props.location.state.ticketData;
    ticketData['username'] = this.props.location.state.username
    const username = this.props.location.state.username
    this.state = {
      givenname: "",
      surname: "",
      birth_date: new Date(),
      genders:"",
      phone:"",
      email:"",
      checkbaggage:false,
      bookindex:-1,
      ticketPrice:ticketPrice,
      baggageFee:72,
      serviceFee:10,
      totalPrice:totalPrice,
      ticketData:ticketData,
      bookStatus:"",
      username:username,
      loggedIn: false,
    };
    

    this.handleBirthdate = this.handleBirthdate.bind(this);
    this.handlecheckbaggage = this.handlecheckbaggage.bind(this);

  }

  
  handlecheckbaggage(){
    this.setState({
      checkbaggage:true
    })
  }

  handleBirthdate(date){
    this.setState({
        birth_date:date
    })
  }

  handleSubmit(event) {
    event.preventDefault();
  }

  render() {
    const onToken = (amount, description) => token =>
    axios.post(PAYMENT_SERVER_URL,
      {
        // description:description,
        source: token.id,
        currency: CURRENCY,
        amount: fromUSDToCent(amount)
      })
      .then(successPayment=>{
        this.setState({
          bookStatus:successPayment.status
        })
      })
      .catch(errorPayment);
      if(this.state.bookStatus===200){
        axios.post('/order-history',{
          username:this.state.username
        }).then(res=>{
          console.log(this.state.username)
          if(this.state.username){
            this.props.history.push({
              pathname:'/order',
              state:res.data,
            })
            }else{
              this.props.history.push({
                pathname:'/',
              })
            }
        })
      
    }
    const Checkout = ({ name, description, amount }) =>
    <StripeCheckout
      name={name}
      description={description}
      amount={fromUSDToCent(amount)}
      token={onToken(amount, description)}
      currency={CURRENCY}
      stripeKey={STRIPE_PUBLISHABLE}
    >
    <button className="btn btn-primary">Pay With Card</button>
    </StripeCheckout>
    return (
      <div>
      {/* <Navbar islogin={this.props.logged}/>          */}

        <div className="container">
          <div className="row">

            <div className="col-md-12 order-md-1">
              <h4 className="text mb-3">Traveler Information</h4>
              <form className="information">
                <div className="row">
                  <div className="col-md-4 mb-3">
                    <label>Given names</label>
                    <input type="text" className="form-control" value={this.state.givenname} onChange={e=>{this.setState({givenname:e.target.value})}} />
                  </div>
                  <div className="col-md-4 mb-3">
                    <label>Surname(s)</label>
                    <input type="text" className="form-control" value={this.state.surname} onChange={e=>{this.setState({surname:e.target.value})}} />
                  </div>
                </div>
              <div className="row">
                <div className="col-md-4 mb-3">
                  <label>
                    Date of Birth
                    <DatePicker
                      className="form-control"
                      selected={this.state.birth_date}
                      onChange={this.handleBirthdate}
                    />
                  </label>
                </div>
                <div className="col-md-4 mb-3">
                  <label>
                    Gender
                    <select className="form-control" value={this.state.genders} onChange={e=>{this.setState({genders:e.target.value})}}>
                    <option value="" disabled>Select</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    </select>
                  </label>
                </div>
              </div>
              <div className="row">
                <div className="col-md-4 mb-3">
                  <label>Phone Number
                  <input type="text" className="form-control" value={this.state.phone} onChange={e=>{this.setState({phone:e.target.value})}} />
                  </label>
                </div>
                <div className="col-md-4 mb-3">
                  <label>Email Address
                  <input type="text" className="form-control" value={this.state.email} onChange={e=>{this.setState({email:e.target.value})}} />
                  </label>
                </div>
              </div>
            </form>
          </div>

            <div className="col-md-12 order-md-1">
            <h4 className="text mb-3">Flight Preference</h4>
              <div className="card">
                <div className="card-body">
                  <h5 className="card-title">Personal item</h5>
                  <h5 className="float-right">FREE</h5>
                  <p className="card-text">43 x 22 x 25 cm, 5kg</p>
                  {this.state.checkbaggage&&
                  <div>
                    <h5 className="card-title float-lg-left">Checked Baggage</h5>
                    <h5 className="float-right">$72</h5>
                    <p className="card-text">78 x 26 x 52 cm, 23kg</p>
                  </div>
                  }
                </div>
              </div>
              {!this.state.checkbaggage&&
              <button type="button" className="btn btn-light btn-lg btn-block" onClick={this.handlecheckbaggage}>
                  <h5 className="card-title float-lg-left">Add Checked Baggage</h5>
                  <h5 className="float-right">$72</h5>
                  <p className="card-text">78 x 26 x 52 cm, 23kg</p>
              </button>
              }
          </div>

            <div className="col-md-12 order-md-1">
                <h4 className="text mb-3">Payment Information</h4>
                <ul>
                    <li className="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 className="customer my-0">1 Person</h6>
                        </div>
                        <span className="text" value={this.state.ticketPrice}>{this.state.ticketPrice}</span>
                    </li>
                    {this.state.checkbaggage&&
                    <li className="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 className="customer my-0">1 Checked baggage</h6>
                            </div>
                            <span className="text" value={this.state.baggageFee} >$72</span>
                    </li>
                    }
                    <li className="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 className="customer my-0"  >Service Fee</h6>
                            </div>
                            <span className="text" value={this.state.serviceFee}>$10</span>
                    </li>

                    <li className="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 className="customer my-0">Trip Total:</h6>
                            </div>
                            <span className="text" value={this.state.totalPrice}>{this.state.totalPrice}</span>
                    </li>
                </ul>
                    
               <div className="text-center"><Checkout description={this.state.ticketData} amount={this.state.totalPrice}/></div>
            </div>
            <div className="col-md-12 order-md-1">
            <h4 className="text mb-3">Overview</h4>
            <form>
              <div className="row">
                <div className="col-md-4 mb-3">
                  <label>Given names</label>
                  <input type="text" className="form-control" value={this.state.givenname} disabled/>
                </div>
                <div className="col-md-4 mb-3">
                  <label>Surname(s)</label>
                  <input type="text" className="form-control" value={this.state.surname} disabled/>
                </div>
              </div>
              <div className="row">
                <div className="col-md-4 mb-3">
                  <label>
                    Date of Birth
                    <DatePicker
                      className="form-control"
                      selected={this.state.birth_date}
                    disabled
                    />
                  </label>
                </div>
                <div className="col-md-4 mb-3">
                  <label>
                    Gender
                    <input type="text" className="form-control" value={this.state.genders} disabled/>
                  </label>
                </div>
              </div>
              <div className="row">
                <div className="col-md-4 mb-3">
                  <label>Phone Number
                  <input type="text" className="form-control" value={this.state.phone} disabled/>
                  </label>
                </div>
                <div className="col-md-4 mb-3">
                  <label>Email Address
                  <input type="text" className="form-control" value={this.state.email} disabled/>
                  </label>
                </div>
              </div>
            </form>
          </div>

        </div>
      </div>
      </div>
    );
  }
}

const mapStateToProps = function(state) {
  const flightData = state && state.flightData;
  const logged = state && state.logged;
  const username = state && state.username;
  return {
    ...state,
    flightData: flightData,
    loginStatus:logged,
    username:username

  };
};

const mapDispatchToProps = function(dispatch) {

};

export default connect(mapStateToProps, mapDispatchToProps)(Payout);

