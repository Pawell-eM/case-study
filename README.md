Codingtest
=========

### Setup
System requirements:
- PHP8.0+
- Composer

### Intro
Hi and welcome to limango! You're now going to participate in
a short coding test to see your ability to think logical, 
to work independently with a given situation or environment and
develop in a smart, goal-oriented way.

### Task
Your stakeholder is the owner of a franchise of candy factory. Your product owner
has given you the task of further extending a small candy machine for distribution. 
The input should be the type of candy to be bought, 
the amount of candy a potential customer could want and the amount he is
going to pay with.

The candy and its prices are:
- 'caramels', 4.99 €
- 'lollipop', 2,99 €
- 'mince drops', 0,69 €
- 'chewing gum', 1,99 €
- 'licorice', 3,59 €

You ***don't*** have to think about currencies, there are only €!
You can only buy one type of candy at a time.

The result should be printed on the screen with the count and 
the total amount of the purchased candy as well as a table 
which tells the customer in which coin combination he is going
to get his change.

Example:

```
╭─user@limango:/home
╰─$ php bin/console purchase-candy

╰─$Please select your favorite candy
  [0] caramels
  [1] lollipop
  [2] mince drops
  [3] chewing gum
  [4] licorice
  
╰─$ > 0

╰─$Please input packs of candy you want to buy (Default: 1)> 2

╰─$Please input your payment amount> 10
```

The output should be formatted as:
```
You bought 2 packs of caramels for 9,98 €, each for 4,99 € 
Your change is:
+-------+-------+
| Coin  | Count |
+-------+-------+
| 0.02  | 1     |
+-------+-------+

╰─$ 
```
### Technical caveats
You were given a base scaffolding for implementation to ensure interoperability 
with the existing business. 

Consider possible invalid states and have the machine give user feedback
accordingly, e.g. "less money given than total cost of amount"

You are free to clean up the Command class and use the console for DI.