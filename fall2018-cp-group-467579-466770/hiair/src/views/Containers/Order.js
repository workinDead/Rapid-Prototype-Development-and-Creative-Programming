import React, { Component } from 'react';
import axios from 'axios'
import { connect } from 'react-redux';

class Order extends Component {
    constructor(props){
      super(props);
      // console.log(this.props.location.state)
      const username = this.props.username

      // const orderHistory = props.actions.getOrderHistory(this.props.username);
      this.state = {
        orderHistory:[],
        username:username,
        // orderHistory:this.props.location.state
      };
      axios.post('/order-history',{
        username:this.state.username
      }).then(res=>{
         this.setState({
         orderHistory:res.data
         })

 
          });

    }

    render(){
      console.log(this.state.orderHistory)
      // console.log(this.state.tripData)
        return(
          // <div></div>
            <div className="container">
                <div className="trip-header"> Manage Your Order</div>

            { // default sort by price
                this.state.orderHistory!==null  &&
                this.state.orderHistory.map((trip, index) => (
                  <div className="row trip" key={index} trip_class={trip.trip_class}>
                  <div className="col">{(trip.duration ? Math.floor(trip.duration/60) + ' h': '-')}</div>
                  <div className="col">
                  <div><span className="material-icons col-sm-1">flight_takeoff</span></div>

                  {
                    trip.return_date && 
                    <div><span className="material-icons col-sm-1">flight_land</span></div>

                  }
                  </div>
                  
                  <div className="col-3">
                    <div>{trip.origin} - {trip.destination} </div>
                    <div>{trip.depart_date} </div>
                    {trip.return_date && <div>{trip.return_date}</div>}
                    
                  </div>
                  <div className="col-3">
                    <div>{trip.gate}</div>
                  </div>
                  <div className="col">
                    <div>{trip.value}</div>
                  </div>
                </div>
                  ) 
                )
            }
            </div>

        );

    }
}
// export default Order;
const mapStateToProps = function(state) {
  const {  logged ,username} = state;
  return {
    ...state,
      logged: logged,
      username:username
  };
  
};

const mapDispatchToProps = function(dispatch) {

};

export default connect(mapStateToProps, mapDispatchToProps)(Order);