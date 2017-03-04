1. Originally, we had Customer and Staff tables and no Account table because Customer and Staff —ISA— Account and they are disjoint. We changed to have Customer, Staff, and Account tables so that customer and staff account id's are unique.
2. Removed some candidate keys: 
   - `assigned` and `(arrivial, departure)` from `Flight`: there can be a few flights on the same arrivial and departure airport pair, 
   - `(flightId, customerId)` from `Ticket`: a customer can book a few tickets on the same flight so this does not make sense,
   - `travel_document` from `Customer`: a customer can have a few travel documents stored as one customer account can book tickets for more than one person.
   - `id` from `Acount`, `Flight`, and `Ticket` was changed from `unsigned int` to `unsigned bigint` to mitigate bugs where an array index is used as an id.