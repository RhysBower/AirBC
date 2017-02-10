Account(**id**: int, name: string, email: string, username: string, password: string)
Primary Key: id

Aircraft(**id**: string, type: string, first_class_seats: int, business_seats: int, economy_seats: int, purchase_date: date, status: enum)
Primary Key: id

Airport(**id**: string, name: string)
Primary Key: id

Customer(**id**: int, travel_document: string, billing_address: string, phone_number: string, loyalty_member: int, points: int)
Primary Key: id
Foreign Key:
- id references Account.id

Flight(**id**: int, date_time: date, assigned: string, arrival: string, departure: string)
Primary Key: id
Foreign Key:
- assigned references Aircraft.id
- assival, departure references Route.arrival, Route.departure

Route(**departure**: string, **arrival**: string, first_class: int, business: int, economy: int)
Primary Key: departure, arrival
Foreign Key:
- arrival references Airport.id
- departure references Airport.id

Staff(**id**: int, title: string)
Primary Key: id
Foreign Key:
- id references Account.id

Ticket(**id**: int, seat_type: enum, flight: int)
Primary Key: id
Foreign Key:
- flight references Flight.id ////// ?
