// CurrentFlight.js
import 'rc-slider/assets/index.css';
import 'rc-tooltip/assets/bootstrap.css';
import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { connect } from 'react-redux';
import {ToggleButton,ToggleButtonGroup} from 'react-bootstrap'
// import { flightIcon } from '../../utils';
import * as actions from '../../store/actions/index';
import { Loader, FlightCardError } from '../Components/index';
import Slider from 'rc-slider';
import Tooltip from 'rc-tooltip';

// input range slider
const createSliderWithTooltip = Slider.createSliderWithTooltip;
const Range = createSliderWithTooltip(Slider.Range);

// const Handle = Slider.Handle;

// const handle = (props) => {
//   const { value, dragging, index, ...restProps } = props;
//   return (
//     <Tooltip
//       prefixCls="rc-slider-tooltip"
//       overlay={value}
//       visible={dragging}
//       placement="top"
//       key={index}
//     >
//       <Handle value={value} {...restProps} />
//     </Tooltip>
//   );
// };

class CurrentFlight extends Component {
  constructor(props) {
    super(props);
    // console.log(tion.state);
    props.actions.getFlightData({ flightSearchData: this.props.location.state});
    // console.log(this.props);

    this.state = {
      toggleBtnControl: 1,
      tripData:[],
      minPrice:0,
      maxPrice:1,
      rangePrice:[],
      minDuration:0,
      maxDuration:1,
      rangeDuration:[],
      tripType:false
      };

    this.handleToggleBtnChange = this.handleToggleBtnChange.bind(this);
    this.handlePriceRange = this.handlePriceRange.bind(this);
    this.handleBook = this.handleBook.bind(this);
  }

  componentDidMount() {
    
  }


  handleToggleBtnChange(e){
    var tripData = [];
    if(e===1){
      document.getElementById('price-toggle').fontweight = 700;
      document.getElementById('duration-toggle').fontweight = 300;
      document.getElementById('date-toggle').fontweight = 300;

      tripData = [].concat(this.props.main)
      .sort(function(a,b){
        return (a.value < b.value) ? -1 : (a.value > b.value) ? 1 : 0; 
      });
      // console.log(tripData);
    }else if(e===2){
      document.getElementById('price-toggle').fontweight = 300;
      document.getElementById('duration-toggle').fontweight = 700;
      document.getElementById('date-toggle').fontweight = 300;
      tripData = [].concat(this.props.main)
      .sort(function(a,b){
        return (a.duration < b.duration) ? -1 : (a.duration > b.duration) ? 1 : 0; 
      });
    }else{
      document.getElementById('price-toggle').fontweight = 300;
      document.getElementById('duration-toggle').fontweight = 300;
      document.getElementById('date-toggle').fontweight = 700;

      tripData = [].concat(this.props.main)
      .sort(function(a,b){
        return (a.depart_date < b.depart_date) ? -1 : (a.depart_date > b.depart_date) ? 1 : 0; 
      });
    }
    this.setState({
      toggleBtnControl:e,
      tripData: tripData
      });

  }
  handlePriceRange(rangePrice){
    // console.log(rangePrice)
    var tripData = [].concat(this.props.main)
    .map(function(trip){
      // console.log(trip.value)
      if(trip.value >= rangePrice[0] && trip.value <= rangePrice[1]){
        return trip
      }else{
        return null
      }
    });
    tripData = tripData.filter(function (el) {
      return el != null;
    });
    // console.log(tripData);

    this.setState({
      tripData: tripData
      });
 
  }
  // handleBook(e){
  //   // console.log(e.target.name)
  //   // console.log(this.state.tripData[e.target.name])
  //   console.log(    this.state.tripData[e.target.name]   )
    
  // }
  handleBook = (event) => {
    // this.props.actions.flightBookData({ bookIndex: event.target.name 
    //  });
     this.props.history.push({
       pathname:'/payout',
       state:{
         ticketData:this.state.tripData[event.target.name],
         username:this.props.username
       }
     })
  }
  // componentDidUpdate = (prevProps) => {
  //   const { flightData } = this.props;
    
  //   console.log(flightData)
  //   if (prevProps.flightData !== flightData) {
  //     this.props.history.push({
  //       pathname: '/current-flight',
  //       state: {
  //           flightData: flightData,
  //       },
  //     });
  //   }
  // }
  componentDidUpdate(prevProps) {
    var minPrice = 0
    var maxPrice = 1
    var minDuration = 0
    var maxDuration = 1
    // let { minPrice, maxPrice, minDuration, maxDuration } = this.state

    if (this.props.main !== prevProps.main ) {
      let tripType = false;
      const tripData = [].concat(this.props.main)
      .sort(function(a,b){
    
        minPrice = (a.value < b.value) ? (a.value<minPrice || minPrice===0 ? a.value:minPrice):(b.value < minPrice) || minPrice===0  ? b.value:minPrice;
        maxPrice = (a.value > b.value) ? (a.value>maxPrice ? a.value:maxPrice):(b.value > maxPrice) ? b.value:maxPrice;
        minDuration = ((a.duration < b.duration &&  a.duration !== null)||b.duration===null) ? (a.duration===null? minDuration:(a.duration<minDuration || minDuration===0? a.duration:minDuration)):(b.duration < minDuration  || minDuration===0)? b.value:minDuration;
        maxDuration = (a.duration > b.duration) ? (a.duration>maxDuration ? a.duration:maxDuration):(b.duration > maxDuration) ? b.duration:maxDuration;
        return (a.value < b.value) ? -1 : (a.value > b.value) ? 1 : 0; 
      });
      if(tripData[0].return_date){
        tripType = true;
      }

      this.setState({
        tripData:tripData,
        minPrice:minPrice,
        maxPrice:maxPrice,
        rangePrice:[minPrice,maxPrice],
        rangeDuration:[minDuration,minDuration],
        minDuration:minDuration,
        maxDuration:maxDuration,
        tripType:tripType
       });
      console.log(tripData)
      // console.log(this.props.location.state.tripType)
      // console.log(tion.state)
    }

  }




