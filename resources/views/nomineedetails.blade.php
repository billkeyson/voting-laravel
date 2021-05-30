@extends('layouts.app')

@section('content')
    <div class="col-md-5" style="display: flex;justify-content:center;align-items:center;flex-direction: column;">
        <h3 class="nomineeName" style="font-weight: 950;">{{ $nominee->name }}</h3>
        <div class="categoryname__or__nomineename" style="font-weight: 900;">
            {{ $eventName }}
        </div>
    </div>

    <div class="col-md-7">
        <div class="card text-center w-75" style="margin: 10px auto 10px auto">
            <div class="card-header">
                Voting Datails
            </div>
            <div class="card-body">
                <h5 class="card-title">
                    Enter your vote details to proceed
                </h5>
                <form class="card-text text-center" style="padding: 10px auto 10px auto" method="POST" action="{{route('payment.charge',['nomineeId'=>$nominee->id])}}">
                    {{ csrf_field() }}
                    <div class="col-md-12">

                        <div class="form-group">
                            <label for="votesCounts">Number Of Votes</label>
                            <input type="number" class="form-control" id="votesCounts" name="vote_counts" min="1"
                                placeholder="Number of Votes">
                        </div>

                        <div class="form-group" id="paymentMethod">
                            <label for="pMethod">Select Payment Method</label>
                            <select name= "payment_method" id="pMethod" class="form-control">
                                <option selected>Select Payment Method</option>
                                <option value='mobile_money'>Mobile Money</option>
                                <option value='card'>Credit Card</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="mobilenumber">Phone Number</label>
                            <input type="text" maxlength="10" class="form-control"
                            name="mobilenumber"
                             id="mobilenumber"
                                placeholder="Mobile Number">
                        </div>

                        <div class="form-group" style="display: none" id="userEmail">
                            <label for="email">Email</label>
                            <input type="text" maxlength="10"  name="email" class="form-control" id="email" placeholder="examplemail.com">
                        </div>

                        
                        <div class="form-group" id="network_provider">
                            <label for="network">Select Your Mobile Network</label>
                            <select class="" name= "network_provider" class="form-control" id="network">
                                <option selected>Select Mobile Network</option>
                                <option value='mtn'>MTN</option>
                                <option value='vod'>Vodafone</option>
                                <option value='tgo'> Airtel/Tigo</option>
                            </select>
                        </div>

                        <div class="totalAmount">
                            <strong id="totalAount" style="font-weight: 900;">Amount GHC 0.0</strong>
                        </div>

                        <button type="submit" class="btn btn-primary">Proceed With Payment</button>

                    </div>


                </form>
            </div>

        </div>


    </div>

    <script>
        // show hidden element
        const userEmail = document.getElementById("userEmail");
        const paymentMethod = document.getElementById("paymentMethod");
        const network_provider = document.getElementById("network_provider");

        paymentMethod.addEventListener('change', (event) => {
            if (event.target.value == 'card') {
                if (userEmail.style.display == 'none')
                {
                    userEmail.style.display = 'block';
                }

                network_provider.style.display='none';

            } else if(event.target.value == 'momo') {
                userEmail.style.display = 'none';
                network_provider.style.display='block';

            }
        });

        // increate =vote amount on onChange
        const voteCounts = document.getElementById("votesCounts");
        const totalDisplay = document.getElementById("totalAount");

        voteCounts.addEventListener('change', (event) => {
            totalDisplay.innerHTML = "Amount GHC " + event.target.value * {{ $unitCost }}
        });

    </script>
@endsection
