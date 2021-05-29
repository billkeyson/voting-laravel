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
                <form class="card-text text-center" style="padding: 10px auto 10px auto" method="POST">

                    <div class="col-md-12">

                        <div class="form-group">
                            <label for="votesCounts">Number Of Votes</label>
                            <input type="number" class="form-control" id="votesCounts" name="voteCounts" min="1"
                                placeholder="Number of Votes">
                        </div>

                        <div class="form-group">
                            <label for="paymentMethod1">Select Payment Method</label>
                            <select class="paymentMethod" id="paymentMethod1" class="form-control">
                                <option selected>Select Payment Method</option>
                                <option value='momo'>Mobile Money</option>
                                <option value='card'>Credit Card</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="mobilenumber">Phone Number</label>
                            <input type="text" maxlength="10" class="form-control" id="mobilenumber"
                                placeholder="Mobile Number">
                        </div>

                        <div class="form-group" style="display: none" id="userEmail">
                            <label for="email">Email</label>
                            <input type="text" maxlength="10" class="form-control" id="email" placeholder="examplemail.com">
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
        const paymentMethod = document.querySelector(".paymentMethod");
        paymentMethod.addEventListener('change', (event) => {
            if (event.target.value == 'card') {
                if (userEmail.style.display == 'none')
                    userEmail.style.display = 'block';
            } else {
                userEmail.style.display = 'none';
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
