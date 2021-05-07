<x-app-layout>
    <script src="https://js.stripe.com/v3/"></script>

    <style>
        .StripeElement {
            box-sizing: border-box;

            height: auto;

            padding: 13px;

            border: 1px solid rgba(209, 213, 219,1);
            border-radius: 0.375rem/* 6px */;
            background-color: white;

            transition: box-shadow 150ms ease;

            --tw-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)
        }

        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }

        .StripeElement--invalid {
            border-color: #fa755a;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }
    </style>

    <div class="container mx-auto my-4 px-4 sm:px-8">
        <x-alert/>
        <div class="bg-white shadow rounded p-4 flex flex-col justify-center">
            <div class="mt-4">
                <x-label for="subcscription-plan">Plan</x-label>
                <select name="plan" id="subscription-plan" class='w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50'>
                    @foreach($plans as $key=>$plan)
                        <option value="{{$key}}">{{$plan}}</option>
                    @endforeach
                </select>
            </div>
            <div class="mt-4">
                <x-label for="card-holder-name">Name</x-label>
                <x-input placeholder="Card Holder" id="card-holder-name" type="text" class="w-full"/>
            </div>
            
            <div class="mt-4">
                <!-- Stripe Elements Placeholder -->
                <x-label for="card-element">Card</x-label>
                <div id="card-element"></div>
            </div>
            
            <x-button class="mt-4" id="card-button" data-secret="{{ $intent->client_secret }}">Pay</x-button>
        </div>            
    </div>

    <script>
        window.addEventListener('load', function() {


            const stripe = Stripe('{{env('STRIPE_KEY')}}');

            const elements = stripe.elements();
            const cardElement = elements.create('card');

            cardElement.mount('#card-element');

            const cardHolderName = document.getElementById('card-holder-name');
            const cardButton = document.getElementById('card-button');
            const clientSecret = cardButton.dataset.secret;

            const plan = document.getElementById('subscription-plan').value;

            cardButton.addEventListener('click', async (e) => {
                const { setupIntent, error } = await stripe.handleCardSetup(
                    clientSecret, cardElement, {
                        payment_method_data: {
                            billing_details: { name: cardHolderName.value }
                        }
                    }
                );

                if (error) {
                    // Display "error.message" to the user...
                } else {
                    // The card has been verified successfully...
                    console.log('handling success', setupIntent.payment_method);

                    axios.post('/subscribe',{
                        payment_method: setupIntent.payment_method,
                        plan : plan
                    }).then((data)=>{
                        location.replace(data.data.success_url)
                    });
                }
            });
        })
    </script>
</x-app-layout>