  render() {
    
    const { loading, loaded, error }= this.props;
    const wrapperStyle = { width: 200, margin: 20 };
    const blankStyle= {  "paddingTop": "30px" } 
    if (error) {
      return (
        <div>
          <FlightCardError />
        </div>
      );
    }

    if (loading) {
      return (
        <Loader />
      );
    }
    if(loaded){ 

       return (
         
  <div>
        {
          this.state.maxPrice>1&&(
            <div className="filter-card">
              <div className="filter-options">
                    <div className="row">
                        <div className="filteritem-container"><label className="filter-lablel">PRICE</label></div>
                        <div className="filteritem-container">
                          <div style={wrapperStyle}>
                          <Range min={this.state.minPrice} max={this.state.maxPrice} defaultValue={[this.state.minPrice, this.state.maxPrice]} onChange={this.handlePriceRange} tipFormatter={value => `${value}` } />
                          </div>
                        </div>
                    </div>
                    {
                      this.state.tripType === false &&
                    <div className="row">
                    
                    <div className="filteritem-container"><label className="filter-lablel">FLIGHT DURATION</label></div>

                    <div className="filteritem-container">
                      <div style={wrapperStyle}>
                      <Range min={this.state.minDuration} max={this.state.maxDuration} defaultValue={[this.state.minDuration, this.state.maxDuration]} onChange={value=>{this.setState({rangeDuration:value}) ;}} tipFormatter={value => `${value}` } />
                      </div>
                    </div>

                  </div>
                    }

                    
              </div>
         </div>  
          )
        }
  
       <div className="container">

            <div className="trip-header"> Please select your departing flight</div>
            
            <div className="sort-options row justify-content-around"> 
        
            <ToggleButtonGroup
              type="radio"
              name="trip-radio"
              value={this.state.toggleBtnControl}
              onChange={this.handleToggleBtnChange}
              className="btn-group-toggle col-6 "
            >
              <ToggleButton value={1} className = {this.toggleBtnControl===1? 'btn-outline-warning':''} id="price-toggle" >Price</ToggleButton>
              <ToggleButton value={2} className = {this.toggleBtnControl===2? 'btn-outline-warning':''} id='duration-toggle'>Duration</ToggleButton>
              <ToggleButton value={3} className = {this.toggleBtnControl===3? 'btn-outline-warning':''} id='date-toggle'>Date</ToggleButton>

            </ToggleButtonGroup>
         
        
            <span className="btn col-6 text-right" >Total cost ($) </span>

            </div>
              { // default sort by price
                this.state.tripData!==null  &&
                this.state.tripData.map((trip, index) => (
                  
                  <div className="row trip" key={index} trip_class={trip.trip_class}>
                  <div className="col">{(trip.duration ? Math.floor(trip.duration/60) + ' h': '-')}</div>
                  <div className="col">
                  <div style={blankStyle}><span></span></div>
                  <div><span className="material-icons col-sm-1">flight_takeoff</span></div>

                  {
                    this.state.tripType && 
                    <div><span className="material-icons col-sm-1">flight_land</span></div>

                  }
                  </div>
                  
                  <div className="col-3">
                    <div>{trip.origin} - {trip.destination} </div>
                    <div>{trip.depart_date} </div>
                    {this.state.tripType && <div>{trip.return_date}</div>}
                    
                  </div>
                  <div className="col-3">
                    <div>{trip.gate}</div>
                  </div>
                  <div className="col">
                  <div>{trip.value}</div>
                  <button className="btn-sm btn-primary" name={index} onClick={this.handleBook}>book</button>

                  </div>
                </div>
                  ) 
                )
              }
              </div>

        </div>
              );}
            }}

const mapStateToProps = function(state) {
  // 要再申明一个 给bar????/// 如果没有网 应该要有提醒
  const {  main,loading,loaded,error } = state;
  const logged = state && state.logged;

  return {
    ...state,
    main: main,
    loading:loading,
    loaded:loaded,
    error:error,
    loginStatus:logged
  };
  
};

const mapDispatchToProps = function(dispatch) {
  return {
    actions: {
      getFlightData: function(flightSearchData) {
 
        dispatch(actions.getFlightData(flightSearchData));
      },
    },
  };
};

export default connect(mapStateToProps, mapDispatchToProps)(CurrentFlight);