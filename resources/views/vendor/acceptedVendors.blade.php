<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<h1>Dear {{$userName}}:</h1>
thank you for having the interest of joining us,
We are sending this message to inform you that your application has been accepted.
and therefor you are offecially a business partner and here are the details needed 
client_id : {{$secret->id}}
client_secret: {{$secret->secret}}
grant_type : password

please use this link http://api/auth/token to get the needed token to access our files

Kinldy read  the attached file for further instructions

used api to add new eveents :

- location_img 

to add  an image for the location where the event takes place

- event

to provide the event name if  there is one a string is provided

- adultsPrice

to provide the ticket price if existed an integer is provided

- childrenPrice

to provide the ticket price for children if existed an integer is provided

- numberOfTickets

to provide us with the number tickets to be sold to the public through our window inte

- singer

to provide with the name of singers should be an array 

- date
to provide date of the event and should be date format

- location
to provide location name and should be string

- description
to provide the description for the event should be string

- address
to provide the address of the location should be string
- longitud
to provide the longitud of the location if desired 
- latitude
to provide the longitud of the location if desired 

- location_description
to provide the description for the event's location should be string

</body>
</html>