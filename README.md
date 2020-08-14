# Jepsen-brite

# Part 1

## Organisation du travail: 

### Mathieu  
  #### Front end
- [x] principale,
- [x] inscription,
- [x] connection,
- [x] profil de l'utilisateur,
- [x] modification du profil de l'utilisateur,
- [x] ancien événement,
- [x] affichage d'un événement,
- [x] création d'un événement,
- [x] modification d'un événement.

### Bryan
  #### Back end
- [x] création d'un profil utilisateur, 
- [ ] mail de confirmation d'inscription, 
- [x] connection, 
- [x] deconnection,
- [x] header de connection (connecter à un compte ou pas),
- [x] profil de l'utilisateur, 
- [x] suppression d'un compte utilisateur, 
- [x] modification d'un compte utilisateur,
- [x] ajouter un avatar,
- [x] test de déploiement sur heroku,
- [x] déploiment du site sur heroku.

### Said
  #### Back end 
- [ ] évenement, 
- [ ] ancien evenement, 
- [ ] affichage d'un événement, 
- [ ] création d'un événement, 
- [ ] modification d'un événement, 
- [ ] suppression d'un événement,
- [ ] comentaire des événements.

### organisation du travail: scrum

Réunion matinale et réunion pm => si besoin on peut faire du pear coding

# Specifications

|Challenge Parameters  |Challenge Details              |
|:---------------------|:------------------------------|
|Repository            |`jepsen-brite`            |
|Challenge type        |`learning challenge`           |
|Duration              |`2 weeks`                       |
|Deadline              |`31/07/2020 17h00`             |
|Deployment method     |`Heroku`                 |
|Group composition     |`Bryan`, `Mathieu`, `Saïd`     |
|Project submition     |[Google form]()|



## Learning Objectives 

- Generate templates with PHP
- Be able to use the superglobals $_GET, $_POST, $_COOKIE and $_SESSION variable.
- Implement a CRUD
- Create a DB following the client requests
- Be able to manage SQL requests
- Use PDO
- Deploy on Heroku

## The Mission

A client from the cultural sector, Henry Fiesta, ask you to provide him a new website. The purpose of this website is to show all kinds of events to the public according to their point of interest. 

The website will be visible to any visitor who have to register to be able to interact (like registering for an event, putting in a comment, etc.).

