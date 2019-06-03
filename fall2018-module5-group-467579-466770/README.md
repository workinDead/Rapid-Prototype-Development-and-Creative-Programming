# Ajax calendar
* The link to Ajax calendar: http://13.58.19.111/~hlan/icalendar/iCalendar.html

# Login Details
three existed users
 - username for login: admin
 - username for login: workindead
 - username for login: bella
 - password for all these three users to login: 123
 
# Creative Portion
 - Users can tag an event with a particular category and enable/disable those tags in the calendar view. There are four categories in our calendar web: default, recreation, work and other, which are the same as the tag when a user adds a new event(5 points)
 - Users can share their calendar with additional users: our web allow users to share its whole calendar to others who registered in our web already. In addition, the shared friend list can be edited; Those who are shared a calendar have access to others' calendar, which means he or she can choose to view others' calendar (events that belongs to the calendar sender will be shown) but can't edit. (5 points)
 - Users can create group events that display on multiple users calendars: we create a separate table in database which represents user's edit privilege. Thus, when add or edit event, one can add coworks field, by filling in the registered user name in it.  (5 points)
 - Additional point: appealing css, useful guidance (when you move your mouse onto any element in our navigation bar and wait 2-3 seconds, you will get a hint about the function) and best practice without reloading our page when using our web.
 
# Worth to know before testing our web:
 - When signing up: you should only enter valid string in username and password field. We set the rule as it is general to all: username and password may consist of 0-9 a-zA-Z but not any other thing, whcih means we already prevent users to attack our database even though we still strengthen the protection in our php.
 - 

