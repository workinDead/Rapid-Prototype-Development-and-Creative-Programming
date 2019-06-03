// import React, { Component } from 'react';
// import axios from 'axios';
// import StripeCheckout from 'react-stripe-checkout';

// import STRIPE_PUBLISHABLE from '../../constants/stripe';
// import PAYMENT_SERVER_URL from '../../constants/server';
// import { Redirect } from 'react-router-dom'




// const CURRENCY = 'USD';

// const fromUSDToCent = amount => amount * 100;

// const successPayment = data => {
//   alert('Payment Successful');
//   console.log(data);
// };

// const errorPayment = data => {
//   alert('Payment Error');
//   console.log(data);
// };
// // var booked = false;

// const onToken = (amount, description) => token =>
//   axios.post(PAYMENT_SERVER_URL,
//     {
//       // description:description,
//       source: token.id,
//       currency: CURRENCY,
//       amount: fromUSDToCent(amount)
//     })
//     .then(function(successPayment){
//      console.log(description)

//       axios.post('/book-ticket',{
//         ticketData:description
//       })
//     })
//     .catch(errorPayment);



// const Checkout = ({ name, description, amount }) =>
//   <StripeCheckout
//     name={name}
//     description={description}
//     amount={fromUSDToCent(amount)}
//     token={onToken(amount, description)}
//     currency={CURRENCY}
//     stripeKey={STRIPE_PUBLISHABLE}
//   >
//   <button className="btn btn-primary">Pay With Card</button>
//   </StripeCheckout>
  

// export default Checkout;