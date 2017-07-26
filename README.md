# mor-stripe
Copyright (c) 2017 Arcadier

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

=====================================================================
<br/>
Simple step by step on how to configure the custom payment per the Arcadier admin interface

Step 1: Download Extract the <a href= "https://github.com/Arcadier/mor-stripe/blob/master/arcadier-mor-stripe.zip">arcadier-mor-stripe.zip file</a>, and import the <b>payment_logs.sql</b> file into your database, or you may create your own table  but make sure you set the table name in file under the same name

Step 2: Open the <b>config.php file</b>, set your site url and your maketplace site url for the API call followed by seting the <b>database connection information</b>

Step 3: Login to your <b>marketplace admin portal</b> using your admin credentials

Step 4: Go to <b>Payments & Transactions</b> > <b>Configure Payments</b> and click on <b>Add a custom payment method</b>. (You may also edit an existing custom payment method)

Step 5: Fill in the required fields with the relevant information like <b>Payment Name</b>, <b>Logo</b> and <b>description</b>

Step 6: Create the <b>Handshake</b> and <b>Call back file</b> or you may also use the one attached here

Step 7: Input your <b>Handshake / Connection URL</b> (e.g: https://www.yourdomain.com/payments/handshake.php )

Steps 8: Input your <b>Call back / Redirect URL</b> (e.g.: https://www.yourdomain.com/payments/stripe-pay.php )

Step 9: Create one database and table to store the <b>PayKey</b> and return it, the code is already given in the files and all you have to do is the connection on the <b>config.php</b> file as per your database

Step 10: Once completed, the payment method will be available on your marketplace for your sellers to onboard with and your buyers to checkout.
