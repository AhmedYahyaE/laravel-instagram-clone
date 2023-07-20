<!-- This Vue Component is imported in public/js/app.js and resources/js/app.js files -->
<!-- When this Follow/Unfollow Button is clicked in profiles/index.blade.php, both "user-id" and "follows" values are sent with an HTTP Request via an Axios call from the frontend/JavaScript/browser to the Server using an Axios call (Axios library) -->
<template>
    <div>
        <button class="btn btn-primary ms-4" @click="followUser" v-text="buttonText"></button> <!-- When the button is clicked, trigger the followUser() function -->
    </div>
</template>


<script>
    import { Axios } from 'axios'

    export default {
        props: ['userId', 'follows'], // Those properties 'userId' and 'follows' come from the <follow-button> HTML element in profiles/index.blade.php (which, in turn, come from index() method in ProfilesController.php)    // In Vue.js, props are used to pass data from a parent component to a child component. The props property in the component's options object allows you to specify an array of property names that the component expects to receive. Each property name specified in the props array corresponds to a value that can be passed to the component when it is used.    // https://vuejs.org/guide/components/props.html

        data: function () { // data attribute
            return {
                status: this.follows // 'follows' is a Boolean (true or false)    // status is a default state, whether the user is initially attached (following) or not (not following) to that particular profile
            }
        },

        mounted() {
            console.log('Component mounted.')
        },

        methods: {
            followUser() {
                axios.post('/follow/' + this.userId) // Check the toggle() method inside the store() method in FollowsController.php    // JavaScript Promises
                .then(response => {  // in case of success    // JavaScript Promises
                    this.status = !this.status; // flip/toggle the status (flip the Boolean)
                    console.log(response.data);
                }).catch(errors => { // in case of errors (for example, user is not authenticated (not logged-in))
                    if (errors.response.status == 401) { // Because we've applied the 'auth' middleware on the whole FollowsController.php Controller in its constructor function, so when trying to access this route without being authenticated/logged-in, we get the "401" "Unauthorized" Status Code, and then we get redirected to the login page    // 401 means the user is NOT authenticated (UNauthenticated/not logged-in/logged-out/guest/visitor)    // If the user clicks the "Follow/Unfollow" Button while being unauthenticated/logged-out/Guest/Visitor, redirect them to 'login' page
                        window.location = '/login'; // redirect to the login page    // If the user clicks the "Follow/Unfollow" Button while being unauthenticated/logged-out/Guest/Visitor, redirect them to 'login' page
                    }
                });
            }
        },

        computed: { // Computed Properties
            buttonText() { // The Follow/Unfollow Button    // This method is triggered upon the click of the "Follow/Unfollow" Button
                return this.status ? 'Unfollow' : 'Follow'; // if    this.follows    is equal to 'true', this means the user is "following" that profile, so show only the 'Unfollow' button, but if it's equal to 'false', this means the user is "not following" that profile, so show the 'Follow' button
            }
        }
    }
</script>