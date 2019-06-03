// sets up the schema
const mongoose = require('mongoose')
const Schema = mongoose.Schema
mongoose.promise = Promise

// Define orderSchema methods
const orderSchema = new Schema({

	_id: {
        type: mongoose.Schema.Types.ObjectId,
        index: true,
        required: true,
        auto: true,
        unique:true
      },
    trip_class: { type: String, unique: false, required: false },
    depart_date: { type: String, unique: false, required: false },
    return_date: { type: String, unique: false, required: false },
    destination: { type: String, unique: false, required: false },
    duration: { type: String, unique: false, required: false },
    distance: { type: String, unique: false, required: false },
    gate: { type: String, unique: false, required: false },
    number_of_changes: { type: String, unique: false, required: false },
    origin: { type: String, unique: false, required: true },
    value: { type: String, unique: false, required: true },
    username: { type: String, unique: true, required: true,ref:'user'},

})

// Define schema methods
// orderSchema.methods = {

// }

// Define pre-hooks for the save method
// orderSchema.pre('save', function (next) {
// 	// if (!this.order_id) {
// 	// 	console.log('models/user.js =======NO PASSWORD PROVIDED=======')
// 	// 	next()
// 	// } else {
// 	// 	console.log('models/user.js in pre save');
// 	// 	next()
// 	// }
// })

const Order = mongoose.model('orders', orderSchema)
module.exports = Order
// module.exports = mongoose.models.User || mongoose.model('User', userSchema);
