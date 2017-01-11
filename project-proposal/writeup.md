# 1. Project Description

# 2. Application Specification

## 2.1 Purchase - Example

**User:** Clerk

**Input:** UPC, quantity, payment type

Optional input (depending on payment type): cash amount, or credit card type and number, or account type and number.

**Output:** "OK" or "Cancelled"

**Basic Case:**

The system will remove quantity many items from the item table check if the item is taxable, and calculate the total value. If the amount is to be charged on a credit card, will ask for authorization. If the payment is to be charged to a UBStore account, check for sufficient funds. If all go well it adds a log record in the purchases log table and returns "OK".

**Exceptions:**

* If item is not in the database, transaction is aborted and "Cancelled" is returned.
* If there are not enough pieces in stock transaction is aborted and "Cancelled" is returned.
* If not enough cash is tendered, transaction is aborted and "Cancelled" is returned.
* If credit card is not authorized, the customer is asked to pay cash.
* If UBStore account for the item category does not exist, or does not have sufficient funds, the customer is given the option to chose another form of payment (cash or credit card).

# 3. Platform to use
We will use PHP with the Oracle database to create a web app hosted on the ugrad servers.