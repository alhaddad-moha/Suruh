<!DOCTYPE html>
<!--
Copyright (c) 2016 Google Inc.

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
-->
<html>
<head>
    <meta charset=utf-8/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phone Authentication with invisible ReCaptcha</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Material Design Theming -->
    <link rel="stylesheet" href="https://code.getmdl.io/1.1.3/material.orange-indigo.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script defer src="https://code.getmdl.io/1.1.3/material.min.js"></script>

    <link rel="stylesheet" href="main.css">
    <!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/5.0.4/firebase.js"></script>

    <!-- Add Firebase products that you want to use -->
    <script src="https://www.gstatic.com/firebasejs/ui/4.8.0/firebase-ui-auth.js"></script>
    <link type="text/css" rel="stylesheet" href="https://www.gstatic.com/firebasejs/ui/4.8.0/firebase-ui-auth.css"/>
    <style>
        .height-100 {
            height: 100vh
        }

        .card {
            width: 400px;
            border: none;
            height: 300px;
            box-shadow: 0px 5px 20px 0px #d2dae3;
            z-index: 1;
            display: flex;
            justify-content: center;
            align-items: center
        }

        .card h6 {
            color: red;
            font-size: 20px
        }

        .inputs input {
            width: 40px;
            height: 40px
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            margin: 0
        }

        .card-2 {
            background-color: #fff;
            padding: 10px;
            width: 350px;
            height: 100px;
            bottom: -50px;
            left: 20px;
            position: absolute;
            border-radius: 5px
        }

        .card-2 .content {
            margin-top: 50px
        }

        .card-2 .content a {
            color: red
        }

        .form-control:focus {
            box-shadow: none;
            border: 2px solid red
        }

        .validate {
            border-radius: 20px;
            height: 40px;
            background-color: red;
            border: 1px solid red;
            width: 140px
        }
    </style>

</head>
<body>

<div id="check"></div>
<div class="container height-100 d-flex justify-content-center align-items-center">
    <div class="position-relative">
        <div class="card p-2 text-center">
            <h6>يرجى إدخال رمز التحقق<br> لتأكيد إستلام الطلب</h6>
            <div><span>تم إرسال الكود الى الرقم: </span> <small>{{$customer->mobile_number}}</small></div>
            <div id="otp" class="inputs d-flex flex-row justify-content-center mt-2"><input
                    class="m-2 inputs text-center form-control rounded" type="text" id="first" maxlength="1"/> <input
                    class="m-2 inputs text-center form-control rounded" type="text" id="second" maxlength="1"/> <input
                    class="m-2 inputs text-center form-control rounded" type="text" id="third" maxlength="1"/> <input
                    class="m-2 inputs text-center form-control rounded" type="text" id="fourth" maxlength="1"/> <input
                    class="m-2 inputs text-center form-control rounded" type="text" id="fifth" maxlength="1"/> <input
                    class="m-2 inputs text-center form-control rounded" type="text" id="sixth" maxlength="1"/></div>
            <div class="mt-4">
                <button id="btnVerify" class="btn btn-danger px-4 validate">التحقق</button>
            </div>
        </div>
    </div>
</div><!-- Import and configure the Firebase SDK -->

<!-- Container for the sign in status and user info -->

<!-- Import and configure the Firebase SDK -->
<!-- These scripts are made available when the app is served or deployed on Firebase Hosting -->
<!-- If you do not serve/host your project using Firebase Hosting see https://firebase.google.com/docs/web/setup -->
<script src="/__/firebase/9.14.0/firebase-app-compat.js"></script>
<script src="/__/firebase/9.14.0/firebase-auth-compat.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="/__/firebase/init.js"></script>


