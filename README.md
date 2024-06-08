# FORUM_PROJECT
This is a forum website project.

Problem Statement:
When we take our first step in the world of programming, the first thing which comes in our mind while we encounter a problem is to google the solution. But sometimes googling a solution can become a tedious task. So to deal with this problem I have builded a basic Forum website in which your doubts will get cleared.

Description of the project:
1. In this project I have given users a facility to sign up to our website and login to our website. 
2. We have also created a categories section so that users can choose in which category they have to post their doubts.
3. The user can post his thread(doubt) which gets listed on our threadlist page.
4. And on that thread people can comment on their solutions.

Tech used to build this project:
Front end was builded using Bootstrap.
Back end was builded using PHP.


Challenges faced while making this project:

1. The first challenge while making this project we faced was that the password that got saved in our database was in text format. This might lead to data breach in future.
Solution: To prevent this problem I have used a functionality in PHP named password hashing which uses some kind of hashing algorithm to convert the password into a long character hash.

2. Second challenge I faced was to prevent our website from XSS attack.
Solution: To tackle this challenge I have used a function in PHP named str_replace().Basically this function replaces the angular brackets of HTML tags(<>) to string like ('&lt' , '&gt').

Future improvement scope in this project:
I will be shifting this website onto some newer tech stack like MERN in future so that I could add more functionalities to that project.


![alt text](php.png)
![alt text](<bootstrap logo.jpg>)