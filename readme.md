## JGomes Exercise for fixeAds:

This is an exercise for fixeAds in sequence to a job offer witch I have to give them a possible solve for a previews problem provided.

I don't know what are the possible requirements in terms of SO, PHP version, 
machine configs, modules (like PDO), blablabla.. 

So for this reason I decided to make it as simple as possible without any 
external source or extra PHP modules, just using only native php, js and mysql.

To make it more organized, I did a simple MVC pattern "home made" without 
autoloads, routing or something more complex.. just to separate logical..

I did a config path with db connection configs and a public path to put all necessary assets. 

## Install:

1) First of all type all the DB parameters on file ( file: config/.env )

2) After run the script "install" on browser ( http://{server_url}/public/install.php ). 
This will create the necessary database stuff.

3) The exercise is on page http://{server_url}/index.php?controller=register&action=index

## Explanation:

## Contacts

José Gomes

Email: zx.gomes@gmail.com
