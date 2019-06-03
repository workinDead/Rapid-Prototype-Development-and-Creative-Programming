const configureStripe = require('stripe');

const STRIPE_SECRET_KEY = process.env.NODE_ENV === 'production'
    ? 'sk_live_MY_SECRET_KEY'
    : 'sk_test_3o1wV7bP6I41YjcyYNLHSUWz';

const stripe = configureStripe(STRIPE_SECRET_KEY);

module.exports = stripe;