<script type="text/javascript">

    /**
     * Set up UI event listeners and registering Firebase auth listeners.
     */
    window.onload = function () {
        const firebaseConfig = {
            apiKey: "AIzaSyAmzAPxLNJCjOV64VUMTCUlXiuh6U5Vpcw",
            authDomain: "wejhati-49ee1.firebaseapp.com",
            projectId: "wejhati-49ee1",
            storageBucket: "wejhati-49ee1.appspot.com",
            messagingSenderId: "64940353723",
            appId: "1:64940353723:web:6b353de7fe65eb8112a19e",
            measurementId: "G-GL9Z6EX7MP"
        };

        firebase.initializeApp(firebaseConfig);

        // Listening for auth state changes.
        firebase.auth().onAuthStateChanged(function (user) {
            if (user) {
                // User is signed in.
                var uid = user.uid;
                var email = user.email;
                var photoURL = user.photoURL;
                var phoneNumber = user.phoneNumber;
                var isAnonymous = user.isAnonymous;
                var displayName = user.displayName;
                var providerData = user.providerData;
                var emailVerified = user.emailVerified;
            }
        });

        document.getElementById('btnVerify').addEventListener('click', onVerifyCodeSubmit);

        window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('check', {
            'size': 'invisible',
            'callback': function (response) {
                // reCAPTCHA solved, allow signInWithPhoneNumber.
                //   onSignInSubmit();
            }
        });
        recaptchaVerifier.render().then(function (widgetId) {
            window.recaptchaWidgetId = widgetId;
        });
        onSignInSubmit();
    };

    /**
     * Function called when clicking the Login/Logout button.
     */
    function onSignInSubmit() {
        if (isPhoneNumberValid()) {
            window.signingIn = true;
            // updateSignInButtonUI();
            var phoneNumber = getPhoneNumberFromUserInput();
            var appVerifier = window.recaptchaVerifier;
            firebase.auth().signInWithPhoneNumber(phoneNumber, appVerifier)
                .then(function (confirmationResult) {
                    // SMS sent. Prompt user to type the code from the message, then sign the
                    // user in with confirmationResult.confirm(code).
                    window.confirmationResult = confirmationResult;
                    window.signingIn = false;
                }).catch(function (error) {
                // Error; SMS not sent
                console.error('Error during signInWithPhoneNumber', error);
                window.alert('Error during signInWithPhoneNumber:\n\n'
                    + error.code + '\n\n' + error.message);
                window.signingIn = false;
            });
        }
    }


    /**
     * Function called when clicking the "Verify Code" button.
     */
    function onVerifyCodeSubmit(e) {
        e.preventDefault();
        if (!!getCodeFromUserInput()) {
            window.verifyingCode = true;
            var code = getCodeFromUserInput();
            confirmationResult.confirm(code).then(function (result) {
                // User signed in successfully.
                var user = result.user;
                window.verifyingCode = false;
                window.confirmationResult = null;
                console.log("Done sucess");
                window.open("/order/update", "_self");

            }).catch(function (error) {
                // User couldn't sign in (bad verification code?)
                console.error('Error while checking the verification code', error);
                window.alert('Error while checking the verification code:\n\n'
                    + error.code + '\n\n' + error.message);
                window.verifyingCode = false;

            });
        }
    }

    /**
     * Cancels the verification code input.
     */
    function cancelVerification(e) {
        e.preventDefault();
        window.confirmationResult = null;

    }

    /**
     * Signs out the user when the sign-out button is clicked.
     */
    function onSignOutClick() {
        firebase.auth().signOut();
    }

    /**
     * Reads the verification code from the user input.
     */
    function getCodeFromUserInput() {
        var input1 = document.getElementById('first').value;
        var input2 = document.getElementById('second').value;
        var input3 = document.getElementById('third').value;
        var input4 = document.getElementById('fourth').value;
        var input5 = document.getElementById('fifth').value;
        var input6 = document.getElementById('sixth').value;
        var code = input1 + input2 + input3 + input4 + input5 + input6;
        console.log("Your code is: " + code);
        return code;
    }

    /**
     * Reads the phone number from the user input.
     */
    function getPhoneNumberFromUserInput() {
        //     return "+966509312422";
        //   return "+967734996700";
        var phone = @json($customer->mobile_number);
        return phone;
    }

    /**
     * Returns true if the phone number is valid.
     */
    function isPhoneNumberValid() {
        var pattern = /^\+[0-9\s\-\(\)]+$/;
        var phoneNumber = getPhoneNumberFromUserInput();
        return phoneNumber.search(pattern) !== -1;
    }

    /**
     * Re-initializes the ReCaptacha widget.
     */
    function resetReCaptcha() {
        if (typeof grecaptcha !== 'undefined'
            && typeof window.recaptchaWidgetId !== 'undefined') {
            grecaptcha.reset(window.recaptchaWidgetId);
        }
    }

    /**
     * Updates the Sign-in button state depending on ReCAptcha and form values state.
     */

    /**
     * Updates the Verify-code button state depending on form values state.
     */

    /**
     * Updates the state of the Sign-in form.
     */

    /**
     * Updates the state of the Verify code form.
     */
</script>

<script>
    $(".inputs").keyup(function () {
        if (this.value.length === 1) {
            var $next = $(this).next('.inputs');
            if ($next.length)
                $(this).next('.inputs').focus();
            else
                $(this).blur();
        }
    });
</script>

</body>
</html>
