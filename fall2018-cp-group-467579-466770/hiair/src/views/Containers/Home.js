
import DatePicker from "react-datepicker";
import { BrowserRouter as Router, Route } from 'react-router-dom' 

import "react-datepicker/dist/react-datepicker.css";

import Navbar from '../Containers/Navbar';
import React from 'react';
import { connect } from 'react-redux';
import { setFlightTextInput,
  setDefaultInput } from '../../store/actions/index';


export class Home extends React.Component {

  constructor(props) {
    super(props);

    this.state = {
      origin:'',
      destination:'',
      tripType:false,
      begin_of_period:new Date(),
      end_of_period:new Date(),
      loggedIn: false,
      username: null
   };

    this.handleChange = this.handleChange.bind(this);
    this.handleBegin = this.handleBegin.bind(this);
    this.handleEnd = this.handleEnd.bind(this);
    this.handleOneway = this.handleOneway.bind(this);
    this.handleRoundway = this.handleRoundway.bind(this);
    this.handleSubmit = this.handleSubmit.bind(this);

    this.props.actions.setDefaultInput();
  
    }

  handleChange(event) {
    this.setState({
        [event.target.name]: event.target.value.trim()
    })
  }

  handleBegin(date){
      this.setState({
          begin_of_period:date
      })
  }
  handleEnd(date){
      this.setState({
          end_of_period:date
      })
  }
  handleOneway(){
    this.setState({
      tripType:false
    });
  }
  handleRoundway(){
    this.setState({
      tripType:true
    });
  }

  handleSubmit = (event) => {
    this.props.actions.setFlightTextInput({ flightData: 
      {
        origin:this.state.origin,
        destination:this.state.destination,
        month:this.state.begin_of_period,
        tripType:this.state.tripType,
        end_of_period:this.state.end_of_period

      }
     });
  }

  componentDidUpdate = (prevProps) => {
    const { flightData } = this.props;
        if (prevProps.flightData !== flightData) {
      this.props.history.push({
        pathname: '/current-flight',
        state: {
            flightData: flightData,
        },
      });
    }
  }


  render() {
    return (
        <div>
       <Navbar islogin={this.props.logged}/>         

        <div className="flight-search">
        <h1>
                Great travel deals.
        </h1>
        <div className="triptype-select">
                <button className="btn btn-outline-light active-triptype"   name="oneway-btn"  onClick={this.handleOneway}>One Way</button>
                <button className="btn btn-outline-light" name="roundtrip-btn"onClick={this.handleRoundway}>Round Trip</button>

        </div>
        <form className="form-inline" method='' action=''>
                <div className="search-content">
                    <div className="search-wrapper"><input type="text" className="form-control" id="origin" name="origin" value={this.state.origin} onChange={this.handleChange} /></div>
                    <div className="search-wrapper"><input type="text" className="form-control" id="destination" name="destination" value={this.state.destination}  onChange={this.handleChange}  /></div>
                    <DatePicker className="form-control" id="begin_of_period" name="begin_of_period" selected={this.state.begin_of_period} onChange={this.handleBegin}  />
                    {this.state.tripType&&
                    <DatePicker className="form-control" id="end_of_period" name="end_of_period" selected={this.state.end_of_period} onChange={this.handleEnd}  /> 
                     }
                    <button type="submit" className="btn btn-primary" onClick={this.handleSubmit} >
                    Search Flights
                    </button>
                </div>
        </form>

        
        </div>
        </div>
    );
  }
};

const mapStateToProps = function(state) {
  const flightData = state && state.flightData;
  const logged = state && state.logged;
  console.log(logged)

  return {
    ...state,
    flightData: flightData,
    loginStatus:logged

  };
};

const mapDispatchToProps = function(dispatch) {
  const dispatchActions = {
  
    setFlightTextInput: function(flightTextConfig) {
      dispatch(setFlightTextInput(flightTextConfig));
    },
    setDefaultInput: function() {
      dispatch(setDefaultInput());
    },
    // getLoginData: function(){
    //   dispatch(getLoginData());
    // }
  };

  return {
    actions: dispatchActions,
  };
};

export default connect(mapStateToProps, mapDispatchToProps)(Home);


