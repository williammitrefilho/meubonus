# meubonus
A lightweight minimalist PHP web app for bookkeeping

### 1. Introduction
I have been a small business owner in the food service industry for 7 years now, and along the way I met with several challenges, one of which was keeping good morale among the coworkers.
Being it a Store-in-store venue (more specifically a coffehouse inside a big construction materials supplier), my coworkers, in face of the impressive size and structure of the megastore out there, sometimes struggled to avert the feeling of being overlooked, "trapped" in a small business.
In fact, such big retailers often feature a huge and intricate internal marketing structure, which may be hard to reproduce in a small scale.
The first solution was to implement a goals system, in which they could accumulate small bonuses for a number of small achievements on the course of a working day. It was a great success, but along with it came the problem of bookkeeping. For it to be truly effective it would be necessary to provide them with a means of querying their earnings in real-time.
And then there was the light.

### 2. Overview
**meubonus** is intended to be inexpensive, lightweight, and extremely easy to use and install. Its code is easy to understand. Its MVC architecture resembles that of Magento, but with a much more basic structure.

It features two interfaces: admin and user

##### 1. Admin
<your_url>/admin is the administrator app, where the manager will add transactions.
As is common in bookkeeping, there is no way to "delete" a transaction. A mistaken one must be compensated by another one of the same amount, opposite sign.

##### 2. User
<your_url>/ it the user app, where coworkers log in to check their balances.

### 3. Installing
1. Clone the repository
2. Update the [config.php](cfg/config.php) file with your database and domain credentials
3. In MySQL, insert your admin user in table **mb_usuarios_admin**, your coworkers in **mb_usuarios**, and their accounts on **mb_contas**