You can compare this project to [**Eventbrite**](https://www.eventbrite.com/), except that Henry thinks you will make a better product. So, don't disapoint him. He has already paid a deposit. 

Henry doesn't have special request for the design, you're free to follow your own inspiration. 
*But don't be too focus on the design*, the aim of this project is to deliver something functional. You can take a template already made by *Bootstrap* or *Materialize*. 


### Users

Any visitor can consult the website and navigate through the event, but to interact, he must be connected as a *User*.

* Any visitor should be able to sign up and log in. 
* There is no admin user, everybody has got the same rights. 
* When a user sign up (**CREATE**), he must receive an email. 
* A user must have an unique : 
	- *email adress* which is private, so don't show it to the others users. 
	- *password*
	- *nickname* which will be displayed on the website.
	- *avatar* (use [Gravatar](https://en.gravatar.com/)) which will be displayed on the website.
* A user logged can create an event. 

### Profile page

* It displays the user informations (**READ**).  
* Users will be able to modify (**UPDATE**) their information (except email) on this page.  
* He should be able to **DELETE** his account via this page. 

### Homepage

* The homepage presents (**READ**) a list of upcoming events, in chronological order (the next to occur is the first presented, then the next, etc.). Each event must be displayed with his name, date and hour.
* At least, the 5 upcoming events should be displayed, Max 21 upcoming events.
* On each event a link must allow to go to the page of the event.
* The first event to occur has to be highlighted.

### Event page

An event should contain at least :

* A title
* The author
* A date and an hour
* An image
* A description. It must be _rich_: it must interprets **markdown** and shows **emojis**.
* A category (for example : concert, exhibition, conference...)

All these informations must be displayed on the event page. 

The author of an event, and only him, can **UPDATE** his own event. The update can be made as well on the same page as redirect to an other page (you're free to choose the best process).  

The author of an event, and only him, can **DELETE** his own event.  

* There must be a link to the event creation page.
* Any user can post a comment on the event. It must interprets **markdown** and shows **emojis**.


### Event creation page

This is here a user can **CREATE** an event.

### Past Events page

It displays the past events. It can looks like the homepage.  

### Category page

As there is not administrator for this application, you can create categories in advanced in the DB and constrains the users to use some categories (for example : concert, exhibition, conference...).

The category page displays events in regards to category. It can looks like the homepage.  

### The menu

* The menu should link to all the important pages.
* There must be a link to the profile page.
* Don't forget to add a submenu for the categories. It could be display as a sidebar for example. 


## Constraints

* Use SCRUM methodology to communicate and advance in team. Your SCRUM meeting should be a ritual everyday. The 3 steps of a SCRUM meeting :
	- Tell what was done.
	- Tell what difficulties you encountered.
	- Define objectives.
* The back-end must be programmed in **PHP**, and there is no constraint about the way you code.
* The database must be in SQL. 
* The project should be published on [**Heroku**](https://heroku.com). You have free credits to use on Heroku with your **GitHub Student Pack**.
* You must hash your password with a solution like *bcrypt*. 
* No credential must be commited on the repo Github. 

# Part 2

# Specifications


|Challenge Parameters  |Challenge Details              |
|:---------------------|:------------------------------|
|Repository            |`jepsen-brite`            |
|Challenge type        |`consolidation challenge`           |
|Duration              |`2 weeks`                       |
|Deadline              |`14/08/2020 17h00`             |
|Deployment method     |`Heroku`                 |
|Group composition     |`Bryan`, `Michael`, `Mathieu`  |
|Project submition     |[Google form]()		|

## Learning Objectives 

* Dealing with an change in your team -> requires skills : solution oriented, team player, team manager. 
* Re-organised the code and the DB. Remember : *"To do and undo, it's always part of the job"*
* Going deeper in PHP and SQL



## The Mission

Henry Fiesta, the client of the project Jepsen Brite is very enthusiast after the presentation of your job, and now he would like to add new features to his website to be in better position on the market. 

Unfortunaletely, a member of your team was contacted by a headhunter and he decided to leave your team for an another one !

But don't worry ! Your boss has already engaged a new colleague who will integrate your team. Explain him your work on the project and how your code works. 


### Finish the previous job

The project may not contain all the features of the basic application. 

You must finalize these functionalities which are essential to achieve the new functionalities.

Also, if you have some bugs, you have to correct them. 

You will have to do everything in your power to ensure that all the new features can be implemented and work perfectly.

### New features

#### 1. Possibility to register to an event

It makes sense, the users should have the possibility to participate to an event. Add a button where a user can show he will participate to the event. 

Also, a list of participants should be displayed on the Page Event. 

#### 2. Subcategories 

You have categories, this is nice, but Henry would like to go more deeply. He would like to implement **subcategories**.

For example, for the category *concert*, you should tell which kind of music it is : *classic*, *pop*, *reggaeton*, *metal*...

An event can have several subcategories. For example, if Amon Amarth plays an acoustic concert, your user should see : *acoustic* and *metal* for this event. 

Create at least 2 events with 2 subcategories. 

#### 3. User private dashboard

Create a dashboard for the user, so he could manage his events. 

The dashboard should at least shows : 
- a list of events he will participate
- a list of events he participated
- a list of events he created

#### 4. Add administrator account

Henry would like to keep the control of his website. So, he would like an admin account which gives him the possibility to delete :
* fake events
* users
* comments

His account must have the same rights as a user (create and update events, comments). 

#### 5. A video or an image

When a user create an event, he should have the choice to display an image or a **video url** (like YouTube, Vimeo..) to illustrate his event. 


#### 6. Adress and Map

An event must have an adress. On the Event page, the localisation should be displayed on a map.  

You can use for example Google Maps or OpenStreetMap. 

### Bonus

- If an event is modified, all the users registered should be informed either by a message, by a notification or by an email (or the all together). 
- Send a message, notification or email one day before an event occur to the users registered. 



