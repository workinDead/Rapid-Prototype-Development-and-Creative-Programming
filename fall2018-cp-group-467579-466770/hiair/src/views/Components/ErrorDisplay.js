import React from 'react';
// import LightningBolt from '../assets/lightning.svg';
import DatePicker from "react-datepicker";

const Home = () => {
    console.log('ErrorDisplay.js');
    return (

        <div className="flight-search">
        <h1>
                Great travel deals.
        </h1>
        <div className="triptype-select">
                <button className="btn btn-outline-light active-triptype"   name="oneway-btn" >One Way</button>
        {/* style="background:transparent; border:0px;" */}
                <button className="btn btn-outline-light" name="roundtrip-btn" >Round Trip</button>

        </div>
        <form className="form-inline" method='POST' action='/search-flight'>
        {/* method:post action:search */}
                <div className="search-content">
                    <div className="wrapper"><input type="text" className="form-control" id="origin" name="origin"  /></div>
                    <div className="wrapper"><input type="text" className="form-control" id="destination" name="destination"   /></div>
                    <DatePicker className="form-control" id="begin_of_period" name="begin_of_period"  />
                    <DatePicker className="form-control" id="end_of_period" name="end_of_period"  /> 
                    <button type="submit" className="btn btn-primary" >
                    Search Flights
                    </button>
                </div>
        </form>


        </div>

    );
};

export default Home;