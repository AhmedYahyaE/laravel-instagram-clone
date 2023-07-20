# Instagram Clone Laravel Project
This is a Laravel (and partially Vue.js ) application which mimics the core functionalities of the popular social media platform, Instagram. The project is built using Laravel framework (and Vue.js), providing a robust and scalable foundation for creating an image-sharing platform. The project also features a User Following System (Follow/Unfollow Button) based on Vue.js Components and making HTTP Requests from the frontend using Axios JavaScript library.

Frontend technologies used: Bootstrap (responsive/mobile first design), Vue.js, and Axios JavaScript library.

## Screenshots:
***Homepage:***

![instagram-clone-homepage](https://github.com/AhmedYahyaE/laravel-instagram-clone/assets/118033266/1225c585-4296-4f5a-9907-15183fb5c344)

***User Profile:***

![instagram-clone-profile-page](https://github.com/AhmedYahyaE/laravel-instagram-clone/assets/118033266/a24e38c9-2ec4-45d1-bd3c-9de7dc3fb8e6)

***User Following System (Follow/Unfollow Button):***

![instagram-profile-page-2](https://github.com/AhmedYahyaE/laravel-instagram-clone/assets/118033266/d698e19a-0a24-43eb-8717-50c8220bbac3)

***User Profile Management:***

![instagram-clone-edit-profile](https://github.com/AhmedYahyaE/laravel-instagram-clone/assets/118033266/8b9f8ba0-d7f3-4601-a1de-fbd35b9f44d7)

***Adding Posts:***

![instagram-clone-add-new-post](https://github.com/AhmedYahyaE/laravel-instagram-clone/assets/118033266/6b597622-44de-488a-97f6-17ac21a2bfbb)

## Features:
1- Using Laravel's '[storage](storage)' directory (public disk and local driver) for storing user-uploaded images (instead of the regular '[public](public)' directory). Additionally, using a Symbolic Link between the '[storage/app/public](storage/app/public)' directory and '[public/storage](public/storage)' directory to display images throughout the application.

2- User Following System (Follow/Unfollow Button).

3- Authorization using Laravel "Policies" classes.

4- Using Laravel Cache (caching) to optimize performance.

5- Using Eloquent Events / Model Events.

6- Laravel Telescope.

7- Using SQLite, the lightweight database engine.

8- Sending automatic Welcome emails to new registered users (using Mailable and Mailtrap).

9- Making HTTP Requests to the server from the frontend using Axios JavaScript library.

10- Using Vue.js Components.

11 - Using "Intervention Image" package for handling and manipulation of user-uploaded images.

12- Eloquent Pagination.

13- User Profile Management.

14-  User Registration, Authentication and Authorization.

## Application Routes:
All the application routes are defined in the [web.php](/routes/web.php) file.

## Installation & Configuration:

1- Open your terminal, navigate to the project root directory, and use the '***git clone https://github.com/AhmedYahyaE/laravel-instagram-clone.git***' command, or just download the ZIP project.

2- Run '***composer install***' command.

3- Run '***npm install***' command (and only in case that you face any issues/errors, run the 'npm audit fix' command), and then run the '***npm run build***' command.

4- Recreate the Symbolic Link between the '[storage/app/public](storage/app/public)' directory and '[public/storage](public/storage)' directory by removing/deleting the [public/storage](public/storage) directory first, then run the '***php artisan storage:link***' command.

5- Run the '***php artisan serve***' command.

\*\* Ready-to-use registered account credentials you can use to log in:
> **Email**: **test@test.com**, **Password**: **11111111**

> **Email**: **other@email.com**, **Password**: **11111111**
    
> **Email**: **test3@test.com**, **Password**: **11111111**

> **Email**: **ramy.morsy@gmail.com**, **Password**: **11111111**




## Contribution:
Contributions to my Instagram Clone Laravel application are most welcome! If you find any issues or have suggestions for improvements or want to add new features, please open an issue or submit a pull request.
