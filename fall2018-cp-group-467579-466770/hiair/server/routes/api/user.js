const User = require('../../database/models/user.js')
const Order = require('../../database/models/order.js')

const passport = require('../../passport/index.js')

module.exports = (app) =>{
    app.post('/book-ticket',(req,res)=>{
        // console.log('book-ticket')
        const { value, trip_class,return_date,origin,number_of_changes,gate,duration,distance,destination,depart_date,username } = req.body.ticketData
        // const username = req.body.username
        const newOrder = new Order({
            value:value, 
            trip_class:trip_class,
            return_date:return_date,
            origin:origin,
            number_of_changes:number_of_changes,
            gate:gate,
            duration:duration,
            distance:distance,
            destination:destination,
            depart_date:depart_date,
            username:username
        })

        newOrder.save(function (err) {
            if (err) return res.json(err);
          });
        });

    app.post('/order-history',(req,res)=>{
        const  {username}  = req.body
        console.log(username)
        console.log(req.body)
        Order.find({ username: username }, (err, order) => {
            if(err){
                console.log('order.js post error: ', err)
            }else{
                // console.log(res)
                res.send(order)
            }
        })

    })
    app.post('/signup', (req, res) => {
        // console.log('user signup');
    
        const { username, password } = req.body
        // ADD VALIDATION
        User.findOne({ username: username }, (err, user) => {
            if (err) {
                // console.log('user.js post error: ', err)
            } else if (user) {
                res.json({
                    error: `Sorry, already a user with the username: ${username}`
                })
            }
            else {
                const newUser = new User({
                    username: username,
                    password: password
                })
                newUser.save((err, savedUser) => {
                    if (err) return res.json(err)
                    res.json(savedUser)
                })
            }
        })
    })
    app.post(
        '/login',
        function (req, res, next) {
            // console.log('routes/user.js, login, req.body: ');
            // console.log(req.body)
            next()
        },
        passport.authenticate('local'),
        (req, res) => {
            // console.log('logged in', req.user);
            var userInfo = {
                username: req.user.username
            };
            res.send(userInfo);
        }
    )
    app.get('/signup', (req, res, next) => {
        // console.log('===== user!!======')
        // console.log(req.user)
        if (req.user) {
            res.json({ user: req.user })
        } else {
            res.json({ user: null })
        }
    })
    
    app.post('/logout', (req, res) => {
        if (req.user) {
            req.logout()
            res.send({ msg: 'logging out' })
        } else {
            res.send({ msg: 'no user to log out' })
        }
    })



}