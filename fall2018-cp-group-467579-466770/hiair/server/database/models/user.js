// sets up the schema
const mongoose = require('mongoose')
const Schema = mongoose.Schema
const bcrypt = require('bcryptjs'); // hash password with bcryptjs
mongoose.promise = Promise

// Define userSchema methods
const userSchema = new Schema({

	username: { type: String, unique: true, required: true },
	password: { type: String, unique: false, required: true }

})

// Define schema methods
userSchema.methods = {
	checkPassword: function (inputPassword) {
		return bcrypt.compareSync(inputPassword, this.password)
	},
	hashPassword: plainTextPassword => {
		return bcrypt.hashSync(plainTextPassword, 10) // integer: the salt length to generate
	}
}

// Define pre-hooks for the save method
userSchema.pre('save', function (next) {
	if (!this.password) {
		console.log('models/user.js =======NO PASSWORD PROVIDED=======')
		next()
	} else {
		console.log('models/user.js hashPassword in pre save');
		
		this.password = this.hashPassword(this.password)
		next()
	}
})

const User = mongoose.model('users', userSchema)
module.exports = User
// module.exports = mongoose.models.User || mongoose.model('User', userSchema);
