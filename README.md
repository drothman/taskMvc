#taskMvc

Great lightweight PHP MVC designed for for back-end developers who need to quickly develop/debug a back-end API without needing a mobile client.
Uses the command line to pass query string parameters to a controller's action.

#### Code Generated Documentation at http://www.davidrothman.us/taskMvc  

#### Code at http://www.github.com/drothman/taskMvc 

##Install
* Clone locally 

* Install php-cgi to pass query string parameters from command line (shouldn't interfere withe existing php installation)

        apt-get install php-cgi

* Install sample MySQL database in resources/sql if desired

* Start and get help by running from command line:

        php taskMvc.php



##Example

###Set-up

Sample task uses your local MySQL DB after you the database in the resources/sql 
directory is imported to your local MySQL instance. 


###Sample Task

Write a PHP program that takes the following as query string parameters:

The name of a category from the sample database (for example 'Afrika_Borwa' if you're using the sample data)
The number of articles to list
A start date in ISO 8601 format (for example '2011-07-31')
An end date in ISO 8601 format (for example '2013-10-17')

Using these 4 parameters, your program should answer the question: 

"In the category X, what were the X most-edited articles between the days X and X, 
and how many times were each of them edited during that period." 

Don't worry about subcategories. 
The results should be output as JSON, along with the total time that the query or queries took to run.

###Help on Implementation for Sample Task

To get a list of the most recently edited articles for a category,
run the prorgam by typing in the command line:

      php-cgi task.php '&controller=[controller]&action=[action]&category=[category]&limit=[limit]&start=[start]&end=[end]

For Example:

      php-cgi taskMvc.php '&controller=page&action=mostRevisedForCat&category=Afrika_Borwa&limit=10&start=2011-07-31&end=2013-10-31'

You enter:

Controller (for example 'page')

Action (for example 'mostRevisedForCat')

Parameters for the action: 

(*** query string parameter names must match action's parameter names if any ***)

'category' : (for example 'Afrika_Borwa' )

'limit' : Number of Articles to list (for example 10)

'start' : Start Date in ISO 8601 format (for example '2011-07-31')

'end' : End Date in ISO 8601 format (for example '2011-07-31')


And you will get a JSON answer to the question:

'In the category X, what were the X most-edited articles between the
days X and X, and how many times were each of them edited during
that period.' \n\n";

One more time, here's the example of the args in the format you need to pass in:

    php-cgi taskMvc.php '&controller=page&action=mostRevisedForCat&category=Afrika_Borwa&limit=10&start=2011-07-31&end=2013-10-31'

*** Use php-cgi to pass the parameters in a query string ***

### Format for Help on Specific Actions
To get help on a specific Action:

    php-cgi taskMvc.php '&controller=page&action=mostRevisedForCat' --help

or 

    php-cgi taskMvc.php '&controller=page&action=mostRevisedForCat' -h
